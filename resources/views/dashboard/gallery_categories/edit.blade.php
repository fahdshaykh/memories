@extends('dashboard.layouts.admin')

@section('title', 'Edit Gallery Category - Admin Dashboard')

@section('content')
<style>
.sharp-corner,
.sharp-corner * {
    border-radius: 0 !important;
}
.image-preview-sharp {
    width: 220px;
    height: 130px;
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
    border-radius: 0 !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <div class="card sharp-corner">
                <form method="post" action="{{ route('galleries.categories.update', ['category' => $category->id]) }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Edit Gallery Category: <span class="text-primary">{{ $category->title }}</span></h4>
                        <a href="{{ route('galleries.categories.index') }}" class="btn btn-sm btn-outline-secondary sharp-corner">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label>Category Title <span class="text-danger">*</span></label>
                            <input type="text" id="category-title" name="title" value="{{ old('title', $category->title) }}" 
                                   class="form-control sharp-corner @error('title') is-invalid @enderror" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Slug <span class="text-danger">*</span></label>
                            <input type="text" id="category-slug" name="slug" value="{{ old('slug', $category->slug) }}" 
                                   class="form-control sharp-corner @error('slug') is-invalid @enderror" required>
                            <small class="form-text text-muted">URL-friendly identifier for this gallery collection.</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Description / Content</label>
                            <textarea class="form-control sharp-corner @error('content') is-invalid @enderror" 
                                      name="content" rows="4">{{ old('content', $category->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Cover Image</label>
                            @php
                                $imagePath = $category->image;
                                if ($imagePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                                    $currentImgUrl = asset('storage/' . $imagePath);
                                } elseif ($imagePath && file_exists(public_path('category_images/' . basename($imagePath)))) {
                                    $currentImgUrl = asset('category_images/' . basename($imagePath));
                                } else {
                                    $currentImgUrl = asset('default.png');
                                }
                            @endphp

                            <div class="d-flex align-items-center mb-2">
                                <div class="image-preview-sharp mr-3" onclick="document.getElementById('cat-image-file').click();">
                                    <img id="image-preview-img" src="{{ $currentImgUrl }}" alt="{{ $category->title }}" onerror="this.onerror=null; this.src='{{ asset('default.png') }}';">
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary sharp-corner mb-1" onclick="document.getElementById('cat-image-file').click();">
                                        <i class="fas fa-upload mr-1"></i> Change Image
                                    </button>
                                    <div class="text-muted small">JPG, PNG, or WebP. Max 10MB.</div>
                                </div>
                            </div>
                            <input type="file" id="cat-image-file" name="image" class="d-none" accept="image/*" onchange="previewCategoryImg(this)">
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="control-label mb-1">Status</div>
                            <label class="custom-switch mt-2 pl-0">
                                <input type="checkbox" name="status" value="1" class="custom-switch-input" {{ old('status', $category->status) ? 'checked' : '' }}>
                                <span class="custom-switch-indicator sharp-corner"></span>
                                <span class="custom-switch-description">Active (Visible on Website)</span>
                            </label>
                        </div>

                        <!-- SEO & Google Ranking Suite -->
                        @include('dashboard.partials.seo_fields', ['model' => $category, 'urlPrefix' => url('/categories') . '/'])
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('galleries.categories.index') }}" class="btn btn-secondary sharp-corner mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary sharp-corner px-4">
                            <i class="fas fa-save mr-1"></i> Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewCategoryImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('image-preview-img');
            img.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
