@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-header', 'Overview Dashboard')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold m-0 text-dark">Welcome back, {{ auth('admin')->user()->name }} 👋</h3>
        <p class="text-muted small m-0">Here is what is happening with your Webwiders Software Solutions blog platform today.</p>
    </div>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
        <i class="fa-solid fa-plus me-2"></i> Create New Blog
    </a>
</div>

<!-- Metrics Row -->
<div class="row g-3 mb-4">
    <!-- Total Blogs -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-muted fw-bold small">Total Blogs</span>
                    <h2 class="fw-bold m-0 text-dark mt-2">{{ $totalBlogs }}</h2>
                </div>
                <div class="p-3 rounded-circle fs-3 text-white" style="background-color: #6A47ED; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Published Blogs -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-muted fw-bold small">Published</span>
                    <h2 class="fw-bold m-0 text-success mt-2">{{ $publishedBlogs }}</h2>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle fs-3" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Draft Blogs -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-muted fw-bold small">Drafts</span>
                    <h2 class="fw-bold m-0 text-warning mt-2">{{ $draftBlogs }}</h2>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle fs-3" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-pen-ruler"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Blogs Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h5 class="fw-bold m-0 text-dark">Recent Blogs</h5>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 70px;">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Published Date</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBlogs as $blog)
                    <tr>
                        <td>
                            @if($blog->featured_image_url)
                                <img src="{{ $blog->featured_image_url }}" alt="Thumbnail" class="rounded object-fit-cover" width="50" height="40">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center text-muted small" style="width: 50px; height: 40px;">
                                    <i class="fa-regular fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ Str::limit($blog->title, 50) }}</div>
                            <small class="text-muted">/blog/{{ $blog->slug }}</small>
                        </td>
                        <td>
                            @if($blog->status === 'published')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                    <i class="fa-solid fa-circle me-1 fs-6"></i> Published
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">
                                    <i class="fa-solid fa-circle me-1 fs-6"></i> Draft
                                </span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ $blog->published_at ? $blog->published_at->format('M d, Y H:i') : 'N/A' }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-sm btn-light text-primary me-1" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-light text-secondary" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fa-regular fa-folder-open fs-3 d-block mb-2"></i>
                            No blogs found. <a href="{{ route('admin.blogs.create') }}">Create your first blog post</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
