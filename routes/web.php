<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\AddCakeController;
use App\Http\Controllers\PresentController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::resource('users', UserController::class);

Route::get('/', [HomeController::class, 'view_home'])->name('home');
Route::get('/cake/{id}', [CakeController::class, 'cake_detail'])->name('detail');
Route::get('/all', [HomeController::class, 'list_all'])->name('all');
Route::get('/banhsinhnhat', [HomeController::class, 'list_birthday_cake'])->name('banhsinhnhat');
Route::get('/banhle', [HomeController::class, 'list_cake'])->name('banhle');
Route::get('/douong', [HomeController::class, 'list_drink'])->name('douong');
Route::get('/giftset', [HomeController::class, 'list_giftset'])->name('giftset');
Route::get('/gioithieu', [PresentController::class, 'view_present'])->name('gioithieu');
Route::get('/tintuc', function () {
    return view('tintuc');
})->name('tintuc');
Route::post('/pay', function (Request $request) {
    $total = $request->input('total');
    return view('pay', compact('total'));
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addcake', [AddCakeController::class, 'index'])->name('addcake.index');
    Route::post('/addcake/store-or-update', [AddCakeController::class, 'storeOrUpdate'])->name('addcake.storeOrUpdate');
    Route::delete('/addcake/{id}', [AddCakeController::class, 'destroy'])->name('addcake.destroy');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/vnpay_payment', [VNPayController::class, 'vnpay_payment'])->name('vnpay.payment');
    Route::get('/vnpay/return', [VNPayController::class, 'vnpayReturn'])->name('vnpay.return');
    Route::get('/thank-you', fn(Request $request) => view('thank-you', ['order_id' => $request->query('order_id'), 'total' => $request->query('total')]))->name('thank-you');

    Route::post('/submit-order', function (Request $request) {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string',
            'shipping' => 'required|in:delivery,pickup',
            'payment' => 'required|in:cod,vnpay',
            'total' => 'required|numeric|min:1000',
        ]);

        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'fullname' => $validated['fullname'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'shipping' => $validated['shipping'],
            'payment' => $validated['payment'],
            'total_price' => $validated['total'],
            'status' => 'pending',
        ]);

        \App\Models\Cart::where('user_id', auth()->id())->delete();

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'message' => 'Đơn hàng đã được tạo thành công!'
        ]);
    })->middleware('auth');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('employees', [EmployeeController::class, 'index'])->name('employees');
    Route::post('employees/store-or-update', [EmployeeController::class, 'storeOrUpdate'])->name('employees.storeOrUpdate');
    Route::delete('employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
});

require __DIR__ . '/auth.php';