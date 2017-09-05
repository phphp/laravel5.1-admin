<ol class="breadcrumb">
	<li><a href="{{ route('role_index') }}" {!! is_route('role_index') ? 'style="color:#555"' : '' !!}>所有角色</a></li>
    <li><a href="{{ route('role_create') }}" {!! is_route('role_create') ? 'style="color:#555"' : '' !!}>新建角色</a></li>
	<li><a href="{{ route('update_roles_cache') }}" title="角色和权限有缓存，更新以生效修改">更新缓存</a></li>
</ol>
<p></p>
