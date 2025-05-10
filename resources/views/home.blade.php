@extends('layout.master')
@section('maincontent')
<!-- Phần banner chạy tự động -->

<div class="swiper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper" style="height: 570px">
        <!-- Slides -->
        <div class="swiper-slide"><img src="img/banner1.webp" alt="Banner 1"></div>
        <div class="swiper-slide"><img src="img/banner2.webp" alt="Banner 2"></div>
        <div class="swiper-slide"><img src="img/banner3.webp" alt="Banner 3"></div>
        <div class="swiper-slide"><img src="img/banner4.webp" alt="Banner 4"></div>
        ...
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

<!-- Phần nội dung chính -->
<div class="homebanner">
    <div class="grid">
        <a href="/banhsinhnhat" class="grid_item">
            <div class="card" style="width: 22rem; border: 0;">
                <img class="card-img-top card-img-bottom" src="img/grid_item1.webp" alt="Card image cap">
            </div>
        </a>
        <a href="/banhle" class="grid_item">
            <div class="card" style="width: 22rem; border: 0;">
                <img class="card-img-top card-img-bottom" src="img/grid_item2.webp" alt="Card image cap">
            </div>
        </a>
        <a href="/giftset" class="grid_item">
            <div class="card" style="width: 22rem; border: 0;">
                <img class="card-img-top card-img-bottom" src="img/grid_item3.webp" alt="Card image cap">
            </div>
        </a>
    </div>
</div>
<div class="new_cake">
    <h1>SẢN PHẨM MỚI</h1>
    <div class="product-container">
        @foreach($list_cake as $cake)
        <a href="{{ route('detail', $cake->id) }}" class="product-card">
            <div class="product-info">
                <h2>{{ $cake->name }}</h2>
                <p>{{ Str::limit($cake->info, 120, '...') }}</p>
                <span class="price">{{ $cake->price }}₫</span>
            </div>
            <div class="product-image">
                <img src="{{ asset( $cake->img) }}" alt="">
            </div>
        </a>
        @endforeach
    </div>
</div>
<div>
    <div>
        <div class="hot-product">
            <div class="boder">
                <div class="image-card">
                    <img src="img/hot_product1.webp" alt="Bánh ngọt">
                </div>
            </div>
            <div class="boder">
                <div class="image-card">
                    <img src="img/hot_product2.webp" alt="Bánh ngọt">
                </div>
            </div>
        </div>

        <div class="hot-product">
            <div class="boder">
                <div class="image-card">
                    <img src="img/hot_product3.webp" alt="Bánh ngọt">
                </div>
            </div>
            <div class="boder">
                <div class="image-card">
                    <img src="img/hot_product4.webp" alt="Bánh ngọt">
                </div>
            </div>
        </div>
    </div>
    <div class="menu">
        <h1>MENU</h1>
        <div class="product-container">
            @foreach($list_cake as $cake)
            <a href="{{ route('detail', $cake->id) }}" class="product-card">
                <div class="product-info">
                    <h2>{{ $cake->name }}</h2>
                    <p>{{ Str::limit($cake->info, 120, '...') }}</p>
                    <span class="price">{{ $cake->price }}₫</span>
                </div>
                <div class="product-image">
                    <img src="{{ asset( $cake->img) }}" alt="">
                </div>
            </a>
            @endforeach
        </div>
        <a href="/all"><button class="all">Xem tất cả</a>
    </div>
</div>

<section class="about-us">
    <div class="container-about">
        <div class="about-content">
            <div class="about-image">
                <img src="img/infor1.png" alt="Về chúng tôi">
            </div>
            <div class="about-text">
                <h2>VỀ CHÚNG TÔI</h2>
                <p class="highlight">A PIECE OF CAKE, A PART OF WHOLE LIFE <br> BÁNH SẺ CHIA, TRỌN CUỘC SỐNG</p>
                <h3>#Nơi giao thoa nghệ thuật bánh ngọt Pháp cùng hương vị nông sản Việt</h3>
                <p>Artemis Pastry ra đời với niềm đam mê mang đến những chiếc bánh Entremet cầu kỳ của ẩm thực Pháp,
                    kết hợp hài hòa cùng trái cây nhiệt đới tươi ngon của Việt Nam.
                    Không chỉ mang tính nghệ thuật về thị giác, mỗi tác phẩm của Artemis Pastry
                    còn chứa nghệ thuật trong từng tầng hương vị.</p>
                <h3>#Cùng sẻ chia và lưu giữ mọi khoảnh khắc đáng nhớ trong cuộc đời</h3>
                <p>Như một biểu tượng của sự gắn kết, mỗi miếng bánh là một phần của ký ức,
                    lưu giữ những khoảnh khắc khó quên.</p>
                <a href="/gioithieu"><button class="btn-more">ĐỌC THÊM</button></a>
            </div>
        </div>
    </div>
</section>

<script>
    var swiper = new Swiper(".swiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
@endsection