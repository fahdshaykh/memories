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

        if($request->image){

            $originalFile = $request->file('image');

            $originalFile->move(public_path().'/post_images/', $post_file = time().'.'.$originalFile->getClientOriginalExtension());

            $post->image = $post_file;

        }

        $post->category_id = $request->category_id;
        $post->title = $request->title;
        // $post->slug = $request->slug;
        $post->content = $request->content;
        $post->published_at = now(); //$request->published_at ? now() : null;
        // $post->save();

        // SLUG LOGIC — SAME AS STORE
        $slug = $request->filled('slug') 
            ? Str::slug($request->slug, '-') 
            : Str::slug($request->title, '-');

        $baseSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $post->slug = $slug;

        $post->save();

        // TAGS
        if ($request->filled('tags')) {
            $tagNames = array_filter(array_map('trim', explode(',', $request->tags)));
            $tagNames = array_map(fn($tag) => preg_match('/[\x{0600}-\x{06FF}]/u', $tag) ? $tag : strtolower($tag), $tagNames);
            $post->syncTags($tagNames);
        } else {
            $post->detachTags($post->tags);
        }
        
        if($request->quote) {

            foreach($request->quote as $key=>$quote) {

                $quote_id = Quote::create([
                    'post_id' => $post->id,
                    'quote' => $quote,
                    'order' => $key
                ]);

            }
            
        }

        session()->flash('status', 'New post was created!');

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
        if($request->image){
            
            $document_path = public_path()."/post_images/".$post->image;  // Value is not URL but directory file path

            if(File::exists($document_path)) {

                File::delete($document_path);
            }

            $originalFile = $request->file('image');

            $originalFile->move(public_path().'/post_images/', $post_file = time().'.'.$originalFile->getClientOriginalExtension());

            $post->image = $post_file;

        }

        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->published_at = now(); //$request->published ? now() : null;

        // SLUG LOGIC — SAME AS STORE
        $slug = $request->filled('slug') 
            ? Str::slug($request->slug, '-') 
            : Str::slug($request->title, '-');

        $baseSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $post->slug = $slug;

        $post->save();

        // TAGS
        if ($request->filled('tags')) {
            $tagNames = array_filter(array_map('trim', explode(',', $request->tags)));
            $tagNames = array_map(fn($tag) => preg_match('/[\x{0600}-\x{06FF}]/u', $tag) ? $tag : strtolower($tag), $tagNames);
            $post->syncTags($tagNames);
        } else {
            $post->detachTags($post->tags);
        }

        Quote::where('post_id', $post->id)->delete();

        if($request->quote) {

            foreach($request->quote as $key => $quote) {

                Quote::create([
                    'quote' => $quote,
                    'post_id' => $post->id,
                    'order' => $key
                ]);

            }
            
        }



        session()->flash('success', 'New post was Updated!');

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Storage::delete($post->image);
        $image_path = public_path()."/post_images/".$post->image;  // Value is not URL but directory file path

        if(File::exists($image_path)) {

            File::delete($image_path);
        }

        $post->delete();

        session()->flash('success', 'New post was Deleted!');

        return redirect()->route('posts.index');
    }
}
