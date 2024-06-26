<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
        @if(auth()->user()->myrole == 3 && auth()->user()->restaurant)
        <div class="restaurantName text-white  pt-2 ">
                <span>{{ \Illuminate\Support\Str::limit(auth()->user()->restaurant->name,30)}}</span>
        </div>
        @endif
    </div>

    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a data-toggle="tooltip" data-placement="bottom" title="Go to Frontend" href="{{ route('home') }}" class="nav-link nav-link-lg beep" target="_blank"><i class="fa fa-globe"></i></a>
        </li>
        <li class="dropdown">
            <a href="{{ route('admin.profile') }}" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ auth()->user()->image }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ __('Hi') }}, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('Profile') }}
                </a>

                @if(auth()->user()->myrole == 3 && auth()->user()->restaurant)
                <a href="{{ route('admin.restaurant.restaurant-edit',auth()->user()->restaurant) }}" class="dropdown-item has-icon">
                    <i class="fa fa-store fa-fw"></i> {{ __('validation.attributes.restaurant_id') }}
                </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
