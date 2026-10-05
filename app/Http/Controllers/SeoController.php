<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\GalleryCategory;
use App\Models\VideoCategory;
use App\Models\Tag;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Generate dynamic XML Sitemap with Google Image Sitemap support
     */
    public function sitemap(): Response
    {
        $posts = Post::latest()->get();
        $postCategories = PostCategory::where('status', 1)->latest()->get();
        $galleryCategories = GalleryCategory::where('status', 1)->latest()->get();
        $videoCategories = VideoCategory::where('status', 1)->latest()->get();
        $tags = class_exists(Tag::class) ? Tag::has('posts')->get() : collect();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

        // 1. Homepage
        $xml .= '<url>';
        $xml .= '<loc>' . htmlspecialchars(url('/')) . '</loc>';
        $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        // 2. Hub / Collection Indexes
        $collections = [
            route('categories.user') => ['priority' => '0.8', 'changefreq' => 'weekly'],
            route('videos.user')     => ['priority' => '0.8', 'changefreq' => 'weekly'],
            route('about.index')     => ['priority' => '0.5', 'changefreq' => 'monthly'],
            route('contact')         => ['priority' => '0.5', 'changefreq' => 'monthly'],
            route('faq')             => ['priority' => '0.5', 'changefreq' => 'monthly'],
            route('terms')           => ['priority' => '0.4', 'changefreq' => 'monthly'],
            route('privacy-policy')  => ['priority' => '0.4', 'changefreq' => 'monthly'],
            route('user-guide')      => ['priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($collections as $url => $meta) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url) . '</loc>';
            $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>' . $meta['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $meta['priority'] . '</priority>';
            $xml .= '</url>';
        }

        // 3. Blog Posts
        foreach ($posts as $post) {
            $loc = $post->canonical_url ?: route('welcome.show', $post->slug);
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($loc) . '</loc>';
            $xml .= '<lastmod>' . ($post->updated_at ? $post->updated_at->toAtomString() : now()->toAtomString()) . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            if ($post->image) {
                $xml .= '<image:image>';
                $xml .= '<image:loc>' . htmlspecialchars(asset('storage/' . $post->image)) . '</image:loc>';
                $xml .= '<image:title>' . htmlspecialchars($post->title) . '</image:title>';
                $xml .= '</image:image>';
            }
            $xml .= '</url>';
        }

        // 4. Post Categories
        foreach ($postCategories as $cat) {
            $loc = $cat->canonical_url ?: route('category.posts', $cat->slug);
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($loc) . '</loc>';
            $xml .= '<lastmod>' . ($cat->updated_at ? $cat->updated_at->toAtomString() : now()->toAtomString()) . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            if ($cat->image) {
                $xml .= '<image:image>';
                $xml .= '<image:loc>' . htmlspecialchars(asset('storage/' . $cat->image)) . '</image:loc>';
                $xml .= '<image:title>' . htmlspecialchars($cat->title) . '</image:title>';
                $xml .= '</image:image>';
            }
            $xml .= '</url>';
        }

        // 5. Gallery Categories
        foreach ($galleryCategories as $gcat) {
            $loc = $gcat->canonical_url ?: route('gallery.show', $gcat->slug);
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($loc) . '</loc>';
            $xml .= '<lastmod>' . ($gcat->updated_at ? $gcat->updated_at->toAtomString() : now()->toAtomString()) . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            if ($gcat->image) {
                $xml .= '<image:image>';
                $xml .= '<image:loc>' . htmlspecialchars(asset('storage/' . $gcat->image)) . '</image:loc>';
                $xml .= '<image:title>' . htmlspecialchars($gcat->title) . '</image:title>';
                $xml .= '</image:image>';
            }
            $xml .= '</url>';
        }

        // 6. Video Categories
        foreach ($videoCategories as $vcat) {
            $loc = $vcat->canonical_url ?: route('video.show', $vcat->slug);
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($loc) . '</loc>';
            $xml .= '<lastmod>' . ($vcat->updated_at ? $vcat->updated_at->toAtomString() : now()->toAtomString()) . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            if ($vcat->image) {
                $xml .= '<image:image>';
                $xml .= '<image:loc>' . htmlspecialchars(asset('storage/' . $vcat->image)) . '</image:loc>';
                $xml .= '<image:title>' . htmlspecialchars($vcat->title) . '</image:title>';
                $xml .= '</image:image>';
            }
            $xml .= '</url>';
        }

        // 7. Tags
        foreach ($tags as $tag) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('tags.show', $tag->name)) . '</loc>';
            $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.6</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8'
        ]);
    }

    /**
     * Generate dynamic robots.txt
     */
    public function robots(): Response
    {
        $robots = "User-agent: *\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /admin/*\n";
        $robots .= "Disallow: /search\n";
        $robots .= "Disallow: /subscribe\n";
        $robots .= "Disallow: /unsubscribe/*\n";
        $robots .= "Allow: /\n\n";
        $robots .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($robots, 200, [
            'Content-Type' => 'text/plain; charset=utf-8'
        ]);
    }

    /**
     * Generate valid RSS 2.0 feed
     */
    public function feed(): Response
    {
        $posts = Post::with('category')->latest()->take(25)->get();

        $rss = '<?xml version="1.0" encoding="UTF-8"?>';
        $rss .= '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom">';
        $rss .= '<channel>';
        $rss .= '<title>' . htmlspecialchars(config('app.name', 'Wisherpro') . ' - Memories, Quotes & Stories') . '</title>';
        $rss .= '<link>' . htmlspecialchars(url('/')) . '</link>';
        $rss .= '<description>' . htmlspecialchars('Discover inspiring life quotes, stories, photography, and video moments on Wisherpro.') . '</description>';
        $rss .= '<language>en-us</language>';
        $rss .= '<lastBuildDate>' . now()->toRfc2822String() . '</lastBuildDate>';
        $rss .= '<atom:link href="' . htmlspecialchars(url('/feed')) . '" rel="self" type="application/rss+xml" />';

        foreach ($posts as $post) {
            $link = route('welcome.show', $post->slug);
            $description = $post->seo_description ?: strip_tags(substr($post->content, 0, 200)) . '...';

            $rss .= '<item>';
            $rss .= '<title>' . htmlspecialchars($post->title) . '</title>';
            $rss .= '<link>' . htmlspecialchars($link) . '</link>';
            $rss .= '<guid isPermaLink="true">' . htmlspecialchars($link) . '</guid>';
            $rss .= '<pubDate>' . ($post->created_at ? $post->created_at->toRfc2822String() : now()->toRfc2822String()) . '</pubDate>';
            $rss .= '<description>' . htmlspecialchars($description) . '</description>';
            $rss .= '<content:encoded><![CDATA[' . $post->content . ']]></content:encoded>';

            if ($post->category) {
                $rss .= '<category>' . htmlspecialchars($post->category->title) . '</category>';
            }

            if ($post->image) {
                $imageUrl = asset('storage/' . $post->image);
                $rss .= '<enclosure url="' . htmlspecialchars($imageUrl) . '" length="0" type="image/jpeg" />';
            }

            $rss .= '</item>';
        }

        $rss .= '</channel>';
        $rss .= '</rss>';

        return response($rss, 200, [
            'Content-Type' => 'application/rss+xml; charset=utf-8'
        ]);
    }
}
