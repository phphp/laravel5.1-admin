@extends('admin/main')


@section('title')所有权限@stop


@section('content')

	@include('admin/permission/breadcrumb')

	<div class="table-responsive">

		<div id="sortable_danger" class="alert alert-danger" style="display: none"><p>排序失败</p></div>
		<div id="sortable_success" class="alert alert-success" style="display: none"><p>排序成功</p></div>
		<table class="table table-striped table-bordered" id="sortable" ajax-url="{{route('admin_ajax_sort_permission')}}">
			<tr>
				<th>ID</th>
				<th>名称</th>
				<th>URL</th>
				<th>CODE</th>
				<th>操作</th>
			</tr>
		@foreach ( $permissions as $v )
			<tr class="moveable" id="{{$v->id}}">
				<td>{{$v->id}}</td>
				<td><a href="{{ route('permission_show', ['id'=>$v->id]) }}">{{$v->name}}</a></td>
				<td>{{$v->url}}</td>
				<td>{{$v->code}}</td>
				<td>
					<a href="{{ route('permission_edit', ['id'=>$v->id]) }}">
						<button class="btn btn-primary btn-sm pull-left"><i class="glyphicon glyphicon-pencil"></i></button>
					</a>
					<form class="pull-left" action="{{ route('permission_destroy', ['id'=>$v->id]) }}" method="post">
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