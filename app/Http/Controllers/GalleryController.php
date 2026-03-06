<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SubscriberController;

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
        $categories = Category::latest()->get();

        return view('dashboard.galleries.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.webp';

            $img = Image::make($image->getRealPath());
            $img->fit(1200, 700, function ($constraint) {
                $constraint->upsize();
            });
            $img->encode('webp', 90);

            $path = 'gallery_images/' . $filename;
            Storage::disk('public')->put($path, $img->stream()->__toString());

            $data['image'] = $path;
        }

        $gallery = Gallery::create($data);

        // Send newsletter to subscribers
        try {
            $subscriberController = new SubscriberController();
            $subscriberController->sendNewsletter($gallery, 'gallery');
        } catch (\Exception $e) {
            // Log error but don't fail the gallery creation
            \Log::error('Newsletter send failed: ' . $e->getMessage());
        }

        return redirect()->route('galleries.index')->with('success','Gallery image created successfully');
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

        if ($request->hasFile('image')) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $image = $request->file('image');
            $filename = time() . '.webp';

            $img = Image::make($image->getRealPath());
            $img->fit(1200, 700, function ($constraint) {
                $constraint->upsize();
            });
            $img->encode('webp', 90);

            $path = 'gallery_images/' . $filename;
            Storage::disk('public')->put($path, $img->stream()->__toString());

            $data['image'] = $path;
        }

        $gallery->update($data);

        return redirect()->route('galleries.index')->with('success', 'Gallery image updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Gallery image deleted successfully');
    }


}
