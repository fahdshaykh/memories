<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Spatie\Tags\Tag;

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
		if (Schema::hasTable('categories') && Schema::hasTable('posts')) {
			$categories = Category::withCount('posts')
				->where('status', '1')
                ->latest()
				->limit(5)
				->get();

			$latestPosts = Post::where('status', 'published')
				->orderBy('created_at', 'desc')
                ->latest()
				->limit(5)
				->get();

			// TAGS WITH POST COUNT (YE WAHI HAI JO TUM CHAHTE HO!)
			$popularTags = \Spatie\Tags\Tag::query()
            ->select('tags.*', DB::raw('COUNT(taggables.taggable_id) as posts_count'))
            ->join('taggables', function ($join) {
                $join->on('tags.id', '=', 'taggables.tag_id')
                     ->where('taggables.taggable_type', '=', 'App\\Models\\Post');
            })
            ->join('posts', 'posts.id', '=', 'taggables.taggable_id')
            ->where('posts.status', '=', 'published')
            ->groupBy('tags.id')
            ->orderByDesc('posts_count')
            ->latest()
            ->limit(20)
            ->get();

			View::share([
				'categories'  => $categories,
				'latestPosts' => $latestPosts,
				'popularTags'  => $popularTags,
			]);
		}

		Schema::defaultStringLength(191);
	}

}
