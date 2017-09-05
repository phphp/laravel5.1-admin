<?php

use Illuminate\Database\Seeder;

// use
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        Role::create([
            'name' => '超级管理员',
            'sort' => 1,
        ]);
        Role::create([
            'name' => '管理员',
            'sort' => 2,
        ]);
        Role::create([
            'name' => '后台游客',
            'sort' => 3,
        ]);
        Role::create([
            'name' => '普通会员',
            'sort' => 4,
        ]);
    }
}
