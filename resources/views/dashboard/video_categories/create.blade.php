@extends('dashboard.layouts.admin')

@section('title', 'Create Video Category - Admin Dashboard')

@section('content')
<style>
.sharp-corner,
.sharp-corner * {
    border-radius: 0 !important;
}
.image-preview-sharp {
    width: 200px;
    height: 120px;
    border: 2px dashed #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    background: #f8fafc;
    border-radius: 0 !important;
}
.image-preview-sharp img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
    border-radius: 0 !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <div class="card sharp-corner">
                <form method="post" action="{{ route('videos.categories.store') }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Create Video Category</h4>
                        <a href="{{ route('videos.categories.index') }}" class="btn btn-sm btn-outline-secondary sharp-corner">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label>Category Title <span class="text-danger">*</span></label>
                            <input type="text" id="category-title" name="title" value="{{ old('title') }}" 
                                   class="form-control sharp-corner @error('title') is-invalid @enderror" 
                                   placeholder="e.g. Tutorials, Music, Shorts" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Slug <span class="text-danger">*</span></label>
                            <input type="text" id="category-slug" name="slug" value="{{ old('slug') }}" 
                                   class="form-control sharp-corner @error('slug') is-invalid @enderror" 
                                   placeholder="e.g. video-tutorials" required>
                            <small class="form-text text-muted">URL-friendly identifier for this video category.</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Description / Content</label>
                            <textarea class="form-control sharp-corner @error('content') is-invalid @enderror" 
                                      name="content" rows="4" placeholder="Brief description of this video category...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Cover Image</label>
                            <div class="image-preview-sharp" onclick="document.getElementById('cat-image-file').click();">
                                <span id="upload-placeholder" class="text-muted small text-center p-2">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-1 d-block text-secondary"></i>
                                    Click to choose cover image
                                </span>
                                <img id="image-preview-img" src="" alt="Preview">
                            </div>
                            <input type="file" id="cat-image-file" name="image" class="d-none" accept="image/*" onchange="previewCategoryImg(this)">
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="control-label mb-1">Status</div>
                            <label class="custom-switch mt-2 pl-0">
                                <input type="checkbox" name="status" value="1" class="custom-switch-input" {{ old('status', 1) ? 'checked' : '' }}>
                                <span class="custom-switch-indicator sharp-corner"></span>
                                <span class="custom-switch-description">Active (Visible on Website)</span>
                            </label>
                        </div>

                        <!-- SEO & Google Ranking Suite -->
                        @include('dashboard.partials.seo_fields', ['model' => null, 'urlPrefix' => url('/videos') . '/'])
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('videos.categories.index') }}" class="btn btn-secondary sharp-corner mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary sharp-corner px-4">
                            <i class="fas fa-save mr-1"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('category-title').addEventListener('input', function() {
    var slugInput = document.getElementById('category-slug');
    if (!slugInput.dataset.manual) {
        var slug = this.value.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugInput.value = slug;
    }
});

document.getElementById('category-slug').addEventListener('change', function() {
    this.dataset.manual = "1";
});

function previewCategoryImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('image-preview-img');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('upload-placeholder').style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
