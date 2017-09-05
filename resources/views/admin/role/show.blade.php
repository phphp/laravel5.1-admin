@extends('admin/main')


@section('title')角色信息@stop


@section('content')

	@include('admin/role/breadcrumb')

	<h4>{{ $role->name }} 角色</h4>
	<p>ID: {{ $role->id }}, sort: {{ $role->sort }}</p>
	<hr>

	<h4>拥有的权限</h4>
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>权限名称</th>
				<th>URL</th>
				<th>CODE</th>
			</tr>
		@foreach ( $permissions as $v )
			<tr>
				<td>{{$v->id}}</td>
				<td>{{$v->name}}</td>
				<td>{{$v->url}}</td>
				<td>{{$v->code}}</td>
			</tr>
		@endforeach
		</table>
	</div>



@stop

