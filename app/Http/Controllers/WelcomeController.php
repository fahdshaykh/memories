<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Quote;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome($slug = null)
    {
        if($slug){
            $category = Category::where('slug', $slug)->first();
            $posts = Post::latest()->where('category_id', $category->id)->paginate(10);
        } else {
            $posts = Post::latest()->paginate(10);
        }

        return view('welcome', compact('posts'));
    }

    public function postDetail($slug)
    {
        $post = Post::where('slug', $slug)->first();

        $quotes = Quote::where('post_id', $post->id)
                   ->orderBy('order', 'asc')
                   ->get();

        return view('post', compact('post','quotes'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $posts = Post::where(function ($query) use ($searchTerm) {
            $query->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('content', 'LIKE', '%' . $searchTerm . '%');
        })->orWhereHas('category', function ($query) use ($searchTerm) {
            $query->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('content', 'LIKE', '%' . $searchTerm . '%');
        })->latest()->paginate(10);


        return view('welcome', compact('posts'));
    }

    public function categories()
    {
        return view('categories');
    }

    public function gallery($slug)
    {
        $category = Category::where('slug', $slug)->first();

        $galleries = Gallery::where('category_id', $category->id)->latest()->paginate(10);;

        return view('galleries', compact('galleries', 'category'));
    }

}
