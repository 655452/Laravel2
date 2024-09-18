@extends('frontend.layouts.restaurent_app')
@push('meta')
<meta property="og:url" content="{{ route('restaurant.show', [$restaurant->slug]) }}" />
<meta property="og:type" content="{{ setting('site_name') }}">
<meta property="og:title" content="{{ $restaurant->name }}">
<meta property="og:description" content="{{ $restaurant->description }}">
<!-- 4    <meta property="og:image" content="{{ $restaurant->image }}"> -->
@endpush

@push('body-data')
data-bs-spy="scroll" data-bs-target="#scrollspy-menu" data-bs-smooth-scroll="true"
@endpush

@section('main-content')

<!--====== RESTAURANT PART START =========-->
<style>
    .rest-media img {
        height: 45vh;
    }

    @media (max-width: 768px) {
        .rest-media img {
            height: 30vw;
        }
    }
</style>

<section class="restaurant">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 rest-col">
                <div class="rest-content">
                    <figure class="rest-media">









                        <a class="d-block" href="{{ route('restaurant.show', [$restaurant->slug]) }}">
                            <img class="res-img" src="{{ asset($restaurant->image) }}" alt="restaurant">
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

                            <button id="review-button" type="button" data-bs-toggle="modal" data-bs-target="#shop-modal">
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
                            </button>


                            <div class="rest-location">
                                <style>
                                    .description-res {
                                        width: 40vw;
                                    }

                                    @media (max-width: 768px) {
                                        .description-res {
                                            width: 80vw;
                                        }
                                    }
                                </style>
                                <span class="description-res">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.99992 8.95346C9.14867 8.95346 10.0799 8.02221 10.0799 6.87346C10.0799 5.7247 9.14867 4.79346 7.99992 4.79346C6.85117 4.79346 5.91992 5.7247 5.91992 6.87346C5.91992 8.02221 6.85117 8.95346 7.99992 8.95346Z"
                                            stroke="#1F1F39" stroke-width="1.5" />
                                        <path
                                            d="M2.4133 5.66016C3.72664 -0.113169 12.28 -0.106502 13.5866 5.66683C14.3533 9.0535 12.2466 11.9202 10.4 13.6935C9.05997 14.9868 6.93997 14.9868 5.5933 13.6935C3.7533 11.9202 1.64664 9.04683 2.4133 5.66016Z"
                                            stroke="#1F1F39" stroke-width="1.5" />
                                    </svg>
                                    {{ \Illuminate\Support\Str::limit($restaurant->address, 65) }}
                                    <br>
                                    <!-- Description Section -->

                                    <div>
                                        <span id="description"></span>
                                        <button id="more-btn" style="display: none; background: none; color:black; border: none; cursor: pointer;">...more</button>
                                    </div>
                            </div>


                            <!-- Popup for full description -->
                            <div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 5px; width: 80vw; z-index: 1000;">
                                <span id="full-description"></span>
                                <button id="close-popup" style="display: block; margin-top: 10px; background: none; border: none; color: blue; cursor: pointer;">Close</button>
                            </div>

                            <!-- Overlay for popup -->
                            <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
                            <!-- Handles -->
                            <div style="display: flex; align-items: center; margin-top: 5px;">
                                <a id="instagram-link" href="#" target="_blank" style="margin-left: 10px; background-color: #E1306C; border-radius: 5px; display: inline-block;">
                                    <img width="25" height="25" src="https://img.icons8.com/ios/50/ffffff/instagram-new--v1.png" alt="Instagram" class="social-button" />
                                </a>
                                <a id="facebook-link" href="#" target="_blank" style="margin-left: 10px; background-color: #3b5998; border-radius: 50%; display: inline-block;">
                                    <img width="25" height="25" src="https://img.icons8.com/ios/50/ffffff/facebook-new.png" alt="Facebook" class="social-button" />
                                </a>
                            </div>

                            <script>
                                // Sample description string from the backend
                                const descriptionString = "{{ $restaurant->description }}";

                                // Function to extract Instagram, Facebook, and Description
                                function extractInfo(str) {
                                    const instagramMatch = str.match(/instagram=([\w\.]+)/);
                                    const facebookMatch = str.match(/facebook=([\w\s]+) description/);
                                    const descriptionMatch = str.match(/description=([^]+)/);

                                    const instagram = instagramMatch ? instagramMatch[1] : '';
                                    const facebook = facebookMatch ? facebookMatch[1] : '';
                                    const description = descriptionMatch ? descriptionMatch[1].trim() : '';

                                    return {
                                        instagram,
                                        facebook,
                                        description
                                    };
                                }

                                // Extracted information
                                const info = extractInfo(descriptionString);
                                console.log(info);

                                // Display the extracted information on the frontend
                                const descriptionElement = document.getElementById('description');
                                const moreBtn = document.getElementById('more-btn');
                                const fullDescriptionElement = document.getElementById('full-description');
                                const popup = document.getElementById('popup');
                                const overlay = document.getElementById('overlay');
                                const closePopupBtn = document.getElementById('close-popup');

                                // Set the full description in the popup
                                fullDescriptionElement.textContent = info.description;

                                // Display the first 10 words of the description
                                const words = info.description.split(' ');
                                const first10Words = words.slice(0, 25).join(' ');
                                descriptionElement.innerHTML = first10Words;

                                // Show the "More" button if the description has more than 10 words
                                if (words.length > 10) {
                                    moreBtn.style.display = 'inline';
                                }

                                // "More" button click event
                                moreBtn.addEventListener('click', function() {
                                    popup.style.display = 'block';
                                    overlay.style.display = 'block';
                                });

                                // Close popup button click event
                                closePopupBtn.addEventListener('click', function() {
                                    popup.style.display = 'none';
                                    overlay.style.display = 'none';
                                });

                                // Close popup when clicking outside of it
                                overlay.addEventListener('click', function() {
                                    popup.style.display = 'none';
                                    overlay.style.display = 'none';
                                });

                                // Set social media links
                            if (info.instagram && info.instagram.trim() !== "") {
                                document.getElementById('instagram-link').href = `https://www.instagram.com/${info.instagram}`;
                            } else {
                                document.getElementById('instagram-link').style.display = 'none';
                            }
                            
                            if (info.facebook && info.facebook.trim() !== "") {
                                document.getElementById('facebook-link').href = `https://www.facebook.com/${info.facebook}`;
                            } else {
                                document.getElementById('facebook-link').style.display = 'none';
                            }
                            
                                                           
                            </script>


                            <!-- 
