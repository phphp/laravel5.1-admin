<?php

use Illuminate\Database\Seeder;

// use
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 		DB::table('categories')->delete();
        Category::create([
            'name' => '默认',
            'slug' => 'default',
            'sort' => 1,
        ]);
    }
}
