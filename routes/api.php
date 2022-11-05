<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('privacy',[App\Http\Controllers\V1\Consumer\CmsController::class,'privacy']);
Route::get('terms_condition',[App\Http\Controllers\V1\Consumer\CmsController::class,'terms_condition']);


Route::post('consumer/register', [App\Http\Controllers\V1\Consumer\UserController::class, 'ConsumerRegister']);
Route::post('sendotp', [App\Http\Controllers\V1\Consumer\UserController::class, 'sendOtp']);
Route::post('login', [App\Http\Controllers\V1\Consumer\UserController::class, 'authenticate']);
Route::post('products', [App\Http\Controllers\V1\Consumer\ProductController::class, 'categoryProduct']);
Route::post('product/detail', [App\Http\Controllers\V1\Consumer\ProductController::class, 'productDetail']);
Route::get('category', [App\Http\Controllers\V1\Consumer\CategoryController::class, 'index']);
Route::post('search/product', [App\Http\Controllers\V1\Consumer\ProductController::class, 'searchProduct']);


Route::get('address/type',[App\Http\Controllers\V1\Consumer\AddressController::class, 'address_type_list']);


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('addto/cart', [App\Http\Controllers\V1\Consumer\CartController::class, 'addToCart']);
    Route::post('update/cart', [App\Http\Controllers\V1\Consumer\CartController::class, 'updateCart']);
    Route::post('cart', [App\Http\Controllers\V1\Consumer\CartController::class, 'Cart']);
    Route::post('cart/delete', [App\Http\Controllers\V1\Consumer\CartController::class, 'deleteCart']);
    
// Address

    Route::post('address/list',[App\Http\Controllers\V1\Consumer\AddressController::class, 'address_list']);
    Route::post('address/delete',[App\Http\Controllers\V1\Consumer\AddressController::class, 'delete_address']);
    Route::post('address/add',[App\Http\Controllers\V1\Consumer\AddressController::class, 'add_address']);

    //order
    Route::post('placeOrder',[App\Http\Controllers\V1\Consumer\OrderController::class, 'place_order']);
    Route::post('userOrder/list',[App\Http\Controllers\V1\Consumer\OrderController::class, 'user_order_list']);
    Route::post('userOrder/detail',[App\Http\Controllers\V1\Consumer\OrderController::class, 'user_order_detail']);

    Route::post('generate/payment/id',[App\Http\Controllers\V1\Consumer\PaymentController::class, 'generatePaymentId']);
    Route::post('verify/payment',[App\Http\Controllers\V1\Consumer\PaymentController::class, 'verifyPayment']);


});

