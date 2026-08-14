@extends('admin.layouts.app')

@section('title', 'Manage Categories')
@section('page-header', 'Blog Categories Management')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-2 align-items-center">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search category by name or description..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-secondary px-3">Filter</button>
                @if(request('search'))
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary ms-auto px-3">
                    <i class="fa-solid fa-plus me-1"></i> Add Category
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
                    <th scope="col" style="width: 60px;">#</th>
                    <th scope="col">Category Name & Slug</th>
                    <th scope="col">Description</th>
                    <th scope="col" class="text-center">Total Blogs</th>
                    <th scope="col">Created Date</th>
                    <th scope="col" class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="fw-semibold text-muted">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td>
                            <div class="fw-bold text-dark mb-1">{{ $category->name }}</div>
                            <small class="text-muted d-block">
                                <i class="fa-solid fa-tag me-1 text-primary"></i>/category/{{ $category->slug }}
                            </small>
                        </td>
                        <td class="small text-muted" style="max-width: 300px;">
                            {{ $category->description ? Str::limit($category->description, 90) : 'No description added' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill fw-semibold">
                                <i class="fa-solid fa-newspaper me-1"></i>{{ $category->blogs_count }} Articles
                            </span>
                        </td>
                        <td class="small text-muted">
                            {{ $category->created_at->format('Y-m-d') }}
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade text-start" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-header-title text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Category Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-3">
                                            <p class="mb-2">Are you sure you want to delete category <strong>"{{ $category->name }}"</strong>?</p>
                                            @if($category->blogs_count > 0)
                                                <div class="alert alert-warning small mb-0 rounded-3">
                                                    <i class="fa-solid fa-circle-info me-1"></i> Note: This category is assigned to <strong>{{ $category->blogs_count }}</strong> blog post(s). Deleting it will set those blog posts' category to <em>Uncategorized (Null)</em> without deleting the articles themselves.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger rounded-3 px-4">Delete Category</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fa-solid fa-tags fs-1 d-block mb-3 opacity-25"></i>
                                <h5>No Categories Found</h5>
                                <p class="small mb-3">Get started by creating your first blog category.</p>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-plus me-1"></i> Add Category
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
