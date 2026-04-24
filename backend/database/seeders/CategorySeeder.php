<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Appetizers',
                'slug' => 'appetizers',
                'description' => 'Start your meal with our delicious appetizers',
                'image_url' => 'https://images.unsplash.com/photo-1541014741259-de529411b96a?w=400&h=300&fit=crop',
                'sort_order' => 1,
            ],
            [
                'name' => 'Main Course',
                'slug' => 'main-course',
                'description' => 'Hearty and flavorful main dishes',
                'image_url' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=300&fit=crop',
                'sort_order' => 2,
            ],
            [
                'name' => 'Seafood',
                'slug' => 'seafood',
                'description' => 'Fresh catches from the ocean',
                'image_url' => 'https://images.unsplash.com/photo-1551248429-40975aa4de74?w=400&h=300&fit=crop',
                'sort_order' => 3,
            ],
            [
                'name' => 'Pasta',
                'slug' => 'pasta',
                'description' => 'Handmade pasta with authentic sauces',
                'image_url' => 'https://images.unsplash.com/photo-1473093295043-cdd812d0e601?w=400&h=300&fit=crop',
                'sort_order' => 4,
            ],
            [
                'name' => 'Steaks',
                'slug' => 'steaks',
                'description' => 'Premium cuts cooked to perfection',
                'image_url' => 'https://images.unsplash.com/photo-1546241072-48010ad2862c?w=400&h=300&fit=crop',
                'sort_order' => 5,
            ],
            [
                'name' => 'Desserts',
                'slug' => 'desserts',
                'description' => 'Sweet endings to your meal',
                'image_url' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400&h=300&fit=crop',
                'sort_order' => 6,
            ],
            [
                'name' => 'Beverages',
                'slug' => 'beverages',
                'description' => 'Refreshing drinks and cocktails',
                'image_url' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=400&h=300&fit=crop',
                'sort_order' => 7,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
