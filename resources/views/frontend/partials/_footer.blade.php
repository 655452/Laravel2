<!--======== FOOTER PART START ========-->
<footer class="footer">
    <div class="container">
        <div class="row" style="align-items: center;">
            <div class="col-12 col-sm-4 col-lg-4">
                <div class="footer-about">
                    <a href="{{ url('/') }}" class="footer-logo"><img
                            src="{{ asset('images/' . setting('site_logo')) }}" alt="logo"></a>
                    <p> {{ __('Follow Us on ') }} </p>
                    <nav>
                        @if (setting('facebook'))
                            <a href="{{ url(setting('facebook')) }}" class="fa-brands fa-facebook-f"></a>
                        @endif
                        @if (setting('instagram'))
                            <a href="{{ url(setting('instagram')) }}" class="fa-brands fa-instagram"></a>
                        @endif
                        <!-- @if (setting('twitter'))
                            <a href="{{ url(setting('twitter')) }}" class="fa-brands fa-twitter"></a>
                        @endif
                        @if (setting('youtube'))
                            <a href="{{ url(setting('youtube')) }}" class="fa-brands fa-youtube"></a>
                        @endif -->
                    </nav>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-lg-4">
                <div class="footer-widget">
                    <!-- <h5 class="footer-title">{{ __('footer.about') }}</h5> -->
                    <nav>
                    
                        <!-- @if (!blank($footermenus))
                            @foreach ($footermenus as $footer_menu)
                                @if ($footer_menu->footer_menu_section_id == \App\Enums\FooterMenuSection::ABOUT)
                                    <a href="{{ route('page', $footer_menu) }}"> {{ $footer_menu->title }} </a>
                                @endif
                            @endforeach
                        @endif -->

                        <!--   only for  privacy  policy -->
                        <a target="_blank" href="http://woich.in/about">  <strong>About Us</strong></a>
                        <a target="_blank" href="http://woich.in/page/contact-us">Contact Us</a>
                        <a target="_blank" href="http://woich.in">Woich.in</a>
                       
                        
                        

                        
                        <!-- <a href="http://woich.in/page/privacy">Privacy Policy</a> -->
                        <!-- <a href="http://woich.in/about">About Us</a> -->
                        <!-- @if (!blank($footermenus))
                            @foreach ($footermenus as $footer_menu)
                                @if ($footer_menu->footer_menu_section_id == \App\Enums\FooterMenuSection::SERVICES)
                                    <a href="{{ route('page', $footer_menu) }}">{{ $footer_menu->title }}</a>
                                @endif
                            @endforeach
                        @endif -->
                    </nav>
                </div>
                
            </div>
            <div class="col-12 col-sm-4 col-lg-4">
                <div class="footer-widget">
                    <!-- <h5 class="footer-title">{{ __('footer.about') }}</h5> -->
                    <nav>
                    <a target="_blank" href="http://woich.in/page/terms-and-condition"> <strong>Terms And Conditions</strong></a>
                    <a target="_blank"  href="http://woich.in/page/privacy">Privacy Policy</a>
                    <a target="_blank" href="#"> Who are we </a>

                    
                        
                        
                    </nav>
                </div>
                
            </div>
            <!-- commenting services -->
            <!-- <div class="col-12 col-sm-4 col-lg-3">
                <div class="footer-widget">
                    <h5 class="footer-title"> {{ __('footer.services') }} </h5>
                    <nav>
                        @if (!blank($footermenus))
                            @foreach ($footermenus as $footer_menu)
                                @if ($footer_menu->footer_menu_section_id == \App\Enums\FooterMenuSection::SERVICES)
                                    <a href="{{ route('page', $footer_menu) }}">{{ $footer_menu->title }}</a>
                                @endif
                            @endforeach
                        @endif
                    </nav>
                </div>
            </div> -->
            <!-- commenting Downloads App section -->
            <!-- <div class="col-12 col-lg-4">
                <div class="footer-contact">
                    <h5 class="footer-title"> {{ __('Download Apps') }} </h5>
                    <nav>
                        @if (setting('android_app_link') || setting('ios_app_link'))
                            @if (setting('android_app_link'))
                                <a href="{{ setting('android_app_link') }}" target="_blank" class="d-block mb-2">
                                    <img src="{{ asset('frontend/images/play.png') }}" alt="">
                                </a>
                            @endif
                            @if (setting('ios_app_link'))
                                <a href="{{ setting('ios_app_link') }}" target="_blank" class="d-block mb-2">
                                    <img src="{{ asset('frontend/images/app.png') }}" alt="">
                                </a>
                            @endif
                        @endif
                    </nav>
                    <ul>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1.33325 5.66683C1.33325 3.3335 2.66659 2.3335 4.66659 2.3335H11.3333C13.3333 2.3335 14.6666 3.3335 14.6666 5.66683V10.3335C14.6666 12.6668 13.3333 13.6668 11.3333 13.6668H4.66659"
                                    stroke="#1F1F39" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M11.3334 6L9.24674 7.66667C8.56008 8.21333 7.43341 8.21333 6.74674 7.66667L4.66675 6"
                                    stroke="#1F1F39" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M1.33325 11H5.33325" stroke="#1F1F39" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1.33325 8.3335H3.33325" stroke="#1F1F39" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span> {{ setting('site_email') }} </span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13 6.25C13 4.92392 12.4732 3.65215 11.5355 2.71447C10.5979 1.77678 9.32608 1.25 8 1.25C6.69021 1.24976 5.43263 1.76349 4.49763 2.68072C3.56264 3.59795 3.02489 4.84545 3 6.155C2.60218 6.155 2.22064 6.31304 1.93934 6.59434C1.65804 6.87564 1.5 7.25718 1.5 7.655V9.655C1.5 10.0528 1.65804 10.4344 1.93934 10.7157C2.22064 10.997 2.60218 11.155 3 11.155H4C4.39782 11.155 4.77936 10.997 5.06066 10.7157C5.34196 10.4344 5.5 10.0528 5.5 9.655V7.655C5.5 7.25718 5.34196 6.87564 5.06066 6.59434C4.77936 6.31304 4.39782 6.155 4 6.155C4.02481 5.11069 4.45716 4.11751 5.20464 3.38779C5.95211 2.65807 6.95539 2.24971 8 2.25C9.06087 2.25 10.0783 2.67143 10.8284 3.42157C11.5786 4.17172 12 5.18913 12 6.25C11.6022 6.25 11.2206 6.40804 10.9393 6.68934C10.658 6.97064 10.5 7.35218 10.5 7.75V9.75C10.5013 10.0806 10.6119 10.4015 10.8144 10.6628C11.017 10.9242 11.3002 11.1112 11.62 11.195C11.242 11.8817 10.6103 12.3932 9.86 12.62C9.73986 12.3604 9.54799 12.1406 9.30703 11.9864C9.06607 11.8323 8.78605 11.7502 8.5 11.75H7.5C7.10218 11.75 6.72064 11.908 6.43934 12.1893C6.15804 12.4706 6 12.8522 6 13.25C6 13.6478 6.15804 14.0294 6.43934 14.3107C6.72064 14.592 7.10218 14.75 7.5 14.75H8.5C8.83128 14.7484 9.1527 14.6371 9.4141 14.4336C9.67551 14.2301 9.86218 13.9458 9.945 13.625C10.5592 13.475 11.1292 13.1816 11.6081 12.7688C12.087 12.3559 12.4612 11.8354 12.7 11.25H13C13.3978 11.25 13.7794 11.092 14.0607 10.8107C14.342 10.5294 14.5 10.1478 14.5 9.75V7.75C14.5 7.35218 14.342 6.97064 14.0607 6.68934C13.7794 6.40804 13.3978 6.25 13 6.25ZM4.5 7.655V9.655C4.5 9.78761 4.44732 9.91479 4.35355 10.0086C4.25979 10.1023 4.13261 10.155 4 10.155H3C2.86739 10.155 2.74021 10.1023 2.64645 10.0086C2.55268 9.91479 2.5 9.78761 2.5 9.655V7.655C2.5 7.52239 2.55268 7.39521 2.64645 7.30145C2.74021 7.20768 2.86739 7.155 3 7.155H4C4.13261 7.155 4.25979 7.20768 4.35355 7.30145C4.44732 7.39521 4.5 7.52239 4.5 7.655ZM8.5 13.75H7.5C7.36739 13.75 7.24021 13.6973 7.14645 13.6036C7.05268 13.5098 7 13.3826 7 13.25C7 13.1174 7.05268 12.9902 7.14645 12.8964C7.24021 12.8027 7.36739 12.75 7.5 12.75H8.5C8.63261 12.75 8.75979 12.8027 8.85355 12.8964C8.94732 12.9902 9 13.1174 9 13.25C9 13.3826 8.94732 13.5098 8.85355 13.6036C8.75979 13.6973 8.63261 13.75 8.5 13.75ZM13.5 9.75C13.5 9.88261 13.4473 10.0098 13.3536 10.1036C13.2598 10.1973 13.1326 10.25 13 10.25H12C11.8674 10.25 11.7402 10.1973 11.6464 10.1036C11.5527 10.0098 11.5 9.88261 11.5 9.75V7.75C11.5 7.61739 11.5527 7.49021 11.6464 7.39645C11.7402 7.30268 11.8674 7.25 12 7.25H13C13.1326 7.25 13.2598 7.30268 13.3536 7.39645C13.4473 7.49021 13.5 7.61739 13.5 7.75V9.75Z"
                                    fill="#1F1F39" />
                            </svg>
                            <span> {{ setting('site_phone_number') }} </span>
                        </li>
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
    <div class="footer-bottom">
        <p>{{ setting('site_footer') }}</p>
    </div>
</footer>
<!--======= FOOTER PART END =========-->
 