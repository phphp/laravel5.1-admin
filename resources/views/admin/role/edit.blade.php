@extends('admin/main')


@section('title')编辑角色@stop


@section('content')

	@include('admin/role/breadcrumb')

	<form action="{{ route('role_update', ['id'=>$role->id]) }}" method="post">
		{{csrf_field()}}
		<div class="form-group">
			<label>角色名称</label>
			<input type="text" class="form-control" name="name" placeholder="name" value="{{ $role->name }}" required="required">
		</div>
		<div class="form-group">
			<label>选择权限</label>
		</div>
		@foreach ( $allPermissions as $v )
		<div class="form-group">
			<label class="checkbox-inline" title="{{ $v['url'] }}" style="display:block">
				<input
				@foreach ($permissions as $value)
					@if ( $value->id == $v->id )
						checked="checked"
					@endif
				@endforeach
				type="checkbox" name="permissions[]" value="{{ $v->id }}"> {{ $v->name }} <span class="text-warning">({{ $v->url }})</span>
			</label>
		</div>
		@endforeach
		<button type="submit" class="btn btn-primary">修改</button>
	</form>



@stop

