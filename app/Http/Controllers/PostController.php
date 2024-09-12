<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        $post->slug = $request->slug;
        $post->content = $request->content;
        $post->save();

        
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

        return view('dashboard.posts.edit', [
            'post' => $post,
            'quotes' => $quotes,
            'categories' => $categories
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
        $post->slug = $request->slug;
        $post->content = $request->content;
        $post->save();

        

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
