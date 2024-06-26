@extends('frontend.layouts.restaurent_app')
@push('meta')
    <meta property="og:url" content="{{ route('restaurant.show', [$restaurant->slug]) }}" />
    <meta property="og:type" content="{{ setting('site_name') }}">
    <meta property="og:title" content="{{ $restaurant->name }}">
    <meta property="og:description" content="{{ $restaurant->description }}">
    <meta property="og:image" content="{{ $restaurant->image }}">
@endpush

@push('body-data')
    data-bs-spy="scroll" data-bs-target="#scrollspy-menu" data-bs-smooth-scroll="true"
@endpush

@section('main-content')

    <!--====== RESTAURANT PART START =========-->
    <section class="restaurant">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 rest-col">
                    <div class="rest-content">
                        <figure class="rest-media">
                            <a class="d-block" href="{{ route('restaurant.show', [$restaurant->slug]) }}">
                                <img src="{{ asset($restaurant->image) }}" alt="restaurant">
                            </a>
                        </figure>

                        <div class="rest-profile">
                            <div class="rest-info">
                                <h1 class="rest-name">
                                    @if ($restaurant->opening_time < $currenttime && $restaurant->closing_time > $currenttime)
                                        <span class="dot on me-1" title="Open Now"></span>
                                    @else
                                        <span class="dot off me-1" title="Close Now"></span>
                                    @endif
                                    {{ $restaurant->name }}
                                </h1>
                                <p class="rest-title">
                                    @if (!blank($restaurant->cuisines))
                                        @foreach ($restaurant->cuisines as $cuisine)
                                            {{ $cuisine->name }}
                                            @if (!$loop->last)
                                                <span>,</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </p>
                                @if (!$average_rating == 0)
                                    <div class="rest-review">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $average_rating)
                                                <i class="fa-solid fa-star active"></i>
                                            @else
                                                <i class="fa-solid fa-star"></i>
                                            @endif
                                        @endfor
                                        <span>({{ $rating_user_count }} {{ __('frontend.reviews') }})</span>
                                    </div>
                                @endif
                                <div class="rest-location">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.99992 8.95346C9.14867 8.95346 10.0799 8.02221 10.0799 6.87346C10.0799 5.7247 9.14867 4.79346 7.99992 4.79346C6.85117 4.79346 5.91992 5.7247 5.91992 6.87346C5.91992 8.02221 6.85117 8.95346 7.99992 8.95346Z"
                                            stroke="#1F1F39" stroke-width="1.5" />
                                        <path
                                            d="M2.4133 5.66016C3.72664 -0.113169 12.28 -0.106502 13.5866 5.66683C14.3533 9.0535 12.2466 11.9202 10.4 13.6935C9.05997 14.9868 6.93997 14.9868 5.5933 13.6935C3.7533 11.9202 1.64664 9.04683 2.4133 5.66016Z"
                                            stroke="#1F1F39" stroke-width="1.5" />
                                    </svg>
                                    <span> {{ \Illuminate\Support\Str::limit($restaurant->address, 65) }} </span>
                                </div>
                            </div>
                            <div class="rest-btns">
                                <!-- Table Order -->
                                <!-- @if ($restaurant->table_status == \App\Enums\TableStatus::ENABLE)
                                    <button type="button" class="rest-book-btn" data-bs-toggle="modal"
                                        data-bs-target="#booking-modal">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.3335 1.3335V3.3335" stroke="white" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.6665 1.3335V3.3335" stroke="white" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.3335 6.06006H13.6668" stroke="white" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M14 5.66683V11.3335C14 13.3335 13 14.6668 10.6667 14.6668H5.33333C3 14.6668 2 13.3335 2 11.3335V5.66683C2 3.66683 3 2.3335 5.33333 2.3335H10.6667C13 2.3335 14 3.66683 14 5.66683Z"
                                                stroke="white" stroke-miterlimit="10" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M10.463 9.13314H10.469" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10.463 11.1331H10.469" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M7.99715 9.13314H8.00314" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M7.99715 11.1331H8.00314" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.52938 9.13314H5.53537" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.52938 11.1331H5.53537" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                         <span>View Contact</span>
                                        <span>{{ __('frontend.table') }} </span>
                                    </button>
                                @endif -->

                                <button type="button" class="rest-book-btn" data-bs-toggle="modal"
                                        data-bs-target="#shop-modal">
                                        <!-- Table Order -->
                                         <span>View Contact</span>
                                        <!-- <span>{{ __('frontend.table') }} </span> -->
                                    </button>
                                    <!-- i icon commented -->
                                <!-- <button type="button" class="rest-info-btn" data-bs-toggle="modal"
                                    data-bs-target="#shop-modal">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.00016 14.6668C11.6668 14.6668 14.6668 11.6668 14.6668 8.00016C14.6668 4.3335 11.6668 1.3335 8.00016 1.3335C4.3335 1.3335 1.3335 4.3335 1.3335 8.00016C1.3335 11.6668 4.3335 14.6668 8.00016 14.6668Z"
                                            stroke="#EE1D48" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8 5.3335V8.66683" stroke="#EE1D48" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M7.99609 10.6665H8.00208" stroke="#EE1D48" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button> -->
                            </div>
                        </div>

                        @if (array_key_exists($restaurant->id, $vouchers))
                            <div class="rest-voucher">
                                @php
                                    $amount = $vouchers[$restaurant->id]->discount_type == \App\Enums\DiscountType::FIXED ? currencyName(round($vouchers[$restaurant->id]->amount)) : round($vouchers[$restaurant->id]->amount) . '%';
                                @endphp
                                <button type="button">{{ __('frontend.voucher') }} <span>
                                        {{ $vouchers[$restaurant->id]->slug }} </span></button>
                                <p>{{ __('frontend.use_voucher') }} {{ $vouchers[$restaurant->id]->slug }}
                                    {{ __('frontend.and_get') }} {{ $amount }}
                                    {{ __('frontend.off_on_orders_over') }}
                                    <span>{{ currencyName($vouchers[$restaurant->id]->minimum_order_amount) }}</span>
                                </p>
                            </div>
                        @endif

                        <div class="rest-menu-wrapper" id="scrollspy-menu">
                            <div class="rest-menu-group">
                                <button type="button" class="rest-swiper-prev fa-solid fa-chevron-left"></button>
                                <div class="swiper rest-swiper">
                                    <nav class="swiper-wrapper">
                                        @foreach ($categories as $category)
                                            <a href="#listing_product{{ $category->id }}" wire:key="{{ $category->id }}"
                                                class="swiper-slide">
                                                {{ $category->name }}
                                            </a>
                                        @endforeach
                                        @if (!blank($other_products))
                                            <a href="#listing_product_other" class="swiper-slide">
                                                {{ __('frontend.other') }}
                                            </a>
                                        @endif
                                    </nav>
                                </div>
                                <button type="button" class="rest-swiper-next fa-solid fa-chevron-right"></button>
                            </div>
                        </div>

                        @livewire('show-page', ['restaurant' => $restaurant])

                    </div>
                    <!-- catalog section -->
                     <style>
                        .catalog{
                                width:90%; 
                                height:50vh;
                            }
                         @media (max-width: 830px) {
                            .catalog{
                                width:90%; 
                                height:40vh;
                            }
        }
                     </style>
                    <center><h3>Catalog</h3></center>
                    <center style="margin:10vh 0px;"> 
                        <button  type="button" class="rest-book-btn catalog" 
                                        >
                                        <!-- Table Order -->
                                         
                                         <iframe style="height: 100%; width:90%;" src="http://127.0.0.1:8000/frontend/images/Food_catalog.pdf#toolbar=0" allow="fullscreen"><span>Catalog</span></iframe>
                                        <!-- <span>{{ __('frontend.table') }} </span> -->
                                    </button></center>
                    @include('frontend.partials._footer')
                </div>

                <!--=======  Side bar card ========-->
                <aside class="cart-sidebar active">
                    <div class="cart-content">
                        <button class="cart-close fa-solid fa-xmark" type="button"></button>
                        @livewire('order-cart', ['restaurant' => $restaurant])
                    </div>
                </aside>
            </div>
        </div>
    </section>
    <!--=======  RESTAURANT PART END ========-->

    <!--======= Add to Cart Modal Start  ========-->
    @livewire('show-cart', ['restaurant' => $restaurant])


    <!--====== Table BOOKING MODAL START =========-->
    <div class="modal fade booking-modal" id="booking-modal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="booking-modal-header">
                    <button class="fa-regular fa-circle-xmark" type="button" data-bs-dismiss="modal"></button>
                    <h3>{{ __('frontend.table_booking') }} </h3>
                    <img src="{{ asset('frontend/images/gif/table.gif') }}" alt="gif">
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('restaurant.reservation') }}" class="bookForm" method="GET">
                    <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant->id }}">
                    <div class="booking-modal-content">
                        <div class="booking-modal-group">
                            <div class="booking-modal-select">
                                <h4><span> {{ __('frontend.pick_date') }} </span>
                                    <span class="dateshow">
                                        {{ date('d M Y') }}
                                    </span>
                                </h4>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="booking-modal-option">
                                <dl>
                                    <dt>{{ __('frontend.choose_date') }} </dt>
                                    <dd class="date">
                                        <input type="date" name="reservation_date" value="{{ date('Y-m-d') }}" id="datePick">
                                    </dd>
                                </dl>
                                <button class="done" type="button">{{ __('frontend.done') }} </button>
                            </div>
                        </div>
                        <div class="booking-modal-group">
                            <div class="booking-modal-select">
                                <h4><span>{{ __('frontend.number_guests') }} </span>
                                    <span class="guestQty guestotal d-inline">1</span>
                                    <span class="d-inline guestQty">{{ __('frontend.guests') }} </span>
                                </h4>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div class="booking-modal-option">
                                <dl>
                                    <dt> {{ __('frontend.choose_guests_number') }} </dt>
                                    <dd class="cart-counter">
                                        <button type="button" class="fa-solid fa-minus qminus"></button>
                                        <input type="number" name="qtyInput" value="1" id="qtyInput"
                                            class="cart-counter-value">
                                        <button type="button" class="fa-solid fa-plus qplus"></button>
                                    </dd>
                                </dl>
                                <button class="done plusMinusBtn" type="button">{{ __('frontend.done') }}</button>
                            </div>
                        </div>
                        <div class="booking-modal-time  @error('time_slot') is-invalid @enderror">
                            <h4>{{ __('frontend.time_slots') }}</h4>

                            <ul class="panel-dropdown-scrollable  reserveList" id="showTimeSlot">

                            </ul>

                        </div>

                        <div class="text-danger jsbook">

                        </div>
                    </div>
                    <div class="booking-modal-footer">
                        <button type="submit" id="bkkkid" class="cart-btn">{{ __('frontend.request_to_book') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--====== Table BOOKING MODAL PART END ==========-->


    <!--======= Resturent Infromation MODAL START =========-->
    <div class="modal fade shop-modal" id="shop-modal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="shop-modal-header">
                    <button class="fa-regular fa-circle-xmark" type="button" data-bs-dismiss="modal"></button>
                    <img src="{{ $restaurant->image }}" alt="restaurant">
                </div>
                <div class="shop-modal-meta">
                    <h3>{{ $restaurant->name }} </h3>
                    @if (!blank($restaurant->cuisines))
                        <h4>
                            @foreach ($restaurant->cuisines as $cuisine)
                                {{ $cuisine->name }}
                                @if (!$loop->last)
                                    <span>-</span>
                                @endif
                            @endforeach
                        </h4>
                    @endif
                    <p>{{ __('frontend.open') }} {{ date('h:i A', strtotime($restaurant->opening_time)) }} -
                        {{ date('h:i A', strtotime($restaurant->closing_time)) }} </p>
                </div>
                <div class="nav nav-tabs">
                    <a class="nav-link active" data-bs-toggle="tab" href="#about">{{ __('frontend.about') }}</a>
                    <a class="nav-link" data-bs-toggle="tab" href="#reviews">{{ __('frontend.reviews') }}</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="about">
                        <div class="shop-modal-about">
                            <ul>
                                <!-- dynamic restaurant   content -->
                                <!-- <li>
                                    <h3>{{ __('frontend.delivery_hours') }} </h3>
                                    <p> {{ date('h:i A', strtotime($restaurant->opening_time)) }} -
                                        {{ date('h:i A', strtotime($restaurant->closing_time)) }} </p>
                                </li>
                                <li>
                                    <h3>{{ __('frontend.address') }}</h3>
                                    <p>{{ $restaurant->address }} </p>
                                </li> -->
                                <li>
                                    <h3>1. </h3>
                                    <p>	Woicher’s contact (8:00 am to 8:00 pm)
                                        98XXXXX
                                    </p>
                                </li>
                                <li>
                                    <h3>2. </h3>
                                    <p>	Usual Delivery time - 2-3 days 
                                    </p>
                                </li>
                            </ul>
                            <img src="data:image/png;base64,{!! $qrCode !!}" alt="qr">
                        </div>
                    </div>

                    <div class="tab-pane fade" id="reviews">

                        @if (!blank($order_status))
                            <form action="{{ route('restaurant.ratings-update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div id="add-review" class="add-review-box custom-width">
                                    <h5>{{ __('frontend.add_review') }}</h5>
                                    <hr>
                                    <div class="sub-ratings-container">
                                        <div class="add-sub-rating">
                                            <div class="sub-rating-title">{{ __('frontend.review') }}
                                                <i class="tip"
                                                    data-tip-content="{{ __('frontend.auality_customer') }}"></i>
                                            </div>
                                            <div class="sub-rating-stars">
                                                <div class="clearfix"></div>
                                                <div class="leave-rating">
                                                    <input class="d-none" type="radio" value="5" name="rating"
                                                        {{ 5 == old('rating') ? 'checked' : '' }} id="rating-5">
                                                    <label for="rating-5" class="fa fa-star"></label>
                                                    <input class="d-none" type="radio" value="4" name="rating"
                                                        {{ 4 == old('rating') ? 'checked' : '' }} id="rating-4">
                                                    <label for="rating-4" class="fa fa-star"></label>
                                                    <input class="d-none" type="radio" value="3" name="rating"
                                                        {{ 3 == old('rating') ? 'checked' : '' }} id="rating-3">
                                                    <label for="rating-3" class="fa fa-star"></label>
                                                    <input class="d-none" type="radio" value="2" name="rating"
                                                        {{ 2 == old('rating') ? 'checked' : '' }} id="rating-2">
                                                    <label for="rating-2" class="fa fa-star"></label>
                                                    <input class="d-none" type="radio" value="1" name="rating"
                                                        {{ 1 == old('rating') ? 'checked' : '' }} id="rating-1">
                                                    <label for="rating-1" class="fa fa-star"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                                    <input type="hidden" name="status" value="5">

                                    <div class="form-group mt-2 pt-2">
                                        <label class="reviewLabel">{{ __('frontend.write_review') }} <span
                                                class="text-danger">*</span> </label>
                                        <textarea name="review" type="text" cols="40" rows="3" aria-label="With textarea"
                                            placeholder="{{ __('frontend.write_review') }} " class="form-control @error('review') is-invalid @enderror">{{ old('review') }}</textarea>
                                        @if ($errors->has('review'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('review') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <button type="submit" class="rest-book-btn">
                                        {{ __('frontend.submit_review') }}
                                    </button>
                                </div>
                            </form>
                        @endif
                        <br>
                        @if (!blank($ratings))
                            <ul class="shop-modal-review">
                                @foreach ($ratings as $rating)
                                    <li>
                                        {{-- <h3>{{ $rating->user->name }} </h3> --}}
                                        <dl>

                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $rating->rating)
                                                    <svg class="active" width="14" height="14"
                                                        viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M5.97191 1.37497C6.4383 0.599986 7.56186 0.599985 8.02825 1.37497L9.15178 3.24189C9.31933 3.5203 9.59263 3.71886 9.90919 3.79218L12.0319 4.28381C12.9131 4.48789 13.2603 5.55646 12.6674 6.23951L11.239 7.88495C11.026 8.13034 10.9216 8.45162 10.9497 8.77535L11.1381 10.9461C11.2163 11.8472 10.3073 12.5076 9.47449 12.1548L7.46819 11.3048C7.16899 11.1781 6.83117 11.1781 6.53197 11.3048L4.52568 12.1548C3.69283 12.5076 2.78386 11.8472 2.86206 10.9461L3.05045 8.77535C3.07855 8.45162 2.97416 8.13034 2.76115 7.88495L1.33279 6.23951C0.739863 5.55646 1.08706 4.48789 1.96824 4.28381L4.09097 3.79218C4.40753 3.71886 4.68083 3.5203 4.84838 3.24189L5.97191 1.37497Z"
                                                            stroke-width="1.5" />
                                                    </svg>
                                                @else
                                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M5.97191 1.37497C6.4383 0.599986 7.56186 0.599985 8.02825 1.37497L9.15178 3.24189C9.31933 3.5203 9.59263 3.71886 9.90919 3.79218L12.0319 4.28381C12.9131 4.48789 13.2603 5.55646 12.6674 6.23951L11.239 7.88495C11.026 8.13034 10.9216 8.45162 10.9497 8.77535L11.1381 10.9461C11.2163 11.8472 10.3073 12.5076 9.47449 12.1548L7.46819 11.3048C7.16899 11.1781 6.83117 11.1781 6.53197 11.3048L4.52568 12.1548C3.69283 12.5076 2.78386 11.8472 2.86206 10.9461L3.05045 8.77535C3.07855 8.45162 2.97416 8.13034 2.76115 7.88495L1.33279 6.23951C0.739863 5.55646 1.08706 4.48789 1.96824 4.28381L4.09097 3.79218C4.40753 3.71886 4.68083 3.5203 4.84838 3.24189L5.97191 1.37497Z"
                                                            stroke-width="1.5" />
                                                    </svg>
                                                @endif
                                            @endfor


                                            <div class="star-rating" data-rating="{{ $rating->rating }}"> </div>

                                            <dd> {{ $rating->updated_at->format('d M Y, h:i A') }}</dd>
                                        </dl>
                                        <p>{{ $rating->review }} </p>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--======= Resturent Infromation MODAL END ==========-->
@endsection

@push('js')
    <script> const reservationUrl = "{{ route('reservation.check') }}";</script>
    <script src="{{ asset('frontend/js/booking.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/show.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/loader.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/navcount.js') }}" type="text/javascript"></script>
@endpush

@push('livewire')
    <script src="{{ asset('js/order-cart.js') }}"></script>
@endpush
