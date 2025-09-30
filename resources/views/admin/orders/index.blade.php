<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Đơn hàng</title>
    <style>
        /* Style cơ bản cho trang */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Style cho bảng */
        table {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
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
            color: #333;
        }

        /* Làm nổi bật các hàng xen kẽ */
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Hiệu ứng khi rê chuột vào hàng */
        tbody tr:hover {
            background-color: #e9f5ff;
        }

        /* Style cho nút "Xem chi tiết" */
        .view-details {
            display: inline-block;
            padding: 8px 16px;
            background-color: #5a4432;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .view-details:hover {
            background-color: #5a4432;
        }

        /* Căn giữa nội dung */
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
    <div class="content">
        <h2>Danh sách Đơn hàng</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt hàng</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody id="order-list">
                @foreach ($orders as $order)
                    <tr data-id="{{ $order->id }}">
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user_id }}</td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <span class="view-details" onclick="viewOrderDetails('{{ route('admin.orders.show', $order->id) }}')">Xem chi tiết</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="text-align: right; margin-bottom: 15px;">
            <a href="{{ route('admin.orders.export') }}" class="view-details" style="background-color: green;">Xuất Excel</a>
        </div>
    
    </div>

    <script>
        function viewOrderDetails(url) {
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
                .catch(error => console.error('Error loading order details:', error));
        }
    </script>
</body>
</html>