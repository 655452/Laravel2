<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong> <i class="fa fa-bars"></i> &nbsp  {{ __('frontend.all_category') }}</strong></a>
        <div class="dropdown-menu">
            @foreach($categories as $category)
                <a class="dropdown-item" href="#">{{ $category }}</a>
            @endforeach
        </div>
    </li>
    @foreach($categories->take(7) as $category)
        <li class="nav-item">
            <a class="nav-link" href="#">{{ $category }}</a>
        </li>
    @endforeach
</ul>
