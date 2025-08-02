<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/add-payment', [PaymentController::class, 'addPaymentForm'])->name('payments.addPayment');
    Route::post('/payments/{payment}/add-payment', [PaymentController::class, 'addPayment'])->name('payments.addPayment');
    Route::get('/payments/{payment}/items/{item}/edit', [PaymentController::class, 'editPaymentItem'])->name('payments.paymentItems.edit');
    Route::put('/payments/{payment}/items/{item}', [PaymentController::class, 'updatePaymentItem'])->name('payments.paymentItems.update');
    Route::get('/orders/{id}/pdf', [OrderController::class, 'downloadPdf'])->name('orders.pdf');
    Route::get('/orders/export-sales-pdf', [OrderController::class, 'exportSalesPdf'])->name('orders.exportSalesPdf');
    Route::get('orders/{order}/bill', [OrderController::class, 'bill'])->name('orders.bill');
    Route::get('orders-report', [OrderController::class, 'report'])->name('orders.report');
    Route::get('/export-sales-excel', [OrderController::class, 'exportSalesExcel'])->name('export.sales.excel');
    Route::resource('orders', OrderController::class);
});
require __DIR__ . '/auth.php';
