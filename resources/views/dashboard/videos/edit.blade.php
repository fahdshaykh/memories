@extends('dashboard.layouts.admin')

@section('script')



@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" action="{{ route('videos.update', ['video' => $video->id]) }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                <div class="card-header">
                    <h4>Edit Video</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Select category</label>
                        <select class="form-control" name="category_id" required="">
                          <option value="">Select Category</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $video->category_id) == $category->id ? ' selected' : '' }}> {{ $category->title }}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{old('title', $video->title)}}" class="form-control" required="">
                        @error('title')
                        <div class="invalid-message">
                            {{ $errors->first('title') }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" value="{{old('slug', $video->slug)}}" placeholder="wish-me-slug" class="form-control" required="">
                        @error('slug')
                        <div class="invalid-message">
                            {{ $errors->first('slug') }}
                        </div>
                        @enderror
                    </div>
                    {{-- <div class="form-group mb-2">
                        <label>Content</label>
                        <textarea class="form-control" name="content">{{ $video->content }}</textarea>
                    </div> --}}

                    <div class="form-group mb-2">

                        <video width="320" height="240" controls>
                            <source src="{{ $video->video_file ? asset('storage/' . $video->video_file) : asset('placeholder.jpg') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

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