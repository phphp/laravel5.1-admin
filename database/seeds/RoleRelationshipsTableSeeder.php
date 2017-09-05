<?php

use Illuminate\Database\Seeder;

// use
use App\RoleRelationship;

class RoleRelationshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('role_relationships')->delete();
        RoleRelationship::create([
            'user_id' => '1',
            'role_id' => '1',
        ]);
        RoleRelationship::create([
            'user_id' => '2',
            'role_id' => '2',
        ]);
    }
}
