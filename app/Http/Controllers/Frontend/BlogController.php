<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display listing of published blogs on public frontend.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $categorySlug = $request->query('category');

        $activeCategory = null;
        if ($categorySlug) {
            $activeCategory = Category::where('slug', $categorySlug)->first();
        }

        $blogs = Blog::published()
            ->with('category')
            ->when($search, function ($query, $search) {
                $query->search($search);
            })
            ->when($categorySlug, function ($query, $slug) {
                $query->category($slug);
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::withCount(['blogs' => function ($query) {
            $query->published();
        }])->orderBy('name')->get();

        return view('frontend.blogs.index', compact('blogs', 'search', 'categorySlug', 'activeCategory', 'categories'));
    }

    /**
     * Display a single published blog post by slug.
     */
    public function show(string $slug): View
    {
        $blog = Blog::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $categories = Category::withCount(['blogs' => function ($query) {
            $query->published();
        }])->orderBy('name')->get();

        return view('frontend.blogs.show', compact('blog', 'categories'));
    }
}
