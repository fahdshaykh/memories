<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('/search', [WelcomeController::class, 'search'])->name('search.posts');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');

Route::get('/post/{slug?}', [WelcomeController::class, 'postDetail'])->name('welcome.show');
Route::get('/category/{slug?}', [WelcomeController::class, 'categoryPosts'])->name('category.posts');

//this is gallery module sectio
Route::get('/categories/all', [WelcomeController::class, 'categories'])->name('categories.user');
Route::get('/categories/{slug?}', [WelcomeController::class, 'gallery'])->name('gallery.show');

Route::get('/videos/all', [WelcomeController::class, 'videos'])->name('videos.user');
Route::get('/videos/{slug?}', [WelcomeController::class, 'video'])->name('video.show');

Route::view('/about-us', 'about')->name('about.index');

/*
|--------------------------------------------------------------------------
| Pages Routes
|--------------------------------------------------------------------------
*/
Route::get('/faq', [WelcomeController::class, 'faq'])->name('faq');
Route::get('/user-guide', [WelcomeController::class, 'userGuide'])->name('user-guide');
Route::get('/terms', [WelcomeController::class, 'terms'])->name('terms');
Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');
Route::post('/contact', [WelcomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/privacy-policy', [WelcomeController::class, 'privacyPolicy'])->name('privacy-policy');

Route::prefix('admin')->group(function () {
    // Login Routes
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login'); // name it as 'admin.login' for specificity
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('categories', CategoryController::class);
    Route::get('category-status', [CategoryController::class, 'categoryStatus']);

    Route::resource('posts', PostController::class);

    Route::resource('galleries', GalleryController::class);

    Route::resource('videos', VideoController::class);

    // Contact Routes
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
    Route::put('contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::put('contacts/{contact}/mark-unread', [ContactController::class, 'markAsUnread'])->name('contacts.mark-unread');
});
// require __DIR__.'/auth.php';

use App\Http\Controllers\SubscriberController;

/*
|--------------------------------------------------------------------------
| Newsletter Routes
|--------------------------------------------------------------------------
*/
Route::post('/subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');
Route::get('/unsubscribe/{token}', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');

