<?php

namespace App\Http\Controllers;

use Spatie\Tags\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($tag) // Sirf slug milega
    {
        $tag = Tag::findFromString($tag);

        if (!$tag) {
            abort(404, 'Tag not found');
        }

        $posts = Post::withAnyTags([$tag->name])
                    ->published()
                    ->latest()
                    ->paginate(12);

        return view('tags.show', compact('tag', 'posts'));
    }
}
