<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('/{slug?}', [WelcomeController::class, 'postDetail'])->name('welcome.show');
Route::get('/category/{slug?}', [WelcomeController::class, 'welcome'])->name('category.posts');
Route::get('/', [WelcomeController::class, 'search'])->name('search.posts');

Route::view('/about-us', 'about')->name('about.index');

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
});
// require __DIR__.'/auth.php';
