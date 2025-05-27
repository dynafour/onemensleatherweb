<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FrontendController;
use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\AuthLanding;
use App\Exports\ExcelExport;


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

// AUTH PROSES
Route::get('/', function () {
    return redirect('/home');
});


// Halaman login hanya bisa diakses kalau BELUM login
Route::middleware(AuthLanding::class)->group(function () {
    // GET METHOD
    // FRONTEND
    Route::get('/home', [FrontendController::class, 'index'])->name('home');
    Route::get('/list-product', [FrontendController::class, 'product'])->name('list.main.product');
    Route::get('/list-product/{id_category}', [FrontendController::class, 'product'])->name('list.product');
    Route::get('/detail-product', [FrontendController::class, 'detail_product']);
    Route::get('/detail-product/{id_product}', [FrontendController::class, 'detail_product'])->name('detail.product');
    Route::get('/list-product/{id_category}/{start}', [FrontendController::class, 'product']);
    Route::get('/list-categories', [FrontendController::class, 'category'])->name('list.category');
    Route::get('/about', [FrontendController::class, 'about'])->name('about');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

    // AUTH
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('forgot');


    // POST METHOD
    Route::post('/login-proses', [AuthController::class, 'loginProses'])->name('login.process');
    Route::post('/register-proses', [AuthController::class, 'registerProses'])->name('register.process');
    Route::post('/forgot-proses', [AuthController::class, 'forgotProses'])->name('forgot.process');
    Route::post('/confirm-proses', [AuthController::class, 'confirmProses'])->name('confirm.process');
    Route::post('/change-password', [AuthController::class, 'ubahPassword'])->name('auth.change_password');
    Route::post('/insert-comment', [FrontendController::class, 'insert_comment'])->name('insert.comment');
});

// Halaman dashboard hanya bisa diakses kalau SUDAH login
Route::middleware(CheckAuth::class)->group(function () {
    // GET METHOD (VIEW)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/category', [ProductController::class, 'category'])->name('category');
    Route::get('/comment', [ProductController::class, 'comment'])->name('comment');
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi');
    Route::get('/report', [TransactionController::class, 'report'])->name('report');
    //  POST METHOD
    Route::post('/ubah-profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    // // CATEGORY
    Route::post('/ubah-category', [ProductController::class, 'update_category'])->name('category.update');
    Route::post('/tambah-category', [ProductController::class, 'insert_category'])->name('category.insert');
     // // PRODUCT
    Route::post('/ubah-product', [ProductController::class, 'update_product'])->name('product.update');
    Route::post('/tambah-product', [ProductController::class, 'insert_product'])->name('product.insert');
    Route::post('/import-transaksi', [TransactionController::class, 'import'])->name('transaction.import');


    // AJAX
    // // PRODUCT
    Route::post('/detail_product', [ProductController::class, 'detail_product'])->name('product.detail');
    Route::post('/stock-product', [ProductController::class, 'stock_product'])->name('product.stock');
    // // REPORT
    Route::post('/report-ajax', [TransactionController::class, 'reportAjax'])->name('transaction.ajax.report');



    // DATATABLE
    Route::get('/product/data', [ProductController::class, 'getProduct'])->name('product.data');
    Route::get('/category/data', [ProductController::class, 'getCategory'])->name('category.data');
    Route::get('/comment/data', [ProductController::class, 'getComment'])->name('comment.data');
    Route::get('/transaction/data', [TransactionController::class, 'getTransaction'])->name('transaction.data');
    Route::get('/product-report/data',[TransactionController::class,'reportProductData'])->name('report.product');


    // GLOBAL FUNCTION
    Route::post('/switch/{db?}', [SettingController::class, 'switch']);
    Route::post('/delete', [SettingController::class, 'hapusdata']);
    Route::post('/single/{db?}/{id?}', [SettingController::class, 'single']);
    Route::post('/export', [SettingController::class, 'export']);
    
});



Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');