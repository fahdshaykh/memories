<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('id', 'DESC')->get();

        return view('dashboard.galleries.index', ['galleries' => $galleries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();

        if($request->image){

            $originalFile = $request->file('image');

            $originalFile->move(public_path().'/gallery_images/', $post_file = time().'.'.$originalFile->getClientOriginalExtension());

            $data['image'] = $post_file;

        }

        $gallery = Gallery::create($data);

        return redirect()->route('galleries.index')->with('success', 'gallery created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('dashboard.galleries.edit', ['gallery' => $gallery]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();
        if($request->image){
            
            $document_path = public_path()."/gallery_images/".$gallery->image;  // Value is not URL but directory file path

            if(File::exists($document_path)) {

                File::delete($document_path);
            }

            $originalFile = $request->file('image');

            $originalFile->move(public_path().'/gallery_images/', $post_file = time().'.'.$originalFile->getClientOriginalExtension());

            $data['image'] = $post_file;

        }

        // dd($data);
        $gallery = $gallery->update($data);

        return redirect()->route('galleries.index')->with('success', 'gallery updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        if($gallery->image){
            
            $document_path = public_path()."/gallery_images/".$gallery->image;  // Value is not URL but directory file path

            if(File::exists($document_path)) {

                File::delete($document_path);
            }

        }

        $gallery = $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'gallery deleted successfully');
    }


}
