<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cake;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        return view('cart', ['cartItems' => $cartItems, 'total' => $total, 'cartItemCount' => $cartItems->count()]);
    }

    public function add(Request $request, $productId)
    {
        $quantityToAdd = $request->quantity ?? 1;
    
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();
    
        if ($cart) {
            // Nếu đã có trong giỏ thì chỉ cần tăng thêm số lượng
            $cart->increment('quantity', $quantityToAdd);
        } else {
            // Nếu chưa có thì tạo mới với số lượng
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantityToAdd,
                'image_url' => $request->image_url,
            ]);
        }
    
        return $request->ajax()
            ? response()->json(['success' => 'Đã thêm vào giỏ hàng!'])
            : redirect()->route('cart.index');
    }
    

    public function update(Request $request, $id)
    {
        $cartItem = Cart::find($id);
        $request->input('action') == 'increase' ? $cartItem->increment('quantity') : $cartItem->decrement('quantity', $cartItem->quantity > 1 ? 1 : 0);
        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail()->delete();
        return redirect()->route('cart.index');
    }

    public function checkout(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $order = Order::create(['user_id' => Auth::id(), 'total_price' => $total, 'status' => 'đang chờ', 'payment_method' => $request->input('payment_method')]);

        foreach ($cartItems as $item) {
            OrderItem::create(['order_id' => $order->id, 'cake_id' => $item->product->id, 'quantity' => $item->quantity, 'price' => $item->product->price]);
        }

        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('thank-you', ['order_id' => $order->id, 'total' => $total]);
    }
}

