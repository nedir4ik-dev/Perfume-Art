<?php

use App\Http\Controllers\Admin\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TickerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\WishlistController;

// 1. Myhmanlar (Userler) üçin umumy marşrutlar
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/cart/get-data', [ProductController::class, 'getCartData'])->name('cart.data');
Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [ProductController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [ProductController::class, 'removeFromCart'])->name('cart.remove');
Route::view('/contact', 'app.contact')->name('contact');
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
Route::get('/success', [OrderController::class, 'success'])->name('pages.success');
Route::get('/search-products', [ProductController::class, 'liveSearch'])->name('live-search');
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])
    ->name('wishlist.toggle')
    ->middleware('auth');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');
Route::view('/terms-of-service', 'pages.terms')->name('terms');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');

// 2. Diňe myhmanlar üçin Login sahypasy
Route::middleware(["guest", "throttle:5,1"])->group(function () {

    Route::get('/admin/login', function () {
        return view('auth.login');
    })->name("login");

    Route::post('/admin/login', [LoginController::class, 'login']);
    Route::get('forget-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // 2. Täze parol ýazylýan sahypa (Emaildäki linkden gelýän ýeri)
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::get('locale/{locale}', [HomeController::class, 'locale'])->name('locale')->where('locale', '[a-z]+');
    Route::post('/logout', [LoginController::class, 'logout'])->name("logout");

    Route::prefix('admin')->name('admin.')->group(function () {


        // --- DASHBOARD ---
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->middleware('permission:view-dashboard')
            ->name('dashboard');

        Route::get('/check-new-orders', [OrderController::class, 'checkNewOrders'])
            ->middleware('permission:view-dashboard')
            ->name('orders.check');


        // --- HARYTLAR, BRANDLAR, KATEGORIÝALAR ---
        Route::middleware('permission:manage-products')->group(function () {
            Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
            Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
            Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
            Route::resource('products', ProductController::class);
        });

        Route::middleware('permission:manage-categories')->group(function () {
            Route::resource('categories', CategoryController::class);
        });

        Route::middleware('permission:manage-brands')->group(function () {
            Route::resource('brands', BrandController::class);
        });

        Route::middleware('permission:manage-tickers')->group(function () {
            Route::post('/tickers/toggle-global', [TickerController::class, 'toggleGlobal'])->name('tickers.toggle-global');
            Route::resource('tickers', TickerController::class);
        });

        // --- SARGYTLAR ---
        Route::middleware('permission:manage-orders')->group(function () {
            Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
            Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
            Route::post('/orders/clear-old', [OrderController::class, 'clearOldOrders'])->name('orders.clearOld');
        });

        // --- MAHABATLAR (ADS) ---
        Route::middleware('permission:manage-ads')->group(function () {
            Route::get('/ads', [AdvertisementController::class, 'index'])->name('ads.index');
            Route::get('ads/create', [AdvertisementController::class, 'create'])->name('ads.create');
            Route::post('/ads/store', [AdvertisementController::class, 'store'])->name('ads.store');
            Route::get('/ads/{id}/edit', [AdvertisementController::class, 'edit'])->name('ads.edit');
            Route::put('/ads/{id}', [AdvertisementController::class, 'update'])->name('ads.update');
            Route::delete('/ads/{id}', [AdvertisementController::class, 'destroy'])->name('ads.destroy');
        });

        Route::get('/popups', [PopupController::class, 'index'])->name('popups.index');
        Route::post('/popups', [PopupController::class, 'store'])->name('popups.store');
        Route::post('/popups/{popup}/toggle', [PopupController::class, 'toggle'])->name('popups.toggle');
        Route::delete('/popups/{popup}', [PopupController::class, 'destroy'])->name('popups.destroy');

        // --- LOGLAR (ACTIVITIES) ---
        Route::middleware('permission:manage-activities')->group(function () {
            Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
            Route::get('/activities/{id}', [ActivityController::class, 'showActivity'])->name('activities.show');
            Route::post('/logs/clear', [ActivityController::class, 'clearOldLogs'])->name('logs.clear');
        });

        // --- SISTEMA (BACKUP & SETTINGS) ---
        Route::middleware('permission:manage-backups')->group(function () {
            Route::get('/backups', [BackupController::class, 'index'])->name('backup.index');
            Route::post('/backups/create', [BackupController::class, 'create'])->name('backup.create');
            Route::get('backups/download', [BackupController::class, 'download'])->name('backup.download');
        });

        Route::middleware('permission:manage-settings')->group(function () {
            Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
            Route::post('/settings/clear-cache', [SettingController::class, 'clearCache'])->name('settings.clearCache');
        });

        // --- ROLLAR WE ULANYJYLAR ---
        Route::middleware('permission:manage-roles')->group(function () {
            Route::resource('roles', RoleController::class);
        });

        Route::middleware('permission:manage-users')->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
            Route::post('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        // --- HABARLAR (MESSAGES) ---
        Route::middleware('permission:view-dashboard')->group(function () {
            Route::get('/messages', [ContactController::class, 'adminIndex'])->name('messages.index');
            Route::post('/messages/{id}/read', [ContactController::class, 'markAsRead'])->name('messages.read');
            Route::post('/messages/{id}/reply', [ContactController::class, 'reply'])->name('messages.reply');
        });

        // --- MAZMUN DOLANDYRYŞ (CMS) ---
        Route::middleware('permission:manage-pages')->group(function () {
            Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
            Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
            Route::post('/pages/store', [PageController::class, 'store'])->name('pages.store');
            Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
            Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
            Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
        });
    });
});
