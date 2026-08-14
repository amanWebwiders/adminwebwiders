<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Http\Requests\Admin\UploadImageRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs with search & filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $categoryId = $request->query('category_id');

        $blogs = Blog::query()
            ->with('category')
            ->when($search, function ($query, $search) {
                $query->search($search);
            })
            ->when($status, function ($query, $status) {
                if (in_array($status, ['draft', 'published'])) {
                    $query->where('status', $status);
                }
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.blogs.index', compact('blogs', 'search', 'status', 'categoryId', 'categories'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Unique slug generation
        $slugSource = !empty($data['slug']) ? $data['slug'] : $data['title'];
        $data['slug'] = $this->generateUniqueSlug($slugSource);

        // Featured image upload
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blogs', $filename, 'public');
            $data['featured_image'] = $path;
        }

        // Default published_at if published status set without explicit date
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog details in admin.
     */
    public function show(Blog $blog): View
    {
        $blog->load('category');

        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        $data = $request->validated();

        // Unique slug generation if title or slug changed
        $slugSource = !empty($data['slug']) ? $data['slug'] : $data['title'];
        $data['slug'] = $this->generateUniqueSlug($slugSource, $blog->id);

        // Featured image replacement
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blogs', $filename, 'public');
            $data['featured_image'] = $path;
        }

        // Set published_at if status changed to published and no date set
        if ($data['status'] === 'published' && empty($data['published_at']) && !$blog->published_at) {
            $data['published_at'] = now();
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Upload image directly inside CKEditor 5.
     */
    public function uploadImage(UploadImageRequest $request): JsonResponse
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . Str::random(12) . '.' . $file->getClientOriginalExtension();
            
            // Store in storage/app/public/blogs/content/
            $path = $file->storeAs('blogs/content', $filename, 'public');
            $url = asset('storage/' . $path);

            return response()->json([
                'uploaded' => true,
                'url' => $url,
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'Image upload failed. Please try again.',
            ],
        ], 400);
    }

    /**
     * Helper method to generate unique slug.
     */
    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Blog::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
