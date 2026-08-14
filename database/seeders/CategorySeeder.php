<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest trends, updates, and news in technology and digital software.',
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Guides, frameworks, and tutorials on modern full-stack web development.',
            ],
            [
                'name' => 'Mobile Apps',
                'slug' => 'mobile-apps',
                'description' => 'Insights into iOS, Android, and cross-platform app development.',
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => 'SEO, social media, and digital branding strategies for growth.',
            ],
            [
                'name' => 'AI & Cloud',
                'slug' => 'ai-and-cloud',
                'description' => 'Artificial intelligence, machine learning, and cloud infrastructure.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Assign default category (Web Development) to existing blogs if uncategorized
        $defaultCategory = Category::where('slug', 'web-development')->first();
        if ($defaultCategory) {
            Blog::whereNull('category_id')->update(['category_id' => $defaultCategory->id]);
        }
    }
}
