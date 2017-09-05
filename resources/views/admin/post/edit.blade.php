@extends('admin/main')


@section('title')编辑文章@stop


@section('content')

	<div class="col-md-8">
	<form action="{{ route('admin_update_post', ['id'=>$post->id]) }}" method="post" id="">
		{{csrf_field()}}
		<div class="form-group">
			<label>title</label>
			<input type="text" class="form-control" name="title" placeholder="" value="{{ $post->title }}" required="required">
		</div>
		<div class="form-group">
			<label>slug</label>
			<input type="text" class="form-control" name="slug" placeholder="" value="{{ $post->slug }}" required="required">
		</div>
		<div class="form-group">
			<label class="radio-inline"><input type="radio" name="status" value="public" {{$post->status=='public' ? 'checked="checked"' : ''}}> 公开 </label>
			<label class="radio-inline"><input type="radio" name="status" value="hidden" {{$post->status=='hidden' ? 'checked="checked"' : ''}}> 隐藏 </label>
		</div>
		<div class="form-group">
			<label class="radio-inline"><input type="radio" name="type" value="post" {{$post->type=='post' ? 'checked="checked"' : ''}}> 文章 </label>
			<label class="radio-inline"><input type="radio" name="type" value="page" {{$post->type=='page' ? 'checked="checked"' : ''}}> 页面 </label>
		</div>
		<div class="form-group">
			<label>选择分类</label>
			<?php if ( ! $selectedCategory ) { $category_id = 0; ?>
			<p>注意：当前文章无分类，可能是由于删除了分类导致的；默认选中了第一个分类，请注意修改</p>
			<?php } else { $category_id = $selectedCategory->category_id; } ?>
			<select class="form-control" name="category">
				<label>category</label>
				@foreach ( $categories as $v )
				<option value="{{$v->id}}" <?php if ( $category_id == $v->id ) { ?>selected="selected"<?php } ?>>{{$v->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label>内容</label>
			<textarea class="form-control" rows="30" name="content">{{$post->content}}</textarea>
		</div>
		<div class="form-group">
			<label>选择标签</label>
			<div class="muti-tags">
				<div class="checkbox">
					@foreach ( $tags as $v )
					<input type="checkbox" id="tag{{$v->id}}" name="tags[]" value="{{$v->id}}"
						@foreach ($selectedTagIds as $value)
							@if ( $value->tag_id == $v->id )
								checked="checked"
							@endif
						@endforeach
					>
					<label for="tag{{$v->id}}">{{$v->name}}</label>
					@endforeach
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">修改</button>
	</form>
	</div>

	<div class="col-md-4">
	{{-- 上传文件 --}}
	<h2>上传附件</h2>
	<form role="form" enctype="multipart/form-data">
		<div class="form-group">
			<div class="input-group">
				<input id="upload_file" class="file" type="file" multiple data-preview-file-type="any" data-upload-url="{{ route('admin_filesystem_ajax_upload') }}" name="upload_file">
				<p class="help-block">上传文件，返回使用路径。</p>
			</div>
		</div>
	</form>

	<table class="table table-bordered" id="file-lists">
		<tr>
			<th>已上传附件</th>
			<th>相对路径</th>
			<th>管理文件</th>
		</tr>

	</table>
	<script type="text/javascript">
	$("#upload_file").fileinput({
		language: 'zh',
		uploadUrl: '{{ route('admin_filesystem_ajax_upload') }}', // action
		allowedFileExtensions : [
			<?php
				$tmp = '';
				foreach( explode(',', config('admin.font_upload_extension')) as $v ) {
					$tmp .= '"'.$v.'",';
				}
				echo trim($tmp, ',');
			?>
		],
		overwriteInitial: false,
		maxFileSize: {{ config('admin.upload_file_size') }}, // 最大大小
		maxFileCount: 3, // 同时上传最多文件数量
		uploadExtraData: {
			'_token'			: '{{csrf_token()}}',
			'rename'			: 1
		},
	});
	$("#upload_file").on("fileuploaded", function (event, data, previewId, index) {
		host = document.domain;
		$("#file-lists").append(
			'<tr>'+
				'<td><a href="http://'+host+'/uploads/img/{{date('Y/m/d')}}/'+ data.response +'" target="_blank">'+ data.response +'</a></td>'+
				'<td>/uploads/img/{{date('Y/m/d')}}/'+ data.response +'</td>'+
				'<td>'+
					'<a href="{{ route('admin_filesystem', "folder=uploads/img/".date('Y/m/d')) }}" target="_blank">'+
						'<button class="btn btn-info btn-sm pull-left">'+
							'<i class="glyphicon glyphicon-cog"></i>'+
						'</button>'+
					'</a>'+
				'</td>'+
			'</tr>'
		);
	});
	</script>
	{{-- 上传文件 end --}}

	{{-- ajax add tag start  --}}
	<hr>
	<h4>添加新标签</h4>
	<div class="form-group">
		<input type="hidden" name="current_folder" value="">
		<div class="input-group col-md-12">
			<span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
			<input class="form-control" type="text" placeholder="新标签名" name="new_tag_name">
			<input class="form-control" type="text" placeholder="新标签的 slug" name="new_tag_slug">
			<span class="input-group-addon"><button id="add_tag" class="btn btn-primary" type="submit">创建新标签</button></span>
		</div>
	</div>
	<div id="add_tag_success">
	</div>
	<script type="text/javascript">
	$(function () {
		 $('#add_tag').on('click', function () {
			$.ajax({
				type: 'POST',
				url: '{{route('admin_ajax_store_tag')}}',
				data: {
					new_tag_name : $("input[name=new_tag_name]").val(),
					new_tag_slug : $("input[name=new_tag_slug]").val()
				},
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
				success: function(data){
					console.log(data);
					// 提示添加成功
					$('#add_tag_success').append("<p>"+data.tag_name+" 添加成功</p>");
					// 在 list 中显示，并且选中
					$('.muti-tags .checkbox').append(
						'<input type="checkbox" id="tag'+data.tag_id+'" name="tags[]" value="'+data.tag_id+'" checked="checked">'+
						'<label for="tag'+data.tag_id+'">'+data.tag_name+'</label>'
					);
				},
				error: function(xhr, error){
					console.debug(xhr);
					console.debug(error);
					if (xhr.status == 422) {
						alert('参数错误 [422]');
					} else if (xhr.status == 500) {
						alert('Internal Server Error [500].');
					}
				}
			});
		});
	});
	</script>
	{{-- ajax add tag end --}}
	</div>


@stop


@section('js')
	{{-- fileinput 拖拽上传 --}}
	<link href="https://cdn.bootcss.com/bootstrap-fileinput/4.3.6/css/fileinput.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.3.6/js/fileinput.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.3.6/js/locales/zh.min.js"></script>
	{{-- 确认离开 --}}
	<script src="/js/unsave_confirm.js"></script>
@stop