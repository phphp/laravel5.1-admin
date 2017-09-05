@extends('admin/main')


@section('title')分类信息@stop


@section('content')

	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>slug</th>
			</tr>
			<tr>
				<td>{{$category->id}}</td>
				<td>{{$category->name}}</td>
				<td>{{$category->slug}}</td>
			</tr>
		</table>
	</div>



@stop

