@extends('frontend.layouts.app')
@push('meta')
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:type" content="Foodbank">
    <meta property="og:title" content="{{ setting('banner_title') }}">
    <meta property="og:description" content="Explore top-rated attractions, activities and more">
    <meta property="og:image" content="{{ asset('images/' . setting('site_logo')) }}">

    <link rel="stylesheet" href="https://andreruffert.github.io/rangeslider.js/assets/rangeslider.js/dist/rangeslider.css">
@endpush

@section('main-content')
    <!--======= RESTAURANT PART START ========-->
    
    <section class="restaurant section-gap-66" style="margin-top: 8vh;">
        <div class="container">
            <div class="filter-group" id="filter">
                <div class="swiper filter-swiper">
                    <nav class="swiper-wrapper d-flex flex-wrap">
                        <a onclick="expedition('all')" class="expedition me-md-3 me-sm-2 me-0" data-filter=".delivery-filter">
                            <button type="button" class="swiper-slide @if (Request::get('expedition') == 'all' || Request::get('expedition') == '') active @endif">
                                <i class="fa-solid fa-check-double"></i>
                                <span>{{ __('frontend.all') }} </span>
                            </button>
                        </a>
                        <a onclick="expedition('delivery')" class="expedition me-md-3 me-sm-2 me-0" data-filter=".delivery-filter">
                            <button type="button" class="swiper-slide  @if (Request::get('expedition') == 'delivery') active @endif">
                                <!-- <i class="fa-solid fa-person-biking"></i> -->
                                <!-- changes -->
                                <span>Organic</span>
                                <!-- <span>{{ __('frontend.delivery') }}</span> -->
                            </button>
                        </a>
                        <a onclick="expedition('pickup')" class="expedition me-md-3 me-sm-2 me-0" data-filter=".delivery-filter">
                            <button type="button" class="swiper-slide  @if (Request::get('expedition') == 'pickup') active @endif">
                                <!-- <i class="fa-solid fa-burger"></i> -->
                                <span>Healthy</span>
                                <!-- <span>{{ __('frontend.takeaway') }} </span> -->
                            </button>
                        </a>
                        <a onclick="expedition('table')" class="expedition me-md-3 me-sm-2 me-0" data-filter=".delivery-filter">
                            <button type="button" class="swiper-slide @if (Request::get('expedition') == 'table') active @endif">
                                <!-- <i class="fa-solid fa-border-all"></i> -->
                                <!-- <span> {{ __('frontend.table') }} </span> -->
                                 <span>Kids Friendly</span>
                            </button>
                        </a>
                    </nav>
                </div>

                <form method="GET" action="{{ route('search', Request::query()) }}" id="myForm">
                    <input type="hidden" class="form-control" id="lat" name="lat"
                        value="{{ Request::get('lat') }}">
                    <input type="hidden" class="form-control" id="long" name="long"
                        value="{{ Request::get('long') }}">
                    <input type="hidden" id="expedition" name="expedition" value="{{ Request::get('expedition') }} ">
                    <div class="filter-options">

                        <div class="filter-search">
                            <button type="submit" class="lni lni-search-alt"></button>
                            <!-- <input type="text" name="query" id="search"
                                placeholder="{{ __('frontend.search_placeholder') }}" value="{{ Request::get('query') }}"> -->
                                <!-- changes made -->
                                <input type="text" name="query" id="search"
                                placeholder="Search by business" value="{{ Request::get('query') }}">
                        </div>

                        <!-- remove search by Locations -->
                        <!-- <div class="filter-search location">
                            <a href="javascript:void(0)">
                                <button type="submit" class="lni lni-search-alt" onclick="getLocation()"></button>
                            </a>
                            <div id="autocomplete-container">
                                <input id="autocomplete-input" type="text"
                                    placeholder="{{ __('frontend.by_location') }}">
                            </div>
                        </div> -->

                        <div class="filter-select">
                            <div class="dropdownParent">
                                <!-- L2 Drop Down cusines change -->
                                <span class="custonDropdown d-flex justify-content-center">
                                L2 
                                </span>
                                <ul class="cDrop">
                                    <!-- <div class="row checkNew">
                                        @foreach ($cuisines as $cuisine)
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <?php
                                                    $checked = '';
                                                    if (!blank(Request::get('cuisines'))) {
                                                        $checked = in_array($cuisine->slug, Request::get('cuisines')) ? 'checked' : '';
                                                    } ?>
                                                    <input id="check-{{ $cuisine->id }}" type="checkbox" multiple
                                                        name="cuisines[]" value="{{ $cuisine->slug }}" <?= $checked ?>>
                                                    <label for="check-{{ $cuisine->id }}">{{ $cuisine->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div> -->

                                                        <!-- Buttons -->
                                                        <!-- <div class="panel-buttons">
                                                            <button class="panel-cancel">{{ __('frontend.cancel') }}</button>
                                                            <button class="panel-apply">{{ __('frontend.apply') }}</button>
                                                        </div> -->



                    <div class="row checkNew">
                        <div class="col-xl-6">
                            <div class="form-group">                
                                <input type="checkbox" multiple>
                                <label>Nutri & Organics Food</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Snacks (Munchies)</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Sweet Tooth</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Artisanal Foods</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Wholesome Meal</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Party Food</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Pickles Tickle</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Yogis</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Zumba & Aerobics</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Dance</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Stronger Kids</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Artsy & Craftsy</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Musical Minds</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Floristry & Greens</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Pen Craft</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Kids Workshops</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Adults Workshops</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Personalized Gifting</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Kids Gifting</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Corporate & Seasonal Gifting</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Theme Parties</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Decor</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Food</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Gifts</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Offline Classes</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Online Classes</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Decor & Utilities</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Divine Decor</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Seasonal Decor</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Organics</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Palmistry</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Tarot</label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <input type="checkbox" multiple>
                                <label>Healing</label>
                            </div>
                        </div>
                    </div>

                                    <!-- L2 drop down ends  Here -->
                                </ul>
                            </div>
                        </div>
                        <div class="filter-select">
                            <span class="custonDropdown d-flex justify-content-center">
                                {{ __('frontend.distance_radius') }}
                            </span>
                            <ul class=" cDrop">
                                <div class="row radiousTxt">
                                    <p> {{ __('frontend.radious_around_destination') }} </p>

                                    <div class="kilo">
                                        <output id="relationship-status-output" class="relationship">100</output>
                                        <span>{{ __('frontend.km') }} </span>
                                    </div>
                                    <input type="range" id="relationship-status-slider"
                                        class="relationship-status-slider" min="1" max="100" step="1" name="distance" value="100">
                                </div>

                                <!-- Buttons -->
                                <div class="panel-buttons">
                                    <button class="panel-cancel">{{ __('frontend.cancel') }} </button>
                                    <button class="panel-apply">{{ __('frontend.apply') }}</button>
                                </div>
                            </ul>
                        </div>

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

            <div class="filter-header d-flex align-items-center justify-content-start">
                <h3> {{ $restaurants->total() }} {{ __('frontend.results_found') }}</h3>
            </div>

            <div class="row">
                @include('frontend.restaurant.search-restaurant')
            </div>
        </div>
    </section>
    <!--====== RESTAURANT PART END =============-->
@endsection

@push('js')
    <!-- Push Js = -->
    <script>
        var restaurants = @json($mapRestaurants);
        var mapLat = '{{ Request::get('lat ') }}';
        var mapLong = '{{ Request::get('long ') }}';
    </script>

    <script type="text/javascript" src="{{ asset('frontend/js/rangeslider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/customrangeslider.js') }}"></script>

    <script type="text/javascript" src="{{ asset('frontend/js/map-current.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/scripts/typed.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ setting('google_map_api_key') }}&libraries=places&callback=initAutocomplete">
    </script>
    <script type="text/javascript" src="{{ asset('themes/scripts/infobox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/scripts/markerclusterer.js') }}"></script>

    <script src="{{ asset('js/search/search.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/scripts/maps.js') }}"></script>
@endpush
