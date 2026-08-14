@extends('frontend.layouts.app')

@section('title', 'Latest Blogs & Tech Insights')

@section('breadcrumb_title', 'Blogs & Articles')
@section('breadcrumb_active', 'Blog Standard')

@section('content')
<!-- News Standard Section Start -->
<section class="news-standard-section section-padding">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="news-standard-wrapper">
                    @if($activeCategory)
                        <div class="alert alert-primary bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fa-solid fa-filter me-2 text-primary"></i>
                                Showing articles in <strong>"{{ $activeCategory->name }}"</strong> category
                            </div>
                            <a href="{{ route('frontend.blogs.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Clear Filter <i class="fa-solid fa-xmark ms-1"></i>
                            </a>
                        </div>
                    @endif

                    @forelse($blogs as $blog)
                        <div class="news-standard-items mb-4">
                            <div class="thumb position-relative">
                                <a href="{{ route('frontend.blogs.show', $blog->slug) }}">
                                    @if($blog->featured_image_url)
                                        <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" style="width: 100%; height: 380px; object-fit: cover; border-radius: 16px;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="width: 100%; height: 280px; border-radius: 16px;">
                                            <i class="fa-regular fa-image fs-1 opacity-50"></i>
                                        </div>
                                    @endif
                                </a>
                                @if($blog->category)
                                    <a href="{{ route('frontend.blogs.index', ['category' => $blog->category->slug]) }}" class="badge bg-primary text-white position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill text-decoration-none shadow-sm fw-semibold">
                                        <i class="fa-solid fa-tag me-1"></i> {{ $blog->category->name }}
                                    </a>
                                @endif
                            </div>
                            <div class="content pt-4">
                                <ul class="post-cat d-flex align-items-center gap-4 mb-3 text-muted small">
                                    <li>
                                        <i class="fa-regular fa-user me-1 text-primary"></i>
                                        By Admin
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-calendar-days me-1 text-primary"></i>
                                        {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}
                                    </li>
                                    @if($blog->category)
                                        <li>
                                            <i class="fa-solid fa-folder me-1 text-primary"></i>
                                            <a href="{{ route('frontend.blogs.index', ['category' => $blog->category->slug]) }}" class="text-secondary text-decoration-none">
                                                {{ $blog->category->name }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <h3>
                                    <a href="{{ route('frontend.blogs.show', $blog->slug) }}">
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                <p class="mt-2 mb-4">
                                    {{ Str::limit($blog->short_description ?: strip_tags($blog->content), 180) }}
                                </p>
                                <a href="{{ route('frontend.blogs.show', $blog->slug) }}" class="theme-btn">
                                    Read Details <i class="fa-regular fa-arrow-right-long ms-2"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 bg-light rounded-4 my-4 p-5">
                            <i class="fa-solid fa-newspaper fs-1 text-muted opacity-50 mb-3"></i>
                            <h4 class="fw-bold">No Articles Found</h4>
                            <p class="text-muted">We couldn't find any published blog posts matching your search criteria.</p>
                            @if(request('search') || request('category'))
                                <a href="{{ route('frontend.blogs.index') }}" class="theme-btn mt-3">Clear Filters</a>
                            @endif
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($blogs->hasPages())
                        <div class="page-nav-wrap pt-5 text-center">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-12 col-lg-4">
                <div class="main-sidebar sticky-style">
                    <!-- Search Widget -->
                    <div class="single-sidebar-widget mb-4">
                        <div class="wid-title">
                            <h4>Search Articles</h4>
                        </div>
                        <div class="search-widget">
                            <form action="{{ route('frontend.blogs.index') }}" method="GET">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles...">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    @if($categories->count() > 0)
                        <div class="single-sidebar-widget mb-4">
                            <div class="wid-title">
                                <h4>Categories</h4>
                            </div>
                            <div class="news-cat-list">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <a href="{{ route('frontend.blogs.index') }}" class="d-flex justify-content-between align-items-center p-2 rounded-3 text-decoration-none {{ !request('category') ? 'bg-primary text-white fw-bold px-3' : 'text-dark hover-bg-light' }}">
                                            <span>All Categories</span>
                                        </a>
                                    </li>
                                    @foreach($categories as $cat)
                                        <li class="mb-2">
                                            <a href="{{ route('frontend.blogs.index', ['category' => $cat->slug]) }}" class="d-flex justify-content-between align-items-center p-2 rounded-3 text-decoration-none {{ request('category') === $cat->slug ? 'bg-primary text-white fw-bold px-3' : 'text-dark hover-bg-light' }}">
                                                <span><i class="fa-solid fa-chevron-right fs-6 me-2 opacity-50"></i> {{ $cat->name }}</span>
                                                <span class="badge {{ request('category') === $cat->slug ? 'bg-white text-primary' : 'bg-light text-muted' }} rounded-pill">{{ $cat->blogs_count }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- About Widget -->
                    <div class="single-sidebar-widget mb-4">
                        <div class="wid-title">
                            <h4>About Webwiders</h4>
                        </div>
                        <div class="news-content">
                            <p>
                                Webwiders Software Solutions brings you expert technical insights, blog articles, and tutorials on modern technology and digital strategies.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
