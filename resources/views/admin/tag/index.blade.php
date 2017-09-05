@extends('admin/main')


@section('title')所有标签@stop


@section('content')

	<div class="table-responsive">

		<table class="table table-striped table-bordered" id="" ajax-url="{{route('admin_ajax_sort_category')}}">
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>slug</th>
				<th>操作</th>
			</tr>
		@foreach ( $tags as $v )
			<tr id="{{$v->id}}">
				<td>{{$v->id}}</td>
				<td><a href="{{ route('admin_show_tag', ['id'=>$v->id]) }}">{{$v->name}}</a></td>
				<td>{{$v->slug}}</td>
				<td>
					<a href="{{ route('admin_edit_tag', ['id'=>$v->id]) }}">
						<button class="btn btn-primary btn-sm pull-left"><i class="glyphicon glyphicon-pencil"></i></button>
					</a>
					<form class="pull-left" action="{{ route('admin_destroy_tag', ['id'=>$v->id]) }}" method="post">
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

