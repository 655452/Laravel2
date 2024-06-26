<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="iNiLabs - The infinite invention labs">
    <meta name="author" content="iNiLabs Team">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Foodank License Activation</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        .logo {
            max-width: 130px;
            max-height: 50px;
        }
    </style>

</head>

<body>

<div class="col-lg-9 mx-auto p-2 py-md-3">
    <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
        <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
            <img src="{{asset('images/logo.png')}}" alt="" class="logo">
        </a>
    </header>

    <main>
        <div class="container col-xxl-8">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-2">
                <div class="col-10 col-sm-8 col-lg-6">
                    <div class="embed-responsive embed-responsive-21by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/UaegLmkALDM"
                                allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="display-6 fw-bold lh-3 mb-3 text-warning">{{ $message }}</h3>
                    <p class="lead">Kindly login <a href="{{ config('installer.upgradeLicenseCodeUrl') }}">here</a> {{ __('to activate your purchase key') }}</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-5">
                        <a class="btn btn-primary btn-lg mr-4" href="{{ config('installer.upgradeLicenseCodeUrl') }}" role="button" target="_blank">{{ __('Upgrade License') }}</a>
                        <a class="btn btn-light btn-lg" href="{{ route('home') }}"  role="button">{{ __('Verify Activation') }}</a>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a class="btn btn-warning btn-lg mr-4 pr-5 pl-5" href="{{ config('installer.buyNowUrl') }}" role="button" target="_blank">{{ __(' Buy Now') }}</a>
                        <a class="btn btn-light btn-lg pr-5 pl-5" href="{{ config('installer.supportUrl') }}"  role="button">{{ __(' Get Support') }}</a>
                    </div>
                </div>
            </div>

            <footer class="pt-5 my-5 text-muted border-top">
                Created by the iNiLabs team &middot; &copy; 2022
            </footer>
        </div>
    </main>

</div>


<script type="text/javascript" src="{{asset('themes/scripts/jquery-3.4.1.min.js')}}"></script>
<script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

</body>
</html>
