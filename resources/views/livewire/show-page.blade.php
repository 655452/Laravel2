<div class="">

    @php
        $currenttime = \Carbon\Carbon::now()->format('H:i:s');
    @endphp
<style>
/* Container for search bar */
.search-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 25px 20px 0px 20px;
}

/* Search input field */
#searchBar {
    width: 250px;
    padding: 10px 20px;
    border: 1px solid white;
    font-size: 16px;
    outline: none;
}

/* Search button */
.search-container button {
    padding: 10px 20px;
    border: 1px solid #ccc;
    border-left: none;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    outline: none;
}

.search-container button:hover {
    background-color: #0056b3;
}

/* Search icon */
.search-container button i.fa-search {
    margin-right: 5px;
}

/* Optional: Style the highlighted menu item */
.product-card-title.highlight {
    background-color: yellow;
}
.search-wrap{
    border-radius: 50px;
    width: 350px;
    border: 1px solid #ccc; 
    display: flex;
    justify-content: space-evenly;
    align-items: center;

}
</style>
 <div class="search-container">
       <div class="search-wrap">
        <input type="text" id="searchBar" placeholder="Search menu items" onkeypress="searchAndHighlight()">
      
        <i onclick="searchAndHighlight()" class="fa fa-search"></i> 
       </div>
       
    </div>
    @if (!blank($categories_products))
        @foreach ($categories_products as $categories_product_key => $categories_product)
            <div wire:ignore="" wire:key="{{ $categories_product_key }}" id="listing_product{{ $categories_product_key }}">
                <div class="product-category" id="popular-items{{ $categories_product_key }}">
                    @if (isset($categories[$categories_product_key]->name))
                        <h3 class="product-category-title">{{ $categories[$categories_product_key]->name }} </h3>
                    @endif
                    <div class="product-card-groupp">
                        <div class="row gx-3 gy-3">
                            @if (!blank($categories_product))
                                @foreach ($categories_product as $menu_item)
                                    <div class="col-md-4 " wire:key="{{ $menu_item['id'] }}">
                                        <div class="product-card">
                                            <figure
                                                class="product-card-media d-flex justify-content-center align-items-center">


                                                        <!-- image carasole here for menu items-->
                                    <div style="height:150px;" id="carousel-menu-{{ $menu_item['id'] }}-{{ $categories[$categories_product_key]->id }}">
                                        @foreach ($menu_item['media'] as $key => $media)
                                            <img style="object-fit:contain;"  class="carousel-image" data-index="{{ $key }}" src="{{ $media['original_url'] }}" alt="{{ $media['file_name'] }}" >
                                        @endforeach
                                    </div>
                                                <style>
                                                   @keyframes slideOut {
                                                        0% {
                                                            transform: translateX(0%);
                                                        }
                                                        100% {
                                                            transform: translateX(-10%);
                                                        }
                                                    }

                                                    @keyframes slideIn {
                                                        0% {
                                                            transform: translateX(10%);
                                                        }
                                                        100% {
                                                            transform: translateX(0%);
                                                        }
                                                    }

                                                    .carousel-image {
                                                        width: 150px;
                                                        height: auto;
                                                        object-fit: contain;
                                                         position:relative;
                                                        transition: transform 1s ease-in-out;
                                                    }

                                                    .active {
                                                    /*    animation: slideIn 1s forwards;*/
                                                        z-index:2;
                                                        }
                                                    .hidden {
                                                      /*  animation: slideOut 1s forwards;*/

                                                        z-index:0;
                                                    }

                                                </style>
                                        <script>
                                           
                                           document.getElementById("carousel-menu-{{ $menu_item['id'] }}-{{ $categories[$categories_product_key]->id }}").addEventListener("click", function(event) {
                                                const images = this.querySelectorAll(".carousel-image");
                                                let currentIndex = 0;

                                                // Find the active image
                                                        // Find the active image (the one with opacity 1)
    images.forEach((image, index) => {
        if (parseFloat(image.style.opacity) === 1) {
            currentIndex = index;
        }
    });
                                            
                                                // Hide the current image
                                                images[currentIndex].style.opacity=0;
                                                images[currentIndex].style.display ='none';                                            
                                                // Calculate the index of the next image
                                                const nextIndex = (currentIndex + 1) % images.length;
                                            
                                                // Show the next image
                                                images[nextIndex].style.opacity=1;
                                                images[nextIndex].style.display ='initial';

                                                // Ensure the next image is properly displayed
    images[nextIndex].style.zIndex = 2;
    images[currentIndex].style.zIndex = 1;
                                            });



                                            

                                        </script>
  

                                            </figure>



                                        <!-- Add review for menu items -->
                            <style>
                                     .overlay {
                                            position: fixed;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            background-color: rgba(0, 0, 0, 0.7);
                                            z-index: 1000;
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                        }

                                        .popup-form-container {
                                            background: white;
                                            padding: 20px;
                                            border-radius: 5px;
                                            width: 80%;
                                            max-width: 600px;
                                        }

                                        .leave-rating-dummy {
                                            cursor: pointer;
                                            display: flex;
                                            gap: 5px;
                                        }


                            </style> 
                                        <div id="popup-overlay-{{ $menu_item['id'] }}" class="overlay popup-overlay" style="display: none;">
                                                <div class="popup-form-container">
                                                <style>
                                                    .menu-item-details {
                                                        border: 1px solid #ddd;
                                                        padding: 15px;
                                                        border-radius: 5px;
                                                        background-color: #f9f9f9;
                                                        margin-top: 20px;
                                                    }
                                                
                                                    .rating-summary p {
                                                        margin: 0;
                                                        font-size: 16px;
                                                        font-weight: bold;
                                                    }
                                                
                                                    .reviews-section {
                                                        margin-top: 20px;
                                                    }
                                                
                                                    .reviews-section h3 {
                                                        margin-bottom: 15px;
                                                        font-size: 18px;
                                                        color: #333;
                                                    }
                                                
                                                    .review-item {
                                                        margin-bottom: 20px;
                                                    }
                                                
                                                    .review-item p {
                                                        margin: 5px 0;
                                                        font-size: 14px;
                                                    }
                                                
                                                    .review-item hr {
                                                        margin-top: 10px;
                                                        border: none;
                                                        border-top: 1px solid #eee;
                                                    }
                                                </style>

                                                <h3>{{ $menu_item['name'] }}</h3>

                                <div class="menu-item-details">
                                    <!-- Display Average Rating and Total Reviews -->
                                    <div class="rating-summary">
                                        <p>Average Rating: {{ $menu_item['average_rating'] }}</p>
                                        <p>Total Reviews: {{ $menu_item['total_reviews'] }}</p>
                                    </div>

                                    <!-- Display Each Review -->
                                    <div class="reviews-section">
                                        <h3>Customer Reviews:</h3>
                                        @if($menu_item['review']->isNotEmpty())
                                            @foreach($menu_item['review'] as $rating)
                                                <div class="review-item">
                                                    <p> {{ $rating['review'] }}

                                                    @php
                                                                                $ratingReview = round($rating['rating'] ); // Round the rating to the nearest integer
                                                                            @endphp

                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($i <= $ratingReview)
                                                                                    <label class="fa fa-star" style="color: orange;"></label>
                                                                                @else
                                                                                    <label class="fa fa-star" style="color: #ccc;"></label> <!-- Gray out the stars not filled -->
                                                                                @endif
                                                                            @endfor
                                                </p>
                                                    <!-- <p><strong>Rating:</strong> {{ $rating['rating'] }}</p> -->
                                                    <!-- If you have the user's name associated with the review -->

                                                    <hr>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No reviews yet.</p>
                                        @endif
                                    </div>
                                </div>
                                                    
                                                    <form action="{{ route('restaurant.Itemratings-update') }}" method="POST">
                                                        @csrf
                                                        <div id="add-review2" class="add-review-box custom-width">
                                                            <h5 style="margin-top: 20px;">{{ __('frontend.add_review') }}</h5>
                                                            <hr>
                                                            <div class="sub-ratings-container">
                                                                <div class="add-sub-rating">
                                                                    <div class="sub-rating-title">{{ __('frontend.review') }}
                                                                        <i class="tip" data-tip-content="{{ __('frontend.auality_customer') }}"></i>
                                                                    </div>
                                                                    <div class="sub-rating-stars">
                                                                        <div class="clearfix"></div>
                                                                    <style>
                                                                                 /* Hide the radio buttons but keep them clickable */
                                                                            .leave-rating2 input[type="radio"] {
                                                                                opacity: 0;
                                                                                position: absolute;
                                                                            }

                                                                            /* Style the stars */
                                                                            .leave-rating2 label {
                                                                                color: #ccc; /* Gray color for unselected stars */
                                                                                font-size: 17px; /* Adjust the size of the stars */
                                                                                cursor: pointer;
                                                                                transition: color 0.2s ease-in-out;
                                                                            }

                                                                            /* Change color for all stars from left to the selected one */
                                                                            .leave-rating2 input[type="radio"]:checked ~ label {
                                                                                color: #ccc; /* Reset the color of unselected stars */
                                                                            }

                                                                            .leave-rating2 label:hover,
                                                                            .leave-rating2 label:hover ~ label,
                                                                            .leave-rating2 input[type="radio"]:checked ~ label,
                                                                            .leave-rating2 input[type="radio"]:checked ~ label ~ label {
                                                                                color: #ffcc00; /* Yellow color for selected and hovered stars */
                                                                            }

                                                                            /* Change color for stars before the selected one */
                                                                            .leave-rating2 label:hover ~ label {
                                                                                color: #ccc;
                                                                            }

                                                                    </style>
                                                                        <div class="leave-rating2">
                                                                            <input type="radio" value="5" name="rating">
                                                                            <label for="rating-5" class="fa fa-star"></label>
                                                                            <input type="radio" value="4" name="rating">
                                                                            <label for="rating-4" class="fa fa-star"></label>
                                                                            <input type="radio" value="3" name="rating">
                                                                            <label for="rating-3" class="fa fa-star"></label>
                                                                            <input type="radio" value="2" name="rating">
                                                                            <label for="rating-2" class="fa fa-star"></label>
                                                                            <input type="radio" value="1" name="rating">
                                                                            <label for="rating-1" class="fa fa-star"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="menu_item_id" value="{{ $menu_item['id'] }}">
                                                            <input type="hidden" name="status" value="5">
                                                            <div class="form-group mt-2 pt-2">
                                                                
                                                                <textarea name="review" type="text" style="width:100%" rows="3" aria-label="With textarea" placeholder="{{ __('frontend.write_review') }}">{{ old('review') }}</textarea>
                                                            </div>
                                                            <button type="submit" class="rest-book-btn">{{ __('frontend.submit_review') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>


                                        <div onclick="triggerLink(event, {{ $menu_item['id'] }})" class="product-card-content" id="product-card-{{ $menu_item['id'] }}">

                                @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime) <h4 class="product-card-title showClosedNotification">
                                    {{ \Illuminate\Support\Str::limit($menu_item['name'], 100) }}
                                    </h4>
                                    @else
                                    <a href="#variation-{{ $menu_item['id'] }}" wire:click.prevent="addToCartModal({{ $menu_item['id'] }})" id="link-{{ $menu_item['id'] }}" style="display: none;"></a>
                                    <h4 class="product-card-title">
                                        {{ \Illuminate\Support\Str::limit($menu_item['name'], 100) }}
                                    </h4>
                                    @endif

                                    <p class="product-card-text">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($menu_item['description']), 70) !!}
                                    </p>

                                          <!-- Adding ratings demo start -->
                                       <!-- Display star ratings -->
                                        <div class="leave-rating-dummy">
                                            @php
                                                $rating = round($menu_item['average_rating']); // Round the rating to the nearest integer
                                            @endphp
                                                                            
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rating)
                                                    <label class="fa fa-star" style="color: orange;"></label>
                                                @else
                                                    <label class="fa fa-star" style="color: #ccc;"></label> <!-- Gray out the stars not filled -->
                                                @endif
                                            @endfor
                                            <p class="totalReview" >{{ $menu_item['total_reviews'] }}</p>
                                   
                                        </div>

                                         <style>
                                            .totalReview{
                                                justify-content: center;
                                                font-weight: 1000;
                                                width: 22px;
                                                height: 20px;
                                                background-color: #e86121;
                                                border-radius: 50%;
                                                color:white;
                                                display: flex;
                                                align-items: center;
   
                                            }

                                        </style>
                                        <script>
                                            document.querySelectorAll('.leave-rating-dummy').forEach(function(element) {
                                                    element.addEventListener('click', function() {
                                                        var id = this.getAttribute('data-id');
                                                        var popup = document.getElementById('popup-overlay-' + id);
                                                        popup.style.display = 'flex';
                                                    });
                                                });
                                                
                                                document.querySelectorAll('.popup-overlay').forEach(function(popup) {
                                                    popup.addEventListener('click', function(event) {
                                                        if (event.target === this) {
                                                            this.style.display = 'none';
                                                        }
                                                    });
                                                });
                                        
                                        </script>
                                    <div class="product-card-info">
                                        <div class="product-card-price">
                                            @if ($menu_item['discount_price'] > 0)
                                            <del>
                                                <!-- {{ setting('currency_code') }} -->
                                                        ₹       {{ $menu_item['unit_price'] }}</del>
                                            <span>
                                            <!--        {{ setting('currency_code') }}  -->
                                                ₹{{ $menu_item['unit_price'] - $menu_item['discount_price'] }}</span>
                                            @else
                                            <span>
                                                <!-- {{ setting('currency_code') }} -->
                                        ₹{{ $menu_item['unit_price'] - $menu_item['discount_price'] }}</span>
                                            @endif
                                        </div>

                                        @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime)
                                        <!--  <button class="product-card-add showClosedNotification">
                                             <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.6433 5.22689C11.2525 4.79523 10.6633 4.54439 9.84668 4.45689V4.01356C9.84668 3.21439 9.50835 2.44439 8.91335 1.90773C8.31251 1.35939 7.53085 1.10273 6.72001 1.17856C5.32585 1.31273 4.15335 2.66023 4.15335 4.11856V4.45689C3.33668 4.54439 2.74751 4.79523 2.35668 5.22689C1.79085 5.85689 1.80835 6.69689 1.87251 7.28023L2.28085 10.5294C2.40335 11.6669 2.86418 12.8336 5.37251 12.8336H8.62751C11.1358 12.8336 11.5967 11.6669 11.7192 10.5352L12.1275 7.27439C12.1917 6.69689 12.2033 5.85689 11.6433 5.22689ZM6.80168 1.98939C7.38501 1.93689 7.93918 2.11773 8.37085 2.50856C8.79668 2.89356 9.03585 3.44189 9.03585 4.01356V4.42189H4.96418V4.11856C4.96418 3.08023 5.82168 2.08273 6.80168 1.98939ZM4.91168 7.67106H4.90585C4.58501 7.67106 4.32251 7.40856 4.32251 7.08773C4.32251 6.76689 4.58501 6.50439 4.90585 6.50439C5.23251 6.50439 5.49501 6.76689 5.49501 7.08773C5.49501 7.40856 5.23251 7.67106 4.91168 7.67106ZM8.99501 7.67106H8.98918C8.66835 7.67106 8.40585 7.40856 8.40585 7.08773C8.40585 6.76689 8.66835 6.50439 8.98918 6.50439C9.31585 6.50439 9.57835 6.76689 9.57835 7.08773C9.57835 7.40856 9.31585 7.67106 8.99501 7.67106Z" />
                                            </svg>
                                            <span>{{ __('frontend.add') }}</span>
                                            </button>
                                            @else

                                                <!-- 
                                            <a href="#variation-{{ $menu_item['id'] }}" wire:key="{{ $menu_item['id'] }}" class="product-card-add" wire:click.prevent="addToCartModal({{ $menu_item['id'] }})">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.6433 5.22689C11.2525 4.79523 10.6633 4.54439 9.84668 4.45689V4.01356C9.84668 3.21439 9.50835 2.44439 8.91335 1.90773C8.31251 1.35939 7.53085 1.10273 6.72001 1.17856C5.32585 1.31273 4.15335 2.66023 4.15335 4.11856V4.45689C3.33668 4.54439 2.74751 4.79523 2.35668 5.22689C1.79085 5.85689 1.80835 6.69689 1.87251 7.28023L2.28085 10.5294C2.40335 11.6669 2.86418 12.8336 5.37251 12.8336H8.62751C11.1358 12.8336 11.5967 11.6669 11.7192 10.5352L12.1275 7.27439C12.1917 6.69689 12.2033 5.85689 11.6433 5.22689ZM6.80168 1.98939C7.38501 1.93689 7.93918 2.11773 8.37085 2.50856C8.79668 2.89356 9.03585 3.44189 9.03585 4.01356V4.42189H4.96418V4.11856C4.96418 3.08023 5.82168 2.08273 6.80168 1.98939ZM4.91168 7.67106H4.90585C4.58501 7.67106 4.32251 7.40856 4.32251 7.08773C4.32251 6.76689 4.58501 6.50439 4.90585 6.50439C5.23251 6.50439 5.49501 6.76689 5.49501 7.08773C5.49501 7.40856 5.23251 7.67106 4.91168 7.67106ZM8.99501 7.67106H8.98918C8.66835 7.67106 8.40585 7.40856 8.40585 7.08773C8.40585 6.76689 8.66835 6.50439 8.98918 6.50439C9.31585 6.50439 9.57835 6.76689 9.57835 7.08773C9.57835 7.40856 9.31585 7.67106 8.99501 7.67106Z" />
                                                </svg>
                                                <span>{{ __('frontend.add') }}</span>
                                            </a> -->
                                            @endif
                                    </div>
                            </div>
                            <script>
                                function triggerLink(event, menuItemId) {
                                    event.preventDefault();
                                    document.getElementById('link-' + menuItemId).click();
                                }
                            </script>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @if (!blank($other_products))
        <div wire:ignore="" id="listing_product_other">
            <div class="product-category" id="popular-items">
                <h3 class="product-category-title">{{ __('levels.other') }} </h3>
                <div class="product-card-groupp">
                    <div class="row gx-3 gy-3">
                        @foreach ($other_products as $other_product)
                            <div class="col-md-6" wire:key="{{ $other_product['id'] }}">
                                <div class="product-card">
                                    <figure class="product-card-media d-flex justify-content-center align-items-center">

                                        <img data-src="{{ $other_product['image'] }}" class="lazy" alt="product">

                                        <div class="loader-container">
                                            <img src="{{ asset('frontend/images/default/loader.gif') }}" class="loader"
                                                alt="loading">
                                        </div>
                                    </figure>
                                    <div onclick="triggerLink(event, {{ $menu_item['id'] }})" class="product-card-content">
                                        @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime)
                                            <h4 class="product-card-title showClosedNotification">
                                                {{ \Illuminate\Support\Str::limit($menu_item['name'], 40) }}
                                            </h4>
                                        @else
                                            <a href="#variation-{{ $menu_item['id'] }}"
                                                wire:click.prevent="addToCartModal({{ $menu_item['id'] }})">
                                                <h4 class="product-card-title">
                                                        <!-- {{ \Illuminate\Support\Str::limit($menu_item['name'], ) }} -->
                                                        $menu_item['name']
                                                </h4>
                                            </a>
                                        @endif
                                        <p class="product-card-text">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($other_product['description']), 70) !!}
                                        </p>

                                        <div class="product-card-info">
                                            <div class="product-card-price">
                                                @if ($other_product['discount_price'] > 0)
                                                    <del>{{ setting('currency_code') }}{{ $other_product['unit_price'] }}
                                                    </del>
                                                    <span>
                                                        {{ setting('currency_code') }}{{ $other_product['unit_price'] - $other_product['discount_price'] }}
                                                    </span>
                                                @else
                                                    <span>
                                                        {{ setting('currency_code') }}{{ $other_product['unit_price'] - $other_product['discount_price'] }}
                                                    </span>
                                                @endif
                                            </div>


                                            @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime)
                                                <button class="product-card-add showClosedNotification">
                                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.6433 5.22689C11.2525 4.79523 10.6633 4.54439 9.84668 4.45689V4.01356C9.84668 3.21439 9.50835 2.44439 8.91335 1.90773C8.31251 1.35939 7.53085 1.10273 6.72001 1.17856C5.32585 1.31273 4.15335 2.66023 4.15335 4.11856V4.45689C3.33668 4.54439 2.74751 4.79523 2.35668 5.22689C1.79085 5.85689 1.80835 6.69689 1.87251 7.28023L2.28085 10.5294C2.40335 11.6669 2.86418 12.8336 5.37251 12.8336H8.62751C11.1358 12.8336 11.5967 11.6669 11.7192 10.5352L12.1275 7.27439C12.1917 6.69689 12.2033 5.85689 11.6433 5.22689ZM6.80168 1.98939C7.38501 1.93689 7.93918 2.11773 8.37085 2.50856C8.79668 2.89356 9.03585 3.44189 9.03585 4.01356V4.42189H4.96418V4.11856C4.96418 3.08023 5.82168 2.08273 6.80168 1.98939ZM4.91168 7.67106H4.90585C4.58501 7.67106 4.32251 7.40856 4.32251 7.08773C4.32251 6.76689 4.58501 6.50439 4.90585 6.50439C5.23251 6.50439 5.49501 6.76689 5.49501 7.08773C5.49501 7.40856 5.23251 7.67106 4.91168 7.67106ZM8.99501 7.67106H8.98918C8.66835 7.67106 8.40585 7.40856 8.40585 7.08773C8.40585 6.76689 8.66835 6.50439 8.98918 6.50439C9.31585 6.50439 9.57835 6.76689 9.57835 7.08773C9.57835 7.40856 9.31585 7.67106 8.99501 7.67106Z" />
                                                    </svg>
                                                    <span>{{ __('frontend.add') }}</span>
                                                </button>
                                            @else
                                                <a href="#variation-{{ $other_product['id'] }}"
                                                    wire:key="{{ $other_product['id'] }}" class="product-card-add"
                                                    wire:click.prevent="addToCartModal({{ $other_product['id'] }})">
                                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.6433 5.22689C11.2525 4.79523 10.6633 4.54439 9.84668 4.45689V4.01356C9.84668 3.21439 9.50835 2.44439 8.91335 1.90773C8.31251 1.35939 7.53085 1.10273 6.72001 1.17856C5.32585 1.31273 4.15335 2.66023 4.15335 4.11856V4.45689C3.33668 4.54439 2.74751 4.79523 2.35668 5.22689C1.79085 5.85689 1.80835 6.69689 1.87251 7.28023L2.28085 10.5294C2.40335 11.6669 2.86418 12.8336 5.37251 12.8336H8.62751C11.1358 12.8336 11.5967 11.6669 11.7192 10.5352L12.1275 7.27439C12.1917 6.69689 12.2033 5.85689 11.6433 5.22689ZM6.80168 1.98939C7.38501 1.93689 7.93918 2.11773 8.37085 2.50856C8.79668 2.89356 9.03585 3.44189 9.03585 4.01356V4.42189H4.96418V4.11856C4.96418 3.08023 5.82168 2.08273 6.80168 1.98939ZM4.91168 7.67106H4.90585C4.58501 7.67106 4.32251 7.40856 4.32251 7.08773C4.32251 6.76689 4.58501 6.50439 4.90585 6.50439C5.23251 6.50439 5.49501 6.76689 5.49501 7.08773C5.49501 7.40856 5.23251 7.67106 4.91168 7.67106ZM8.99501 7.67106H8.98918C8.66835 7.67106 8.40585 7.40856 8.40585 7.08773C8.40585 6.76689 8.66835 6.50439 8.98918 6.50439C9.31585 6.50439 9.57835 6.76689 9.57835 7.08773C9.57835 7.40856 9.31585 7.67106 8.99501 7.67106Z" />
                                                    </svg>
                                                    <span>{{ __('frontend.add') }}</span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
