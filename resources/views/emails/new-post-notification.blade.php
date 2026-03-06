<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        .header h1 {
            color: #333;
            margin: 0;
        }
        .content {
            padding: 20px 0;
        }
        .post-title {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .post-meta {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Wisherpro - New Post</h1>
        </div>

        <div class="content">
            <h2 class="post-title">{{ $post->title }}</h2>

            <p class="post-meta">
                @if(isset($post->category) && $post->category)
                Category: {{ $post->category->title }} |
                @endif
                Date: {{ \Carbon\Carbon::parse($post->published_at ?? $post->created_at ?? now())->format('d M Y') }}
            </p>

            <p>Hello!</p>

            <p>A new post has been published on our blog.</p>

            <p><strong>{{ $post->title }}</strong></p>

            <p>{{ Str::limit(strip_tags($post->content), 200) }}</p>

            <p style="text-align: center;">
                <a href="{{ route('welcome.show', $post->slug) }}" class="button">Read Full Post</a>
            </p>
        </div>

        <div class="footer">
            <p>If you no longer wish to receive these emails, <a href="{{ route('unsubscribe', $subscriber ? $subscriber->verification_token : 'your-token-here') }}">click here to unsubscribe</a>.</p>
            <p>&copy; {{ date('Y') }} Wisherpro. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
