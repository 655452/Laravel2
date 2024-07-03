@extends('frontend.layouts.app')
@push('meta')
    <meta property="og:url" content="{{ route('home') }}" />
    <meta property="og:type" content="FoodBank" />
    <meta property="og:title" content="{{ setting('banner_title') }}">
    <meta property="og:description" content="Explore top-rated attractions, activities and more">
    <meta property="og:image" content="{{ asset('images/' . setting('site_logo')) }}">
@endpush

@section('main-content')

    <!--======== BANNER PART START ==========-->
    <!-- old banner part -->
    <!-- <section class="banner section-gap-90">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-7 col-lg-6">

                    <h1 class="banner-title"> {{ Str::limit(setting('banner_title'), 75) }} </h1>

                    <p class="banner-subtitle"> {{ __('frontend.subtitle') }} </p>
                    <form method="GET" action="{{ route('search') }}">
                        <div class="main-search-input">
                            <input type="hidden" id="lat" name="lat" required="" value="">
                            <input type="hidden" id="long" name="long" required="" value="">
                            <input type="hidden" id="expedition" name="expedition" value="{{ __('all') }}">

                            <div class="banner-search main-search-input-item location">
                                <div id="autocomplete-container" class="me-auto ms-2 w-100">
                                    <input id="autocomplete-input" type="text" placeholder="{{ __('frontend.search') }}">
                                </div>
                                <a href="javascript:void(0)">
                                    <span id="locationIcon" onclick="getLocation()">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 19.5C16.1421 19.5 19.5 16.1421 19.5 12C19.5 7.85786 16.1421 4.5 12 4.5C7.85786 4.5 4.5 7.85786 4.5 12C4.5 16.1421 7.85786 19.5 12 19.5Z"
                                                stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12 4V2" stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M4 12H2" stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12 20V22" stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M20 12H22" stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                                <button type="submit">{{ __('frontend.search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-5 col-lg-6">
                    <div class="banner-image">
                        <img src="{{ asset('images/' . setting('banner_image')) }}"
                            alt="hero">


                    </div>
                </div>
            </div>
        </div>
    </section> -->



<!-- new banner section -->




<section class=" section-gap-90" style=" background-color: #f0f0f0;  margin:0px;padding:0px;">

<section class="carousel">
<div class="carousel-inner">
        <div class="cara">
            <img src="https://media.istockphoto.com/id/506903162/photo/luxurious-villa-with-pool.jpg?s=612x612&w=0&k=20&c=Ek2P0DQ9nHQero4m9mdDyCVMVq3TLnXigxNPcZbgX2E=" alt="Image 1">
        </div>
        <div class="cara cara2">
            <img src="https://images.pexels.com/photos/258154/pexels-photo-258154.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 2 Upper">
            <img src="https://images.pexels.com/photos/261101/pexels-photo-261101.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 2 Lower">
        </div>
        <div class="cara">
            <img src="https://images.pexels.com/photos/297984/pexels-photo-297984.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 1">
        </div>
        <div class="cara cara2">
            <img src="https://images.unsplash.com/photo-1583121274602-3e2820c69888?fm=jpg&w=3000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8ZmVycmFyaSUyMGNhcnxlbnwwfHwwfHx8MA%3D%3D" alt="Image 2 Upper">
            <img src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg?cs=srgb&dl=pexels-mikebirdy-170811.jpg&fm=jpg" alt="Image 2 Lower">
        </div>
        <div class="cara">
            <img src="https://images.pexels.com/photos/1320686/pexels-photo-1320686.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 1">
        </div>
        <div class="cara cara2">
            <img src="https://images.pexels.com/photos/1134175/pexels-photo-1134175.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 2 Upper">
            <img src="https://images.pexels.com/photos/32870/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=600" alt="Image 2 Lower">
        </div>
        <div class="cara">
            <img src="https://images.pexels.com/photos/5997993/pexels-photo-5997993.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 1">
        </div>
        <div class="cara cara2">
            <img src="https://images.pexels.com/photos/5997994/pexels-photo-5997994.jpeg?auto=compress&cs=tinysrgb&w=600">
            <img src="https://images.pexels.com/photos/259580/pexels-photo-259580.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 2 Lower">
        </div>
        <div class="cara">
            <img src="https://images.pexels.com/photos/14464638/pexels-photo-14464638.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 1">
        </div>

        <div class="cara cara2">
            <img src="https://images.pexels.com/photos/12835315/pexels-photo-12835315.jpeg?auto=compress&cs=tinysrgb&w=600">
            <img src="https://images.pexels.com/photos/17630869/pexels-photo-17630869/free-photo-of-timex-expedition-on-hand-of-groom.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 2 Lower">
        </div>
        <div class="cara">
            <img src="https://images.pexels.com/photos/1438832/pexels-photo-1438832.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Image 1">
        </div>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const carouselInner = document.querySelector(".carousel-inner");
        const carouselItems = carouselInner.querySelectorAll(".cara");
        const totalItems = carouselItems.length-6;
        const itemWidth = carouselItems[0].clientWidth;
        let currentIndex = 0;

        function slideNext() {
            currentIndex = (currentIndex + 1) % totalItems;
            carouselInner.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        }

        setInterval(slideNext, 3000); // Change slide every 1 second
    });
</script>
</section>

<!-- section styling -->

    <!--======== BANNER PART END ========-->


    <!--========  FEATURE PART START ========-->
    <section class="feature">
        <div class="container">
            <span class="section-subtitle" style="margin-top: 2vh;"> {{ __('How to Order') }} </span>
            <h2 class="section-title"> {{ __('It’s as easy as this ') }} </h2>

            <div class="swiper feature-swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <!-- <svg width="70" height="70" viewBox="0 0 70 70" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M35 65.625C35.4934 65.6221 35.9714 65.4525 36.3563 65.1438C37.1875 64.4 59.0625 46.7687 59.0625 28.4375C59.0625 22.0557 56.5274 15.9353 52.0148 11.4227C47.5022 6.91015 41.3818 4.375 35 4.375C28.6182 4.375 22.4978 6.91015 17.9852 11.4227C13.4726 15.9353 10.9375 22.0557 10.9375 28.4375C10.9375 46.7687 32.8125 64.4 33.6438 65.1438C34.0286 65.4525 34.5066 65.6221 35 65.625ZM15.3125 28.4375C15.3125 23.2161 17.3867 18.2085 21.0788 14.5163C24.771 10.8242 29.7786 8.75 35 8.75C40.2214 8.75 45.229 10.8242 48.9212 14.5163C52.6133 18.2085 54.6875 23.2161 54.6875 28.4375C54.6875 42.2188 39.6594 56.4594 35 60.5719C30.3406 56.4594 15.3125 42.2188 15.3125 28.4375Z"
                                fill="#EE1D48" />
                            <path
                                d="M45.9375 28.4375C45.9375 26.2743 45.296 24.1596 44.0942 22.361C42.8924 20.5623 41.1842 19.1604 39.1856 18.3326C37.187 17.5047 34.9879 17.2881 32.8662 17.7102C30.7445 18.1322 28.7957 19.1739 27.266 20.7035C25.7364 22.2332 24.6947 24.182 24.2727 26.3037C23.8506 28.4254 24.0672 30.6245 24.8951 32.6231C25.7229 34.6217 27.1248 36.3299 28.9235 37.5317C30.7221 38.7335 32.8368 39.375 35 39.375C37.9008 39.375 40.6828 38.2227 42.734 36.1715C44.7852 34.1203 45.9375 31.3383 45.9375 28.4375ZM28.4375 28.4375C28.4375 27.1396 28.8224 25.8708 29.5435 24.7916C30.2646 23.7124 31.2895 22.8712 32.4886 22.3745C33.6878 21.8778 35.0073 21.7479 36.2803 22.0011C37.5533 22.2543 38.7226 22.8793 39.6404 23.7971C40.5582 24.7149 41.1832 25.8842 41.4364 27.1572C41.6896 28.4302 41.5597 29.7497 41.063 30.9489C40.5663 32.148 39.7251 33.1729 38.6459 33.894C37.5667 34.6151 36.2979 35 35 35C33.2595 35 31.5903 34.3086 30.3596 33.0779C29.1289 31.8472 28.4375 30.178 28.4375 28.4375Z"
                                fill="#EE1D48" />
                        </svg> -->



                        <center>
                        <img style="width: 20%;" src="https://cdn-icons-png.flaticon.com/128/11552/11552033.png" alt="Image">
                        </center>
                        <!-- <h3> {{ __('Browse unique products') }} </h3> -->
                         <h3>Discover products</h3>
                         <p> They are pure, unique & handcrafted </p>
                        <!-- <p> {{ __('Fill out your address & search ') }} </p> -->
                    </div>
                    <div class="swiper-slide">
                        <!-- <svg width="70" height="70" viewBox="0 0 70 70" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M63.4375 61.2501H31.4781C27.799 61.2446 24.2699 59.7911 21.6541 57.204C19.0383 54.6168 17.546 51.1039 17.5 47.4251H43.75C44.3302 47.4251 44.8866 47.1946 45.2968 46.7844C45.707 46.3741 45.9375 45.8177 45.9375 45.2376C45.9375 44.6574 45.707 44.101 45.2968 43.6908C44.8866 43.2805 44.3302 43.0501 43.75 43.0501H17.5V41.5626C17.5 40.9824 17.7305 40.426 18.1407 40.0158C18.5509 39.6055 19.1073 39.3751 19.6875 39.3751H50.3125C50.8927 39.3751 51.4491 39.6055 51.8593 40.0158C52.2695 40.426 52.5 40.9824 52.5 41.5626V47.2719C52.5176 49.9669 51.7581 52.6099 50.3125 54.8844C49.998 55.3694 49.8882 55.959 50.007 56.5247C50.1259 57.0903 50.4638 57.5859 50.9469 57.9032C51.1878 58.0624 51.4579 58.1722 51.7415 58.2265C52.0251 58.2808 52.3167 58.2783 52.5993 58.2194C52.882 58.1604 53.1502 58.046 53.3884 57.8829C53.6267 57.7197 53.8303 57.511 53.9875 57.2688C55.8931 54.2844 56.8958 50.8129 56.875 47.2719V41.5626C56.8678 40.0978 56.3707 38.6775 55.4629 37.5279C54.5551 36.3783 53.2888 35.5655 51.8656 35.2188C51.5509 33.7877 50.8729 32.4618 49.8969 31.3688C48.9554 30.2987 47.7631 29.4788 46.427 28.9825C45.0908 28.4862 43.6524 28.329 42.2406 28.5251C41.2612 26.7877 39.7176 25.4371 37.8656 24.6969C36.8364 24.2821 35.7378 24.0668 34.6281 24.0626C33.09 24.0603 31.5784 24.4635 30.2458 25.2316C28.9132 25.9997 27.8066 27.1055 27.0375 28.4376C25.295 28.6668 23.6619 29.4154 22.351 30.5859C21.04 31.7564 20.1119 33.2946 19.6875 35.0001C17.947 35.0001 16.2778 35.6915 15.0471 36.9222C13.8164 38.1529 13.125 39.8221 13.125 41.5626V47.2719C13.125 52.1395 15.0586 56.8077 18.5005 60.2496C21.9424 63.6914 26.6106 65.6251 31.4781 65.6251H63.4375C64.0177 65.6251 64.5741 65.3946 64.9843 64.9844C65.3945 64.5741 65.625 64.0177 65.625 63.4376C65.625 62.8574 65.3945 62.301 64.9843 61.8908C64.5741 61.4805 64.0177 61.2501 63.4375 61.2501ZM28.1094 32.8126C28.6355 32.9195 29.1825 32.8293 29.6464 32.559C30.1103 32.2888 30.4586 31.8574 30.625 31.3469C30.824 30.7954 31.1317 30.2894 31.5301 29.8592C31.9284 29.4289 32.4092 29.0831 32.9439 28.8423C33.4785 28.6015 34.0561 28.4707 34.6423 28.4575C35.2285 28.4443 35.8114 28.5491 36.3563 28.7657C36.9816 29.009 37.54 29.3978 37.9851 29.9C38.4302 30.4021 38.7492 31.0031 38.9156 31.6532C38.9948 31.954 39.1372 32.2345 39.3333 32.4759C39.5295 32.7173 39.7749 32.9141 40.0531 33.0532C40.3381 33.1832 40.6477 33.2505 40.9609 33.2505C41.2742 33.2505 41.5838 33.1832 41.8687 33.0532C42.8425 32.6719 43.9207 32.652 44.9078 32.9971C45.895 33.3422 46.7259 34.0295 47.25 34.9344H24.2812C24.6768 34.2758 25.2389 33.7329 25.9109 33.3604C26.5829 32.9879 27.3412 32.799 28.1094 32.8126ZM15.75 61.2501H4.375C3.79484 61.2501 3.23844 61.4805 2.8282 61.8908C2.41797 62.301 2.1875 62.8574 2.1875 63.4376C2.1875 64.0177 2.41797 64.5741 2.8282 64.9844C3.23844 65.3946 3.79484 65.6251 4.375 65.6251H15.75C16.3302 65.6251 16.8866 65.3946 17.2968 64.9844C17.707 64.5741 17.9375 64.0177 17.9375 63.4376C17.9375 62.8574 17.707 62.301 17.2968 61.8908C16.8866 61.4805 16.3302 61.2501 15.75 61.2501ZM23.9094 15.1376C24.4736 16.0197 24.6917 17.0793 24.5219 18.1126C24.4948 18.4001 24.525 18.6901 24.6106 18.9658C24.6961 19.2416 24.8355 19.4977 25.0205 19.7194C25.2056 19.9411 25.4327 20.1239 25.6888 20.2573C25.9448 20.3908 26.2248 20.4722 26.5125 20.4969H26.7094C27.257 20.4992 27.7855 20.2959 28.1905 19.9274C28.5955 19.5588 28.8476 19.0517 28.8969 18.5063C29.1355 16.6384 28.7428 14.7442 27.7812 13.1251C27.4311 12.5176 27.1731 11.8615 27.0156 11.1782C26.9799 10.6225 27.0673 10.0658 27.2715 9.5478C27.4757 9.02978 27.7916 8.56319 28.1969 8.18132C28.4184 7.99436 28.6006 7.76522 28.7328 7.50724C28.865 7.24925 28.9446 6.96756 28.967 6.67854C28.9894 6.38951 28.9541 6.09892 28.8632 5.82365C28.7723 5.54838 28.6276 5.29393 28.4375 5.07507C28.243 4.86122 28.0079 4.68805 27.7461 4.56558C27.4842 4.44312 27.2006 4.37377 26.9117 4.36157C26.6229 4.34936 26.3345 4.39454 26.0632 4.49448C25.7919 4.59442 25.5431 4.74714 25.3312 4.94382C24.3703 5.83783 23.6412 6.95213 23.2067 8.19066C22.7723 9.42919 22.6456 10.7548 22.8375 12.0532C23.0443 13.1276 23.4053 14.1665 23.9094 15.1376ZM42.6344 15.1376C43.2062 16.0168 43.4322 17.0766 43.2688 18.1126C43.2139 18.6898 43.3905 19.2651 43.7596 19.7122C44.1288 20.1593 44.6604 20.4416 45.2375 20.4969H45.4563C46.0039 20.4992 46.5324 20.2959 46.9374 19.9274C47.3424 19.5588 47.5945 19.0517 47.6438 18.5063C47.8758 16.6359 47.4754 14.7416 46.5063 13.1251C46.1584 12.5266 45.9073 11.8769 45.7625 11.2001C45.7235 10.6408 45.8092 10.0799 46.0135 9.55782C46.2178 9.03575 46.5355 8.56559 46.9437 8.18132C47.1563 7.98598 47.3283 7.75068 47.45 7.48886C47.5716 7.22704 47.6405 6.94382 47.6527 6.65538C47.6649 6.36694 47.6201 6.07892 47.521 5.80777C47.4219 5.53662 47.2703 5.28765 47.075 5.07507C46.8797 4.8625 46.6444 4.69048 46.3825 4.56883C46.1207 4.44719 45.8375 4.37831 45.5491 4.36612C45.2606 4.35394 44.9726 4.39868 44.7015 4.4978C44.4303 4.59692 44.1813 4.74848 43.9688 4.94382C43.0157 5.84086 42.2978 6.95842 41.8782 8.19815C41.4586 9.43787 41.3502 10.7617 41.5625 12.0532C41.7702 13.1274 42.1312 14.1661 42.6344 15.1376ZM33.8625 16.9532C34.4367 17.8312 34.6557 18.8947 34.475 19.9282C34.448 20.2157 34.4781 20.5057 34.5637 20.7815C34.6493 21.0572 34.7886 21.3134 34.9737 21.535C35.1587 21.7567 35.3858 21.9395 35.6419 22.073C35.898 22.2064 36.1779 22.2879 36.4656 22.3126H36.6625C37.2101 22.3148 37.7386 22.1115 38.1437 21.743C38.5487 21.3744 38.8007 20.8673 38.85 20.3219C39.0936 18.4468 38.7008 16.5441 37.7344 14.9188C37.3879 14.3173 37.1301 13.669 36.9688 12.9938C36.9343 12.435 37.0222 11.8754 37.2262 11.3541C37.4302 10.8327 37.7455 10.3621 38.15 9.97507C38.5753 9.58283 38.8279 9.03805 38.8525 8.45999C38.8771 7.88192 38.6717 7.31766 38.2812 6.8907C38.0867 6.67685 37.8517 6.50368 37.5898 6.38121C37.3279 6.25874 37.0443 6.1894 36.7555 6.17719C36.4667 6.16499 36.1782 6.21016 35.907 6.3101C35.6357 6.41004 35.3869 6.56277 35.175 6.75945C34.214 7.65346 33.4849 8.76776 33.0505 10.0063C32.616 11.2448 32.4893 12.5704 32.6812 13.8688C32.9225 14.949 33.3205 15.9882 33.8625 16.9532Z"
                                fill="#EE1D48" />
                        </svg> -->
                        <center>

                        <img style="width: 20%;" src="https://cdn-icons-png.flaticon.com/128/2449/2449714.png" alt="Image2">
                        </center>
                        
                        <h3> {{ __('View Contact') }} </h3>
                        <p>Click view contact to see Woicher’s contact or click whatsapp icon to send a message to the woicher
                        </p>
                        <!-- <p> {{ __('To see Woicher’s contact or Message the Woicher') }}</p> -->
                    </div>
                    <div class="swiper-slide">
                        <!-- <svg width="70" height="70" viewBox="0 0 70 70" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M65.6249 50.3125H28.4374C27.2299 50.3125 26.2499 51.2925 26.2499 52.5C26.2499 53.7075 27.2299 54.6875 28.4374 54.6875H62.0855L60.5018 57.8528C60.1299 58.5988 59.3796 59.0625 58.5462 59.0625H11.4537C10.6202 59.0625 9.86992 58.5988 9.49804 57.8528L7.91429 54.6875H13.1249C14.3324 54.6875 15.3124 53.7075 15.3124 52.5C15.3124 51.2925 14.3324 50.3125 13.1249 50.3125H4.37492C3.61586 50.3125 2.91367 50.7063 2.51336 51.3494C2.11523 51.9947 2.07804 52.7997 2.41711 53.4778L5.58242 59.8106C6.70242 62.0484 8.95336 63.4375 11.4537 63.4375H58.5462C61.0465 63.4375 63.2952 62.0484 64.4152 59.8106L67.5805 53.4778C67.9196 52.7997 67.8824 51.9947 67.4843 51.3494C67.0862 50.7063 66.384 50.3125 65.6249 50.3125Z"
                                fill="#EE1D48" />
                            <path
                                d="M19.6875 50.3125C18.48 50.3125 17.5 51.2925 17.5 52.5C17.5 53.7075 18.48 54.6875 19.6875 54.6875H21.875C23.0825 54.6875 24.0625 53.7075 24.0625 52.5C24.0625 51.2925 23.0825 50.3125 21.875 50.3125H19.6875ZM4.375 48.125H65.625C66.8325 48.125 67.8125 47.145 67.8125 45.9375C67.8125 44.73 66.8325 43.75 65.625 43.75H65.5134C64.5269 29.8769 54.285 18.5303 40.9238 15.8988C41.3241 15.0544 41.5625 14.1203 41.5625 13.125C41.5625 9.50687 38.6181 6.5625 35 6.5625C31.3819 6.5625 28.4375 9.50687 28.4375 13.125C28.4375 14.1203 28.6759 15.0544 29.0741 15.8988C15.715 18.5303 5.47313 29.8769 4.48656 43.75H4.375C3.1675 43.75 2.1875 44.73 2.1875 45.9375C2.1875 47.145 3.1675 48.125 4.375 48.125ZM32.8125 13.125C32.8125 11.9197 33.7947 10.9375 35 10.9375C36.2053 10.9375 37.1875 11.9197 37.1875 13.125C37.1875 14.3303 36.2053 15.3125 35 15.3125C33.7947 15.3125 32.8125 14.3303 32.8125 13.125ZM35 19.6875C48.7353 19.6875 60.0206 30.2991 61.1384 43.75H8.86156C9.97938 30.2991 21.2647 19.6875 35 19.6875Z"
                                fill="#EE1D48" />
                        </svg> -->
                        <center>
                            <img style="width: 20%;" src="https://cdn-icons-png.flaticon.com/128/3014/3014736.png" alt="Image3">
                        </center>
                        <h3> {{ __('Call the Woicher  ') }} </h3>
                        <p>Call the woicher to place an order or wait for couple of working hours to get a call back</p>
                        <!-- <p> {{ __('To place your order or wait a couple of hours for a call back') }}</p> -->
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>
    <!--======== FEATURE PART END =======-->





    <!--========= Cusines PART START ========-->
    @if (!blank($bestSellingCuisines))
        <section class="category section-gap-66">
            <div class="container">
                <!-- <h2 class="section-title borderd">{{ __('frontend.popular_cuisines') }} </h2> -->
                <h2 class="section-title borderd">Popular Categories </h2>
                <div class="row">

                    @foreach ($bestSellingCuisines as $key => $bestSellingCusine)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('search', ['cuisines' => [$bestSellingCusine->slug], 'expedition' => 'all']) }}"
                                class="category-card">
                                <img class="bestSellingCusineImage" src="{{ $bestSellingCusine->image }}"
                                    alt="category">

                                <h4> {{ Str::of(strip_tags($bestSellingCusine->name))->limit(18) }}</h4>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif
    <!--========== Cusines PART END =========-->


    <!--=========  RESTAURANT PART START ========-->

    @if (!blank($bestSellingRestaurants))
    <style>
     @media (max-width: 767px) {
    .section-gap-66 {
        margin-bottom: 16px;
        margin-top: 12vh;
    }
}
   </style>
        <section class="restaurant section-gap-66"  >
            <div class="container">
                <!-- <h2 class="section-title borderd">{{ __('frontend.most_visited_restaurants') }}</h2> -->
                <h2 class="section-title borderd">Most Loved </h2>

                <div class="row">
                    @foreach ($bestSellingRestaurants as $restaurant)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <a href="{{ route('restaurant.show', [$restaurant]) }}" class="restaurant-card">
                                <figure class="figure position-relative">
                                    <img class="bestSellingRestaurantsImage" src="{{ $restaurant->image }}"
                                        alt="restaurant">
                                    @if (array_key_exists($restaurant->id, $vouchers))
                                        <span class="coupon-label"> {{ __('frontend.voucher') }}
                                            {{ $vouchers[$restaurant->id] }} </span>
                                    @endif
                                </figure>


                                <div class="content">
                                    <h4>{{ Str::of(strip_tags($restaurant->name))->limit(18) }}</h4>
                                    <div class="ratings">

                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $restaurant->avgRating($restaurant->id)['avgRating'])
                                                <svg class="active" width="14" height="14" viewBox="0 0 14 14"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.97191 1.37497C6.4383 0.599986 7.56186 0.599985 8.02825 1.37497L9.15178 3.24189C9.31933 3.5203 9.59263 3.71886 9.90919 3.79218L12.0319 4.28381C12.9131 4.48789 13.2603 5.55646 12.6674 6.23951L11.239 7.88495C11.026 8.13034 10.9216 8.45162 10.9497 8.77535L11.1381 10.9461C11.2163 11.8472 10.3073 12.5076 9.47449 12.1548L7.46819 11.3048C7.16899 11.1781 6.83117 11.1781 6.53197 11.3048L4.52568 12.1548C3.69283 12.5076 2.78386 11.8472 2.86206 10.9461L3.05045 8.77535C3.07855 8.45162 2.97416 8.13034 2.76115 7.88495L1.33279 6.23951C0.739863 5.55646 1.08706 4.48789 1.96824 4.28381L4.09097 3.79218C4.40753 3.71886 4.68083 3.5203 4.84838 3.24189L5.97191 1.37497Z"
                                                        stroke-width="1.5" />
                                                </svg>
                                            @else
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.97191 1.37497C6.4383 0.599986 7.56186 0.599985 8.02825 1.37497L9.15178 3.24189C9.31933 3.5203 9.59263 3.71886 9.90919 3.79218L12.0319 4.28381C12.9131 4.48789 13.2603 5.55646 12.6674 6.23951L11.239 7.88495C11.026 8.13034 10.9216 8.45162 10.9497 8.77535L11.1381 10.9461C11.2163 11.8472 10.3073 12.5076 9.47449 12.1548L7.46819 11.3048C7.16899 11.1781 6.83117 11.1781 6.53197 11.3048L4.52568 12.1548C3.69283 12.5076 2.78386 11.8472 2.86206 10.9461L3.05045 8.77535C3.07855 8.45162 2.97416 8.13034 2.76115 7.88495L1.33279 6.23951C0.739863 5.55646 1.08706 4.48789 1.96824 4.28381L4.09097 3.79218C4.40753 3.71886 4.68083 3.5203 4.84838 3.24189L5.97191 1.37497Z"
                                                        stroke-width="1.5" />
                                                </svg>
                                            @endif
                                        @endfor
                                        <span>({{ $restaurant->avgRating($restaurant->id)['countUser'] }}) </span>

                                    </div>
                                    <div class="location">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.99992 8.95346C9.14867 8.95346 10.0799 8.02221 10.0799 6.87346C10.0799 5.7247 9.14867 4.79346 7.99992 4.79346C6.85117 4.79346 5.91992 5.7247 5.91992 6.87346C5.91992 8.02221 6.85117 8.95346 7.99992 8.95346Z"
                                                stroke="#1F1F39" stroke-width="1.5" />
                                            <path
                                                d="M2.4133 5.66016C3.72664 -0.113169 12.28 -0.106502 13.5866 5.66683C14.3533 9.0535 12.2466 11.9202 10.4 13.6935C9.05997 14.9868 6.93997 14.9868 5.5933 13.6935C3.7533 11.9202 1.64664 9.04683 2.4133 5.66016Z"
                                                stroke="#1F1F39" stroke-width="1.5" />
                                        </svg>
                                        <span>{{ Str::of(strip_tags($restaurant->address)) }}</span>
                                    </div>

                                    @if ($restaurant->opening_time < $current_data && $restaurant->closing_time > $current_data)
                                        <!-- <p class="on"> {{ __('frontend.open_now') }} </p> -->
                                         <br>
                                        <!-- <p class="on"><br> </p> -->
                                    @else
                                        <p class="off">
                                            {{ __('frontend.close_now') }}
                                        </p>
                                    @endif

                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!--=========  RESTAURANT PART End ========-->

    <!--========  APP PART START ======-->
    @if (setting('android_app_link') || setting('ios_app_link'))
        <section class="app section-gap-90">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="app-content">
                            <h2>{{ __('Download the app') }} </h2>
                            <p> {{ __('Click, sit back, and enjoy.') }}</p>

                            <nav>
                                @if (setting('android_app_link'))
                                    <a href="{{ setting('android_app_link') }}" target="_blank">
                                        <img src="{{ asset('frontend/images/play.png') }}" alt="play">
                                    </a>
                                @endif
                                @if (setting('ios_app_link'))
                                    <a href="{{ setting('ios_app_link') }}" target="_blank">
                                        <img src="{{ asset('frontend/images/app.png') }}" alt="">
                                    </a>
                                @endif
                            </nav>

                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="app-image">
                            <img src="{{ asset('images/' . setting('app_mockup')) }}" alt="mockup">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--========== APP PART END =======-->

