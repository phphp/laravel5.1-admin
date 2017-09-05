@extends('admin/main')


@section('title')新建角色@stop


@section('content')

	@include('admin/role/breadcrumb')

	<form action="{{ route('role_store') }}" method="post">
		{{csrf_field()}}
		<div class="form-group">
			<label>角色名称</label>
			<input type="text" class="form-control" name="name" placeholder="name" value="{{old('name')}}" required="required">
		</div>
		<div class="form-group">
			<label>选择权限</label>
		</div>
		@foreach ( $permissions as $v )
		<div class="form-group">
			<label class="checkbox-inline" title="{{ $v['url'] }}" style="display:block">
				<input type="checkbox" name="permissions[]" value="{{ $v->id }}"> {{ $v->name }} <span class="text-warning">({{ $v->url }})</span>
			</label>
		</div>
		@endforeach
		<button type="submit" class="btn btn-primary">新建</button>
	</form>

@stop


@section('tip')
<div class="tip-container">
    <i class="glyphicon glyphicon-info-sign"></i>
    <div class="tips">
        <dl class="list-unstyled">
            <dd>角色名不能重复。</dd>
            <dd>拥有权限的用户能够访问该页面和其下所有页面。</dd>
            <dd>选择权限中所有没有注明的 URL 默认所有用户都有权限访问。需要限制访问某页面的话，可在权限中添加该页面，并付给一些角色。</dd>
        </dl>
    </div>
</div>
@stop
