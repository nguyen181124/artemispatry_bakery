@extends('layout.master')

@section('maincontent')
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        color: white;
    }

    .cake-detail {
        width: 100%;
        height: 80%;
        padding: 40px;
        display: flex;
        flex-direction: row;
        gap: 40px;
        background-color:#5F4B3C;
    }

    .cake-image {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cake-image img {
        max-width: 100%;
        max-height: 60vh;
        border-radius: 12px;
        object-fit: contain;
    }

    .cake-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px;
    }

    .cake-info h2 {
        font-size: 36px;
        margin-bottom: 15px;
    }

    .cake-info .price {
        font-size: 24px;
        color: #bc9669;
        margin-bottom: 20px;
    }

    .cake-info .content {
        font-size: 18px;
        line-height: 1.6;
        white-space: pre-line;
        margin-bottom: 30px;
    }

    .quantity {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .quantity .btn {
        padding: 8px 16px;
        background-color: #c49a6c;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .quantity .btn:hover {
        background-color: #b0825b;
    }

    .btn-add {
        padding: 12px 24px;
        background-color: #c49a6c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-add:hover {
        background-color: #b0825b;
    }

    #success-message {
        margin-top: 15px;
        color: #bc9669;
    }

    #add-to-cart-form {
        text-align: center;
    }
</style>

<div class="cake-detail">
    <div class="cake-image">
        <img src="{{ asset($cake_detail->img) }}" alt="Cake">
    </div>
    <div class="cake-info">
        <h2>{{ $cake_detail->name }}</h2>
        <p class="price">{{ str_replace(',', '.', number_format($cake_detail->price)) }} VNĐ</p>
        <p class="content">{{ preg_replace('/\.\s*/', ".\n", $cake_detail->info) }}</p>

        <div class="quantity">
            <button class="btn" onclick="changeQuantity(-1)">-</button>
            <span id="qty">1</span>
            <button class="btn" onclick="changeQuantity(1)">+</button>
        </div>

        <form id="add-to-cart-form" action="{{ route('cart.add', ['productId' => $cake_detail->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="quantity" id="quantityInput" value="1">
            <input type="hidden" name="image_url" value="{{ asset($cake_detail->img) }}">
            <button type="submit" class="btn-add">Thêm vào giỏ</button>
        </form>

        <div id="success-message" style="display:none;">Đã thêm vào giỏ hàng!</div>
    </div>
</div>

<script>
    function changeQuantity(amount) {
        let qty = document.getElementById('qty');
        let value = parseInt(qty.innerText) + amount;
        if (value > 0) {
            qty.innerText = value;
            document.getElementById('quantityInput').value = value;
        }
    }

    // Gắn event listener một lần khi load trang
    document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
        e.preventDefault(); 

        let formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('success-message').style.display = 'block';
            setTimeout(() => {
                document.getElementById('success-message').style.display = 'none';
            }, 3000);
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã có lỗi xảy ra khi thêm vào giỏ hàng');
        });
    });
</script>
@endsection