@extends('admin.layouts.app')

@section('title', 'Preview: ' . $blog->title)
@section('page-header', 'Blog Post Preview')

@push('styles')
<style>
    .blog-content-body img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        margin: 1rem 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .blog-content-body blockquote {
        border-left: 4px solid #6A47ED;
        padding: 1rem 1.25rem;
        background-color: #F6F3FE;
        border-radius: 0 8px 8px 0;
        color: #2D1B69;
        font-style: italic;
        margin: 1.5rem 0;
    }
    .blog-content-body figure.media {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        margin: 1.5rem 0;
        border-radius: 0.75rem;
    }
    .blog-content-body figure.media iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    .blog-content-body table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    .blog-content-body table td, .blog-content-body table th {
        border: 1px solid #cbd5e1;
        padding: 0.5rem 0.75rem;
    }
    .blog-content-body pre {
        background: #0F172A;
        color: #f8fafc;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
    }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-secondary mb-2 rounded-pill px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Blogs List
        </a>
        <h3 class="fw-bold m-0 text-dark">{{ $blog->title }}</h3>
        <small class="text-muted"><i class="fa-solid fa-link me-1"></i>/blog/{{ $blog->slug }}</small>
    </div>
    <div class="d-flex gap-2">
        @if($blog->status === 'published')
            <a href="{{ route('frontend.blogs.show', $blog->slug) }}" target="_blank" class="btn btn-success rounded-3">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live on Public Site
            </a>
        @endif
        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary rounded-3">
            <i class="fa-solid fa-pen me-1"></i> Edit Blog
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Main Content -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                @if($blog->featured_image_url)
                    <div class="mb-4 text-center">
                        <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 400px; width: 100%; object-fit: cover;">
                    </div>
                @endif

                @if($blog->short_description)
                    <div class="lead p-3 rounded-3 mb-4 text-secondary" style="background-color: #F6F3FE; border-left: 4px solid #6A47ED;">
                        {{ $blog->short_description }}
                    </div>
                @endif

                <hr class="my-4">

                <div class="blog-content-body">
                    {!! $blog->content !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar Metadata -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold m-0 text-dark">Blog Information</h5>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted">Category:</span>
                        @if($blog->category)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill">
                                <i class="fa-solid fa-tag me-1"></i>{{ $blog->category->name }}
                            </span>
                        @else
                            <span class="badge bg-light text-muted border px-3 py-1 rounded-pill">Uncategorized</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted">Status:</span>
                        @if($blog->status === 'published')
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">Published</span>
                        @else
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">Draft</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted">Published Date:</span>
                        <span class="fw-semibold">{{ $blog->published_at ? $blog->published_at->format('M d, Y H:i A') : 'Not Published' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted">Created Date:</span>
                        <span class="fw-semibold">{{ $blog->created_at->format('M d, Y H:i A') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted">Last Updated:</span>
                        <span class="fw-semibold">{{ $blog->updated_at->format('M d, Y H:i A') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- SEO Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold m-0 text-dark"><i class="fa-solid fa-magnifying-glass me-2 text-primary"></i> SEO Meta Data</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <small class="fw-bold text-secondary d-block">Meta Title</small>
                    <span class="small text-dark">{{ $blog->meta_title ?: 'Not set' }}</span>
                </div>
                <div class="mb-3">
                    <small class="fw-bold text-secondary d-block">Meta Description</small>
                    <span class="small text-dark">{{ $blog->meta_description ?: 'Not set' }}</span>
                </div>
                <div>
                    <small class="fw-bold text-secondary d-block">Meta Keywords</small>
                    <span class="small text-dark">{{ $blog->meta_keywords ?: 'Not set' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
