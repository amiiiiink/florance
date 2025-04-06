<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);
Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
Route::patch('/expenses/update-status-and-file', [ExpenseController::class, 'updateStatusAndFile'])->name('expenses.updateStatusAndFile');
Route::resource('expenses', ExpenseController::class);
Route::resource('purchase_invoices', PurchaseInvoiceController::class);
Route::post('/purchase-invoices/change-status', [PurchaseInvoiceController::class, 'changeStatus'])
    ->name('purchase-invoices.change-status');

Route::resource('visitors', VisitorController::class);

Route::get('game', [DashboardController::class,'game']);

