<div id="eskimo-panels">
    <aside id="eskimo-panel" class="eskimo-panel">
        <div class="eskimo-panel-inner">
            <!-- CLOSE SLIDE PANEL BUTTON -->
            <a href="#" class="eskimo-panel-close"><i class="fa fa-times"></i></a>
            <!-- AUTHOR BOX -->

            <!-- RECENT POSTS -->
            <div class="eskimo-recent-entries eskimo-widget">
                <h5 class="eskimo-title-with-border"><span>Recent Posts</span></h5>
                <ul>
                    @foreach($latestPosts as $post)
                    <li>
                        <a href="{{ route('welcome.show', $post->slug) }}">{{ $post->title }}</a>
                        <span class="post-date">{{ $post->created_at->diffForHumans(); }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- CATEGORIES -->
            <div class="eskimo-categories eskimo-widget">
                <h5 class="eskimo-title-with-border"><span>Categories</span></h5>
                <ul>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('category.posts', $category->slug) }}" title="An up-to-date, personal urban guide.">{{ $category->title }}</a> <span class="badge badge-pill badge-default">{{ $category->posts_count }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- TAGS -->
            <div class="eskimo-widget">
                <h5 class="eskimo-title-with-border"><span>Tags</span></h5>
                <div class="eskimo-tag-cloud">
                    @foreach($popularTags as $tag)
                    <a href="{{ route('tags.show', $tag->slug) }}">{{ $tag->name }}<span>{{ $tag->posts_count }}</span></a>
                    @endforeach
                </div>
            </div>
        </div>
    </aside>
</div>