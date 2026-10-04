<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class VideoCategoryController extends Controller
{
    /**
     * Display a listing of video categories.
     */
    public function index()
    {
        $categories = VideoCategory::withCount('videos')->orderBy('id', 'DESC')->get();

        return view('dashboard.video_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new video category.
     */
    public function create()
    {
        return view('dashboard.video_categories.create');
    }

    /**
     * Store a newly created video category in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|min:2|max:255',
            'slug'    => 'required|string|max:255|unique:video_categories,slug',
            'content' => 'nullable|string',
            'image'   => 'nullable',
            'status'  => 'nullable',
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

        VideoCategory::create($data);

        return redirect()->route('videos.categories.index')->with('success', 'Video Category created successfully');
    }

    /**
     * Show the form for editing the specified video category.
     */
    public function edit(VideoCategory $category)
    {
        return view('dashboard.video_categories.edit', compact('category'));
    }

    /**
     * Update the specified video category in storage.
     */
    public function update(Request $request, VideoCategory $category)
    {
        $data = $request->validate([
            'title'   => 'required|min:2|max:255',
            'slug'    => ['required', 'string', 'max:255', Rule::unique('video_categories', 'slug')->ignore($category->id)],
            'content' => 'nullable|string',
            'image'   => 'nullable',
            'status'  => 'nullable',
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

        return redirect()->route('videos.categories.index')->with('success', 'Video Category updated successfully');
    }

    /**
     * Remove the specified video category from storage.
     */
    public function destroy(VideoCategory $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('videos.categories.index')->with('success', 'Video Category deleted successfully');
    }

    /**
     * Toggle video category status via AJAX.
     */
    public function categoryStatus(Request $request)
    {
        $category = VideoCategory::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => 'Status changed successfully.']);
    }
}
