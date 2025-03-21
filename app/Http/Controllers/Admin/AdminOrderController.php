<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Lấy danh sách đơn hàng cùng với các bánh đã mua
        $orders = Order::with('cakes')->get(); // Lấy cả thông tin bánh trong đơn hàng

        // Trả về view để hiển thị đơn hàng và chi tiết bánh
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        // Lấy một đơn hàng cụ thể và chi tiết bánh của đơn hàng đó
        $order = Order::with('cakes')->findOrFail($id);

        // Trả về view hiển thị chi tiết đơn hàng
        return view('admin.orders.show', compact('order'));
    }
}
