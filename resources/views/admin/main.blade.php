<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="robots" content="noindex,nofollow">
	<meta name="_token" content="{{ csrf_token() }}">
	<title>@yield('title') - 后台</title>
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/admin.css">
	<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	@yield('js')
</head>
<body>

	@include('admin/templates/header')


	<div class="container">
		<div class="with_msg">
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
		</div>
	</div>


	<div class="container">
		@yield('content')
	</div>


	@include('admin/templates/footer')


	@yield('tip')


	<script src="/js/admin.js"></script>


	@yield('js_bottom')
</body>
</html>