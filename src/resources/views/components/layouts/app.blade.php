<!DOCTYPE html>
<html lang="en">
<head>
    @livewireStyles
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index - NiceRestaurant Bootstrap Template</title>
    
    <!-- Styles -->
    <link href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet">
</head>
<body class="index-page">

    {{-- Ini tempat konten halaman seperti home, contact, dsb --}}
    @yield('content')

    @livewireScripts

    <!-- Vendor JS -->
    <script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('front/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('front/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('front/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('front/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
</body>
</html>
