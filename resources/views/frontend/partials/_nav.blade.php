<!--========== HEADER PART START ===========-->
<header class="heder-padding">
    <div class="header fixed sticky">
       
        <div class="container nav-header">
            <div class="header-content" style="height: 11vh;flex-wrap:wrap;">

<div style="display: flex; justify-content:space-evenly; width:90vw;">
                
                <a href="{{ route('home') }}" class="header-logo">
                    <img style="width: 150px;" src="@if (\Route::current()->getName() === ' home') {{ asset('images/' . setting('site_logo')) }}
                         @else {{ asset('images/' . setting('site_logo')) }} @endif"
                        data-sticky-logo="{{ asset('images/' . setting('site_logo')) }}" alt="logo">
                </a>
               
                

                @php
                    $href = 'javascript:void(0)';
                    if (!blank(session()->get('session_cart_restaurant'))) {
                        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
                        $href = $routeName != 'restaurant.show' ? route('restaurant.show', [session()->get('session_cart_restaurant')]) : 'javascript:void(0)';
                    }
                @endphp
                <!-- addding search bar -->
                <!-- <div style="height: 80%;" class="main-search-input">
                            <input type="hidden" id="lat" name="lat" required="" value="">
                            <input type="hidden" id="long" name="long" required="" value="">
                            <input type="hidden" id="expedition" name="expedition" value="{{ __('all') }}">

                            <div style="height: 58px;" class="banner-search main-search-input-item location">
                                <div id="autocomplete-container" class="me-auto ms-2 w-100">
                                    <input id="autocomplete-input" type="text" placeholder="{{ __('frontend.search') }}">
                                </div>
                                <a href="javascript:void(0)">
                                    <span id="locationIcon" onclick="getLocation()">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 19.5C16.1421 19.5 19.5 16.1421 19.5 12C19.5 7.85786 16.1421 4.5 12 4.5C7.85786 4.5 4.5 7.85786 4.5 12C4.5 16.1421 7.85786 19.5 12 19.5Z"
                                                stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12 4V2" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M4 12H2" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12 20V22" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M20 12H22" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                                <button style="font-size:20px;" type="submit">{{ __('frontend.search') }}</button>
                            </div>
                        </div>

                <div class="header-group"> -->
                    <style>

                        @media (max-width: 767px) {
                            .desktop-screen{
                                display: none;

                            }    
                        }
                    </style>
                <form class="desktop-screen" method="GET" action="{{ route('search') }}">
                        <div   class="main-search-input">
                            <input type="hidden" id="lat" name="lat" required="" value="">
                            <input type="hidden" id="long" name="long" required="" value="">
                            <input type="hidden" id="expedition" name="expedition" value="{{ __('all') }}">

                            <div style="height: 45px;" class="banner-search main-search-input-item location">
                                <div id="autocomplete-container" class="me-auto ms-2 w-100">
                                    <input id="autocomplete-input" type="text" placeholder="{{ __('frontend.search') }}">
                                </div>
                                <!-- Disable location icon -->
                                <a href="javascript:void(0)">
                                    <span id="locationIcon" onclick="getLocation()">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 19.5C16.1421 19.5 19.5 16.1421 19.5 12C19.5 7.85786 16.1421 4.5 12 4.5C7.85786 4.5 4.5 7.85786 4.5 12C4.5 16.1421 7.85786 19.5 12 19.5Z"
                                                stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12 4V2" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M4 12H2" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12 20V22" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M20 12H22" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                                <!-- <button type="submit" style="font-size: 15px;">{{ __('frontend.search') }}</button> -->
                                <button type="submit" style="font-size: 15px; height: 30px; width: 30px; display: flex; align-items: center; justify-content: center; padding: 0; border: none; ">
                        <img src="https://cdn-icons-png.flaticon.com/128/10934/10934545.png" alt="" style="height: 60%; width: 60%;">
                    </button>

                                
                            </div>
                        </div>
            </form>
                    <!-- search bar  ended -->

