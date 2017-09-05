<nav class="navbar navbar-default navbar-inverse my_nav">
	<div class="container-fluid">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ route('dashboard_homepage') }}">{{config('admin.brand')}}</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

			<ul class="nav navbar-nav">

				<li class="{{ is_route('dashboard_homepage') ? 'active' : '' }}">
					<a href="{{ route('dashboard_homepage') }}">首页</a>
				</li>

				<li class="dropdown {{ ( Request::is('admin/post*') || Request::is('admin/category*') || Request::is('admin/tag*') ) ? 'active' : '' }}">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">文章 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin_post') }}">文章列表</a></li>
						<li><a href="{{ route('admin_create_post') }}">添加文章</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('admin_category') }}">分类列表</a></li>
						<li><a href="{{ route('admin_create_category') }}">添加分类</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('admin_tag') }}">标签列表</a></li>
						<li><a href="{{ route('admin_create_tag') }}">添加标签</a></li>
					</ul>
				</li>

				<li class="dropdown {{ (Request::is('admin/user*')) ? 'active' : '' }}">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">用户 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('user_index') }}">用户列表</a></li>
						<li><a href="{{ route('user_create') }}">添加用户</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('oauth_user') }}">OAuth用户</a></li>
					</ul>
				</li>

				<li class="dropdown {{ ( Request::is('admin/config*') || Request::is('admin/role*') || Request::is('admin/permission*') ) ? 'active' : '' }}">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">设置 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin_config') }}">网站设置</a></li>
						<li><a href="{{ route('role_index') }}">角色设置</a></li>
						<li><a href="{{ route('permission_index') }}">权限设置</a></li>
					</ul>
				</li>

				<li class="{{ (is_route('admin_filesystem')) ? 'active' : '' }}"><a href="{{ route('admin_filesystem') }}">文件管理</a></li>


				<li class="{{ (is_route('admin_queues')) ? 'active' : '' }}"><a href="{{ route('admin_queues') }}">队列</a></li>


				<li><a href="{{ route('admin_logs') }}" target="_bland">日志</a></li>

			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li><a href="/">前台首页</a></li>
				<li class="dropdown {{ (Request::is('admin/profile')) ? 'active' : '' }}">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Request::user()->name}} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin_profile') }}">个人设置</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('admin_logout', ['token'=>csrf_token()]) }}">退出</a></li>
					</ul>
				</li>
				<li><img src="/uploads/avatar/{{Request::user()->avatar}}-m.jpg" class="avatar-small"></li>
			</ul>

		</div><!-- /.navbar-collapse -->

	</div><!-- /.container-fluid -->
</nav>
