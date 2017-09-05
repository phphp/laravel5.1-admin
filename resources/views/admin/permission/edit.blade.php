@extends('admin/main')


@section('title')编辑权限@stop


@section('content')

	@include('admin/permission/breadcrumb')

	<form action="{{ route('permission_update', ['id'=>$permission->id]) }}" method="post">
		{{csrf_field()}}
		<div class="form-group">
			<label>NAME</label>
			<input type="text" class="form-control" name="name" placeholder="" value="{{ $permission->name }}" required="required">
		</div>
		<div class="form-group">
			<label>URL</label>
			<input type="text" class="form-control" name="url" placeholder="" value="{{ $permission->url }}" required="required">
		</div>
		<div class="form-group">
			<label>CODE</label>
			<input type="text" class="form-control" name="code" placeholder="" value="{{ $permission->code }}" required="required">
		</div>
		<button type="submit" class="btn btn-primary">修改</button>
	</form>



@stop

