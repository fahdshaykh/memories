@extends('dashboard.layouts.admin')

@section('script')



@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" action="{{ route('categories.update', ['category' => $category->id]) }}" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                <div class="card-header">
                    <h4>Edit Category</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{old('title', $category->title)}}" class="form-control" required="">
                        @error('title')
                        <div class="invalid-message">
                            {{ $errors->first('title') }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" value="{{old('slug', $category->slug)}}" placeholder="wish-me-slug" class="form-control" required="">
                        @error('slug')
                        <div class="invalid-message">
                            {{ $errors->first('slug') }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label>Content</label>
                        <textarea class="form-control" name="content">{{ $category->content }}</textarea>
                    </div>

                    {{-- <div class="form-group mb-2">

                        <img src="{{ asset('category_images').'/'.$category->image }}" alt="" height="128px" width="128px">

                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" />
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                    </div> --}}
                    
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