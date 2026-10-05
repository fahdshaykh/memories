<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\GalleryCategory;
use App\Models\VideoCategory;
use App\Models\Quote;
use App\Models\Tag;

class SeoSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========================================================
        // 1. POST CATEGORIES WITH SEO METADATA
        // ========================================================
        $catWisdom = PostCategory::updateOrCreate(
            ['slug' => 'life-wisdom'],
            [
                'title'            => 'Life Wisdom',
                'content'          => 'Inspiring quotes, profound reflections, and timeless life advice to help you navigate modern life with clarity and peace.',
                'meta_title'       => 'Best Life Wisdom Quotes & Meaningful Sayings | Wisherpro',
                'meta_description' => 'Discover inspiring life wisdom quotes, uplifting words of wisdom, and timeless life advice to bring clarity, peace, and mindfulness to your daily journey.',
                'meta_keywords'    => 'life quotes, wisdom quotes, words of wisdom, life advice, inspirational thoughts',
                'canonical_url'    => null,
                'image'            => 'category_images/1791150671_6ac2ca4fd06bd.webp',
                'status'           => 1,
            ]
        );

        $catMemories = PostCategory::updateOrCreate(
            ['slug' => 'memories-and-nostalgia'],
            [
                'title'            => 'Memories & Nostalgia',
                'content'          => 'Cherishing the beautiful footprints of the past, nostalgic moments, and heartwarming reminiscences of life.',
                'meta_title'       => 'Cherished Memories & Nostalgic Life Stories | Wisherpro',
                'meta_description' => 'Relive meaningful moments through heartfelt memories, nostalgic storytelling, and personal reflections on love, family, and friendships.',
                'meta_keywords'    => 'cherished memories, life stories, nostalgic moments, family memories, keepsake stories',
                'canonical_url'    => null,
                'image'            => 'category_images/1791146931_6ac2bbb38ae83.webp',
                'status'           => 1,
            ]
        );

        $catMindset = PostCategory::updateOrCreate(
            ['slug' => 'mindset-and-motivation'],
            [
                'title'            => 'Mindset & Motivation',
                'content'          => 'Fuel your daily drive, cultivate resilience, and develop an unstoppable growth mindset with curated thoughts and quotes.',
                'meta_title'       => 'Daily Motivational Quotes & Growth Mindset Sayings | Wisherpro',
                'meta_description' => 'Boost your focus and resilience with powerful motivational quotes, growth mindset sayings, and daily encouragement to reach your personal goals.',
                'meta_keywords'    => 'motivational quotes, growth mindset, daily drive, success quotes, resilience',
                'canonical_url'    => null,
                'image'            => 'category_images/1791146961_6ac2bbd1f15d0.webp',
                'status'           => 1,
            ]
        );

        // Update existing 'happy' category if present
        $catHappy = PostCategory::where('slug', 'happy')->first();
        if ($catHappy) {
            $catHappy->update([
                'meta_title'       => 'Happy Quotes & Joyful Thoughts on Living a Good Life | Wisherpro',
                'meta_description' => 'Brighten your day with joyful quotes, uplifting thoughts on happiness, and heartwarming reminders to celebrate life\'s simple pleasures.',
                'meta_keywords'    => 'happy quotes, quotes about happiness, joy, positive thoughts, cheerful sayings',
            ]);
        }

        // ========================================================
        // 2. SAMPLE POST 1: Life Wisdom
        // ========================================================
        $post1 = Post::updateOrCreate(
            ['slug' => '10-timeless-life-quotes-that-will-change-your-perspective'],
            [
                'category_id'      => $catWisdom->id,
                'title'            => '10 Timeless Life Quotes That Will Change Your Perspective',
                'meta_title'       => '10 Timeless Life Quotes to Transform Your Daily Perspective',
                'meta_description' => 'Explore 10 powerful life quotes and deep reflections designed to cultivate resilience, gratitude, and inner peace in times of uncertainty and growth.',
                'meta_keywords'    => 'life quotes, timeless quotes, positive mindset, quotes about life, perspective quotes',
                'canonical_url'    => null,
                'image'            => 'post_images/1762960472.webp',
                'published_at'     => now()->subDays(2),
                'content'          => '<h2>Shifting Perspective: The Secret to Long-Term Contentment</h2>
<p>In the whirlwind of everyday responsibilities, deadlines, and digital noise, it is remarkably easy to lose sight of the bigger picture. True wisdom often arrives not in complicated theories, but in brief, concentrated sentences that gently reorient our worldview.</p>

<p>When you encounter a quote that resonates deeply, it acts as a mental anchor. Psychologists call this <em>cognitive reframing</em>—the deliberate practice of observing a stressful situation through a renewed lens of possibility and gratitude.</p>

<h3>1. Mastering Your Reaction to Events</h3>
<p>We cannot control external circumstances, but we possess absolute sovereignty over how we respond to them. When facing unforeseen obstacles, pause for thirty seconds before reacting. Ask yourself: <strong>Will this matter a year from now?</strong> Most difficulties immediately shrink to manageable sizes.</p>

<h3>2. The Compound Power of Daily Choices</h3>
<p>Small, consistent actions carried out with love and integrity will invariably outshine occasional grand gestures. Whether reading five pages of a book or pausing to express appreciation to a friend, our daily habits become our fate.</p>

<p>Take these insights with you into your week. Let them remind you that peace of mind is an inside job, accessible whenever you decide to slow down and reflect.</p>',
            ]
        );

        // Tags and Quotes for Post 1
        $post1->syncTags(['life-quotes', 'mindset', 'perspective', 'wisdom']);
        Quote::where('post_id', $post1->id)->delete();
        Quote::create(['post_id' => $post1->id, 'quote' => 'Life is 10% what happens to you and 90% how you react to it.', 'order' => 1]);
        Quote::create(['post_id' => $post1->id, 'quote' => 'The only way to do great work is to love what you do.', 'order' => 2]);
        Quote::create(['post_id' => $post1->id, 'quote' => 'In the middle of every difficulty lies opportunity.', 'order' => 3]);


        // ========================================================
        // 3. SAMPLE POST 2: Memories & Storytelling
        // ========================================================
        $post2 = Post::updateOrCreate(
            ['slug' => 'the-art-of-preserving-beautiful-memories-in-the-digital-age'],
            [
                'category_id'      => $catMemories->id,
                'title'            => 'The Art of Preserving Beautiful Memories in the Digital Age',
                'meta_title'       => 'How to Preserve Cherished Life Memories in the Digital Age',
                'meta_description' => 'Learn creative techniques to safeguard your personal stories, family photos, and nostalgic life moments so they remain unforgettable for future generations.',
                'meta_keywords'    => 'preserving memories, photo memories, life stories, memory keeping, digital preservation',
                'canonical_url'    => null,
                'image'            => 'post_images/1762961059.webp',
                'published_at'     => now()->subDay(),
                'content'          => '<h2>Why Tangible Memories Matter More Than Ever</h2>
<p>Today, billions of photographs are captured each day on smartphones across the globe. Yet paradoxically, we preserve fewer enduring physical artifacts of our lives than generations before us. Hard drives fail, cloud libraries become overwhelmed by duplicate screenshots, and cherished milestones risk becoming forgotten files.</p>

<p>Preserving memories is an active art form. It requires stepping back from passive hoarding and consciously curating the moments that define who we are.</p>

<h3>Practical Steps for Meaningful Memory-Keeping:</h3>
<ul>
    <li><strong>Curate Annual Keepsake Photo Albums:</strong> Rather than storing tens of thousands of unsorted snaps, select your top 50 photos each year and compile them into a hardcover book.</li>
    <li><strong>Record Audio Stories:</strong> Interview older family members and close friends using voice memos. Hearing the timbre and laughter of a loved one\'s voice conveys emotion no text message can match.</li>
    <li><strong>Write Milestone Journal Entries:</strong> Capture the sensory details—the scent of rain during that road trip, the nervous excitement before a first speech, the comfort of your grandmother\'s kitchen.</li>
</ul>

<p>Your memories are your story. Treat them like the priceless family treasures they truly are.</p>',
            ]
        );

        // Tags and Quotes for Post 2
        $post2->syncTags(['memories', 'storytelling', 'photography', 'nostalgia']);
        Quote::where('post_id', $post2->id)->delete();
        Quote::create(['post_id' => $post2->id, 'quote' => 'We do not remember days; we remember moments.', 'order' => 1]);
        Quote::create(['post_id' => $post2->id, 'quote' => 'Memories are the architecture of our identity, built from the moments we hold close.', 'order' => 2]);


        // ========================================================
        // 4. SAMPLE POST 3: Motivation & Daily Drive
        // ========================================================
        $post3 = Post::updateOrCreate(
            ['slug' => '25-short-inspirational-quotes-to-ignite-your-daily-motivation'],
            [
                'category_id'      => $catMindset->id,
                'title'            => '25 Short Inspirational Quotes to Ignite Your Daily Motivation',
                'meta_title'       => '25 Short Inspirational Quotes to Ignite Daily Motivation',
                'meta_description' => 'Need a quick spark of courage? Read these 25 short, punchy inspirational quotes crafted to reset your focus and empower your daily achievements.',
                'meta_keywords'    => 'short inspirational quotes, daily motivation, quick quotes, motivational sayings, focus quotes',
                'canonical_url'    => null,
                'image'            => 'post_images/1762961112.webp',
                'published_at'     => now(),
                'content'          => '<h2>Instant Clarity in Fewer than 10 Words</h2>
<p>Procrastination rarely stems from laziness; more often, it is caused by feeling overwhelmed. When a project seems too massive or life demands pull in competing directions, lengthy lectures do little to help. What you need is an immediate spark of momentum.</p>

<p>Here are concise, high-impact principles to restart your engine today:</p>

<h3>Core Mindset Principles to Live By</h3>
<ol>
    <li><strong>Start where you are:</strong> Perfectionism is the enemy of progress. Execution beats contemplation.</li>
    <li><strong>Energy follows action:</strong> Do not wait for motivation to strike. Begin the first five minutes of work, and motivation will catch up with you.</li>
    <li><strong>Protect your attention:</strong> Where focus goes, energy flows. Shield your mornings from notifications and direct your energy toward what moves the needle.</li>
</ol>

<p>Repeat your favorite mantra aloud before beginning your most challenging assignment today. Notice how a single shift in attitude transforms your output.</p>',
            ]
        );

        // Tags and Quotes for Post 3
        $post3->syncTags(['motivation', 'daily-quotes', 'success', 'positivity']);
        Quote::where('post_id', $post3->id)->delete();
        Quote::create(['post_id' => $post3->id, 'quote' => 'Start where you are. Use what you have. Do what you can.', 'order' => 1]);
        Quote::create(['post_id' => $post3->id, 'quote' => 'Dream big and dare to fail.', 'order' => 2]);
        Quote::create(['post_id' => $post3->id, 'quote' => 'Action is the foundational key to all success.', 'order' => 3]);


        // ========================================================
        // 5. GALLERY CATEGORY & VIDEO CATEGORY SEO SAMPLES
        // ========================================================
        GalleryCategory::updateOrCreate(
            ['slug' => 'nature-and-landscapes'],
            [
                'title'            => 'Nature & Landscapes',
                'content'          => 'Immerse yourself in breathtaking scenery, tranquil mountains, ocean horizons, and golden hour photography.',
                'meta_title'       => 'Breathtaking Nature & Landscape Photography | Wisherpro',
                'meta_description' => 'Immerse yourself in stunning high-resolution photography capturing serene mountain vistas, sunset shores, and tranquil natural wonders.',
                'meta_keywords'    => 'nature photography, landscape photos, nature gallery, scenic photography, outdoor photos',
                'canonical_url'    => null,
                'image'            => 'category_images/1791146931_6ac2bbb38ae83.webp',
                'status'           => 1,
            ]
        );

        VideoCategory::updateOrCreate(
            ['slug' => 'inspirational-short-stories'],
            [
                'title'            => 'Inspirational Short Stories',
                'content'          => 'Cinematic video shorts, motivational anecdotes, and uplifting reflections on living with passion.',
                'meta_title'       => 'Inspirational Short Video Stories & Life Lessons | Wisherpro',
                'meta_description' => 'Watch uplifting short video stories, cinematic reflections, and life-affirming moments curated to give you courage and hope.',
                'meta_keywords'    => 'inspirational videos, short stories, video quotes, cinematic reflections, life lessons',
                'canonical_url'    => null,
                'image'            => 'category_images/1791146961_6ac2bbd1f15d0.webp',
                'status'           => 1,
            ]
        );
    }
}
