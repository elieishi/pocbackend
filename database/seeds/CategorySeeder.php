<?php

use App\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $categories = [ 'Furniture', 'Electronics', 'Cars', 'Property'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categories as $category)
        {
            Category::create([
                'name' => $category,
                'slug' => SlugService::createSlug(Category::class, 'slug', $category)
            ]);
        }
    }
}
