<?php

use Illuminate\Database\Seeder;

// use
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->delete();
        Tag::create([
            'name' => '默认标签',
            'slug' => 'default-tag',
        ]);
    }
}
