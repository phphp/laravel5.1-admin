@extends('admin/main')


@section('title')编辑标签@stop


@section('content')

	<form action="{{ route('admin_update_tag', ['id'=>$tag->id]) }}" method="post">
		{{csrf_field()}}
		<div class="form-group">
			<label>name</label>
			<input type="text" class="form-control" name="name" placeholder="name" value="{{ $tag->name }}" required="required">
		</div>
		<div class="form-group">
			<label>slug</label>
			<input type="text" class="form-control" name="slug" placeholder="slug" value="{{ $tag->slug }}" required="required">
		</div>
		<button type="submit" class="btn btn-primary">修改</button>
	</form>



@stop

