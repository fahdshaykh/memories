# Newsletter System Setup - Complete Instructions

## Created Files:

### 1. Database Migration
- **File**: `database/migrations/2026_03_06_061807_create_subscribers_table.php`
- Run migration: `php artisan migrate`

### 2. Model
- **File**: `app/Models/Subscriber.php`
- Fields: email, is_active, verification_token, is_verified

### 3. Request Validation
- **File**: `app/Http/Requests/StoreSubscriberRequest.php`
- Validates email (required, email format, unique)

### 4. Controller
- **File**: `app/Http/Controllers/SubscriberController.php`
- Methods:
  - `subscribe()` - Handle subscription form
  - `unsubscribe()` - Unsubscribe with token
  - `sendNewsletter()` - Send emails to subscribers

### 5. Email Classes
- `app/Mail/SubscriptionConfirmation.php`
- `app/Mail/NewPostNotification.php`
- `app/Mail/NewVideoNotification.php`

### 6. Email Templates
- `resources/views/emails/subscription-confirmation.blade.php`
- `resources/views/emails/new-post-notification.blade.php`
- `resources/views/emails/new-video-notification.blade.php`

### 7. Updated Files
- `resources/views/layouts/footer.blade.php` - Newsletter form
- `routes/web.php` - Added newsletter routes

## Setup Steps:

### Step 1: Run Migration
```bash
php artisan migrate
```

### Step 2: Configure Mail (if not already done)
Edit `.env` file:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Wisherpro"
```

### Step 3: Add Notification Calls to Controllers

#### In PostController - store() method:
Add at the end after post creation:
```php
use App\Http\Controllers\SubscriberController;

// After: Post::create($data);

// Send newsletter to subscribers
if ($data['status'] ?? true) {
    $subscriberController = new SubscriberController();
    $subscriberController->sendNewsletter($post, 'post');
}
```

#### In VideoController - store() method:
Add at the end after video creation:
```php
use App\Http\Controllers\SubscriberController;

// After: Video::create($data);

// Send newsletter to subscribers
if ($data['status'] ?? true) {
    $subscriberController = new SubscriberController();
    $subscriberController->sendNewsletter($video, 'video');
}
```

## Routes Added:
- `POST /subscribe` - Newsletter subscription
- `GET /unsubscribe/{token}` - Unsubscribe link

## Features:
✅ Email subscription form in footer
✅ Email verification system
✅ Unsubscribe functionality
✅ Automatic email when new post is published
✅ Automatic email when new video is uploaded
✅ Urdu language email templates
✅ Success/error messages in footer

## Testing:
1. Subscribe using footer form
2. Check email for confirmation
3. Create a new post/video
4. Check if subscribers receive notification
