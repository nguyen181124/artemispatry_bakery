@extends('layout.master')
@section('maincontent')
<div class="menu" style="margin-bottom: 97px;">
    <h1>BÁNH SINH NHẬT</h1>
    <div class="product-container" style="margin-bottom: 50px;">
        @foreach($all_cake as $cake)
        @if ($cake['category'] == 1)
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
        @endif
        @endforeach
    </div>

    <h1>BÁNH LẺ</h1>
    <div class="product-container" style="margin-bottom: 50px;">
        @foreach($all_cake as $cake)
        @if ($cake['category'] == 2)
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
        @endif
        @endforeach
    </div>

    <h1>ĐỒ UỐNG</h1>
    <div class="product-container" style="margin-bottom: 50px;">
        @foreach($all_cake as $cake)
        @if ($cake['category'] == 3)
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
        @endif
        @endforeach
    </div>

    <h1>GIFTSET</h1>
    <div class="product-container" style="margin-bottom: 50px;">
        @foreach($all_cake as $cake)
        @if ($cake['category'] == 4)
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
@endsection