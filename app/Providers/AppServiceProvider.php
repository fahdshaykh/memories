<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View::share('categories', Category::withCount('posts')->where('status', '1')->get());
        $categories = Category::withCount('posts')->where('status', '1')->get();
        $latestPosts = Post::where('status', 'published')   
                            ->orderBy('created_at', 'desc') 
                            ->limit(10)                    
                            ->get();
    
        View::share([
            'categories' => $categories,
            'latestPosts' => $latestPosts,  // Share the latest 10 posts
        ]);
        Schema::defaultStringLength(191);
    }
}
