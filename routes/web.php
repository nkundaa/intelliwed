<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BudgetSuggestionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WeddingProfileController;
use Illuminate\Support\Facades\Route;

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

// Language Switch
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session(['locale' => $locale]);
        if (auth()->check()) {
            auth()->user()->update(['locale' => $locale]);
        }
    }
    return redirect()->back();
})->name('language.switch');

// Force English if locale is 'rw'
Route::middleware(['web'])->group(function () {
    Route::get('/force-en', function() {
        session(['locale' => 'en']);
        if (auth()->check()) {
            auth()->user()->update(['locale' => 'en']);
        }
        return redirect()->route('home');
    })->name('force.en');
});

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Public wedding website
Route::get('/wedding/{slug}', [WeddingProfileController::class, 'publicSite'])->name('wedding.site');

// Traditional Rwandan ceremonies info page
Route::get('/rwandan-ceremonies', function () {
    return view('ceremonies.rwandan');
})->name('ceremonies.rwandan');

// Public routes
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show')->whereNumber('service');
Route::get('/vendors', [ServiceController::class, 'vendorsIndex'])->name('vendors.index');
Route::get('/vendors/{vendor}', [ServiceController::class, 'vendorShow'])->name('vendors.show');

// RSVP Public Routes
Route::get('/rsvp/{token}', [\App\Http\Controllers\RsvpController::class, 'show'])->name('rsvp.show');
Route::post('/rsvp/{token}', [\App\Http\Controllers\RsvpController::class, 'submit'])->name('rsvp.submit');

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Budget Planner
    Route::get('/budget-planner', [BookingController::class, 'budgetPlanner'])->name('budget.planner');
    Route::post('/suggest-services', [BookingController::class, 'suggestServices'])->name('suggest.services');
    Route::post('/auto-book', [BookingController::class, 'autoBook'])->name('auto.book');
    
    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    
    // Cart management
    Route::post('/cart/add/{service}', [BookingController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{serviceId}', [BookingController::class, 'removeFromCart'])->name('cart.remove');

    Route::get('/bookings/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::post('/bookings/checkout', [BookingController::class, 'processCheckout'])->name('bookings.process-checkout');
    
    // Invitations
    Route::resource('invitations', \App\Http\Controllers\InvitationController::class);
    
    // Payments
    Route::get('/bookings/{booking}/payment', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/bookings/{booking}/pay', [\App\Http\Controllers\PaymentController::class, 'initiate'])->name('payments.initiate');
    Route::get('/payments/{payment}/status', [\App\Http\Controllers\PaymentController::class, 'status'])->name('payments.status');
    Route::post('/webhooks/payments/{provider}', [\App\Http\Controllers\PaymentController::class, 'webhook'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    
    // Vendor bookings (for vendors only)
    Route::get('/vendor/bookings', [BookingController::class, 'vendorBookings'])->name('bookings.vendor');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
    
    // Client booking cancellation
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Vendor Service Management
    Route::get('/vendor/services', [ServiceController::class, 'vendorServices'])->name('services.vendor');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    
    // Vendor Verification
    Route::get('/vendor/verification', [\App\Http\Controllers\VerificationController::class, 'index'])->name('vendor.verification');
    Route::post('/vendor/verification', [\App\Http\Controllers\VerificationController::class, 'store'])->name('vendor.verification.store');

    // AI Tools
    Route::get('/ai/budget', [\App\Http\Controllers\AiBudgetController::class, 'index'])->name('ai.budget');
    Route::post('/ai/budget/optimize', [\App\Http\Controllers\AiBudgetController::class, 'optimize'])->name('ai.budget.optimize');
    Route::get('/ai/planner', [\App\Http\Controllers\AiBudgetController::class, 'planner'])->name('ai.planner');
    Route::post('/ai/planner/suggest', [\App\Http\Controllers\AiBudgetController::class, 'planSuggest'])->name('ai.planner.suggest');
    Route::get('/ai/match', [\App\Http\Controllers\AiMatchmakingController::class, 'index'])->name('ai.match');
    Route::post('/ai/match', [\App\Http\Controllers\AiMatchmakingController::class, 'match'])->name('ai.match.process');
    
    // Wedding Profile
    Route::get('/wedding-profile', [WeddingProfileController::class, 'index'])->name('wedding.profile');
    Route::post('/wedding-profile', [WeddingProfileController::class, 'store'])->name('wedding.profile.store');
    Route::post('/wedding-profile/generate-slug', [WeddingProfileController::class, 'generateSlug'])->name('wedding.profile.slug');

    // Tasks / Checklist
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');

    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::patch('/gallery/{photo}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{photo}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    // Reviews
    Route::post('/services/{service}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::get('/chat/start/{vendor}', [ChatController::class, 'startOrOpen'])->name('chat.start');
    Route::post('/chat/{conversation}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{conversation}/poll/{lastId?}', [ChatController::class, 'poll'])->name('chat.poll');

    // Notifications
    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);
        auth()->user()->unreadNotifications->markAsRead();
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    Route::post('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.mark-read');

    // Admin routes
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('bookings.admin-index');
        Route::patch('/admin/bookings/{booking}', [BookingController::class, 'adminUpdate'])->name('bookings.admin-update');
        Route::delete('/admin/bookings/{booking}', [BookingController::class, 'adminDestroy'])->name('bookings.admin-destroy');
        
        // Admin Verification Management
        Route::get('/admin/verifications', [\App\Http\Controllers\VerificationController::class, 'adminIndex'])->name('admin.verifications');
        Route::post('/admin/verifications/{verificationRequest}/review', [\App\Http\Controllers\VerificationController::class, 'adminReview'])->name('admin.verifications.review');
    });
});

// Logout route
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');