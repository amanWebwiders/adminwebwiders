@extends('admin.layouts.app')

@section('title', 'Add New Category')
@section('page-header', 'Create New Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <h5 class="fw-bold m-0 text-dark"><i class="fa-solid fa-folder-plus text-primary me-2"></i> Category Details</h5>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Categories
                </a>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <!-- Category Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small text-secondary">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g., Technology, Artificial Intelligence">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label fw-semibold small text-secondary">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted small">/category/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto-generated-from-name">
                        </div>
                        <small class="text-muted">Leave empty to automatically generate from category name.</small>
                        @error('slug')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold small text-secondary">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4 border rounded-3">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
