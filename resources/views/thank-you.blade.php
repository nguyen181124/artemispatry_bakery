<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Artemis Pastry</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
    <style>
        /* Copy toàn bộ CSS từ pay.blade.php */
        body {
            font-family: Arial, sans-serif;
            background-color: #bc9669;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 { text-align: center; color: #333; }
        .confirmation { text-align: left; }
        .success-message {
            margin-bottom: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .success-message h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 5px;
        }
        .success-message p {
            color: #555;
            font-size: 14px;
        }
        .checkmark {
            width: 60px;
            height: 60px;
            background-color: #4CAF50;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 10px;
        }
        .checkmark-symbol {
            width: 20px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(-45deg) scaleX(-1);
        }
        .order-summary {
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .help-link {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }
        .help-link:hover { text-decoration: underline; }
        .button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Artemis Pastry</h1>
        <div class="confirmation">
            <div class="success-message">
                <div class="checkmark">
                    <div class="checkmark-symbol"></div>
                </div>
                <h2>Đặt hàng thành công</h2>
                <p>Cám ơn bạn đã mua hàng!</p>
                <p>Khách hàng vui lòng đợi nhân viên xác nhận đơn hàng thành công.</p>
                <p>Liên hệ <strong>1900.1007</strong> (ấn phím 1)</p>
            </div>
            <div class="order-summary">
                <p>Mã đơn hàng: {{ $order_id }}</p>
                <p>Tổng tiền: {{ number_format($total) }} VNĐ</p>
            </div>
            <div class="actions">
                <a href="#" class="help-link">Cần hỗ trợ? <span>Liên hệ</span></a>
                <a href="{{ route('home') }}" class="button">Tiếp tục mua hàng</a>
            </div>
        </div>
    </div>
</body>
</html>