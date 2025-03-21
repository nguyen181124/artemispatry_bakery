<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class VNPayController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        // Validation dữ liệu từ form
        $request->validate([
            'total' => 'required|numeric|min:1000', // Tổng tiền phải có và hợp lệ
            'fullname' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $total = $request->input('total');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = "5SI6HT8K"; // Mã của bạn
        $vnp_HashSecret = "5JD8WU039H49FTELK7Z3AUZVC7TPAURK"; // Chuỗi bí mật của bạn

        $vnp_TxnRef = time(); // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán hóa đơn từ Artemis Pastry";
        $vnp_OrderType = "Shop Bánh Ngọt";
        $vnp_Amount = $total * 100; // Số tiền VND (phải nhân 100)
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = http_build_query($inputData);
        $hashdata = $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        $vnp_Url .= "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

        return response()->json([
            'code' => '00',
            'message' => 'success',
            'paymentUrl' => $vnp_Url // Đổi 'data' thành 'paymentUrl' để khớp với client
        ]);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $user_id = Auth::id();

        if ($vnp_ResponseCode == '00') { // Thanh toán thành công
            // Lấy giỏ hàng của người dùng
            $cartItems = Cart::where('user_id', $user_id)->with('product')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
            }

            // Tính tổng đơn hàng
            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $user_id,
                'total_price' => $total,
                'status' => 'hoàn thành',
                'payment_method' => 'vnpay',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Lưu các sản phẩm vào bảng order_items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'cake_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Xóa giỏ hàng sau khi thanh toán thành công
            Cart::where('user_id', $user_id)->delete();

            // Chuyển hướng với order_id và total chính xác
            return redirect()->route('thank-you', [
                'order_id' => $order->id, // Sử dụng ID của đơn hàng vừa tạo
                'total' => $total,        // Sử dụng tổng tiền thực tế
            ]);
        } else {
            // Nếu thanh toán thất bại
            return redirect()->route('cart.index')->with('error', 'Thanh toán thất bại!');
        }
    }
}
