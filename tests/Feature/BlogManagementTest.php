<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::create([
            'name' => 'System Admin',
            'email' => 'admin@blog.com',
            'password' => bcrypt('password123'),
        ]);

        Storage::fake('public');
    }

    public function test_admin_can_view_blogs_index()
    {
        $response = $this->actingAs($this->admin, 'admin')->get('/admin/blogs');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_a_published_blog_post()
    {
        $image = UploadedFile::fake()->image('featured.jpg');

        $response = $this->actingAs($this->admin, 'admin')->post('/admin/blogs', [
            'title' => 'Test Blog Post Title',
            'short_description' => 'Test short description',
            'content' => '<p>Test content body</p>',
            'status' => 'published',
            'featured_image' => $image,
        ]);

        $response->assertRedirect('/admin/blogs');

        $this->assertDatabaseHas('blogs', [
            'title' => 'Test Blog Post Title',
            'slug' => 'test-blog-post-title',
            'status' => 'published',
        ]);
    }

    public function test_admin_can_upload_ckeditor_image()
    {
        $image = UploadedFile::fake()->image('content_image.png');

        $response = $this->actingAs($this->admin, 'admin')->postJson('/admin/blogs/upload-image', [
            'upload' => $image,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['uploaded', 'url']);
    }

    public function test_public_user_can_view_published_blogs_only()
    {
        $published = Blog::create([
            'title' => 'Published Article',
            'slug' => 'published-article',
            'content' => '<p>Published text</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $draft = Blog::create([
            'title' => 'Draft Article',
            'slug' => 'draft-article',
            'content' => '<p>Draft text</p>',
            'status' => 'draft',
        ]);

        // Public index lists published
        $response = $this->get('/blogs');
        $response->assertStatus(200)
            ->assertSee('Published Article')
            ->assertDontSee('Draft Article');

        // Public detail loads published
        $response = $this->get('/blog/published-article');
        $response->assertStatus(200);

        // Draft article returns 404
        $response = $this->get('/blog/draft-article');
        $response->assertStatus(404);
    }
}
