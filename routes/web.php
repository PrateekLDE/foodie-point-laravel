<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MenuItemsController;
use App\Http\Controllers\Admin\QrController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RedirectController;

/*
|--------------------------------------------------------------------------
| Route Architecture
|--------------------------------------------------------------------------
|
| Public routes:  No auth, accessible via QR code scan
| Admin routes:   Require auth, owner-only management
|
| Deliberate simplicity: no API routes, no SPA, just server-rendered
| pages. The owner's phone browser just needs to load an HTML page — no
| JavaScript framework overhead, works on a slow kitchen WiFi connection.
|
*/

// ── Public (customer-facing) ──────────────────────────────────────────────────

Route::get('/', [MenuController::class, 'today'])->name('menu.today');

// ── Admin auth ────────────────────────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ── Protected admin area ──────────────────────────────────────────────────
    Route::middleware('auth')->group(function () {

        // Redirect /admin to today's menu item
        Route::get('/', fn() => redirect()->route('admin.menu-items.index'));

        // Menu Items CRUD
        Route::get('menu-items',                    [MenuItemsController::class, 'index'])->name('menu-items.index');
        Route::post('menu-items',                   [MenuItemsController::class, 'store'])->name('menu-items.store');
        Route::get('menu-items/{menuItem}/edit',    [MenuItemsController::class, 'edit'])->name('menu-items.edit');
        Route::put('menu-items/{menuItem}',         [MenuItemsController::class, 'update'])->name('menu-items.update');
        Route::delete('menu-items/{menuItem}',      [MenuItemsController::class, 'destroy'])->name('menu-items.destroy');

        // Quick availability toggle (POST not DELETE — idempotent toggle)
        Route::post('menu-items/{menuItem}/toggle', [MenuItemsController::class, 'toggleAvailability'])->name('menu-items.toggle');

        // Copy menu items from another date
        Route::post('menu-items/copy',              [MenuItemsController::class, 'copyFromDate'])->name('menu-items.copy');

        // QR code management
        Route::get('qr',                              [QrController::class, 'show'])->name('qr.show');
        Route::get('qr/download',                     [QrController::class, 'download'])->name('qr.download');
    });
});
