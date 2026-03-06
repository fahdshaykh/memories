<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::orderBy('id', 'DESC')->get();

        return view('dashboard.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();

        return view('dashboard.videos.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        $data = $request->validated();

        // Auto-generate slug from title if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set default status to active (1)
        $data['status'] = 1;

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $videoFile = $request->file('video_file');
            $videoFilename = time() . '_' . Str::random(8) . '.' . $videoFile->getClientOriginalExtension();

            $videoPath = 'gallery_videos/' . $videoFilename;
            Storage::disk('public')->put($videoPath, file_get_contents($videoFile));

            $data['video_file'] = $videoPath;
        }

        Video::create($data);

        return redirect()->route('videos.index')->with('success', 'ویڈیو کامیابی سے شامل ہو گئی!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return view('dashboard.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        $categories = Category::latest()->get();

        return view('dashboard.videos.edit', compact('video', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        $data = $request->validated();

        // Auto-generate slug from title if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Only update status if it's in the validated data
        if (array_key_exists('status', $data)) {
            $data['status'] = $data['status'] ? 1 : 0;
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete old video file if exists
            if ($video->video_file && Storage::disk('public')->exists($video->video_file)) {
                Storage::disk('public')->delete($video->video_file);
            }

            $videoFile = $request->file('video_file');
            $videoFilename = time() . '_' . Str::random(8) . '.' . $videoFile->getClientOriginalExtension();

            $videoPath = 'gallery_videos/' . $videoFilename;
            Storage::disk('public')->put($videoPath, file_get_contents($videoFile));

            $data['video_file'] = $videoPath;
        }

        $video->update($data);

        return redirect()->route('videos.index')->with('success', 'ویڈیو کامیابی سے اپ ڈیٹ ہو گئی!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        // Delete video file if exists
        if ($video->video_file && Storage::disk('public')->exists($video->video_file)) {
            Storage::disk('public')->delete($video->video_file);
        }

        $video->delete();

        return redirect()->route('videos.index')->with('success', 'ویڈیو کامیابی سے ڈیلیٹ ہو گئی!');
    }
}
