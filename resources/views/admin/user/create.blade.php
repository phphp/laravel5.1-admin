@extends('admin/main')


@section('title')新建用户@stop


@section('js')<link href="https://cdn.bootcss.com/jquery-jcrop/0.9.12/css/jquery.Jcrop.css" rel="stylesheet">@stop


@section('content')

	<div class="col-md-7">
		<form action="{{ route('user_store') }}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<div class="form-group">
				<label>用户名称</label>
				<input type="text" class="form-control" name="name" placeholder="name" value="{{old('name')}}" required="required">
			</div>
			<div class="form-group">
				<label>email</label>
				<input type="email" class="form-control" name="email" placeholder="email" value="{{old('email')}}" required="required">
			</div>
			<div class="form-group">
				<label>password</label>
				<input type="password" class="form-control" name="password" placeholder="password" required="required">
			</div>
			<div class="form-group">
				<label><input type="checkbox" name="active" value="1" @if (old('active')) checked="checked" @endif> active </label>
			</div>
			<div class="form-group">
				<label><input type="checkbox" name="admin" value="1" @if (old('admin')) checked="checked" @endif> admin </label>
			</div>
			<div class="form-group">
				<label>选择角色</label>
			</div>
			@foreach ( $roles as $v )
			<div class="form-group">
				<label class="checkbox-inline" title="{{ $v['url'] }}" style="display:block">
					<input type="checkbox" name="roles[]" value="{{ $v->id }}"> {{ $v->name }}
				</label>
			</div>
			@endforeach

			<hr>
				<div class="form-group">
					<label>选择头像</label>
				</div>
					<img id="jcrop" src="/uploads/avatar/default.jpg">
					<div class="preview-container">
						<img class="avatar-l" src="/uploads/avatar/default.jpg">
						<img class="avatar-m" src="/uploads/avatar/default.jpg">
						<img class="avatar-s" src="/uploads/avatar/default.jpg">
					</div>
					<p></p>
					<p class="help-block">拖动选框以选择合适的头像</p>
					<div class="form-group">
						<label>选择上传文件</label>
						<input type="file" id="upload_avatar" name="avatar">
						<input type="hidden" id="avatar_size" name="avatar_size">
					</div>

			<hr>
			<button type="submit" class="btn btn-primary">新建用户</button>
		</form>
	</div>

@stop


@section('tip')
<div class="tip-container">
    <i class="glyphicon glyphicon-info-sign"></i>
    <div class="tips">
        <dl class="list-unstyled">
            <dd>用用户、邮箱不能重复。</dd>
            <dd>密码有长度限制，在配置文件中配置。</dd>
            <dd>active 表示是否激活用户，激活的用户可以登录账号。</dd>
            <dd>admin 表示是否能够登录访问后台，管理员用户可以访问后台。</dd>
            <dd>角色的权限可访问角色／权限页面查看详细。</dd>
            <dd>限制上传的文件大小，在配置文件中配置。</dd>
        </dl>
    </div>
</div>
@stop


@section('js_bottom')
<script src="https://lib.sinaapp.com/js/jquery-ui/1.9.2/jquery-ui.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-jcrop/0.9.12/js/jquery.Jcrop.js"></script>
<script src="/js/jcrop.js"></script>
@stop
