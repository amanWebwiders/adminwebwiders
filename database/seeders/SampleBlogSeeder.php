<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class SampleBlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::updateOrCreate(
            ['slug' => 'getting-started-with-laravel-13-ckeditor-5'],
            [
                'title' => 'Getting Started with Laravel 13 & CKEditor 5',
                'short_description' => 'A comprehensive guide on building production-ready admin portals and blog systems using Laravel 13, Bootstrap 5, and CKEditor 5 with rich media support.',
                'content' => '<h2>Introduction</h2><p>Laravel 13 introduces incredible features for modern web applications. In this article, we explore how to integrate rich media, uploaded images, and video embeds seamlessly.</p><blockquote><p>"Clean code, robust architecture, and security are the cornerstones of production readiness."</p></blockquote><h3>Embedding Media</h3><figure class="media"><iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe></figure><p>Check out our YouTube tutorial embedded above!</p><pre><code>// Example PHP snippet
$blog = Blog::published()->firstOrFail();</code></pre>',
                'meta_title' => 'Getting Started with Laravel 13 & CKEditor 5',
                'meta_description' => 'A comprehensive guide on building production-ready admin portals with Laravel 13.',
                'meta_keywords' => 'laravel 13, ckeditor 5, php, web development',
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'draft-article-upcoming-features'],
            [
                'title' => 'Draft Article: Upcoming Features in Next Release',
                'short_description' => 'This is a draft blog post that should not be visible on the public frontend.',
                'content' => '<p>Work in progress notes for upcoming release...</p>',
                'meta_title' => 'Draft Article',
                'meta_description' => 'Draft article notes.',
                'meta_keywords' => 'draft, upcoming',
                'status' => 'draft',
                'published_at' => null,
            ]
        );
    }
}
