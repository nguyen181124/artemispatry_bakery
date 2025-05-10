<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh toán - Artemis Pastry</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
    <!-- Giữ nguyên CSS, bỏ các kiểu liên quan đến confirmation -->
    <style>
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

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input,
        select {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .section {
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 30px;
        }

        button,
        a.back {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: auto;
            min-width: 150px;
            max-width: 200px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        a.back {
            background-color: #6c757d;
            text-decoration: none;
            display: inline-block;
        }

        a.back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .buttons {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            button,
            a.back {
                width: 80%;
                max-width: 250px;
            }
        }

        .info {
            width: 900px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Artemis Pastry</h1>
        <form id="orderForm" action="/submit-order" method="post">
            @csrf
            <h2>Thông tin đặt hàng</h2>
            <div class="section">
                <input class="info" type="text" name="fullname" placeholder="Họ và tên" required>
                <input class="info" type="text" name="phone" placeholder="Điện thoại" required>
            </div>
            <div class="section">
                <input class="info" type="text" name="address" placeholder="Địa chỉ" required>
                <select name="city">
                    <option value="">Chọn tỉnh thành</option>
                    <option value="my-dinh">Mỹ Đình</option>
                    <option value="soc-son">Sóc Sơn</option>
                </select>
                <div>
                    <input type="radio" id="delivery" name="shipping" checked>
                    <label for="delivery">Giao hàng tận nơi</label>
                    <input type="radio" id="pickup" name="shipping">
                    <label for="pickup">Nhận tại cửa hàng</label>
                </div>
            </div>
            <div class="section" id="payment-methods">
                <div class="payment-option">
                    <input type="radio" id="cod" name="payment" value="cod" checked>
                    <label for="cod">Thanh toán khi giao hàng (COD)</label>
                </div>
                <div class="payment-option">
                    <input type="radio" id="vnpay" name="payment" value="vnpay">
                    <label for="vnpay">Thanh toán bằng VNPay</label>
                </div>
            </div>
            <input type="hidden" name="total" value="{{ $total }}">
            <div class="buttons">
                <a href="#" class="back">Quay lại giỏ hàng</a>
                <button type="submit">Xác nhận đặt hàng</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        let orderForm = document.getElementById("orderForm");
        let deliveryOption = document.getElementById("delivery");
        let pickupOption = document.getElementById("pickup");
        let paymentOptions = document.getElementById("payment-methods");

        orderForm.addEventListener("submit", function(event) {
            event.preventDefault();
            let selectedPayment = document.querySelector('input[name="payment"]:checked')?.value;
            let selectedShipping = document.querySelector('input[name="shipping"]:checked')?.id;
            let formData = new FormData(orderForm);

            // Nếu chọn "Nhận tại cửa hàng" hoặc "Thanh toán khi giao hàng (COD)", chuyển ngay sang trang thành công
            if (selectedShipping === "pickup" || selectedPayment === "cod") {
                window.location.href = "{{ route('thank-you') }}?order_id=12345&total={{ $total }}";
                return;
            }

            if (selectedPayment === "vnpay") {
                fetch("{{ route('vnpay.payment') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.code === '00' && data.paymentUrl) {
                            window.location.href = data.paymentUrl;
                        } else {
                            alert("Không thể tạo thanh toán VNPay: " + (data.message || "Lỗi không xác định"));
                        }
                    })
                    .catch(error => {
                        console.error("Fetch error: ", error);
                        alert("Lỗi khi gọi API VNPay: " + error.message);
                    });
            }
        });

        function togglePaymentMethods() {
            paymentOptions.style.display = pickupOption.checked ? "none" : "block";
        }

        deliveryOption.addEventListener("change", togglePaymentMethods);
        pickupOption.addEventListener("change", togglePaymentMethods);
        togglePaymentMethods();
    });

    </script>
</body>

</html>