<script>
    // Sample description string from the backend
    const descriptionString = "{{ $restaurant->description }}";

    // Function to extract Instagram, Facebook, and Description
    function extractInfo(str) {
        const instagramMatch = str.match(/instagram=([\w\.]+)/);
          const facebookMatch = str.match(/facebook=([\w\s]+) description/);
        const descriptionMatch = str.match(/description=([^]+)/);

        const instagram = instagramMatch ? instagramMatch[1] : '';
        const facebook = facebookMatch ? facebookMatch[1] : '';
        const description = descriptionMatch ? descriptionMatch[1].trim() : '';

        return { instagram, facebook, description };
    }

    // Extracted information
    const info = extractInfo(descriptionString);
        console.log(info);
    // Display the extracted information on the frontend
    document.getElementById('description').innerHtml = info.description+` <button id="close-popup" style="display: block; margin-top: 10px; background: none; border: none; color: blue; cursor: pointer;">Close</button>`;
    document.getElementById('instagram-link').href = `https://www.instagram.com/${info.instagram}`;
    document.getElementById('facebook-link').href = `https://www.facebook.com/${info.facebook}`;
</script>
-->

                            <!-- Handles -->

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
                            <!-- view contacts button -->

                            <button type="button" class="rest-book-btn" data-bs-toggle="modal"
                                data-bs-target="#shop-modal">


                                <img src="https://img.icons8.com/?size=64&id=BBf95mK0q8NH&format=png" style="width: 20px;height:20px;" alt="">


                                <!-- Table Order -->
                                <span>View Contact</span>
                                <!-- <span>{{ __('frontend.table') }} </span> -->
                            </button>

                            <!-- catalog section -->
                            <style>
                                .catalog {
                                    width: 90%;
                                    height: 50vh;
                                }

                                @media (max-width: 830px) {
                                    .catalog {
                                        width: 90%;
                                        height: 40vh;
                                    }
                                }
                            </style>


                            <!-- catalog section ends here -->
                            <button type="button" class="rest-book-btn" data-bs-toggle="modal"
                                data-bs-target="#shop-modal2">

                                <img src="https://img.icons8.com/?size=50&id=986&format=png" style="width: 20px;height:20px;" alt=""> Catalog</button>

                            <div class="modal fade shop-modal" id="shop-modal2" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="shop-modal-header" style="z-index: 1000;">
                                            <button class="fa-regular fa-circle-xmark" type="button" data-bs-dismiss="modal"></button>
                                            <!-- <img src="{{ $restaurant->image }}" alt="restaurant"> -->
                                        </div>
                                        <!-- <iframe style="height: 90vh; width:90%;" src="http://127.0.0.1:8000/frontend/images/food_reciepes.pdf#toolbar=0" allow="fullscreen"><span>Catalog</span></iframe> -->
                                        <script>
                                            console.log("restaurant logo /pdf {{ $restaurant}}")
                                        </script>
                                        <!-- <object data="{{ $restaurant->logo }}" style="width: 100%; height: calc(100vh - 50px);">
                    <span>Catalog</span>
                </object> -->

                                        <div class="pdf-slider-container">
                                            <button class="prev" onclick="moveSlider(-1)">&#10094;</button>
                                            <div class="pdf-slider">
                                                <div class="pdf-items">
                                                    <!-- @if($restaurant->logo)
                                                    <object class="pdf-item" data="{{ $restaurant->logo }}" style="width: 100%; height: calc(100vh - 50px);">
                                                        <span>Catalog</span>
                                                    </object>
                                                    @endif -->
                                                    @foreach($restaurant->media as $media)
                                                    @if($media['mime_type'] == 'application/pdf')
                                                    <div class="pdf-item" style="width: 100%; height: calc(100vh - 50px);">
                                                        <object data="{{ $media['original_url'] }}" type="application/pdf" style="width: 100%; height: 100%;">
                                                            <iframe src="{{ $media['original_url'] }}" style="width: 100%; height: 100%;" frameborder="0">
                                                                <p>Your browser does not support PDFs. <a href="{{ $media['original_url'] }}">Download the PDF</a>.</p>
                                                            </iframe>
                                                        </object>
                                                    </div>
                                                    @endif

                                                    @endforeach
                                                </div>
                                            </div>
                                            <button class="next" onclick="moveSlider(1)">&#10095;</button>
                                        </div>

                                        <style>
                                            .pdf-slider-container {
                                                position: relative;
                                                width: 100%;
                                                overflow: hidden;
                                                display: flex;
                                                align-items: center;
                                            }

                                            .pdf-slider {
                                                overflow: hidden;
                                                width: 100%;
                                            }

                                            .pdf-items {
                                                display: flex;
                                                transition: transform 0.5s ease-in-out;
                                            }

                                            .pdf-item {
                                                min-width: 100%;
                                                margin-right: 10px;
                                                flex-shrink: 0;
                                            }

                                            .prev,
                                            .next {
                                                position: absolute;
                                                top: 50%;
                                                transform: translateY(-50%);
                                                background-color: rgba(0, 0, 0, 0.5);
                                                color: white;
                                                border: none;
                                                padding: 10px;
                                                cursor: pointer;
                                                z-index: 1000;
                                            }

                                            .prev {
                                                left: 0;
                                            }

                                            .next {
                                                right: 0;
                                            }

                                            cr-icon {
                                                display: none;
                                            }
                                        </style>
                                        <script>
                                            let currentIndex = 0;

                                            function moveSlider(direction) {
                                                const items = document.querySelector('.pdf-items');
                                                const totalItems = document.querySelectorAll('.pdf-item').length;

                                                // Calculate the new index
                                                currentIndex += direction;

                                                // Make sure the index is within bounds
                                                if (currentIndex < 0) {
                                                    currentIndex = totalItems - 1;
                                                } else if (currentIndex >= totalItems) {
                                                    currentIndex = 0;
                                                }

                                                // Calculate the new translateX value
                                                const translateXValue = -currentIndex * 100;

                                                // Apply the transformation
                                                items.style.transform = `translateX(${translateXValue}%)`;
                                            }
                                        </script>

                                    </div>
                                </div>
                            </div>
                            <!-- catalog Part ends here -->
                            <!-- whatsapp button                                -->
                            <button type="button" class="rest-info-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
                                    <path fill="#fff" d="M4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5c5.1,0,9.8,2,13.4,5.6C41,14.2,43,18.9,43,24   c0,10.5-8.5,19-19,19c0,0,0,0,0,0h0c-3.2,0-6.3-0.8-9.1-2.3L4.9,43.3z"></path>
                                    <path fill="#fff" d="M4.9,43.8c-0.1,0-0.3-0.1-0.4-0.1c-0.1-0.1-0.2-0.3-0.1-0.5L7,33.5c-1.6-2.9-2.5-6.2-2.5-9.6   C4.5,13.2,13.3,4.5,24,4.5c5.2,0,10.1,2,13.8,5.7c3.7,3.7,5.7,8.6,5.7,13.8c0,10.7-8.7,19.5-19.5,19.5c-3.2,0-6.3-0.8-9.1-2.3       L5,43.8C5,43.8,4.9,43.8,4.9,43.8z"></path>
                                    <path fill="#cfd8dc" d="M24,5c5.1,0,9.8,2,13.4,5.6C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19h0c-3.2,0-6.3-0.8-9.1-2.3L4.9,43.3     l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5 M24,43L24,43L24,43 M24,43L24,43L24,43 M24,4L24,4C13,4,4,13,4,24     c0,3.4,0.8,6.7,2.5,9.6L3.9,43c-0.1,0.3,0,0.7,0.3,1c0.2,0.2,0.4,0.3,0.7,0.3c0.1,0,0.2,0,0.3,0l9.7-2.5c2.8,1.5,6,2.2,9.2,2.2      c11,0,20-9,20-20c0-5.3-2.1-10.4-5.8-14.1C34.4,6.1,29.4,4,24,4L24,4z"></path>
                                    <path fill="#40c351" d="M35.2,12.8c-3-3-6.9-4.6-11.2-4.6C15.3,8.2,8.2,15.3,8.2,24c0,3,0.8,5.9,2.4,8.4L11,33l-1.6,5.8l6-1.6l0.6,0.3       c2.4,1.4,5.2,2.2,8,2.2h0c8.7,0,15.8-7.1,15.8-15.8C39.8,19.8,38.2,15.8,35.2,12.8z"></path>
                                    <path fill="#fff" fill-rule="evenodd" d="M19.3,16c-0.4-0.8-0.7-0.8-1.1-0.8c-0.3,0-0.6,0-0.9,0s-0.8,0.1-1.3,0.6c-0.4,0.5-1.7,1.6-1.7,4       s1.7,4.6,1.9,4.9s3.3,5.3,8.1,7.2c4,1.6,4.8,1.3,5.7,1.2c0.9-0.1,2.8-1.1,3.2-2.3c0.4-1.1,0.4-2.1,0.3-2.3c-0.1-0.2-0.4-0.3-0.9-0.6      s-2.8-1.4-3.2-1.5c-0.4-0.2-0.8-0.2-1.1,0.2c-0.3,0.5-1.2,1.5-1.5,1.9c-0.3,0.3-0.6,0.4-1,0.1c-0.5-0.2-2-0.7-3.8-2.4       c-1.4-1.3-2.4-2.8-2.6-3.3c-0.3-0.5,0-0.7,0.2-1c0.2-0.2,0.5-0.6,0.7-0.8c0.2-0.3,0.3-0.5,0.5-0.8c0.2-0.3,0.1-0.6,0-0.8 C20.6,19.3,19.7,17,19.3,16z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <!-- heart icon -->
                            <button type="button" class="rest-info-btn" id="likeButton" style="border: none; background: none; cursor: pointer;">
                                <img id="likeImage" width="20" height="20" src="https://img.icons8.com/ios/50/F25081/like--v1.png" alt="like--v1" />
                            </button>
                            <script>
                                document.addEventListener('DOMContentLoaded', (event) => {
                                    const likeButton = document.getElementById('likeButton');
                                    const likeImage = document.getElementById('likeImage');

                                    likeButton.addEventListener('click', () => {
                                        const isFilled = likeImage.classList.toggle('heart-filled');
                                        if (isFilled) {
                                            likeImage.src = 'https://img.icons8.com/ios-filled/50/F25081/like--v1.png';
                                            likeButton.style.backgroundColor = 'pink';
                                        } else {
                                            likeImage.src = 'https://img.icons8.com/ios/50/F25081/like--v1.png';
                                            likeButton.style.backgroundColor = 'none';
                                        }
                                    });
                                });
                            </script>


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

                    <!-- handels adding -->



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


                @include('frontend.partials._footer')
            </div>

            <!--=======  Side bar card ========-->
            <aside style="display: none;" class="cart-sidebar active">
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
                <img style="height: 35vh;
    object-fit: cover;" src="{{ $restaurant->image }}" alt="restaurant">
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
                    {{ date('h:i A', strtotime($restaurant->closing_time)) }}
                </p>
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
                                <h3 style="display: flex;">
                                    <img src="https://img.icons8.com/?size=64&id=BBf95mK0q8NH&format=png" style="width: 20px;height:20px;" alt="">
                                    &nbsp; Woicher’s contact - 9833891281
                                </h3>

                            </li>
                            <li>

                                <h3 style="display: flex;"> <img src="https://img.icons8.com/?size=30&id=14oX0z9ydOeX&format=png" style="width: 20px;height:20px;" alt=""> &nbsp; Usual Delivery time - 2-3 days </h3>

                            </li>
                        </ul>
                        <!-- qr code image commenting -->
                        <!-- <img src="data:image/png;base64,{!! $qrCode !!}" alt="qr"> -->
                    </div>
                </div>

                <div class="tab-pane fade " id="reviews"
                    role="tabpanel">

                    <!-- for dummy reviews @  if (!blank($order_status)) -->
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
                    <!-- remove whitespace if stament will work @ endif -->
                    <br>
                    <!-- @if (!blank($ratings)) -->
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
                    <!-- @endif -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- menu ratings -->

<!--======= Resturent Infromation MODAL END ==========-->
@endsection

@push('js')
<script>
    const reservationUrl = "{{ route('reservation.check') }}";
</script>
<script src="{{ asset('frontend/js/booking.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/js/show.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/js/loader.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/js/navcount.js') }}" type="text/javascript"></script>
@endpush

@push('livewire')
<script src="{{ asset('js/order-cart.js') }}"></script>
@endpush