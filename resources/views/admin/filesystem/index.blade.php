@extends('admin/main')


@section('title')管理文件@stop


@section('content')

    <div class="btn-group btn-breadcrumb">
    	<a href="{{ route('admin_filesystem') }}" class="btn btn-default" title="/uploads"><i class="glyphicon glyphicon-home"></i></a>
    	<?php
    		$breadcrumbPath = '';
			$breadcrumb = explode('/', $folder);
			if ( $breadcrumb[0] )
			{
				$breadcrumbSum = count($breadcrumb) - 1;
				$breadcrumbPath = '';
				foreach ( $breadcrumb as $k=>$v )
				{
					$breadcrumbPath .= '/' . array_shift($breadcrumb);
					if ( $k === 0 ) $breadcrumbPath = ltrim($breadcrumbPath, "/");
		?>
        <a href="{{ route('admin_filesystem', "folder=$breadcrumbPath") }}" class="btn btn-default" <?php if($k==$breadcrumbSum) echo 'style="color:#000;font-weight:600"' ?>>{{ $v }}</a>
		<?php
				}
			}
		?>
    </div>

	<p></p>

	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<tr>
				<th>name</th>
				<th>type</th>
				<th>size</th>
				<th>updated at</th>
				<th>actions</th>
			</tr>
		{{-- 目录列 --}}
		@foreach ( $directories as $v )
			<tr>
				<?php
					$nameArr = explode('/', $v);
					$nameStr = array_pop($nameArr);
				?>
				<td><a href="{{ route('admin_filesystem', "folder=$v") }}">{{ $nameStr }}</a></td>
				<td colspan="3">目录</td>
				<td>
					{{-- 目录移动／改名 --}}
					<button class="btn btn-info btn-sm pull-left" data-toggle="modal" data-target="#mvDir" data-name="{{ $nameStr }}"><i class="glyphicon glyphicon-transfer"></i></button>
					{{-- 删除目录 --}}
					<form class="pull-left" action="{{ route('admin_filesystem_destory_directory') }}" method="post">
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="path" value="{{ $breadcrumbPath.'/'.$nameStr }}">
						<button class="confirm_button btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></button>
					</form>
				</td>
			</tr>
		@endforeach
		{{-- 目录移动／改名表单 --}}
		<div class="modal fade" id="mvDir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						{{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
						<h4 class="modal-title" id="myModalLabel">移动／修改目录</h4>
					</div>
					<div class="modal-body">
						<form class="form-inline" action="{{ route('admin_filesystem_move_directory') }}" method="post">
							<p class="help-block" id="currentPath"></p>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon"><i class="glyphicon glyphicon-transfer"></i></div>
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<input id="oldDirPath" type="hidden" name="oldDirPath" value="">
									<input id="newDirPath" class="form-control" type="text" name="newDirPath" value="">
								</div>
							</div>
							<p class="help-block">填写路径移动目录，类似 mv 指令</p>
							<button type="submit" class="btn btn-primary">提交更改</button>
						</form>

					</div>
				</div>
			</div>
		</div>
		<script>
		$('#mvDir').on('show.bs.modal', function (e) {
			btn = $(e.relatedTarget); // 点击的按钮
			name = btn.data("name");
			$("#newDirPath").val('{{ $breadcrumbPath }}/'+name);
			$("#oldDirPath").val('{{ $breadcrumbPath }}/'+name);
			$("#currentPath").text('当前路径：'+'{{ $breadcrumbPath }}/'+name);
		})
		</script>


		{{-- 文件列 --}}
		@foreach ( $files as $v )
			<tr>
				<?php
					$nameArr = explode('/', $v['name']);
					$nameStr = array_pop($nameArr);
				?>
				<td>{{ $nameStr }}</td>
				<td>{{ $v['type'] }}</td>
				<td>{{ $v['size'] }}</td>
				<td>{{ $v['modified'] }}</td>
				<td>
					<a href="{{ asset($v['name']) }}" target="_blank" title="新窗口中打开"><button class="btn btn-success btn-sm pull-left"><i class="glyphicon glyphicon-new-window"></i></button></a>
					{{-- 文件移动／改名 --}}
					<button class="btn btn-info btn-sm pull-left" data-toggle="modal" data-target="#mvFile" data-name="{{ $nameStr }}"><i class="glyphicon glyphicon-transfer"></i></button>
					<form class="pull-left" action="{{ route('admin_filesystem_destory_file') }}" method="post">
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="path" value="{{ $breadcrumbPath.'/'.$nameStr }}">
						<button class="confirm_button btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></button>
					</form>
				</td>
			</tr>
		@endforeach
		</table>
		{{-- 文件移动／改名表单 --}}
		<div class="modal fade" id="mvFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header"><h4 class="modal-title" id="myModalLabel">移动／修改文件</h4></div>
					<div class="modal-body">
						<form class="form-inline" action="{{ route('admin_filesystem_move_file') }}" method="post">
							<p class="help-block" id="currentFilePath"></p>
							<div class="form-group" style="width: 100%">
								<div class="input-group" style="width: 100%">
									<div class="input-group-addon"><i class="glyphicon glyphicon-transfer"></i></div>
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<input id="oldFilePath" type="hidden" name="oldFilePath" value="">
									<input id="newFilePath" class="form-control" type="text" name="newFilePath" value="">
								</div>
							</div>
							<p class="help-block">填写路径移动文件，类似 mv 指令</p>
							<button type="submit" class="btn btn-primary">提交更改</button>
						</form>

					</div>
				</div>
			</div>
		</div>
		<script>
		$('#mvFile').on('show.bs.modal', function (e) {
			btn = $(e.relatedTarget); // 点击的按钮
			name = btn.data("name");
			$("#newFilePath").val('{{ $breadcrumbPath }}/'+name);
			$("#oldFilePath").val('{{ $breadcrumbPath }}/'+name);
			$("#currentFilePath").text('当前路径：'+'{{ $breadcrumbPath }}/'+name);
		})
		</script>
	</div>


	{{-- 新建目录 --}}
	<form role="form" method="post" action="{{ route('admin_filesystem_create_directory') }}">
		<div class="form-group">
			{{csrf_field()}}
			<input type="hidden" name="current_folder" value="{{ $folder }}">
			<div class="input-group col-md-5">
				<span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
				<input class="form-control" type="text" placeholder="新目录名称" name="new_directory_name" required="required">
				<span class="input-group-btn"><button class="btn btn-primary" type="submit">创建新目录</button></span>
			</div>
		</div>
	</form>
	<br>


	{{-- 上传文件 --}}
	<form role="form" enctype="multipart/form-data" multiple>
		<div class="form-group">
			<div class="input-group col-md-5">
				<input id="upload_file" class="file" type="file" multiple data-preview-file-type="any" data-upload-url="{{ route('admin_filesystem_ajax_upload') }}" name="upload_file">
				<p class="help-block">上传至当前目录，文件名不变（特殊符号会替换），不能重名。</p>
			</div>
		</div>
	</form>
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
			'current_folder'	: '../',
		},
	});
	$("#upload_file").on("fileuploaded", function (event, data, previewId, index) {
		$(".table-responsive").children('table').append('<tr class="success"><td colspan="5">文件：'+ data.filenames +' 已上传</td></tr>');
	});
	</script>
	{{-- 上传文件 end --}}






@stop


@section('tip')
<div class="tip-container">
    <i class="glyphicon glyphicon-info-sign"></i>
    <div class="tips">
        <dl class="list-unstyled">
            <dd>默认根目录为 /public 目录，并且 public 目录没有写权限</dd>
            <dd>目录名允许：小写字母、数字、- 和 _</dd>
            <dd>删除操作请谨慎！</dd>
        </dl>
    </div>
</div>
@stop


@section('js')
	{{-- fileinput 拖拽上传 --}}
 	<link href="https://cdn.bootcss.com/bootstrap-fileinput/4.3.6/css/fileinput.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.3.6/js/fileinput.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.3.6/js/locales/zh.min.js"></script>
@stop