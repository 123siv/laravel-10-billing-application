<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\SalesController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');

//product
Route::post('/storeProduct', [ProductController::class, 'store'])->name('storeProduct');
Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('deleteProduct');
Route::get('/getProductData', [ProductController::class, 'getProductData'])->name('getProductData');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/sales/product/{productId}', [ProductController::class, 'getSalesCategories']);

Route::get('/products', function () {
    return view('products.show');
})->name('products.index');

//category
Route::post('/categories', [CategoryController::class, 'store'])->name('storeCat');
Route::delete('/delete-category/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');

//bills
Route::post('/storeBill', [BillController::class, 'store'])->name('storeBill');
Route::get('getProductName', [BillController::class, 'getProductName'])->name('getProductName');
Route::get('/sales/{id}', [BillController::class, 'getBillDetails'])->name('getBillDetails');
Route::get('/sales/categories/{productId}', [BillController::class, 'getProductSalesCategories']);

//sales
Route::get('/getSalesData', [BillController::class, 'getSalesData'])->name('getSalesData');
Route::get('/getAllSales', [BillController::class, 'getAllSales'])->name('getAllSales');

//sales
Route::get('/sales/total/{category}', [SalesController::class, 'getTotalSales']);
