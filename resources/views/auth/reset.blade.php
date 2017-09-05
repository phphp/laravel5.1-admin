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

        <form class="form-horizontal" method="post" action="{{ route('password_post_reset') }}" id="admin_login_form">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
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
                    <label for="inputPassword">新密码</label>
                </div>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2 control-label">
                    <label for="inputPasswordConfirmation">确认密码</label>
                </div>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirmation" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">重置密码</button>
                </div>
            </div>
        </form>

    </div>
</body>
</html>