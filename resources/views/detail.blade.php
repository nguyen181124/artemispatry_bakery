<style>
    .cake-detail {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        width: 300px;
        margin: auto;
        position: relative; 
    }

    .cake-detail img {
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .cake-detail h2 {
        margin: 10px 0;
        font-size: 24px;
        color: #333;
    }

    .cake-detail p {
        margin: 5px 0;
        color: #666;
    }

    .quantity {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 15px 0;
    }

    .quantity .btn {
        padding: 5px 10px;
        background-color: #c49a6c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .quantity .btn:hover {
        background-color: #b0825b;
    }

    button.btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button.btn:hover {
        background-color: #b0825b;
    }

    .close-btn {
        position: absolute;
        top: 1px;
        right: 1px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: orange;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
    }

    .close-btn::before,
    .close-btn::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 3px;
        background-color: white;
    }

    .close-btn::before {
        transform: rotate(45deg);
    }

    .close-btn::after {
        transform: rotate(-45deg);
    }

    .close-btn:hover {
        background-color: darkorange;
    }
</style>

<div class="cake-detail">
    <button class="close-btn" onclick="window.location.href='/'"></button>
    
    <img src="{{ asset($cake_detail->img) }}" alt="Cake" style="width:100%">
    <h2 class="name">{{ $cake_detail->name }}</h2>
    <p class="price">{{ str_replace(',', '.',number_format($cake_detail->price)) }} VNĐ</p>
    <p class="content">{{ $cake_detail->info }}</p>
    
    <div class="quantity">
        <button class="btn" onclick="changeQuantity(-1)">-</button>
        <span id="qty">1</span>
        <button class="btn" onclick="changeQuantity(1)">+</button>
    </div>

    <form id="add-to-cart-form" action="{{ route('cart.add', ['productId' => $cake_detail->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="quantity" id="quantityInput" value="1">
        <!-- Thêm một input ẩn để lưu URL hình ảnh -->
        <input type="hidden" name="image_url" id="image_url" value="{{ asset($cake_detail->img) }}">
        <button type="submit" class="btn" style="background:#c49a6c; color:white; margin-top:10px;">Thêm vào giỏ</button>
    </form>
    
    <div id="success-message" style="display:none; color: green; margin-top: 10px;">Đã thêm vào giỏ hàng!</div>
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