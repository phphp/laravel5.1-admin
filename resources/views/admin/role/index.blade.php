@extends('admin/main')


@section('title')所有角色@stop


@section('content')

	@include('admin/role/breadcrumb')

	<div class="table-responsive">

		<div id="sortable_danger" class="alert alert-danger" style="display: none"><p>排序失败</p></div>
		<div id="sortable_success" class="alert alert-success" style="display: none"><p>排序成功</p></div>
		{{-- 表格 start --}}
		<table class="table table-striped table-bordered" id="sortable" ajax-url="{{route('admin_ajax_sort_role')}}">
			<tr>
				<th>ID</th>
				<th>名称</th>
				<th>操作</th>
			</tr>
			@foreach ( $roles as $v )
			<tr class="moveable" id="{{$v->id}}">
				<td>{{$v->id}}</td>
				<td><a href="{{ route('role_show', ['id'=>$v->id]) }}">{{$v->name}}</a></td>
				<td>
					<a href="{{ route('role_edit', ['id'=>$v->id]) }}">
						<button class="btn btn-primary btn-sm pull-left"><i class="glyphicon glyphicon-pencil"></i></button>
					</a>
					<form class="pull-left" action="{{ route('role_destroy', ['id'=>$v->id]) }}" method="post">
						<input type="hidden" name="_method" value="DELETE">
						{{csrf_field()}}
						<button class="confirm_button btn btn-danger btn-sm pull-left"><i class="glyphicon glyphicon-remove"></i></button>
					</form>

				</td>
			</tr>
			@endforeach
		</table>
		{{-- 表格 end --}}
	</div>

	<div class="table-responsive">
		<h4>对应权限</h4>
		<table class="table table-striped table-bordered">
			<tr>
				<td></td>
			@foreach ( $permissions as $p )
				<td>{{$p->name}}</td>
			@endforeach
			</tr>

		<?php
			foreach ( $roles as $k=>$role ) {
				if ( ! $role->permissions->toArray() ) $permissions_array[$k][] = array();
				else {
					foreach ( $role->permissions as $value ) {
						$permissions_array[$k][] = $value->id;
					}
				}
			}
		?>
		@foreach ( $roles as $k=>$r )
			<tr>
				<td>{{$r->name}}</td>
				@foreach ( $permissions as $p )
				<td style='vertical-align: middle;text-align: center;'>
					@if ( in_array($p->id, $permissions_array[$k]) )
					<i class="glyphicon glyphicon-ok"></i>
					@endif
				</td>
				@endforeach

			</tr>
		@endforeach
		</table>
	</div>

@stop

@section('js_bottom')
	{{-- 拖拽排序，ajax 修改--}}
	<script src="https://lib.sinaapp.com/js/jquery-ui/1.9.2/jquery-ui.min.js"></script>
@stop