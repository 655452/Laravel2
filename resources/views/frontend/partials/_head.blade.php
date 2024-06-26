<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- AUTHOR -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @stack('meta')

    <!-- WEBPAGE TITLE -->
    <title>
        @if (isset($site_title) && setting('site_name'))
            {{ setting('site_name') . ' : ' . $site_title }}
        @elseif(setting('site_name'))
            {{ setting('site_name') }}
        @elseif($site_title)
            {{ $site_title }}
        @else
            {{ '' }}
        @endif
    </title>

    <!-- FAVICON -->
    <link href="{{ asset('images/' . setting('fav_icon')) }}" rel="shortcut icon" type="image/x-icon">

    <!-- LIBRARY -->
    <link rel="stylesheet" href="{{ asset('frontend/lib/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/bootstrap/bootstrap.min.css') }}">

    <!-- FONTS -->
    <link rel="stylesheet" href="{{ asset('frontend/fonts/lineicons/lineicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/fontawesome/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/opensauce/opensauce.min.css') }}">

    <!-- iziToast -->
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/dist/css/iziToast.min.css') }}">

    <!-- CUSTOM -->
    <link rel="stylesheet" href="{{ asset('frontend/css/expanded/style.css') }}">

    <!-- My Custom Css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/expanded/delopovercustom.css') }}">


    @stack('style')

    @livewireStyles
</head>
