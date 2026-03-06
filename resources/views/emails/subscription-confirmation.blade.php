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
        .content p {
            margin-bottom: 15px;
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
            <h1>Welcome to Wisherpro</h1>
        </div>

        <div class="content">
            <h2>Subscription Confirmation</h2>

            <p>Hello!</p>

            <p>Thank you for subscribing to our newsletter! You will now receive updates about our new posts and videos.</p>

            <p>We'll keep you informed about the latest content, articles, and videos from our blog.</p>

            <p>If you ever wish to unsubscribe, you can click the link below:</p>

            <p style="text-align: center;">
                <a href="{{ route('unsubscribe', $subscriber->verification_token) }}" class="button">Unsubscribe</a>
            </p>
        </div>

        <div class="footer">
            <p>This email was sent automatically. Please do not reply.</p>
            <p>&copy; {{ date('Y') }} Wisherpro. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
