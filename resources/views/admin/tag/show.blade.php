@extends('admin/main')


@section('title')标签信息@stop


@section('content')

	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>slug</th>
			</tr>
			<tr>
				<td>{{$tag->id}}</td>
				<td>{{$tag->name}}</td>
				<td>{{$tag->slug}}</td>
			</tr>
		</table>
	</div>



@stop

