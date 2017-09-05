@extends('admin/main')


@section('title')新建权限@stop


@section('content')

	@include('admin/permission/breadcrumb')

	<form action="{{ route('permission_store') }}" method="post">
		{{csrf_field()}}
		<div class="form-group">
			<label>权限名称</label>
			<input type="text" class="form-control" name="name" placeholder="" required="required">
		</div>
		<div class="form-group">
			<label>URL</label>
			<input type="text" class="form-control" name="url" placeholder="" required="required">
		</div>
		<div class="form-group">
			<label>CODE</label>
			<input type="text" class="form-control" name="code" placeholder="" required="required">
		</div>

		<button type="submit" class="btn btn-primary">新建</button>
	</form>

@stop


@section('tip')
<div class="tip-container">
    <i class="glyphicon glyphicon-info-sign"></i>
    <div class="tips">
        <dl class="list-unstyled">
            <dd>自动通过 URL 判断权限，如拥有 "角色操作 (CRUD)" 权限的 role 可以访问地址为 /admin/role 的页面，也可以访问其下所有页面，如：/admin/role/create。</dd>
            <dd>CODE 只会在代码中编写相关程序时候用到。</dd>
            <dd>所有内容都不能和已有权限重名。</dd>
        </dl>
    </div>
</div>
@stop
