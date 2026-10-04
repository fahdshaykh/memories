<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use App\Models\GalleryCategory;
use App\Models\VideoCategory;
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
        $category = PostCategory::where('slug', $slug)->firstOrFail();
        $posts = Post::latest()->where('category_id', $category->id)->paginate(10);

        return view('posts.category_posts', compact('posts', 'category'));
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
        $searchTerm = trim((string) $request->input('search', ''));
        $type = strtolower((string) $request->input('type', 'all'));

        if (!in_array($type, ['all', 'posts', 'galleries', 'videos'])) {
            $type = 'all';
        }

        $words = array_filter(explode(' ', $searchTerm));

        // 1. Posts Query (with category, tags, and quotes)
        $postsQuery = Post::query()->with(['category', 'tags']);
        if ($searchTerm !== '') {
            $postsQuery->where(function ($q) use ($searchTerm, $words) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('content', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('slug', 'LIKE', '%' . $searchTerm . '%');

                foreach ($words as $word) {
                    $q->orWhere('title', 'LIKE', '%' . $word . '%');
                }

                $q->orWhereHas('quotes', function ($quoteQ) use ($searchTerm) {
                    $quoteQ->where('quote', 'LIKE', '%' . $searchTerm . '%');
                });

                $q->orWhereHas('category', function ($catQ) use ($searchTerm) {
                    $catQ->where('title', 'LIKE', '%' . $searchTerm . '%')
                         ->orWhere('content', 'LIKE', '%' . $searchTerm . '%');
                });

                $q->orWhereHas('tags', function ($tagQ) use ($searchTerm) {
                    $tagQ->where('name', 'LIKE', '%' . $searchTerm . '%');
                });
            });

            $postsQuery->orderByRaw("CASE WHEN title LIKE ? THEN 1 WHEN title LIKE ? THEN 2 ELSE 3 END", [
                $searchTerm . '%',
                '%' . $searchTerm . '%'
            ]);
        }
        $postsQuery->latest();

        // 2. Galleries Query
        $galleriesQuery = Gallery::query()->with('category')->where('status', 1);
        if ($searchTerm !== '') {
            $galleriesQuery->where(function ($q) use ($searchTerm, $words) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('content', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('slug', 'LIKE', '%' . $searchTerm . '%');

                foreach ($words as $word) {
                    $q->orWhere('title', 'LIKE', '%' . $word . '%');
                }

                $q->orWhereHas('category', function ($catQ) use ($searchTerm) {
                    $catQ->where('title', 'LIKE', '%' . $searchTerm . '%')
                         ->orWhere('content', 'LIKE', '%' . $searchTerm . '%');
                });
            });

            $galleriesQuery->orderByRaw("CASE WHEN title LIKE ? THEN 1 WHEN title LIKE ? THEN 2 ELSE 3 END", [
                $searchTerm . '%',
                '%' . $searchTerm . '%'
            ]);
        }
        $galleriesQuery->latest();

        // 3. Videos Query
        $videosQuery = Video::query()->with('category')->where('status', 1);
        if ($searchTerm !== '') {
            $videosQuery->where(function ($q) use ($searchTerm, $words) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('content', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('slug', 'LIKE', '%' . $searchTerm . '%');

                foreach ($words as $word) {
                    $q->orWhere('title', 'LIKE', '%' . $word . '%');
                }

                $q->orWhereHas('category', function ($catQ) use ($searchTerm) {
                    $catQ->where('title', 'LIKE', '%' . $searchTerm . '%')
                         ->orWhere('content', 'LIKE', '%' . $searchTerm . '%');
                });
            });

            $videosQuery->orderByRaw("CASE WHEN title LIKE ? THEN 1 WHEN title LIKE ? THEN 2 ELSE 3 END", [
                $searchTerm . '%',
                '%' . $searchTerm . '%'
            ]);
        }
        $videosQuery->latest();

        // Compute counts across all content types
        $postsCount = (clone $postsQuery)->count();
        $galleriesCount = (clone $galleriesQuery)->count();
        $videosCount = (clone $videosQuery)->count();
        $totalAll = $postsCount + $galleriesCount + $videosCount;

        $counts = [
            'all' => $totalAll,
            'posts' => $postsCount,
            'galleries' => $galleriesCount,
            'videos' => $videosCount,
        ];

        // Fetch data based on requested type
        if ($type === 'posts') {
            $posts = $postsQuery->paginate(10)->withQueryString();
            $galleries = collect();
            $videos = collect();
        } elseif ($type === 'galleries') {
            $posts = collect();
            $galleries = $galleriesQuery->paginate(12)->withQueryString();
            $videos = collect();
        } elseif ($type === 'videos') {
            $posts = collect();
            $galleries = collect();
            $videos = $videosQuery->paginate(12)->withQueryString();
        } else {
            // 'all': Show top results for each section
            $posts = (clone $postsQuery)->take(6)->get();
            $galleries = (clone $galleriesQuery)->take(6)->get();
            $videos = (clone $videosQuery)->take(6)->get();
        }

        return view('pages.search_results', compact('posts', 'galleries', 'videos', 'searchTerm', 'type', 'counts', 'totalAll'));
    }

    public function categories()
    {
        $categories = GalleryCategory::where('status', 1)->latest()->get();
        return view('galleries.categories', compact('categories'));
    }

    public function gallery($slug)
    {
        $category = GalleryCategory::where('slug', $slug)->firstOrFail();

        $galleries = Gallery::where('category_id', $category->id)->latest()->paginate(10);

        return view('galleries.galleries', compact('galleries', 'category'));
    }

    public function videos()
    {
        $categories = VideoCategory::where('status', 1)->latest()->get();

        return view('videos.categories', compact('categories'));
    }

    public function video($slug)
    {
        $category = VideoCategory::where('slug', $slug)->firstOrFail();
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
