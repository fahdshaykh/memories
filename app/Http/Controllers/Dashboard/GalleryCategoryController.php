<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of gallery categories.
     */
    public function index()
    {
        $categories = GalleryCategory::withCount('galleries')->orderBy('id', 'DESC')->get();

        return view('dashboard.gallery_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new gallery category.
     */
    public function create()
    {
        return view('dashboard.gallery_categories.create');
    }

    /**
     * Store a newly created gallery category in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|min:2|max:255',
            'slug'             => 'required|string|max:255|unique:gallery_categories,slug',
            'content'          => 'nullable|string',
            'image'            => 'nullable',
            'status'           => 'nullable',
            'meta_title'       => 'nullable|string|max:100',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords'    => 'nullable|string|max:255',
            'canonical_url'    => 'nullable|url|max:255',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.webp';

            $img = Image::make($image->getRealPath());
            $img->fit(1200, 700, function ($constraint) {
                $constraint->upsize();
            });
            $img->encode('webp', 90);

            $path = 'category_images/' . $filename;
            Storage::disk('public')->put($path, $img->stream()->__toString());

            $data['image'] = $path;
        }

        GalleryCategory::create($data);

        return redirect()->route('galleries.categories.index')->with('success', 'Gallery Category created successfully');
    }

    /**
     * Show the form for editing the specified gallery category.
     */
    public function edit(GalleryCategory $category)
    {
        return view('dashboard.gallery_categories.edit', compact('category'));
    }

    /**
     * Update the specified gallery category in storage.
     */
    public function update(Request $request, GalleryCategory $category)
    {
        $data = $request->validate([
            'title'            => 'required|min:2|max:255',
            'slug'             => ['required', 'string', 'max:255', Rule::unique('gallery_categories', 'slug')->ignore($category->id)],
            'content'          => 'nullable|string',
            'image'            => 'nullable',
            'status'           => 'nullable',
            'meta_title'       => 'nullable|string|max:100',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords'    => 'nullable|string|max:255',
            'canonical_url'    => 'nullable|url|max:255',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.webp';

            $img = Image::make($image->getRealPath());
            $img->fit(1200, 700, function ($constraint) {
                $constraint->upsize();
            });
            $img->encode('webp', 90);

            $path = 'category_images/' . $filename;
            Storage::disk('public')->put($path, $img->stream()->__toString());

            $data['image'] = $path;
        }

        $category->update($data);

        return redirect()->route('galleries.categories.index')->with('success', 'Gallery Category updated successfully');
    }

    /**
     * Remove the specified gallery category from storage.
     */
    public function destroy(GalleryCategory $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('galleries.categories.index')->with('success', 'Gallery Category deleted successfully');
    }

    /**
     * Toggle gallery category status via AJAX.
     */
    public function categoryStatus(Request $request)
    {
        $category = GalleryCategory::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => 'Status changed successfully.']);
    }
}
