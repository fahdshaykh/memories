@extends('dashboard.layouts.admin')

@section('script')
<link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
<script src="{{ asset('admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" action="{{ route('posts.store') }}" class="needs-validation" novalidate="" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="card-header">
                    <h4>Create Post</h4>
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
                    
                    <div class="form-group mb-2">
                        <label>Content</label>
                        <textarea class="form-control summernote" name="content"></textarea>
                    </div>

                    

                    <div class="col-md-12" id="editor-container">

                        
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="textinput">Quotes</label>
                            <div class="col-md-12 margin-bottom">
                            <input id="textinput" name="quote[]" type="text" placeholder="Enter quotes" class="form-control input-md quote-item" required="">
                            
                            </div>
                        </div>
                        
                    </div>

                        

                    <div class="float-right">
                        <button id="add" class="btn add-more button-yellow uppercase" type="button">+ Add quotes</button>
                        <button class="delete btn button-white uppercase">- Remove quotes</button>
                    </div>

                    <div class="float-right">
                        <button id="add-editor" class="btn add-more button-yellow uppercase" type="button">+Add Content</button>
                        <button id="remove-editor" class="btn button-white uppercase">-Remove Content</button>
                    </div>
                

                    <div class="form-group mb-2">
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" />
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                    </div>


                    {{-- <div class="form-group mb-2">
                        <label>Content</label>
                        <textarea class="summernote" name="more_content"></textarea>
                    </div> --}}

                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary">Publish</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $(".delete").hide();

    // const container = $('#editor-container');
    
    //when the Add Field button is clicked
    $("#add").click(function(e) {
        $(".delete").fadeIn("1500");
        //Append a new row of code to the "#items" div

        const index = $('.quote-item').length;

        const newIput = `
            <div class="next-referral col-12">
                <input id="textinput" name="quote[]" type="text" placeholder="Enter quotes" class="form-control quote-item input-md mt-3 mb-3">
            </div>
        `;
        $('#editor-container').append(newIput);

        // $("#editor-container").append(
        // '<div class="next-referral col-12"><input id="textinput" name="contents[${index}][quote]" type="text" placeholder="Enter quotes" class="form-control input-md mt-3 mb-3"></div>'
        // );
    });

    $("body").on("click", ".delete", function(e) {
        $(".next-referral").last().remove();
    });


  // code for multiple contents
  let editorCount = 0;

    // Function to add a new Summernote editor
    function addEditor() {

        // const container = $('#editor-container');
        const index = $('.content-item').length;

        editorCount++;
        const editorId = 'editor-' + editorCount;
        const newEditor = `
            <div class="editor-wrapper" id="wrapper-${editorId}">
                <textarea id="${editorId}" name="quote[]" class="summernote mt-3 content-item"></textarea>
            </div>
        `;
        $('#editor-container').append(newEditor);
        $('#' + editorId).summernote({
            height: 200,
            placeholder: 'Write here...',
            dialogsInBody: true,
            minHeight: 250
        });
    }

    // Function to remove the last Summernote editor
    function removeEditor() {
        if (editorCount > 0) {
            const editorId = 'editor-' + editorCount;
            $('#wrapper-' + editorId).remove();
            editorCount--;
        }
    }

    // Event listeners for the buttons
    $('#add-editor').click(function() {
        addEditor();
    });

    $('#remove-editor').click(function() {
        removeEditor();
    });
});

</script>