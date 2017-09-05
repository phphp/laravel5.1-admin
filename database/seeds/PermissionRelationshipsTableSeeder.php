<?php

use Illuminate\Database\Seeder;

// use
use App\PermissionRelationship;

class PermissionRelationshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_relationships')->delete();
        PermissionRelationship::create([
            'role_id' => '1',
            'permission_id' => '1',
        ]);
        PermissionRelationship::create([
            'role_id' => '1',
            'permission_id' => '2',
        ]);
        PermissionRelationship::create([
            'role_id' => '1',
            'permission_id' => '3',
        ]);
        PermissionRelationship::create([
            'role_id' => '1',
            'permission_id' => '4',
        ]);
        PermissionRelationship::create([
            'role_id' => '1',
            'permission_id' => '5',
        ]);
        PermissionRelationship::create([
            'role_id' => '1',
            'permission_id' => '6',
        ]);
        PermissionRelationship::create([
            'role_id' => '1',
            'permission_id' => '7',
        ]);
        PermissionRelationship::create([
            'role_id' => '2',
            'permission_id' => '2',
        ]);
        PermissionRelationship::create([
            'role_id' => '2',
            'permission_id' => '3',
        ]);
        PermissionRelationship::create([
            'role_id' => '2',
            'permission_id' => '4',
        ]);
        PermissionRelationship::create([
            'role_id' => '2',
            'permission_id' => '5',
        ]);
        PermissionRelationship::create([
            'role_id' => '2',
            'permission_id' => '6',
        ]);
    }
}
