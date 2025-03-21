
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Giỏ hàng của bạn</title>
    <style>
 
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f9f9f9;
            font-weight: bold;
            color: #333;
        }

        .table td img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
        }

        .cart-item-details {
            margin-left: 15px;
        }

        .cart-item-details h4 {
            font-size: 18px;
            margin: 0;
        }

        .cart-item-details p {
            margin: 5px 0;
            color: #666;
        }

        .quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity button {
            padding: 5px 10px;
            background-color: #c49a6c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .quantity button:hover {
            background-color: #b0825b;
        }

        .cart-summary {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .cart-footer {
            display: flex;
            justify-content: flex-end;
        }

        .cart-footer button {
            background-color: #c49a6c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cart-footer button:hover {
            background-color: #b0825b;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h2>Giỏ hàng của bạn</h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <p>Giỏ hàng của bạn đang trống.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <!-- Display the image from the 'cake' table -->
                            <img src="{{ $item->product->img }}" alt="{{ $item->product->name }}" style="width: 80px; height: 80px;">
                            <div class="cart-item-details">
                                <h4>{{ $item->product->name }}</h4>
                            </div>
                        </td>
                        <td>{{ number_format($item->product->price) }} VNĐ</td>
                        <td>
                            <div class="quantity">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="decrease">-</button>
                                </form>
                                <span>{{ $item->quantity }}</span>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="increase">+</button>
                                </form>
                            </div>
                        </td>
                        <td>{{ number_format($item->product->price * $item->quantity) }} VNĐ</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-summary">
                <span>Tổng cộng:</span>
                <span>{{ number_format($total) }} VNĐ</span>
            </div>

            <div class="cart-footer">
                <form action="{{ url('/pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="total" value="{{ $total }}">
                    <button type="submit" name="redirect">Thanh toán</button>
                </form>
            </div>
        @endif
    </div>
    @endsection
</body>
</html> 