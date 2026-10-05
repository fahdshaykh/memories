<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of post categories.
     */
    public function index()
    {
        $categories = PostCategory::withCount('posts')->orderBy('id', 'DESC')->get();

        return view('dashboard.post_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new post category.
     */
    public function create()
    {
        return view('dashboard.post_categories.create');
    }

    /**
     * Store a newly created post category in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|min:2|max:255',
            'slug'             => 'required|string|max:255|unique:post_categories,slug',
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

        PostCategory::create($data);

        return redirect()->route('posts.categories.index')->with('success', 'Post Category created successfully');
    }

    /**
     * Show the form for editing the specified post category.
     */
    public function edit(PostCategory $category)
    {
        return view('dashboard.post_categories.edit', compact('category'));
    }

    /**
     * Update the specified post category in storage.
     */
    public function update(Request $request, PostCategory $category)
    {
        $data = $request->validate([
            'title'            => 'required|min:2|max:255',
            'slug'             => ['required', 'string', 'max:255', Rule::unique('post_categories', 'slug')->ignore($category->id)],
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
            // Delete old image
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

        return redirect()->route('posts.categories.index')->with('success', 'Post Category updated successfully');
    }

    /**
     * Remove the specified post category from storage.
     */
    public function destroy(PostCategory $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('posts.categories.index')->with('success', 'Post Category deleted successfully');
    }

    /**
     * Toggle post category status via AJAX.
     */
    public function categoryStatus(Request $request)
    {
        $category = PostCategory::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => 'Status changed successfully.']);
    }
}
