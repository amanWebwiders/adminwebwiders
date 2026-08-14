<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index(): View
    {
        $totalBlogs = Blog::count();
        $publishedBlogs = Blog::published()->count();
        $draftBlogs = Blog::draft()->count();
        $recentBlogs = Blog::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalBlogs',
            'publishedBlogs',
            'draftBlogs',
            'recentBlogs'
        ));
    }
}
