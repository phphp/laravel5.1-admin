@extends('admin/main')


@section('title')所有分类@stop


@section('content')

	<div class="table-responsive">

		<div id="sortable_danger" class="alert alert-danger" style="display: none"><p>排序失败</p></div>
		<div id="sortable_success" class="alert alert-success" style="display: none"><p>排序成功</p></div>
		<table class="table table-striped table-bordered" id="sortable" ajax-url="{{route('admin_ajax_sort_category')}}">
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>slug</th>
				<th>操作</th>
			</tr>
		@foreach ( $categories as $v )
			<tr class="moveable" id="{{$v->id}}">
				<td>{{$v->id}}</td>
				<td><a href="{{ route('admin_show_category', ['id'=>$v->id]) }}">{{$v->name}}</a></td>
				<td>{{$v->slug}}</td>
				<td>
					<a href="{{ route('admin_edit_category', ['id'=>$v->id]) }}">
						<button class="btn btn-primary btn-sm pull-left"><i class="glyphicon glyphicon-pencil"></i></button>
					</a>
					<form class="pull-left" action="{{ route('admin_destroy_category', ['id'=>$v->id]) }}" method="post">
						<input type="hidden" name="_method" value="DELETE">
						{{csrf_field()}}
						<button class="confirm_button btn btn-danger btn-sm pull-left"><i class="glyphicon glyphicon-remove"></i></button>
					</form>

				</td>
			</tr>
		@endforeach
		</table>
	</div>

@stop

@section('js_bottom')
	{{-- 拖拽排序，ajax 修改--}}
	<script src="https://lib.sinaapp.com/js/jquery-ui/1.9.2/jquery-ui.min.js"></script>
@stop