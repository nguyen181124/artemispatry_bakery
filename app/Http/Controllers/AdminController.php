<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cake;
use App\Models\Cart;
use App\Models\Order;

class AdminController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login_admin');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Trang quản trị
    public function index()
    {
        return view('admin.dashboard');
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    // Quản lý Bánh (Cakes)
    public function manageCakes()
    {
        $cakes = Cake::all();
        return view('addcake', compact('cakes'));
    }

    // Quản lý Giỏ hàng (Carts)
    public function manageCarts()
    {
        $carts = Cart::all();
        return view('admin.carts', compact('carts'));
    }

    // Quản lý Đơn hàng (Orders)
    public function manageOrders()
    {
        $orders = Order::with('cakes')->get();
        return view('admin.orders', compact('orders'));
    }

    // Quản lý Người dùng (Users)
    public function manageUsers()
    {
        $users = User::where('id', '!=', 9)->get(); // Loại bỏ user có id = 9
        return view('admin.users', compact('users'));
    }

    // Hiển thị danh sách đơn hàng
    public function showOrders()
    {
        $orders = Order::with('cakes')->get();
        return view('admin.orders', compact('orders'));
    }
}