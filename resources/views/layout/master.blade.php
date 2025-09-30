    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Artemis Pastry</title>
        <link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css')}}" />

        <link href="{{ asset ('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') }}" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('style.css') }}">
        <link rel="stylesheet" href="{{ asset('./themify-icons-font/themify-icons/themify-icons.css') }}">

        <script src="{{ asset('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js') }}">
        </script>
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') }}"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    </head>

    <div id="wrapper">
        @include('include.header')
        @yield('maincontent')

    </div>

    <div id="footer">
        @include('include.footer')

    </div>

    </html>