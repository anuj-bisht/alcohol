<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'viewProfile'])->name('profile.edit');
Route::post('/profile/update', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile.update');


//User
Route::get('/Consumer', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('consumer.show');
Route::get('/userstatus/{id}/{value}', [App\Http\Controllers\Admin\UserController::class, 'changeStatus']);
Route::get('/consumer/{user}', [App\Http\Controllers\Admin\UserController::class, 'view'])->name('consumer.view');


// Route::get('/Category/AddCategory', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create');
// Route::post('/Category/StoreCategory', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('category.store');
// Route::get('/Category/EditCategory/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');
// Route::post('/Category/UpdateCategory/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
// Route::post('/Category/UpdateCategory/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
// Route::get('/Category/deleteCategory/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'delete']);

//Category
Route::get('/Category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category.show');
Route::get('/Category/AddCategory', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create');
Route::post('/Category/StoreCategory', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('category.store');
Route::get('/Category/EditCategory/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');
Route::post('/Category/UpdateCategory/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
Route::post('/Category/UpdateCategory/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
Route::get('/Category/deleteCategory/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'delete']);

//Product
Route::get('/Product', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('product.show');
Route::get('/Product/AddProduct', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('product.create');
Route::post('/Product/StoreProduct', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('product.store');
Route::get('/Product/EditProduct/{product}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('product.edit');
Route::post('/Product/UpdateProduct/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('product.update');
// Route::post('/Category/UpdateCategory/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
Route::get('/Product/deleteimage/{id}', [App\Http\Controllers\Admin\ProductController::class, 'deleteImage']);
Route::get('/Product/search/{data}', [App\Http\Controllers\Admin\ProductController::class, 'search']);



//Message
Route::get('/Message', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('message.show');
Route::get('/Message/AddMessage', [App\Http\Controllers\Admin\MessageController::class, 'create'])->name('message.create');
Route::post('/Message/StoreMessage', [App\Http\Controllers\Admin\MessageController::class, 'store'])->name('message.store');
Route::get('/Message/EditMessage/{id}', [App\Http\Controllers\Admin\MessageController::class, 'edit'])->name('message.edit');
Route::post('/Message/UpdateMessage/{id}', [App\Http\Controllers\Admin\MessageController::class, 'update'])->name('message.update');
// Route::post('/Message/UpdateMessage/{id}', [App\Http\Controllers\Admin\MessageController::class, 'update'])->name('category.update');
Route::get('/Message/deletemessage/{id}', [App\Http\Controllers\Admin\MessageController::class, 'deleteMessage']);


//Notification
Route::get('/Notification', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notification.show');
// Route::get('/Message/AddMessage', [App\Http\Controllers\Admin\MessageController::class, 'create'])->name('message.create');
// Route::post('/Message/StoreMessage', [App\Http\Controllers\Admin\MessageController::class, 'store'])->name('message.store');
// Route::get('/Message/EditMessage/{id}', [App\Http\Controllers\Admin\MessageController::class, 'edit'])->name('message.edit');
// Route::post('/Message/UpdateMessage/{id}', [App\Http\Controllers\Admin\MessageController::class, 'update'])->name('message.update');
// // Route::post('/Message/UpdateMessage/{id}', [App\Http\Controllers\Admin\MessageController::class, 'update'])->name('category.update');
// Route::get('/Message/deletemessage/{id}', [App\Http\Controllers\Admin\MessageController::class, 'deleteMessage']);



//Orders
Route::get('/Order', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.show');
Route::get('/order/view/{id}', [App\Http\Controllers\Admin\OrderController::class, 'view'])->name('order.view');

Route::get('/data/search', [App\Http\Controllers\HomeController::class, 'searchData']);

