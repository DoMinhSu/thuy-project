<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Jobs\LogJob;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->group(function () {
    Auth::routes();
    Route::name('admin.')->middleware(['auth'])->group(function () {
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class,'index'])->name('index');
            Route::get('/create', [CategoryController::class,'create'])->name('create');
            Route::post('/store', [CategoryController::class,'store'])->name('store');
            Route::post('/update', [CategoryController::class,'update'])->name('update');
            Route::get('/delete/{model}', [CategoryController::class,'delete'])->name('delete');
        });
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [CustomerController::class,'index'])->name('index');
            Route::get('/create', [CustomerController::class,'create'])->name('create');
            Route::post('/store', [CustomerController::class,'store'])->name('store');
            Route::post('/update', [CustomerController::class,'update'])->name('update');
            Route::get('/delete/{model}', [CustomerController::class,'delete'])->name('delete');
        });
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class,'index'])->name('index');
            Route::get('/create', [ProductController::class,'create'])->name('create');
            Route::post('/store', [ProductController::class,'store'])->name('store');
            Route::post('/update', [ProductController::class,'update'])->name('update');
            Route::get('/delete/{model}', [ProductController::class,'delete'])->name('delete');
        });
        Route::get('dashboard',function (){
            return view('layouts.app');
        });

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});




Route::prefix('user')->name('user.')->group(function () {
    //midleware
    Route::post('regist',[FrontendController::class,'regist'])->name('regist');
    Route::post('login',[FrontendController::class,'login'])->name('login');


    Route::get('logout',[FrontendController::class,'logout'])->name('logout');

});

Route::post('addToCart',[FrontendController::class,'addToCart'])->name('addToCart');
Route::post('updateAllCart',[FrontendController::class,'updateAllCart'])->name('updateAllCart');
Route::get('cart',function ()
{
    $cart = \Cart::getContent();
    $total = \Cart::getTotal();
    return view('frontend.cart',compact('cart','total'));
})->name('cart');
Route::post('getQuantity', function () {
    return \Cart::getTotalQuantity();
})->name('getQuantity');
Route::delete('deleteCartItem', function () {
    \Cart::remove(request('productId'));
    return \Cart::getTotalQuantity();
})->name('deleteCartItem');

Route::post('order', function () {

    if(auth('customers')->check()){
        $customer = auth('customers')->user();
    }

    if(request('customer')){
        $customer = Customer::create(request('customer'));
    }
    DB::transaction(function () use ($customer){
        $order = Order::create([
            'customer_name'=>$customer->name,
            'customer_email'=>$customer->email,
            'customer_phone_number'=>$customer->phone_number,
            'address'=>$customer->address,
            'total'=>\Cart::getTotal(),
            'customer_id'=>$customer->id
        ]);
        foreach (\Cart::getContent() as $key => $value) {
            OrderItem::create([
                'product_name'=>$value->name,
                'product_quantity'=>$value->quantity,
                'total'=>$value->getPriceSum(),
                'product_id'=>$key,
                'order_id'=>$order->id,
                'price'=>$value->price
            ]);
        }
    });
    toast('Đơn hàng của bạn đã được nhận!!','success');

    return back()->with('message','Order thành công!');
})->name('order');


Route::get('/',[FrontendController::class,'home'])->name('index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/testQueueAndSupervisor',function()
{
    LogJob::dispatch()->onConnection('redis')->onQueue('podcasts');
});