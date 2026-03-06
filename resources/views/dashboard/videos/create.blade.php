@extends('dashboard.layouts.admin')

@section('script')



@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" action="{{ route('videos.store') }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                <div class="card-header">
                    <h4>Create Video</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Select category</label>
                        <select class="form-control" name="category_id" required="">
                          <option value="">Select Category</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}"> {{ $category->title }}</option>
                          @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-message">
                            {{ $errors->first('category_id') }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{old('title')}}" class="form-control" required="">
                        @error('title')
                        <div class="invalid-message">
                            {{ $errors->first('title') }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" value="{{old('slug')}}" placeholder="wish-me-slug" class="form-control" required="">
                        @error('slug')
                        <div class="invalid-message">
                            {{ $errors->first('slug') }}
                        </div>
                        @enderror
                    </div>
                    {{-- <div class="form-group mb-2">
                        <label>Content</label>
                        <textarea class="form-control" name="content"></textarea>
                    </div> --}}

                    <div class="form-group mb-2">
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="video_file" />
                            @if ($errors->has('video_file'))
                                <span class="text-danger">{{ $errors->first('video_file') }}</span>
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