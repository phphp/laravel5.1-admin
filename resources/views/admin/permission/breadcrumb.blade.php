<ol class="breadcrumb">
	<li><a href="{{ route('permission_index') }}" {!! is_route('permission_index') ? 'style="color:#555"' : '' !!}>所有权限</a></li>
    <li><a href="{{ route('permission_create') }}" {!! is_route('permission_create') ? 'style="color:#555"' : '' !!}>新建权限</a></li>
    <li><a href="{{ route('update_roles_cache') }}" title="角色和权限有缓存，更新以生效修改">更新缓存</a></li>
</ol>
<p></p>
