@extends('admin.layouts.app')

@section('title', 'Manage Blogs')
@section('page-header', 'Blogs Management')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by title or description..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">-- All Categories --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">-- All Status --</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-secondary px-3">Filter</button>
                @if(request('search') || request('status') || request('category_id'))
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary ms-auto px-3">
                    <i class="fa-solid fa-plus me-1"></i> Add Blog
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 70px;">Image</th>
                    <th scope="col">Title & Slug</th>
                    <th scope="col">Category</th>
                    <th scope="col">Status</th>
                    <th scope="col">Published Date</th>
                    <th scope="col">Created Date</th>
                    <th scope="col" class="text-end" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                    <tr>
                        <td>
                            @if($blog->featured_image_url)
                                <img src="{{ $blog->featured_image_url }}" alt="Featured Image" class="rounded object-fit-cover" width="60" height="45">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center text-muted small" style="width: 60px; height: 45px;">
                                    <i class="fa-regular fa-image fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-1">{{ $blog->title }}</div>
                            <small class="text-muted d-block">
                                <i class="fa-solid fa-link me-1"></i>/blog/{{ $blog->slug }}
                            </small>
                        </td>
                        <td>
                            @if($blog->category)
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill small">
                                    <i class="fa-solid fa-tag me-1"></i>{{ $blog->category->name }}
                                </span>
                            @else
                                <span class="badge bg-light text-muted border px-2 py-1 rounded-pill small">
                                    Uncategorized
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($blog->status === 'published')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                    Published
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">
                                    Draft
                                </span>
                            @endif
                            @if($blog->is_featured)
                                <span class="badge bg-warning text-dark border px-2 py-1 rounded-pill ms-1" title="Featured Post">
                                    <i class="fa-solid fa-star me-1"></i>Featured
                                </span>
                            @endif
                        </td>
                        <td class="small text-muted">
                            {{ $blog->published_at ? $blog->published_at->format('Y-m-d H:i') : 'Not Set' }}
                        </td>
                        <td class="small text-muted">
                            {{ $blog->created_at->format('Y-m-d') }}
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-outline-info" title="Preview View">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $blog->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade text-start" id="deleteModal{{ $blog->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-3 text-secondary">
                                            Are you sure you want to delete blog <strong>"{{ $blog->title }}"</strong>?
                                            @if($blog->category)
                                                <div class="mt-2 text-muted small">
                                                    Category: <span class="badge bg-primary-subtle text-primary">{{ $blog->category->name }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger rounded-3">Yes, Delete Blog</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-folder-open fs-1 d-block mb-3 text-secondary opacity-50"></i>
                            <h5>No blogs found</h5>
                            <p class="small mb-3">Try adjusting your filter parameters or create a new blog post.</p>
                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-primary px-3 rounded-pill">
                                <i class="fa-solid fa-plus me-1"></i> Add New Blog
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($blogs->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $blogs->links() }}
        </div>
    @endif
</div>
@endsection