<script>
function triggerLink(event, menuItemId) {
    event.preventDefault();
    document.getElementById('link-' + menuItemId).click();
}

</script>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

 <script>
                                            
                                            document.querySelectorAll('.leave-rating-dummy').forEach(function(element, index) {
    element.addEventListener('click', function(event) {
        // Get the specific .popup-overlay related to the clicked .leave-rating-dummy
        var popup = document.querySelectorAll('.popup-overlay')[index];
        popup.style.display = 'flex';
    });
});

document.querySelectorAll('.popup-overlay').forEach(function(popup) {
    popup.addEventListener('click', function(event) {
        if (event.target === this) {
            this.style.display = 'none';
        }
    });
});
</script>
<script>


// Function to highlight and scroll to the matching menu item
function searchAndHighlight() {
    // Get the search query from the search bar
    const query = document.getElementById('searchBar').value.toLowerCase();
    
    // Get all elements with the class 'product-card-title'
    const menuItems = document.querySelectorAll('.product-card-title');
    
    // Variable to check if any match is found
    let found = false;
    
    // Loop through each menu item
    menuItems.forEach((item) => {
        // Get the text content of the menu item and convert it to lowercase
        const text = item.textContent.trim().toLowerCase();
        
        // Check if the query is present in the text content
        if (text.includes(query)) {
            // If a match is found, scroll to the item and highlight it
            item.scrollIntoView({ behavior: 'smooth', block: 'center' });
            item.style.backgroundColor = 'white'; // Highlight the item
            found = true;
        } else {
            // Remove the highlight if the item does not match
            item.style.backgroundColor = '';
        }
    });
    
    // If no match is found, alert the user
    if (!found) {
        alert('No matching menu items found.');
    }
}

// Optional: Clear the highlight when the user changes the search query
document.getElementById('searchBar').addEventListener('input', () => {
    const menuItems = document.querySelectorAll('.product-card-title');
    menuItems.forEach((item) => {
        item.style.backgroundColor = '';
    });
});

</script>