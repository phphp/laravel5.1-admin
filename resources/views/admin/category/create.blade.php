@extends('admin/main')


@section('title')新建分类@stop


@section('content')

	<form action="{{ route('admin_store_category') }}" method="post">
		{{csrf_field()}}
		<div class="form-group">
			<label>name</label>
			<input type="text" class="form-control" name="name" placeholder="name" value="{{old('name')}}" required="required">
		</div>
		<div class="form-group">
			<label>slug</label>
			<input type="text" class="form-control" name="slug" placeholder="slug" value="{{old('slug')}}" required="required">
		</div>
		<button type="submit" class="btn btn-primary">新建</button>
	</form>



@stop

