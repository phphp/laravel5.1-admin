@extends('admin/main')


@section('title')编辑用户@stop


@section('js')<link href="https://cdn.bootcss.com/jquery-jcrop/0.9.12/css/jquery.Jcrop.css" rel="stylesheet">@stop


@section('content')

	<div class="col-md-7">
		<form action="{{ route('user_update', ['id'=>$user->id]) }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			{{ method_field('PATCH') }}

			<div id="rgbaster-container">
				<img id="rgbaster" src="/uploads/avatar/{{$user->avatar}}-s.jpg">
			</div>

			<div class="form-group">
				<label>name</label>
				<input type="text" class="form-control" name="name" placeholder="" value="{{ $user->name }}" required="required">
			</div>
			<div class="form-group">
				<label>email</label>
				<input type="text" class="form-control" name="email" placeholder="" value="{{ $user->email }}">
			</div>
			<div class="form-group">
				<label>新密码</label>
				<input type="password" class="form-control" name="password" placeholder="新密码，不填写则使用原密码" id="password">
			</div>
			<div class="form-group">
				<label>确认密码</label>
				<input type="password" class="form-control" name="password_confirmation" placeholder="与上面输入的密码保持一致" id="rePassword">
			</div>
			<div class="form-group">
				<label>用户状态</label>
			</div>
			<div class="form-group">
				<label><input type="radio" name="active" value="1" {{$user->active=='1' ? 'checked="checked"' : ''}}> 激活 </label>
				<label><input type="radio" name="active" value="0" {{$user->active=='0' ? 'checked="checked"' : ''}}> 未激活 </label>
			</div>
			<div class="form-group">
				<label>访问后台</label>
			</div>
			<div class="form-group">
				<label><input type="radio" name="admin" value="1" {{$user->admin=='1' ? 'checked="checked"' : ''}}> 允许 </label>
				<label><input type="radio" name="admin" value="0" {{$user->admin=='0' ? 'checked="checked"' : ''}}> 禁止 </label>
			</div>
			<div class="form-group">
				<label>选择用户</label>
			</div>
			@foreach ( $allRoles as $v )
			<div class="form-group">
				<label class="checkbox-inline" title="{{ $v['name'] }}" style="display:block">
					<input
					@foreach ($roles as $value)
						@if ( $value->id == $v->id )
							checked="checked"
						@endif
					@endforeach
					type="checkbox" name="roles[]" value="{{ $v->id }}"> {{ $v->name }}
				</label>
			</div>
			@endforeach

			<hr>
				<div class="form-group">
					<label>选择头像</label>
				</div>
					<img id="jcrop" src="/uploads/avatar/{{$user->avatar}}-l.jpg">
					<div class="preview-container">
						<img class="avatar-l" src="/uploads/avatar/{{$user->avatar}}-l.jpg">
						<img class="avatar-m" src="/uploads/avatar/{{$user->avatar}}-l.jpg">
						<img class="avatar-s" src="/uploads/avatar/{{$user->avatar}}-l.jpg">
					</div>
					<p></p>
					<p class="help-block">拖动选框以选择合适的头像；不上传新文件，则依旧使用旧头像</p>
					<div class="form-group">
						<label>选择上传文件</label>
						<input type="file" id="upload_avatar" name="avatar">
						<input type="hidden" id="avatar_size" name="avatar_size">
					</div>

			<hr>
			<button type="submit" class="btn btn-primary">修改用户</button>
		</form>
	</div>


@stop


@section('js_bottom')
<script src="https://lib.sinaapp.com/js/jquery-ui/1.9.2/jquery-ui.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-jcrop/0.9.12/js/jquery.Jcrop.js"></script>
<script src="/js/jcrop.js"></script>
<script src="/js/rgbaster.js"></script>
@stop
