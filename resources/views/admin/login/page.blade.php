<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="robots" content="noindex,nofollow">
	<title>登录</title>
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/admin.css">
</head>
<body class="signin_body">

	<div class="signin_form_container">

		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		@if (Session::has('message'))
			<div class="alert alert-success">
				<p>{{ Session::get('message') }}</p>
			</div>
		@endif

		<form class="form-horizontal" method="post" action="{{ route('admin_login_auth') }}" id="admin_login_form">
			{{csrf_field()}}
			<div class="form-group row">
				<div class="col-sm-2 control-label">
					<label for="inputName">Name</label>
				</div>
				<div class="col-sm-10">
					<input name="name" type="text" class="form-control" id="inputName" placeholder="Name" value="{{ old('name') }}" required="required" autofocus="autofocus">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 control-label">
					<label for="inputPassword">Password</label>
				</div>
				<div class="col-sm-10">
					<input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password" minlength="{{ config('admin.password_min_length') }}" required="required">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2 control-label">
					<label for="inputCaptcha">Captcha</label>
				</div>
				<div class="col-sm-10">
					<input name="captcha" type="text" class="form-control" id="inputCaptcha" placeholder="Captcha" siez="4" maxlength="4" required="required">
					<img style="cursor: pointer" id="inputCaptchaImg" src="{{ route('admin_login_captcha') }}" onclick="this.src='{{ route('admin_login_captcha') }}?r='+Math.random();" alt="Captcha">
				</div>
			</div>
			<div class="form-group row">
				<div class="checkbox col-sm-offset-2 col-sm-3">
					<label>
						<input name="remember" type="checkbox" checked="checked"> 记住我
					</label>
				</div>
				<div class="checkbox col-sm-offset-5 col-sm-2">
					<a href="{{ route('password_get_email') }}" style="color: #BBB">找回密码</a>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">Sign in</button>
				</div>
			</div>
		</form>

	</div>

<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>