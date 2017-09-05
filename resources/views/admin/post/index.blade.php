@extends('admin/main')


@section('title')所有文章@stop


@section('content')

	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<tr>
				<th>ID</th>
				<th>title</th>
				{{-- <th>slug</th> --}}
				<th>status</th>
				<th>category</th>
				<th>type</th>
				<th>created at</th>
				<th>updated at</th>
				<th>操作</th>
			</tr>
		@foreach ( $posts as $v )
			<tr>
				<td>{{$v->id}}</td>
				<td><a href="{{ route('admin_show_post', ['id'=>$v->id]) }}">{{$v->title}}</a></td>
				{{-- <td>{{$v->slug}}</td> --}}
				<td>{{$v->status}}</td>
				<td><?php
					if ( $v->category !== null )
						echo $v->category[0]['name'];
					else
						echo '<div>无分类 <i class="glyphicon glyphicon-warning-sign text-danger"></i></td>';
				?></td>
				<td>{{$v->type}}</td>
				<td>{{$v->created_at->format('y/m/d H:i')}}</td>
				<td>{{$v->updated_at->format('y/m/d H:i')}}</td>
				<td>
					<a href="{{ route('admin_edit_post', ['id'=>$v->id]) }}">
						<button class="btn btn-primary btn-sm pull-left"><i class="glyphicon glyphicon-pencil"></i></button>
					</a>
					<form class="pull-left" action="{{ route('admin_destroy_post', ['id'=>$v->id]) }}" method="post">
						<input type="hidden" name="_method" value="DELETE">
						{{csrf_field()}}
						<button class="confirm_button btn btn-danger btn-sm pull-left"><i class="glyphicon glyphicon-remove"></i></button>
					</form>
				</td>
			</tr>
		@endforeach
		</table>
		{!! $posts->render() !!}
	</div>



@stop
