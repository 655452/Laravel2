@extends('frontend.layouts.app')

@push('meta')
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:type" content="Woich">
    <meta property="og:title" content="{{ setting('banner_title') }}">
    <meta property="og:description" content="Explore top-rated attractions, activities and more">
    <meta property="og:image" content="{{ asset('images/' . setting('site_logo')) }}">

    <link rel="stylesheet" href="https://andreruffert.github.io/rangeslider.js/assets/rangeslider.js/dist/rangeslider.css">
    <style>
        /* Custom CSS for the Menu Items Section */


    </style>
@endpush

@section('main-content')
    <!--======= RESTAURANT SECTION START ========-->
    <section class="restaurant section-gap-66">
        <div class="container">

            <!-- Restaurant Filter Section -->
            <div class="filter-group" id="filter">
                <form method="GET" action="{{ route('search', Request::query()) }}" id="myForm">
                    <input type="hidden" class="form-control" id="lat" name="lat" value="{{ Request::get('lat') }}">
                    <input type="hidden" class="form-control" id="long" name="long" value="{{ Request::get('long') }}">
                    <input type="hidden" id="expedition" name="expedition" value="{{ Request::get('expedition') }}">

                    <div class="filter-options d-flex align-items-center justify-content-between">

                        <!-- Search by Business -->
                        <div class="filter-search">
                            <button type="submit" class="lni lni-search-alt"></button>
                            <input type="text" name="query" id="search" placeholder="Search by business" value="{{ Request::get('query') }}">
                        </div>

                        <!-- Filter by Category (Cuisines) -->
                        <div class="filter-select dropdownParent">
                            <span class="custonDropdown d-flex justify-content-center">Category</span>
                            <ul class="cDrop">
                                <div class="row checkNew">
                                    @foreach ($cuisines as $cuisine)
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <?php
                                                $checked = !blank(Request::get('cuisines')) && in_array($cuisine->slug, Request::get('cuisines')) ? 'checked' : '';
                                                ?>
                                                <input id="check-{{ $cuisine->id }}" type="checkbox" multiple name="cuisines[]" value="{{ $cuisine->slug }}" {{ $checked }}>
                                                <label for="check-{{ $cuisine->id }}">{{ $cuisine->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="panel-buttons">
                                    <button class="panel-cancel">{{ __('frontend.cancel') }}</button>
                                    <button id="catApply" class="panel-apply">{{ __('frontend.apply') }}</button>
                                </div>
                            </ul>
                        </div>

                        <!-- Filter by Distance -->
                        <div class="filter-select">
                            <span class="custonDropdown d-flex justify-content-center">{{ __('frontend.distance_radius') }}</span>
                            <ul class="cDrop">
                                <div class="row radiousTxt">
                                    <p>{{ __('frontend.radious_around_destination') }}</p>
                                    <div class="kilo">
                                        <output id="relationship-status-output" class="relationship">100</output>
                                        <span>{{ __('frontend.km') }}</span>
                                    </div>
                                    <input type="range" id="relationship-status-slider" class="relationship-status-slider" min="1" max="100" step="1" name="distance" value="100">
                                </div>
                                <div class="panel-buttons">
                                    <button class="panel-cancel">{{ __('frontend.cancel') }}</button>
                                    <button class="panel-apply">{{ __('frontend.apply') }}</button>
                                </div>
                            </ul>
                        </div>

                        <!-- Clear Button -->
                        <div class="filter-button">
                            <button type="button">
                                <a class="clearBtn d-block" href="{{ route('search') }}" class="text-danger">
                                    <span>{{ __('frontend.clear') }}</span>
                                </a>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Header -->
            <div class="filter-header d-flex align-items-center justify-content-start">
                <h3>{{ $restaurants->total() }} {{ __('frontend.results_found') }}</h3>
            </div>

            <!-- Restaurants List -->
            <div class="row" id="restaurant-list">
                @include('frontend.restaurant.search-restaurant')
            </div>

            <!-- Menu Items Section -->
           
<!-- Menu Items Section -->
@if($menuItems->isNotEmpty())
    <div id="menu-item-results" class="menu-items-container mt-4">
        <h3 style="font-size: 22px;
    font-weight: 700;
    line-height: 34px;
    margin-bottom:30px;" class="menu-items-heading">Menu Items Found</h3>
        <div class="menu-items-grid row">
            <div class="row" id="search-results">
                @foreach ($menuItems as $menuItem)
                    <div class="col-md-4 mb-4 d-flex menu-item"
                         data-price="{{ $menuItem->unit_price }}"
                         data-rating="{{ $menuItem->average_rating }}"
                         data-category="{{ $menuItem->categories->pluck('id')->implode(',') }}"> 
                         <!-- Handle multiple categories -->

                        <div class="card h-100 d-flex flex-row align-items-center" style="width: 100%;">

                            <!-- Image Section -->
                            <div class="card-img-container" style="flex: 0 0 30%;">
                                @if($menuItem->media && $menuItem->media->isNotEmpty())
                                    <img src="{{ $menuItem->media->first()->getUrl() }}" 
                                         alt="{{ $menuItem->name }}" 
                                         class="img-fluid rounded" 
                                         style="width: 100%; height: auto; object-fit: contain;">
                                @else
                                    <img src="/path/to/default-image.jpg" class="img-fluid rounded" 
                                         alt="Default Image" 
                                         style="width: 100%; height: auto; object-fit: cover;">
                                @endif
                            </div>

                            <!-- Menu Item Content -->
                            <div class="card-body ml-3" style="flex: 1;">
                                <a href="{{ route('restaurant.show', [$menuItem->restaurant->slug]) }}" style="color:black;font-size:14px;" >
                                    <p><b>{{ $menuItem->name }}</b></p>
                                    <p class="card-text" style="font-size: 12px;">{{ \Illuminate\Support\Str::limit(strip_tags($menuItem['description']), 40) }}</p>

                                    <!-- Ratings Section -->
                                    <div class="stars d-flex align-items-center mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" style="color: {{ $i <= $menuItem->average_rating ? '#FFD700' : '#D3D3D3' }};"></i>
                                        @endfor
                                        <span class="ml-2 badge badge-pill badge-warning" 
                                              style="background-color: #d4541b; border-radius: 20px; width: 20px; height: 20px; text-align: center; color: white; font-weight: 500; display:flex; justify-content:center;align-items:center;">
                                            {{ $menuItem->total_reviews }}
                                        </span>
                                    </div>

                                    <!-- Price Section -->
                                    @if($menuItem->unit_price > 0)
                                        <p class="card-text">
                                            Price: <strong>₹{{ number_format($menuItem->unit_price, 2) }}</strong>
                                        </p>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif


            <!-- Load More Button -->
            @if ($restaurants->hasMorePages())
                <div class="text-center mt-4">
                    <button id="load-more" class="btn btn-primary" data-url="{{ $restaurants->nextPageUrl() }}">
                        Load More
                    </button>
                </div>
            @endif

        </div>
    </section>
    <!--======= RESTAURANT SECTION END ========-->
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loadMoreButton = document.getElementById('load-more');
            loadMoreButton?.addEventListener('click', function () {
                const url = this.getAttribute('data-url');
                if (url) {
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('restaurant-list').insertAdjacentHTML('beforeend', data.restaurants);
                        if (!data.next_page_url) {
                            loadMoreButton.remove();
                        } else {
                            loadMoreButton.setAttribute('data-url', data.next_page_url);
                        }
                    })
                    .catch(error => console.error('Error loading more restaurants:', error));
                }
            });
        });
    </script>

    <script src="{{ asset('frontend/js/rangeslider.min.js') }}"></script>
    <script src="{{ asset('frontend/js/customrangeslider.js') }}"></script>
@endpush
