<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Video;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactNotification;

class WelcomeController extends Controller
{
    public function welcome($slug = null)
    {
        $posts = Post::latest()->paginate(10);

        return view('welcome', compact('posts'));
    }

    public function categoryPosts($slug = null)
    {

        $category = Category::where('slug', $slug)->first();
        $posts = Post::latest()->where('category_id', $category->id)->paginate(10);

        return view('posts.category_posts', compact('posts'));
    }

    public function postDetail($slug)
    {
        $post = Post::where('slug', $slug)->first();

        $quotes = Quote::where('post_id', $post->id)
                   ->orderBy('order', 'asc')
                   ->get();

        return view('posts.post', compact('post','quotes'));
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
        $categories = Category::latest()->get();
        return view('galleries.categories', compact('categories'));
    }

    public function gallery($slug)
    {
        $category = Category::where('slug', $slug)->first();

        $galleries = Gallery::where('category_id', $category->id)->latest()->paginate(10);;

        return view('galleries.galleries', compact('galleries', 'category'));
    }

    public function videos()
    {
        $categories = Category::latest()->get();

        return view('videos.categories', compact('categories'));
    }

    public function video($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $videos = Video::where('category_id', $category->id)->latest()->paginate(10);

        return view('videos.video', compact('videos', 'category'));
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function userGuide()
    {
        return view('pages.user-guide');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Save to database
        $contact = Contact::create($validated);

        // Send email notification
        try {
            Mail::to('support@wisherpro.com')->send(new ContactNotification($contact));
        } catch (\Exception $e) {
            // Log error but don't fail the submission
            Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you within 24-48 hours.');
    }

}
