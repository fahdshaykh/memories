@php
    $mTitle = old('meta_title', $model->meta_title ?? '');
    $mDesc = old('meta_description', $model->meta_description ?? '');
    $mKeywords = old('meta_keywords', $model->meta_keywords ?? '');
    $mCanonical = old('canonical_url', $model->canonical_url ?? '');
    $previewPrefix = $urlPrefix ?? url('/post') . '/';
@endphp

<div class="card mt-4 border" style="border: 1px solid #e2e8f0; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
    <div class="card-header d-flex justify-content-between align-items-center" style="cursor: pointer; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px;" data-toggle="collapse" data-target="#seoFieldsCollapse" aria-expanded="true">
        <h5 class="mb-0" style="font-size: 1.05rem; font-weight: 700; color: #0f172a !important;">
            <i class="fas fa-search text-primary mr-2"></i> Search Engine Optimization (SEO) & Google Ranking
        </h5>
        <span class="badge badge-primary px-3 py-2" style="font-size: 0.8rem; font-weight: 600; border-radius: 4px;"><i class="fas fa-sliders-h mr-1"></i> SEO Settings</span>
    </div>
    
    <div class="collapse show" id="seoFieldsCollapse">
        <div class="card-body">
            
            <!-- Google SERP Live Snippet Preview -->
            <div class="mb-4 p-3 bg-white" style="border: 1px solid #dadce0; border-radius: 8px; max-width: 650px;">
                <div class="text-muted small mb-2 text-uppercase font-weight-bold" style="letter-spacing: 0.5px; font-size: 0.75rem;">
                    <i class="fab fa-google text-danger"></i> Google Search Snippet Preview
                </div>
                
                <div style="font-family: Arial, sans-serif;">
                    <div id="seo-preview-url" style="color: #202124; font-size: 14px; line-height: 1.3; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <span style="color: #5f6368;">{{ url('/') }} › </span><span id="seo-preview-slug" style="color: #202124;">post-slug</span>
                    </div>
                    <div id="seo-preview-title" style="color: #1a0dab; font-size: 20px; line-height: 1.3; cursor: pointer; text-decoration: none; margin-top: 3px; font-weight: normal; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $mTitle ?: ($model->title ?? 'Your Post Title Here - Wisherpro') }}
                    </div>
                    <div id="seo-preview-desc" style="color: #4d5156; font-size: 14px; line-height: 1.58; word-wrap: break-word; margin-top: 4px;">
                        {{ $mDesc ?: 'This is how your post description will appear in Google search results. Add an engaging meta description to get more clicks.' }}
                    </div>
                </div>
            </div>

            <!-- Meta Title Field -->
            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="font-weight-bold">SEO Meta Title</label>
                    <small id="meta-title-counter" class="text-muted">0 / 60 characters (Recommended: 50-60)</small>
                </div>
                <input type="text" 
                       name="meta_title" 
                       id="meta_title_input" 
                       value="{{ $mTitle }}" 
                       class="form-control" 
                       placeholder="Custom SEO Title (defaults to Post Title if blank)">
                <small class="form-text text-muted">Keep it under 60 characters so Google does not cut it off in search results.</small>
                @error('meta_title')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Meta Description Field -->
            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="font-weight-bold">SEO Meta Description</label>
                    <small id="meta-desc-counter" class="text-muted">0 / 160 characters (Recommended: 150-160)</small>
                </div>
                <textarea name="meta_description" 
                          id="meta_desc_input" 
                          rows="3" 
                          class="form-control" 
                          placeholder="Compelling 150-160 character summary that invites searchers to click">{{ $mDesc }}</textarea>
                <small class="form-text text-muted">A well-written snippet drastically increases click-through rates (CTR) from Google search.</small>
                @error('meta_description')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <!-- Meta Keywords -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Meta Keywords</label>
                        <input type="text" 
                               name="meta_keywords" 
                               value="{{ $mKeywords }}" 
                               class="form-control" 
                               placeholder="e.g. quotes, love, inspiration, life wisdom">
                        <small class="form-text text-muted">Comma-separated target keywords.</small>
                        @error('meta_keywords')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Canonical URL -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Canonical URL (Optional)</label>
                        <input type="url" 
                               name="canonical_url" 
                               id="canonical_url_input"
                               value="{{ $mCanonical }}" 
                               class="form-control" 
                               placeholder="https://yourwebsite.com/original-url">
                        <small class="form-text text-muted">Leave blank to automatically use this page's own URL.</small>
                        @error('canonical_url')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const metaTitleInput = document.getElementById('meta_title_input');
    const metaDescInput = document.getElementById('meta_desc_input');
    const titleInput = document.querySelector('input[name="title"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    const previewTitle = document.getElementById('seo-preview-title');
    const previewDesc = document.getElementById('seo-preview-desc');
    const previewSlug = document.getElementById('seo-preview-slug');
    const titleCounter = document.getElementById('meta-title-counter');
    const descCounter = document.getElementById('meta-desc-counter');

    function updateTitle() {
        const customTitle = metaTitleInput ? metaTitleInput.value.trim() : '';
        const fallbackTitle = titleInput ? titleInput.value.trim() : '';
        const display = customTitle || fallbackTitle || 'Your Post Title Here - Wisherpro';
        if (previewTitle) {
            previewTitle.textContent = display.length > 65 ? display.substring(0, 65) + '...' : display;
        }
        
        if (titleCounter && metaTitleInput) {
            const count = metaTitleInput.value.length;
            titleCounter.textContent = count + ' / 60 characters';
            titleCounter.style.color = (count >= 50 && count <= 60) ? '#28a745' : (count > 60 ? '#dc3545' : '#6c757d');
        }
    }

    function updateDesc() {
        const customDesc = metaDescInput ? metaDescInput.value.trim() : '';
        let display = customDesc;
        
        if (!display) {
            // try to read summernote content or standard content textarea
            const contentArea = document.querySelector('textarea[name="content"]');
            if (contentArea) {
                const text = contentArea.value.replace(/<[^>]*>?/gm, '').trim();
                display = text ? (text.substring(0, 155) + '...') : 'This is how your post description will appear in Google search results.';
            } else {
                display = 'This is how your post description will appear in Google search results.';
            }
        }
        
        if (previewDesc) {
            previewDesc.textContent = display.length > 165 ? display.substring(0, 165) + '...' : display;
        }

        if (descCounter && metaDescInput) {
            const count = metaDescInput.value.length;
            descCounter.textContent = count + ' / 160 characters';
            descCounter.style.color = (count >= 130 && count <= 160) ? '#28a745' : (count > 160 ? '#dc3545' : '#6c757d');
        }
    }

    function updateSlug() {
        if (previewSlug) {
            const s = (slugInput && slugInput.value.trim()) || (titleInput && titleInput.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')) || 'post-slug';
            previewSlug.textContent = s;
        }
    }

    if (metaTitleInput) metaTitleInput.addEventListener('input', updateTitle);
    if (titleInput) titleInput.addEventListener('input', function() {
        updateTitle();
        updateSlug();
    });

    if (metaDescInput) metaDescInput.addEventListener('input', updateDesc);
    if (slugInput) slugInput.addEventListener('input', updateSlug);

    // Initial run
    updateTitle();
    updateDesc();
    updateSlug();
});
</script>
