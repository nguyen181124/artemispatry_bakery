<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('cakes')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('cakes')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }
}
    