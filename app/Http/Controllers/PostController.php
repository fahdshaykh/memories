<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SubscriberController;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->get();

        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', true)->get();
        return view('dashboard.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.webp';

            // Intervention se process
            $img = Image::make($image->getRealPath());
            // $img->resize(1200, 700, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // })->crop(1200, 700);
            $img->encode('webp', 90);

            // Storage mein save karo
            $path = 'post_images/' . $filename;
            Storage::disk('public')->put($path, $img->stream()->__toString());

            $post->image = $path; // DB mein path save
        }

        // Baki sab same...
        $post->category_id = $request->category_id;
        $post->title       = $request->title;
        $post->content     = $request->content;
        $post->published_at = now();

        // Slug logic...
        $slug = $request->filled('slug') ? Str::slug($request->slug, '-') : Str::slug($request->title, '-');
        $baseSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }
        $post->slug = $slug;
        $post->save();

        // Tags + Quotes same...
        if ($request->filled('tags')) {
            $tagNames = array_filter(array_map('trim', explode(',', $request->tags)));
            $tagNames = array_map(fn($tag) => preg_match('/[\x{0600}-\x{06FF}]/u', $tag) ? $tag : strtolower($tag), $tagNames);
            $post->syncTags($tagNames);
        }

        if ($request->quote && is_array($request->quote)) {
            foreach ($request->quote as $key => $quote) {
                if (!empty(trim($quote))) {
                    Quote::create(['post_id' => $post->id, 'quote' => $quote, 'order' => $key]);
                }
            }
        }

        session()->flash('status', 'Post created successfully!');

        // Send newsletter to subscribers
        try {
            $subscriberController = new SubscriberController();
            $subscriberController->sendNewsletter($post, 'post');
        } catch (\Exception $e) {
            // Log error but don't fail the post creation
            \Log::error('Newsletter send failed: ' . $e->getMessage());
        }
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::where('status', true)->get();

        $quotes = Quote::where('post_id', $post->id)
                   ->orderBy('order', 'asc')
                   ->get();

        $existingTags = $post->tags->pluck('name')->implode(', ');

        return view('dashboard.posts.edit', [
            'post' => $post,
            'quotes' => $quotes,
            'categories' => $categories,
            'existingTags' => $existingTags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($request->hasFile('image')) {
            // Purani image delete
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $image = $request->file('image');
            $filename = time() . '.webp';

            $img = Image::make($image->getRealPath());
            // $img->resize(1200, 700, fn($c) => $c->aspectRatio()->upsize())->crop(1200, 700);
            $img->encode('webp', 90);

            $path = 'post_images/' . $filename;
            Storage::disk('public')->put($path, $img->stream()->__toString());

            $post->image = $path;
        }

        // Baki sab same...
        $post->category_id = $request->category_id;
        $post->title       = $request->title;
        $post->content     = $request->content;
        $post->published_at = now();

        $slug = $request->filled('slug') ? Str::slug($request->slug, '-') : Str::slug($request->title, '-');
        $baseSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }
        $post->slug = $slug;

        $post->save();

        // Tags + Quotes same...
        if ($request->filled('tags')) {
            $tagNames = array_filter(array_map('trim', explode(',', $request->tags)));
            $tagNames = array_map(fn($tag) => preg_match('/[\x{0600}-\x{06FF}]/u', $tag) ? $tag : strtolower($tag), $tagNames);
            $post->syncTags($tagNames);
        } else {
            $post->detachTags($post->tags);
        }

        Quote::where('post_id', $post->id)->delete();
        if ($request->quote && is_array($request->quote)) {
            foreach ($request->quote as $key => $quote) {
                if (!empty(trim($quote))) {
                    Quote::create(['post_id' => $post->id, 'quote' => $quote, 'order' => $key]);
                }
            }
        }

        session()->flash('success', 'Post updated successfully!');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        session()->flash('success', 'Post deleted successfully!');
        return redirect()->route('posts.index');
    }
}
