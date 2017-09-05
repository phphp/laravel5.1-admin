@extends('admin/main')


@section('title')编辑分类@stop


@section('content')

	<form action="{{ route('admin_update_category', ['id'=>$category->id]) }}" method="post">
		{{csrf_field()}}
		<div class="form-group">
			<label>name</label>
			<input type="text" class="form-control" name="name" placeholder="name" value="{{ $category->name }}" required="required">
		</div>
		<div class="form-group">
			<label>slug</label>
			<input type="text" class="form-control" name="slug" placeholder="slug" value="{{ $category->slug }}" required="required">
		</div>
		<button type="submit" class="btn btn-primary">修改</button>
	</form>



@stop

