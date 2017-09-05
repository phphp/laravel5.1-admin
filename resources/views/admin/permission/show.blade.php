@extends('admin/main')


@section('title')权限信息@stop


@section('content')

	@include('admin/permission/breadcrumb')

	<h4>{{ $permission->name }}</h4>

	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<td>{{$permission->id}}</td>
			</tr>
			<tr>
				<th>NAME</th>
				<td>{{$permission->name}}</td>
			</tr>
			<tr>
				<th>URL</th>
				<td>{{$permission->url}}</td>
			</tr>
			<tr>
				<th>CODE</th>
				<td>{{$permission->code}}</td>
			</tr>
			<tr>
				<th>sort</th>
				<td>{{$permission->sort}}</td>
			</tr>
		</table>
	</div>



@stop

