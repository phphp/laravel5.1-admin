<?php

use Illuminate\Database\Seeder;

// use
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
        Permission::create([
            'name' => '角色操作 (CRUD)',
            'url' => 'admin/role',
            'code' => 'ADMIN_CRUD_ROLE',
            'sort' => 1,
        ]);
        Permission::create([
            'name' => '权限操作 (CRUD)',
            'url' => 'admin/permission',
            'code' => 'ADMIN_CRUD_PERMISSION',
            'sort' => 2,
        ]);
        Permission::create([
            'name' => '用户管理 (CURD)',
            'url' => 'admin/user',
            'code' => 'ADMIN_CURD_USER',
            'sort' => 3,
        ]);
        
        Permission::create([
            'name' => '文件管理',
            'url' => 'admin/filesystem',
            'code' => 'ADMIN_FILESYSTEM',
            'sort' => 4,
        ]);
        Permission::create([
            'name' => '文章操作 (CRUD)',
            'url' => 'admin/post',
            'code' => 'ADMIN_CRUD_POST',
            'sort' => 5,
        ]);
        Permission::create([
            'name' => '修改个人信息',
            'url' => 'admin/profile',
            'code' => 'UPDATE_SELF_PROFILE',
            'sort' => 6,
        ]);
        Permission::create([
            'name' => '网站配置',
            'url' => 'admin/config',
            'code' => 'ADMIN_CONFIG_SETTING',
            'sort' => 7,
        ]);
    }
}