<!-- second section navbar -->
   <style>
        /* Media query for small screens */
        @media (max-width: 768px) {
            .responsive-element {
                width: 100% !important;
            }
        }
        .responsive-element {
            display: flex;
            justify-content: end;
            gap: 10px; 
            width:40%;
        }
    </style>
<div class="responsive-element" style="">
    
<!-- bell icon added -->
<a href="#" class="header-cart" id="cartLink" style="display: flex; justify-content: center; align-items: center; ">
    <img src="https://cdn-icons-png.flaticon.com/128/1156/1156949.png" title="bell icons" alt="" style="max-width: 60%; max-height: 60%;">
</a>
<!-- whishlist icon added -->
<a href="#" class="header-cart" id="cartLink" style="display: flex; justify-content: center; align-items: center; ">
    <img src="https://cdn-icons-png.flaticon.com/128/9368/9368214.png" title="bell icons" alt="" style="max-width: 60%; max-height: 60%;">
   
</a>

  <!-- cart icon commented -->
                    
                    <!-- <a href="{{ $href }}" class="header-cart" id="cartLink">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.3066 5.97335C12.8599 5.48002 12.1866 5.19335 11.2532 5.09335V4.58668C11.2532 3.67335 10.8666 2.79335 10.1866 2.18001C9.49991 1.55335 8.60658 1.26001 7.67991 1.34668C6.08658 1.50001 4.74658 3.04001 4.74658 4.70668V5.09335C3.81325 5.19335 3.13991 5.48002 2.69325 5.97335C2.04658 6.69335 2.06658 7.65335 2.13991 8.32001L2.60658 12.0333C2.74658 13.3333 3.27325 14.6667 6.13991 14.6667H9.85991C12.7266 14.6667 13.2532 13.3333 13.3932 12.04L13.8599 8.31335C13.9332 7.65335 13.9466 6.69335 13.3066 5.97335ZM7.77324 2.27335C8.43991 2.21335 9.07325 2.42002 9.56658 2.86668C10.0532 3.30668 10.3266 3.93335 10.3266 4.58668V5.05335H5.67325V4.70668C5.67325 3.52002 6.65324 2.38002 7.77324 2.27335ZM5.61325 8.76668H5.60658C5.23991 8.76668 4.93991 8.46668 4.93991 8.10002C4.93991 7.73335 5.23991 7.43335 5.60658 7.43335C5.97991 7.43335 6.27991 7.73335 6.27991 8.10002C6.27991 8.46668 5.97991 8.76668 5.61325 8.76668ZM10.2799 8.76668H10.2732C9.90658 8.76668 9.60658 8.46668 9.60658 8.10002C9.60658 7.73335 9.90658 7.43335 10.2732 7.43335C10.6466 7.43335 10.9466 7.73335 10.9466 8.10002C10.9466 8.46668 10.6466 8.76668 10.2799 8.76668Z"
                                fill="white" />
                        </svg>

                        @if (\Route::currentRouteName() === 'restaurant.show')
                            <sup id="nacCount">0</sup>
                        @else
                            <sup>
                                @if (!blank(session()->get('cart')))
                                    {{ session()->get('cart')['totalQty'] }}
                                @else
                                    0
                                @endif
                            </sup>
                        @endif
                    </a> -->
                    
                    
                    <!-- language drop down commented -->
                    <!-- @if (!blank($language))
                        <div class="header-selection">
                            <button type="button" class="header-selection-btn">
                                @foreach ($language as $lang)
                                    @if (Session()->has('applocale') and Session()->get('applocale') and setting('locale'))
                                        @if (Session()->get('applocale') == $lang->code)
                                            {{ $lang->flag_icon == null ? '🇬🇧' : $lang->flag_icon }}&nbsp
                                            <span>
                                                {{ $lang->name }}
                                            </span>
                                        @endif
                                    @else
                                        @if (setting('locale') == $lang->code)
                                            {{ $lang->flag_icon == null ? '🇬🇧' : $lang->flag_icon }}&nbsp
                                            <span>
                                                {{ $lang->name }}
                                            </span>
                                        @endif
                                    @endif
                                @endforeach
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <ul class="header-selection-list">
                                @foreach ($language as $lang)
                                    <li>
                                        <a href="{{ route('lang.index', $lang->code) }}" class="p-0">
                                            {{ $lang->flag_icon == null ? '🇬🇧' : $lang->flag_icon }}&nbsp
                                            <span>
                                                {{ $lang->name }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif -->

                    @if (Auth::guest())
                        <!--~~~~~~~~~~~~ BEFORE SIGNIN/SIGNUP CODE START ~~~~~~~~~~-->
                        <div class="header-auth">
                            <button type="button" class="header-auth-btn">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.6666 8.00004C14.6666 4.32671 11.6733 1.33337 7.99992 1.33337C4.32659 1.33337 1.33325 4.32671 1.33325 8.00004C1.33325 9.93337 2.16659 11.6734 3.48659 12.8934C3.48659 12.9 3.48658 12.9 3.47992 12.9067C3.54659 12.9734 3.62659 13.0267 3.69325 13.0867C3.73325 13.12 3.76659 13.1534 3.80659 13.18C3.92659 13.28 4.05992 13.3734 4.18659 13.4667C4.23325 13.5 4.27325 13.5267 4.31992 13.56C4.44659 13.6467 4.57992 13.7267 4.71992 13.8C4.76659 13.8267 4.81992 13.86 4.86659 13.8867C4.99992 13.96 5.13992 14.0267 5.28658 14.0867C5.33992 14.1134 5.39325 14.14 5.44659 14.16C5.59325 14.22 5.73992 14.2734 5.88658 14.32C5.93992 14.34 5.99325 14.36 6.04658 14.3734C6.20658 14.42 6.36658 14.46 6.52659 14.5C6.57325 14.5134 6.61992 14.5267 6.67325 14.5334C6.85992 14.5734 7.04658 14.6 7.23992 14.62C7.26658 14.62 7.29325 14.6267 7.31992 14.6334C7.54658 14.6534 7.77325 14.6667 7.99992 14.6667C8.22658 14.6667 8.45325 14.6534 8.67325 14.6334C8.69992 14.6334 8.72658 14.6267 8.75325 14.62C8.94658 14.6 9.13325 14.5734 9.31992 14.5334C9.36658 14.5267 9.41325 14.5067 9.46658 14.5C9.62659 14.46 9.79325 14.4267 9.94658 14.3734C9.99992 14.3534 10.0533 14.3334 10.1066 14.32C10.2533 14.2667 10.4066 14.22 10.5466 14.16C10.5999 14.14 10.6533 14.1134 10.7066 14.0867C10.8466 14.0267 10.9866 13.96 11.1266 13.8867C11.1799 13.86 11.2266 13.8267 11.2733 13.8C11.4066 13.72 11.5399 13.6467 11.6733 13.56C11.7199 13.5334 11.7599 13.5 11.8066 13.4667C11.9399 13.3734 12.0666 13.28 12.1866 13.18C12.2266 13.1467 12.2599 13.1134 12.2999 13.0867C12.3733 13.0267 12.4466 12.9667 12.5133 12.9067C12.5133 12.9 12.5133 12.9 12.5066 12.8934C13.8333 11.6734 14.6666 9.93337 14.6666 8.00004ZM11.2933 11.3134C9.48658 10.1 6.52659 10.1 4.70658 11.3134C4.41325 11.5067 4.17325 11.7334 3.97325 11.98C2.95992 10.9534 2.33325 9.54671 2.33325 8.00004C2.33325 4.87337 4.87325 2.33337 7.99992 2.33337C11.1266 2.33337 13.6666 4.87337 13.6666 8.00004C13.6666 9.54671 13.0399 10.9534 12.0266 11.98C11.8333 11.7334 11.5866 11.5067 11.2933 11.3134Z"
                                        fill="#e86121" />
                                    <path
                                        d="M8 4.62C6.62 4.62 5.5 5.74 5.5 7.12C5.5 8.47333 6.56 9.57333 7.96667 9.61333C7.98667 9.61333 8.01333 9.61333 8.02667 9.61333C8.04 9.61333 8.06 9.61333 8.07333 9.61333C8.08 9.61333 8.08667 9.61333 8.08667 9.61333C9.43333 9.56666 10.4933 8.47333 10.5 7.12C10.5 5.74 9.38 4.62 8 4.62Z"
                                        fill="#e86121" />
                                </svg>
                            </button>
                            <nav class="header-auth-navs">
                                <a href="{{ route('login') }}">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.2 1.33337H9.46667C7.33333 1.33337 6 2.66671 6 4.80004V7.50004H8.96L7.58 6.12004C7.48 6.02004 7.43333 5.89337 7.43333 5.76671C7.43333 5.64004 7.48 5.51337 7.58 5.41337C7.77333 5.22004 8.09333 5.22004 8.28667 5.41337L10.52 7.64671C10.7133 7.84004 10.7133 8.16004 10.52 8.35337L8.28667 10.5867C8.09333 10.78 7.77333 10.78 7.58 10.5867C7.38667 10.3934 7.38667 10.0734 7.58 9.88004L8.96 8.50004H6V11.2C6 13.3334 7.33333 14.6667 9.46667 14.6667H11.1933C13.3267 14.6667 14.66 13.3334 14.66 11.2V4.80004C14.6667 2.66671 13.3333 1.33337 11.2 1.33337Z"
                                            fill="#e86121" />
                                        <path
                                            d="M1.83325 7.5C1.55992 7.5 1.33325 7.72667 1.33325 8C1.33325 8.27333 1.55992 8.5 1.83325 8.5H5.99992V7.5H1.83325Z"
                                            fill="#e86121" />
                                    </svg>
                                    <span> {{ __('topbar.sign_in') }} </span>
                                </a>
                                <a href="{{ route('register') }}">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.6467 1.55329C14.1667 1.00663 13.4533 0.666626 12.6667 0.666626C11.92 0.666626 11.24 0.973293 10.7533 1.47329C10.4733 1.75996 10.26 2.10663 10.1333 2.49329C10.0467 2.75996 10 3.03996 10 3.33329C10 3.83329 10.14 4.30663 10.3867 4.70663C10.52 4.93329 10.6933 5.13996 10.8933 5.31329C11.36 5.73996 11.98 5.99996 12.6667 5.99996C12.96 5.99996 13.24 5.95329 13.5 5.85996C14.1133 5.66663 14.6267 5.24663 14.9467 4.70663C15.0867 4.47996 15.1933 4.21996 15.2533 3.95329C15.3067 3.75329 15.3333 3.54663 15.3333 3.33329C15.3333 2.65329 15.0733 2.02663 14.6467 1.55329ZM13.66 3.81996H13.1667V4.33996C13.1667 4.61329 12.94 4.83996 12.6667 4.83996C12.3933 4.83996 12.1667 4.61329 12.1667 4.33996V3.81996H11.6733C11.4 3.81996 11.1733 3.59329 11.1733 3.31996C11.1733 3.04663 11.4 2.81996 11.6733 2.81996H12.1667V2.34663C12.1667 2.07329 12.3933 1.84663 12.6667 1.84663C12.94 1.84663 13.1667 2.07329 13.1667 2.34663V2.81996H13.66C13.9333 2.81996 14.16 3.04663 14.16 3.31996C14.16 3.59329 13.94 3.81996 13.66 3.81996Z"
                                            fill="#e86121" />
                                        <path
                                            d="M14.6666 8.00004C14.6666 7.12671 14.4999 6.28671 14.1866 5.52004C13.9799 5.66671 13.7466 5.78004 13.4999 5.86004C13.4266 5.88671 13.3533 5.90671 13.2733 5.92671C13.5266 6.56671 13.6666 7.26671 13.6666 8.00004C13.6666 9.54671 13.0399 10.9534 12.0266 11.98C11.8333 11.7334 11.5866 11.5067 11.2933 11.3134C9.48658 10.1 6.52659 10.1 4.70658 11.3134C4.41325 11.5067 4.17325 11.7334 3.97325 11.98C2.95992 10.9534 2.33325 9.54671 2.33325 8.00004C2.33325 4.87337 4.87325 2.33337 7.99992 2.33337C8.72658 2.33337 9.42659 2.47337 10.0666 2.72671C10.0866 2.64671 10.1066 2.57337 10.1333 2.49337C10.2133 2.24671 10.3266 2.02004 10.4799 1.81337C9.71325 1.50004 8.87325 1.33337 7.99992 1.33337C4.32659 1.33337 1.33325 4.32671 1.33325 8.00004C1.33325 9.93337 2.16659 11.6734 3.48659 12.8934C3.48659 12.9 3.48658 12.9 3.47992 12.9067C3.54659 12.9734 3.62659 13.0267 3.69325 13.0867C3.73325 13.12 3.76659 13.1534 3.80659 13.18C3.92659 13.28 4.05992 13.3734 4.18659 13.4667C4.23325 13.5 4.27325 13.5267 4.31992 13.56C4.44659 13.6467 4.57992 13.7267 4.71992 13.8C4.76659 13.8267 4.81992 13.86 4.86659 13.8867C4.99992 13.96 5.13992 14.0267 5.28658 14.0867C5.33992 14.1134 5.39325 14.14 5.44659 14.16C5.59325 14.22 5.73992 14.2734 5.88658 14.32C5.93992 14.34 5.99325 14.36 6.04658 14.3734C6.20658 14.42 6.36658 14.46 6.52659 14.5C6.57325 14.5134 6.61992 14.5267 6.67325 14.5334C6.85992 14.5734 7.04658 14.6 7.23992 14.62C7.26658 14.62 7.29325 14.6267 7.31992 14.6334C7.54658 14.6534 7.77325 14.6667 7.99992 14.6667C8.22658 14.6667 8.45325 14.6534 8.67325 14.6334C8.69992 14.6334 8.72658 14.6267 8.75325 14.62C8.94658 14.6 9.13325 14.5734 9.31992 14.5334C9.36658 14.5267 9.41325 14.5067 9.46658 14.5C9.62659 14.46 9.79325 14.4267 9.94658 14.3734C9.99992 14.3534 10.0533 14.3334 10.1066 14.32C10.2533 14.2667 10.4066 14.22 10.5466 14.16C10.5999 14.14 10.6533 14.1134 10.7066 14.0867C10.8466 14.0267 10.9866 13.96 11.1266 13.8867C11.1799 13.86 11.2266 13.8267 11.2733 13.8C11.4066 13.72 11.5399 13.6467 11.6733 13.56C11.7199 13.5334 11.7599 13.5 11.8066 13.4667C11.9399 13.3734 12.0666 13.28 12.1866 13.18C12.2266 13.1467 12.2599 13.1134 12.2999 13.0867C12.3733 13.0267 12.4466 12.9667 12.5133 12.9067C12.5133 12.9 12.5133 12.9 12.5066 12.8934C13.8333 11.6734 14.6666 9.93337 14.6666 8.00004Z"
                                            fill="#e86121" />
                                        <path
                                            d="M8 4.62C6.62 4.62 5.5 5.74 5.5 7.12C5.5 8.47333 6.56 9.57333 7.96667 9.61333C7.98667 9.61333 8.01333 9.61333 8.02667 9.61333C8.04 9.61333 8.06 9.61333 8.07333 9.61333C8.08 9.61333 8.08667 9.61333 8.08667 9.61333C9.43333 9.56666 10.4933 8.47333 10.5 7.12C10.5 5.74 9.38 4.62 8 4.62Z"
                                            fill="#e86121" />
                                    </svg>
                                    <span> {{ __('topbar.register') }}</span>
                                </a>
                            </nav>
                        </div>
                        <!--~~~~~~~ BEFORE SIGNIN/SIGNUP CODE END ~~~~~~~~-->
                    @else
                        <!--~~~~~~~~~~~ AFTER SIGNIN/SIGNUP CODE START ~~~~~~-->
                        <div class="header-account">
                            <button type="button" class="header-account-btn">
                                <img src="{{ auth()->user()->image }}" alt="">
                                <span>{{ __('topbar.hi') }}, {{ Str::of(auth()->user()->name)->limit(10, '..') }}
                                </span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <nav class="header-account-navs">
                                <a href="{{ route('account.profile') }}"><i
                                        class="lni lni-cog"></i><span>{{ __('topbar.account') }}</span></a>
                                <a href="{{ route('account.order') }}"><i
                                        class="lni lni-cart-full"></i><span>{{ __('topbar.my_orders') }}</span></a>
                                <a href="{{ route('account.reservations') }}"><i
                                        class="lni lni-coffee-cup"></i><span>{{ __('topbar.reservations') }}</span></a>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="lni lni-lock-alt"></i><span>{{ __('topbar.logout') }}</span>
                                </a>
                                <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                </form>
                            </nav>
                        </div>
                        <?php
                                    $myrole  = auth()->user()->myrole ?? 0;
                                    $permissionBackend = [2];
                                    if (!in_array($myrole, $permissionBackend)) {
                                        if ($myrole == 3 && !auth()->user()->restaurant){   ?>
                        <a href="{{ route('admin.restaurants.index') }}" class="header-btn">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.3334 7.26671V2.73337C14.3334 1.73337 13.9067 1.33337 12.8467 1.33337H10.1534C9.09341 1.33337 8.66675 1.73337 8.66675 2.73337V7.26671C8.66675 8.26671 9.09341 8.66671 10.1534 8.66671H12.8467C13.9067 8.66671 14.3334 8.26671 14.3334 7.26671Z"
                                    fill="white" />
                                <path
                                    d="M7.33341 8.73337V13.2667C7.33341 14.2667 6.90675 14.6667 5.84675 14.6667H3.15341C2.09341 14.6667 1.66675 14.2667 1.66675 13.2667V8.73337C1.66675 7.73337 2.09341 7.33337 3.15341 7.33337H5.84675C6.90675 7.33337 7.33341 7.73337 7.33341 8.73337Z"
                                    fill="white" />
                                <path
                                    d="M14.3334 13.2667V11.4C14.3334 10.4 13.9067 10 12.8467 10H10.1534C9.09341 10 8.66675 10.4 8.66675 11.4V13.2667C8.66675 14.2667 9.09341 14.6667 10.1534 14.6667H12.8467C13.9067 14.6667 14.3334 14.2667 14.3334 13.2667Z"
                                    fill="white" />
                                <path
                                    d="M7.33341 4.60004V2.73337C7.33341 1.73337 6.90675 1.33337 5.84675 1.33337H3.15341C2.09341 1.33337 1.66675 1.73337 1.66675 2.73337V4.60004C1.66675 5.60004 2.09341 6.00004 3.15341 6.00004H5.84675C6.90675 6.00004 7.33341 5.60004 7.33341 4.60004Z"
                                    fill="white" />
                            </svg>
                            <span>{{ __('topbar.dashboard') }}</span>
                        </a>
                        <?php }else{?>
                        <a href="{{ route('admin.dashboard.index') }}" class="header-btn">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.3334 7.26671V2.73337C14.3334 1.73337 13.9067 1.33337 12.8467 1.33337H10.1534C9.09341 1.33337 8.66675 1.73337 8.66675 2.73337V7.26671C8.66675 8.26671 9.09341 8.66671 10.1534 8.66671H12.8467C13.9067 8.66671 14.3334 8.26671 14.3334 7.26671Z"
                                    fill="white" />
                                <path
                                    d="M7.33341 8.73337V13.2667C7.33341 14.2667 6.90675 14.6667 5.84675 14.6667H3.15341C2.09341 14.6667 1.66675 14.2667 1.66675 13.2667V8.73337C1.66675 7.73337 2.09341 7.33337 3.15341 7.33337H5.84675C6.90675 7.33337 7.33341 7.73337 7.33341 8.73337Z"
                                    fill="white" />
                                <path
                                    d="M14.3334 13.2667V11.4C14.3334 10.4 13.9067 10 12.8467 10H10.1534C9.09341 10 8.66675 10.4 8.66675 11.4V13.2667C8.66675 14.2667 9.09341 14.6667 10.1534 14.6667H12.8467C13.9067 14.6667 14.3334 14.2667 14.3334 13.2667Z"
                                    fill="white" />
                                <path
                                    d="M7.33341 4.60004V2.73337C7.33341 1.73337 6.90675 1.33337 5.84675 1.33337H3.15341C2.09341 1.33337 1.66675 1.73337 1.66675 2.73337V4.60004C1.66675 5.60004 2.09341 6.00004 3.15341 6.00004H5.84675C6.90675 6.00004 7.33341 5.60004 7.33341 4.60004Z"
                                    fill="white" />
                            </svg>
                            <span>{{ __('topbar.dashboard') }}</span>
                        </a>
                        <?php   } ?>
                        <?php } ?>
                        <!--~~~~~  AFTER SIGNIN/SIGNUP CODE END ~~~-->
                    @endif

</div>
                </div>
            </div>
        </div>
    </div>
</header>
<style>

    @media (min-width: 867px) {
        .mobile-screen{
            display: none;
        }
    }
</style>
<form class="mobile-screen" style="margin-top:3vh" method="GET" action="{{ route('search') }}">
                        <div   class="main-search-input">
                            <input type="hidden" id="lat" name="lat" required="" value="">
                            <input type="hidden" id="long" name="long" required="" value="">
                            <input type="hidden" id="expedition" name="expedition" value="{{ __('all') }}">

                            <div style="height: 45px;" class="banner-search main-search-input-item location">
                                <div id="autocomplete-container" class="me-auto ms-2 w-100">
                                    <input id="autocomplete-input" type="text" placeholder="{{ __('frontend.search') }}">
                                </div>
                                <!-- Disable location icon -->
                                <a href="javascript:void(0)">
                                    <span id="locationIcon" onclick="getLocation()">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 19.5C16.1421 19.5 19.5 16.1421 19.5 12C19.5 7.85786 16.1421 4.5 12 4.5C7.85786 4.5 4.5 7.85786 4.5 12C4.5 16.1421 7.85786 19.5 12 19.5Z"
                                                stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12 4V2" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M4 12H2" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12 20V22" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M20 12H22" stroke="#e86121" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                                <!-- <button type="submit" style="font-size: 15px;">{{ __('frontend.search') }}</button> -->
                                <button type="submit" style="font-size: 15px; height: 30px; width: 30px; display: flex; align-items: center; justify-content: center; padding: 0; border: none; ">
                        <img src="https://cdn-icons-png.flaticon.com/128/10934/10934545.png" alt="" style="height: 60%; width: 60%;">
                    </button>

                                
                            </div>
                        </div>
            </form>
<!--===== HEADER PART END ========-->
