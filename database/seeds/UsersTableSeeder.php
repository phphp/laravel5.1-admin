<?php

use Illuminate\Database\Seeder;

// use
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create([
            'name' => 'admin',
            'email' => 'admin@your.email',
            'password' => 'secret',
            'active' => 1,
            'admin' => 1,
        ]);
        User::create([
            'name' => 'visitor',
            'email' => 'visitor@your.email',
            'password' => 'secret',
            'active' => 1,
            'admin' => 1,
        ]);

    }
}
