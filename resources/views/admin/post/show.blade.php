@extends('admin/main')


@section('title')查看文章@stop


@section('content')

	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>title</th>
				<th>slug</th>
				<th>status</th>
				<th>category</th>
				<th>type</th>
				<th>created_at</th>
				<th>updated_at</th>
			</tr>
			<tr>
				<td>{{$post->id}}</td>
				<td>{{$post->title}}</td>
				<td>{{$post->slug}}</td>
				<td>{{$post->status}}</td>
				<td><?php
					if ( $post->category !== null )
						echo $post->category[0]['name'];
					else
						echo '<div>无分类 <i class="glyphicon glyphicon-warning-sign text-danger"></i></td>';
				?></td>
				<td>{{$post->type}}</td>
				<td>{{$post->created_at}}</td>
				<td>{{$post->updated_at}}</td>
			</tr>
		</table>
	</div>

	<div>
		<p>内容：</p>
		<hr />
		{!! markdown($post->content) !!}
		<hr />
	</div>

	<div>
		<p>标签：
		@foreach ( $post->tags as $v )
		{{$v->name}}&nbsp
		@endforeach
		</p>
	</div>



@stop

