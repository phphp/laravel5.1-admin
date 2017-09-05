<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="robots" content="noindex,nofollow">
    <title>找回密码</title>
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
        @if (Session::has('status'))
            <div class="alert alert-success">
                <p>{{ Session::get('status') }}</p>
            </div>
        @endif

        <form class="form-horizontal" method="post" action="{{ route('password_post_email') }}" id="admin_login_form">
            {{csrf_field()}}
            <div class="form-group row">
                <div class="col-sm-2 control-label">
                    <label for="inputEmail">Email</label>
                </div>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="注册邮箱地址" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2 control-label">
                    <label for="inputCaptcha">Captcha</label>
                </div>
                <div class="col-sm-10">
                    <input name="captcha" type="text" class="form-control" id="inputCaptcha" placeholder="Captcha" minlength="4" maxlength="4" required>
                    <img style="cursor: pointer" id="inputCaptchaImg" src="{{ route('admin_login_captcha') }}" onclick="this.src='{{ route('admin_login_captcha') }}?r='+Math.random();" alt="Captcha">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">发送重置密码邮件</button>
                </div>
            </div>
        </form>

    </div>
</body>
</html>