@endsection



@push('js')
    <script type="text/javascript" src="{{ asset('frontend/js/map-current.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ setting('google_map_api_key') }}&sensor=false&libraries=places&callback=initAutocomplete">
    </script>


<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>




<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const beep = document.getElementById("myAudio1");

        function sound() {
            beep.play();
        }
        // web_token
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "{{ setting('firebase_api_key') }}",
                 authDomain: "{{ setting('firebase_authDomain') }}",
                 projectId:"{{ setting('projectId') }}",
                storageBucket:"{{ setting('storageBucket') }}",
                 messagingSenderId: "{{ setting('messagingSenderId') }}",
                 appId: "{{ setting('appId') }}",
                 measurementId: "{{ setting('measurementId') }}",
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        startFCM();

        function startFCM() {
            messaging.requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(response) {
                    $.ajax({
                        url: '{{ route('store.token') }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            //console.log(response);
                        },
                        error: function(error) {
                            //console.log(error);
                        },
                    });

                }).catch(function(error) {});
        }
        messaging.onMessage(function(payload) {
            //console.log(payload);
            const title = payload.data.title;
            const body = payload.data.body;

            sound();
            $('#custom-width-modal').modal('show');
            $('#notificationTitle').text(title);
            $('#notificationBody').text(body);


            new Notification(title, {
                body: body,
            });
        });

    });
</script>


@endpush