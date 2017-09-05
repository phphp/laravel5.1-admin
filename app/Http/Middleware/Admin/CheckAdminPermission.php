<?php

namespace App\Http\Middleware\Admin;

use Closure;

// use
use App\User;
use App\Role;
use App\Permission;
use Cache;
use Carbon\Carbon;

class CheckAdminPermission
{
    /**
     * 验证已经登录的用户是否有权限访问本页面
     * note:
     *      在 routes.php 相应的规则调用 'checkPermission' 中间件
     *      根据用户 id 查询 roles 再查询 permissions，用 permissions.url 和本次访问链接对比判断是否有权限访问
     *      每日缓存一次 roles permissions 对照数组
     *      如果用户没有分配角色，默认无法访问
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 用户角色 ID 数组
        $userRoles = User::find($request->user()->id)->roles->toArray();
        foreach ( $userRoles as $v )
        {
            $tmp[] = $v['id'];
        }
        $userRoles = $tmp;

        // 角色权限
        if ( !Cache::has('roles') )
        {
            $permissions = Permission::all();
            foreach ( $permissions as $permission )
            {
                $tmp = [];
                foreach ( $permission->roles as $role )
                {
                    $tmp[$role->name] = $role->id;
                }
                $roles[$permission->url] = $tmp;
            }
            /**
             * dd($roles);
             * roles = [
             *     url1 => [roleName1=>roleID1, roleName2=>roleID2 ...]
             *     url2 => [roleName1=>roleID1, roleName2=>roleID2 ...]
             * ]
             */
            $expiresAt = Carbon::today()->addDay(1);
            Cache::store('file')->put('roles', $roles, $expiresAt);
        }
        else
        {
            $roles = Cache::get('roles');
        }

        // 检查访问路径是否可以被用户角色
        foreach ( $roles as $k=>$v )
        {
            if ( $request->is($k.'*') )
            {
                if ( array_intersect($userRoles, $v) ) return $next($request);
            }
        }

        abort( 403, '没有权限访问本页面' );
    }
}
