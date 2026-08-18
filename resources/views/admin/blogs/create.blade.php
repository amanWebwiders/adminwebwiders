@extends('admin.layouts.app')

@section('title', 'Create New Blog')
@section('page-header', 'Create New Blog Post')

@push('styles')
<style>
    .ck-editor__editable_inline {
        min-height: 350px;
    }
</style>
@endpush

@section('content')
<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold m-0 text-dark">Blog Information</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold small text-secondary">Blog Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="Enter compelling blog title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label fw-semibold small text-secondary">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted small">/blog/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto-generated-from-title">
                        </div>
                        <small class="text-muted">Leaves empty to auto-generate from title.</small>
                        @error('slug')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_description" class="form-label fw-semibold small text-secondary">Short Description / Excerpt</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="3" placeholder="Brief summary of the blog post">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rich Content with CKEditor 5 -->
                    <div class="mb-3">
                        <label for="editor" class="form-label fw-semibold small text-secondary">Blog Content (CKEditor 5)</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="editor" name="content">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Settings Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold m-0 text-dark"><i class="fa-solid fa-magnifying-glass-chart text-primary me-2"></i> SEO Optimization Meta Fields</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label fw-semibold small text-secondary">Meta Title</label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" placeholder="SEO Meta Title">
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label fw-semibold small text-secondary">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="2" placeholder="SEO Description (150-160 characters recommended)">{{ old('meta_description') }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label fw-semibold small text-secondary">Meta Keywords</label>
                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="laravel, php, web development">
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label fw-semibold small text-secondary">Tags / Hashtags (Comma Separated)</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" placeholder="Security, UI/UX Design, Digital, AI, Web Development">
                        <small class="text-muted">These tags render as clickable hashtags on the website blog detail page.</small>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options Column -->
        <div class="col-lg-4">
            <!-- Publish Settings Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold m-0 text-dark">Publish Options</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold small text-secondary">Blog Category</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold small text-secondary">Blog Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Save as Draft</option>
                            <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Publish Immediately</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Author Name -->
                    <div class="mb-3">
                        <label for="author" class="form-label fw-semibold small text-secondary">Author Name</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', 'Admin') }}" placeholder="Admin">
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Featured Checkbox -->
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold small text-secondary" for="is_featured">
                            Featured Post (Show in Top Slider)
                        </label>
                    </div>

                    <!-- Published Date -->
                    <div class="mb-4">
                        <label for="published_at" class="form-label fw-semibold small text-secondary">Publish Date & Time</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at') }}">
                        <small class="text-muted">Defaults to current time when publishing.</small>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 fw-bold rounded-3">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i> Save Blog Post
                        </button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-light py-2 border rounded-3">Cancel</a>
                    </div>
                </div>
            </div>

            <!-- Featured Image Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold m-0 text-dark">Featured Image</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 text-center">
                        <div id="imagePreviewContainer" class="mb-3 d-none">
                            <img id="imagePreview" src="#" alt="Featured Image Preview" class="img-fluid rounded border shadow-sm" style="max-height: 200px;">
                        </div>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*" onchange="previewFeaturedImage(this)">
                        <small class="text-muted d-block mt-2">Allowed: JPG, PNG, WEBP, GIF (Max: 2MB)</small>
                        @error('featured_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);

                    fetch("{{ route('admin.blogs.upload-image') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.uploaded) {
                            resolve({ default: result.url });
                        } else {
                            reject(result.error ? result.error.message : 'Upload failed');
                        }
                    })
                    .catch(error => {
                        reject(error || 'Upload error');
                    });
                }));
        }

        abort() {}
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        const editorEl = document.querySelector('#editor');
        if (editorEl && typeof ClassicEditor !== 'undefined') {
            ClassicEditor
                .create(editorEl, {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    mediaEmbed: {
                        previewsInData: true
                    },
                    placeholder: 'Write your rich blog content here...'
                })
                .then(editor => {
                    console.log('CKEditor 5 initialized successfully');
                })
                .catch(error => {
                    console.error('CKEditor Init Error:', error);
                });
        }
    });

    // Auto-generate slug from title
    document.getElementById('title')?.addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.dataset.manual) {
            slugInput.value = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });

    document.getElementById('slug')?.addEventListener('input', function() {
        this.dataset.manual = 'true';
    });

    // Image Preview Function
    function previewFeaturedImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
