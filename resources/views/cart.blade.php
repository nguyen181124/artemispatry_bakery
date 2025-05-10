<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Giỏ hàng của bạn</title>
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-size: 28px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #fafafa;
            color: #555;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
            text-align: left;
        }

        .product-info img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
        }

        .product-info h4 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .quantity {
            min-width: 90px;    
        }

        .quantity input {
            width: 60px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .quantity button {
            padding: 5px 10px;
            margin: 0 5px;
            background: #c49a6c;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .quantity button:hover {
            background: #b0825b;
        }

        .remove-btn {
            background: #e74c3c;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .remove-btn:hover {
            background: #c0392b;
        }

        .cart-summary {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .cart-summary span {
            color: #e67e22;
        }

        .cart-footer {
            text-align: right;
        }

        .cart-footer button {
            background: #c49a6c;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }

        .cart-footer button:hover {
            background: #219150;
        }

        a.continue {
            display: inline-block;
            margin-top: 10px;
            color: #c49a6c;
            text-decoration: none;
            transition: color 0.3s;
        }

        a.continue:hover {
            color: #b0825b;
        }

        /* Responsive */
        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                display: none;
            }

            td {
                padding: 10px;
                text-align: right;
                position: relative;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                font-weight: bold;
                text-align: left;
            }

            .product-info {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style> 
</head>
<body>
    <div class="container">
        <h2 style="color: #c49a6c">Giỏ hàng của bạn</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('all') }}" class="continue">Quay về mua hàng</a>
        @else
            <table>
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
                        <td data-label="Sản phẩm">
                            <div class="product-info">
                                <img src="{{ $item->product->img }}" alt="{{ $item->product->name }}">
                                <h4>{{ $item->product->name }}</h4>
                            </div>
                        </td>
                        <td data-label="Giá">{{ number_format($item->product->price) }} VNĐ</td>
                        <td data-label="Số lượng">
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
                        <td data-label="Tổng">{{ number_format($item->product->price * $item->quantity) }} VNĐ</td>
                        <td data-label="Hành động">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('all') }}" class="continue">Mua hàng tiếp</a>

            <div class="cart-summary">
                Tổng cộng: <span>{{ number_format($total) }} VNĐ</span>
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
</body>
</html>
