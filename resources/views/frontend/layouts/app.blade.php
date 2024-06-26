<!DOCTYPE html>
<html>
@include('frontend.partials._head')

<body  @stack('body-data')>

    <div id="main-wrapper">
        @include('frontend.partials._nav')

        @yield('main-content')
        @includeUnless(request()->is(['login', 'register']), 'frontend.partials._footer')

    </div>
    @include('frontend.partials._scripts')

</body>

</html>
