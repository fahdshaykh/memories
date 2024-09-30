@extends('dashboard.layouts.admin')

@section('script')



@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" action="{{ route('galleries.update', ['gallery' => $gallery->id]) }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                <div class="card-header">
                    <h4>Edit gallery</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Select category</label>
                        <select class="form-control" name="category_id" required="">
                          <option value="">Select Category</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $gallery->category_id) == $category->id ? ' selected' : '' }}> {{ $category->title }}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{old('title', $gallery->title)}}" class="form-control" required="">
                        @error('title')
                        <div class="invalid-message">
                            {{ $errors->first('title') }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" value="{{old('slug', $gallery->slug)}}" placeholder="wish-me-slug" class="form-control" required="">
                        @error('slug')
                        <div class="invalid-message">
                            {{ $errors->first('slug') }}
                        </div>
                        @enderror
                    </div>
                    {{-- <div class="form-group mb-2">
                        <label>Content</label>
                        <textarea class="form-control" name="content">{{ $gallery->content }}</textarea>
                    </div> --}}

                    <div class="form-group mb-2">

                        <img src="{{ asset('gallery_images').'/'.$gallery->image }}" alt="" height="128px" width="128px">

                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" />
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection