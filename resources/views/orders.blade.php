@extends('layout.master')

@section('maincontent')
<style>
body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  margin: 0;
}

.container-fluid {
  /* Cho container chiếm toàn bộ không gian còn lại */
  flex: 1 0 auto;
  
  /* Đảm bảo luôn cao ít nhất bằng viewport trừ footer */
  min-height: calc(60vh - 55px);
  
  width: 95vw;
  margin: auto;
  padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background: #bc9669;
    color: white;
}

tr:nth-child(even) {
    background: #f2f2f2;
}
</style>
<div class="container-fluid">
    <h2>Đơn hàng của tôi</h2>
    <table>
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->total_price }} VNĐ</td>
                    <td>{{ $order->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection