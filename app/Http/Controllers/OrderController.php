<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập
        $orders = Order::with('cakes')->where('user_id', $user->id)->get(); // Lọc đơn hàng theo user_id

        return view('orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('cakes')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $request->total,
            'status' => 'đang chờ',
        ]);

        foreach ($request->cakes as $cake) {
            $order->cakes()->attach($cake['id'], [
                'quantity' => $cake['quantity'],
                'price' => $cake['price'],
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->id, // Trả về ID thực tế
        ]);
        return redirect()->route('admin.orders');
    }
}