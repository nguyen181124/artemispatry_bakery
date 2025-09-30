<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    private $totalPrice = 0;

    public function collection()
    {
        $orders = Order::all();
        $this->totalPrice = $orders->sum('total_price');
        return $orders;
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->user_id,
            number_format($order->total_price, 0, ',', '.') . ' VND',
            $order->created_at->format('d/m/Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Tổng tiền',
            'Ngày đặt hàng',
        ];
    }
}
