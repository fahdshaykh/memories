<?php

namespace App\Providers;

use App\Models\PostCategory;
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
		Schema::defaultStringLength(191);

		if (Schema::hasTable('post_categories') && Schema::hasTable('posts')) {
			$categories = PostCategory::withCount('posts')
				->where('status', '1')
                ->latest()
				->limit(5)
				->get();
		} else {
			$categories = collect();
		}

		if (Schema::hasTable('posts')) {
			$latestPosts = Post::where('status', 'published')
				->orderBy('created_at', 'desc')
                ->latest()
				->limit(5)
				->get();

			// TAGS WITH POST COUNT
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
	}
}
