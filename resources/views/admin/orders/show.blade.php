<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn hàng</title>
    <style>
        /* Style cơ bản cho trang */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        h3 {
            font-size: 22px;
            margin-top: 20px;
            color: #333;
        }

        p {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
        }

        /* Style cho bảng */
        table {
            width: 100%;
            max-width: 900px;
            margin: 0 auto 30px;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #5a4432;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
        }

        td {
            font-size: 16px;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9f5ff;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #5a4432;
            color: white;
            border-radius: 4px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
        }

        .back-link:hover {
            background-color: #5a4432;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chi tiết Đơn hàng #{{ $order->id }}</h2>

        <p><strong>User ID:</strong> {{ $order->user_id }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
        <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at }}</p>

        <h3>Các bánh đã mua:</h3>
        <table>
            <thead>
                <tr>
                    <th>Tên Bánh</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->cakes as $cake)
                    <tr>
                        <td>{{ $cake->name }}</td>
                        <td>{{ $cake->pivot->quantity }}</td>
                        <td>{{ number_format($cake->pivot->price, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <span class="back-link" onclick="goBackToOrders('{{ route('admin.orders.index') }}')">Quay lại Danh sách Đơn hàng</span>
    </div>

    <script>
        function goBackToOrders(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const contentDiv = document.getElementById('content');
                    contentDiv.innerHTML = html;

                    // Thực thi các script trong nội dung được tải
                    const scripts = contentDiv.getElementsByTagName('script');
                    for (let script of scripts) {
                        const newScript = document.createElement('script');
                        newScript.textContent = script.textContent;
                        document.body.appendChild(newScript);
                    }
                })
                .catch(error => console.error('Error loading orders:', error));
        }
    </script>
</body>
</html>