@extends('layout.master')
@section('maincontent')
<div class="menu">
    <h1>GIFTSET</h1>
    <div class="product-container">
        @foreach($giftset as $cake)
        @if ($cake['category'] == 4)
        <a href="{{ route('detail', $cake->id) }}" class="product-card">
            <div class="product-image">
                <img src="{{ asset( $cake->img) }}" alt="">
            </div>
            <div class="product-info">
                <h2>{{ $cake->name }}</h2>
                <p>{{ Str::limit($cake->info, 120, '...') }}</p>
                <span class="price">{{ $cake->price }}₫</span>
            </div>
            
        </a>
        @endif
        @endforeach
    </div>
</div>

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

<style>
    .product-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .product-card {
        display: flex;
        flex-direction: row;
        align-items: center;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
        text-decoration: none;
        color: #333;
    }

    .product-image img {
        width: 150px;
        height: 15  0px;
        object-fit: cover;
        border-radius: 5px;
    }

    .product-info {
        margin-left: 40px;
        flex: 1;
    }

    .price {
        font-weight: bold;
        color: #e91e63;
    }
</style>
@endsection