@extends('frontend.layouts.app')

@section('title', $blog->meta_title ?: $blog->title)
@section('meta_description', $blog->meta_description ?: ($blog->short_description ?: Str::limit(strip_tags($blog->content), 150)))
@section('meta_keywords', $blog->meta_keywords ?: 'blog, article, ' . Str::slug($blog->title, ', '))

@section('breadcrumb_title', Str::limit($blog->title, 40))
@section('breadcrumb_active', 'Blog Details')

@section('content')
<!-- News Details Section Start -->
<section class="news-details-section section-padding">
    <div class="container">
        <div class="news-details-wrapper">
            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="news-post-details">
                        <div class="single-news-post">
                            @if($blog->featured_image_url)
                                <div class="post-featured-thumb mb-4">
                                    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-100 rounded-4 object-fit-cover" style="max-height: 480px;">
                                </div>
                            @endif

                            <div class="post-content">
                                <ul class="post-list d-flex align-items-center gap-4 mb-3 text-muted small">
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
                                            <a href="{{ route('frontend.blogs.index', ['category' => $blog->category->slug]) }}" class="text-secondary text-decoration-none fw-semibold">
                                                {{ $blog->category->name }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                                <h2 class="mb-3 fw-bold text-dark">{{ $blog->title }}</h2>

                                @if($blog->short_description)
                                    <p class="lead text-secondary mb-4 fst-italic">
                                        {{ $blog->short_description }}
                                    </p>
                                @endif

                                <!-- Article Body Content -->
                                <div class="article-content mt-4 mb-5">
                                    {!! $blog->content !!}
                                </div>
                            </div>
                        </div>

                        <!-- Tag & Share Wrapper -->
                        <div class="row tag-share-wrap mt-4 mb-5 p-4 bg-light rounded-4 align-items-center">
                            <div class="col-lg-6 col-12">
                                <div class="tagcloud d-flex align-items-center gap-2">
                                    @if($blog->category)
                                        <span class="fw-semibold text-dark me-1">Category:</span>
                                        <a href="{{ route('frontend.blogs.index', ['category' => $blog->category->slug]) }}" class="btn btn-sm btn-primary rounded-pill px-3 me-2">
                                            <i class="fa-solid fa-tag me-1"></i> {{ $blog->category->name }}
                                        </a>
                                    @endif
                                    <a href="{{ route('frontend.blogs.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Back to all
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-3 mt-lg-0 text-lg-end">
                                <div class="social-share d-flex align-items-center justify-content-lg-end gap-2">
                                    <span class="me-2 fw-semibold text-dark">Share:</span>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($blog->title) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
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
                                    <input type="text" name="search" placeholder="Search articles...">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>
                        </div>

                        <!-- Categories Widget -->
                        @if(isset($categories) && $categories->count() > 0)
                            <div class="single-sidebar-widget mb-4">
                                <div class="wid-title">
                                    <h4>Categories</h4>
                                </div>
                                <div class="news-cat-list">
                                    <ul class="list-unstyled mb-0">
                                        @foreach($categories as $cat)
                                            <li class="mb-2">
                                                <a href="{{ route('frontend.blogs.index', ['category' => $cat->slug]) }}" class="d-flex justify-content-between align-items-center p-2 rounded-3 text-decoration-none {{ $blog->category_id === $cat->id ? 'bg-primary text-white fw-bold px-3' : 'text-dark hover-bg-light' }}">
                                                    <span><i class="fa-solid fa-chevron-right fs-6 me-2 opacity-50"></i> {{ $cat->name }}</span>
                                                    <span class="badge {{ $blog->category_id === $cat->id ? 'bg-white text-primary' : 'bg-light text-muted' }} rounded-pill">{{ $cat->blogs_count }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Back to List Widget -->
                        <div class="single-sidebar-widget mb-4">
                            <div class="wid-title">
                                <h4>Explore More</h4>
                            </div>
                            <div class="news-content text-center py-2">
                                <p class="mb-3 text-muted">Discover more insights and latest updates on our platform.</p>
                                <a href="{{ route('frontend.blogs.index') }}" class="theme-btn w-100 text-center">
                                    View All Articles <i class="fa-regular fa-arrow-right-long ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
