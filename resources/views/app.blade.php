<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="@php
        $favicon = \App\Models\Setting::where('key', 'company_favicon')->value('value');
        echo $favicon ?: '/landing/img/logo/favicon.svg';
    @endphp">
    <title>@php
        $companyName = \App\Models\Setting::where('key', 'company_name')->value('value');
        echo $companyName ?: config('app.name', 'Platform');
    @endphp</title>
    
    <!-- Landing Page CSS -->
    <link rel="stylesheet" href="/landing/css/animate.css">
    <link rel="stylesheet" href="/landing/css/fontawesome.min.css">
    <link rel="stylesheet" href="/landing/css/bootstrap.min.css">
    <link rel="stylesheet" href="/landing/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/landing/css/nice-select.css">
    <link rel="stylesheet" href="/landing/css/odometer.css">
    <link rel="stylesheet" href="/landing/css/venobox.min.css">
    <link rel="stylesheet" href="/landing/css/aos.css">
    <link rel="stylesheet" href="/landing/css/metisMenu.css">
    <link rel="stylesheet" href="/landing/css/spacing.css">
    <link rel="stylesheet" href="/landing/css/main.css">
    
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app"></div>
    
    <!-- Landing Page JS -->
    <script src="/landing/js/jquery-3.5.1.min.js"></script>
    <script src="/landing/js/jquery.appear.js"></script>
    <script src="/landing/js/popper.min.js"></script>
    <script src="/landing/js/bootstrap.min.js"></script>
    <script src="/landing/js/swiper-bundle.min.js"></script>
    <script src="/landing/js/jquery.nice-select.min.js"></script>
    <script src="/landing/js/metisMenu.js"></script>
    <script src="/landing/js/odometer.min.js"></script>
    <script src="/landing/js/jquery.knob.min.js"></script>
    <script src="/landing/js/jquery.final-countdown.min.js"></script>
    <script src="/landing/js/imagesloaded.pkgd.min.js"></script>
    <script src="/landing/js/isotope.pkgd.min.js"></script>
    <script src="/landing/js/venobox.min.js"></script>
    <script src="/landing/js/aos.js"></script>
    <script src="/landing/js/script.js"></script>
</body>
</html>

