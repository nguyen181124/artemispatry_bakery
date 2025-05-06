
<header>
        <!-- Thanh header -->
        <div class="top-header">
            <div class="container-top">
                <div class="user-info">
                    <a href="register" class="user"><i class="ti-user"></i> TÀI KHOẢN</a> |
                    <a href="{{ route('cart.index') }}" class="cart-icon">
                        <i class="ti-shopping-cart"></i>
                        <span id="cart-count">{{ $cartItemCount }}</span>
                    </a>
                </div>
            </div>
        </div>


        <!-- Thanh menu chính -->
        <nav class="main-nav">
            <div class="container">
                <img class="logo" src="{{ asset ('img/logo.webp')}}" alt="">
                <ul class="nav-links">
                    <li class="tab"><a href="/">TRANG CHỦ</a></li>
                    <li class="dropdown">
                        <a class="tab" href="/all">SẢN PHẨM</a>
                        <ul class="dropdown-menu">
                            <li><a href="/banhsinhnhat">Bánh Sinh Nhật</a></li>
                            <li><a href="/banhle">Bánh Lẻ</a></li>
                            <li><a href="/douong">Đồ Uống</a></li>
                            <li><a href="/giftset">Giftset</a></li>
                        </ul>
                    </li>

                    <li class="tab"><a href="/gioithieu">VỀ ARTEMIS PASTRY</a></li>
                    <li class="tab"><a href="{{ route('orders') }}">KIỂM TRA ĐƠN HÀNG</a></li>
                    <li class="tab"><a href="/tintuc">TIN TỨC</a></li>
                </ul>

                <div class="search-bar">
                </div>
            </div>
        </nav>
    </header>