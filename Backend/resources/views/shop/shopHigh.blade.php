<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link
        href="{{ asset('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i') }}"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate.css/animate.min.css') }}">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Vendor JS Files -->
    <script src="{{URL('assets/vendor/aos/aos.js')}}"></script>
    <script src="{{URL('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{URL('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{URL('assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{URL('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

    <script src="https://kit.fontawesome.com/3a0d673fb7.js" crossorigin="anonymous"></script>
    <!-- Template Main JS File -->
    <script src="{{URL('assets/js/main.js')}}"></script>
    <title>Organi Shop</title>
</head>

<body>
    {{ View::make('header') }}
    @yield("high")
    {{ View::make('footer') }}

</body>

</html>
