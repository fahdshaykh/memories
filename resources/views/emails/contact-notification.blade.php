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
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .field-value {
            background-color: #f9f9f9;
            padding: 10px;
            border-left: 3px solid #333;
            margin-top: 5px;
        }
        .message-content {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 3px solid #333;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 New Contact Message</h1>
        </div>

        <div class="content">
            <p>You have received a new message through the contact form.</p>

            <div class="field">
                <div class="field-label">From:</div>
                <div class="field-value">{{ $contact->name }} ({{ $contact->email }})</div>
            </div>

            <div class="field">
                <div class="field-label">Subject:</div>
                <div class="field-value">{{ $contact->subject }}</div>
            </div>

            <div class="field">
                <div class="field-label">Message:</div>
                <div class="message-content">{{ $contact->message }}</div>
            </div>

            <div class="field">
                <div class="field-label">Received:</div>
                <div class="field-value">{{ $contact->created_at->format('l, F j, Y \a\t g:i A') }}</div>
            </div>

            <p style="text-align: center;">
                <a href="mailto:{{ $contact->email }}" class="button">Reply via Email</a>
            </p>
        </div>

        <div class="footer">
            <p>This message was sent from the Wisherpro contact form.</p>
            <p>&copy; {{ date('Y') }} Wisherpro. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
