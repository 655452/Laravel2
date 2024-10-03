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

        .search-wrap {
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
    <!-- <div wire:ignore="" wire:key="{{ $categories_product_key }}" id="listing_product{{ $categories_product_key }}"> -->
    <div wire:ignore="" id="listing_product{{ $categories_product_key }}">
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
                            <!-- HTML -->
                            
                            <figure class="product-card-media d-flex justify-content-center align-items-center">
                                <!-- Image carousel here for menu items -->
                                <div style="height:150px;" id="carousel-menu-{{ $menu_item['id'] }}-{{ $categories[$categories_product_key]->id }}" class="carousel-container position-relative">
                                    @foreach ($menu_item['media'] as $key => $media)
                                    <img style="object-fit:contain;" class="carousel-image" data-index="{{ $key }}" src="{{ $media['original_url'] }}" alt="{{ $menu_item['name'] }}" data-price="{{ $menu_item['unit_price'] }}" data-description=" {{$menu_item['description']}}">
                                    @endforeach

                                    <!-- Navigation buttons -->
                                    <button class="carousel-nav left-nav">&#9664;</button>
                                    <button class="carousel-nav right-nav">&#9654;</button>
                                </div>
                            </figure>

                            <!-- Modal popup -->
                            <div id="modalMenuItem" class="modalMenuItem">
                                <div class="modalMenuItem-content">
                                    <span class="close">&times;</span>
                                    <img id="modal-image" src="" alt="">
                                    <strong>
                                        <h4 id="modal-name"></h4>
                                    </strong>
                                    <strong>
                                        <p id="modal-price"></p>
                                    </strong>
                                    <p id="modal-description"></p>
                                </div>
                            </div>

                            <!-- CSS -->
                            <style>
                                .carousel-container {
                                    position: relative;
                                    width: 150px;
                                    height: 150px;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                }

                                .carousel-image {
                                    display: none;
                                    width: 100%;
                                    height: 100%;
                                    object-fit: contain;
                                }

                                .carousel-image.active {
                                    display: block;
                                }

                                .carousel-nav {
                                    position: absolute;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    background-color: rgba(0, 0, 0, 0.2);
                                    color: white;
                                    border: none;
                                    padding: 10px;
                                    cursor: pointer;
                                    z-index: 1;
                                }

                                .left-nav {
                                    left: 0;
                                }

                                .right-nav {
                                    right: 0;
                                }

                                /* Modal */
                                .modalMenuItem {
                                    display: none;
                                    position: fixed;
                                    z-index: 1000;
                                    left: 0;
                                    top: 0;
                                    width: 100%;
                                    height: 100%;
                                    background-color: rgba(0, 0, 0, 0.7);
                                    justify-content: center;
                                    align-items: center;
                                }

                                .modalMenuItem-content div {
                                    font-size: 12px;
                                }

                                .modalMenuItem-content {
                                    background-color: white;
                                    width: 80%;
                                    height: 80vh;
                                    max-width: 400px;
                                    text-align: center;
                                    position: relative;
                                    overflow-y: auto;
                                    border-radius: 15px;
                                    /* Added border-radius */
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: center;
                                    align-items: center;
                                    scrollbar-width: none;
                                    /* Hide scrollbar in Firefox */
                                    -ms-overflow-style: none;
                                    /* Hide scrollbar in Internet Explorer */
                                }

                                /* Hide scrollbar in Webkit browsers (Chrome, Safari) */
                                .modalMenuItem-content::-webkit-scrollbar {
                                    display: none;
                                }

                                .close {
                                    position: absolute;
                                    top: 10px;
                                    right: 10px;
                                    font-size: 18px;
                                    cursor: pointer;
                                    background-color: red;
                                    border-radius: 50%;
                                    width: 20px;
                                    height: 20px;
                                    text-align: center;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    color: white;
                                    font-weight: bolder;
                                }

                                #modal-image {
                                    max-width: 100%;
                                    max-height: 60vh;
                                    object-fit: contain;
                                }

                                h4#modal-name {
                                    font-size: 14px;
                                    /* Set font size for headings */
                                    margin: 10px 0;
                                }

                                p#modal-price,
                                p#modal-description {
                                    font-size: 12px;
                                    /* Set font size for paragraphs */
                                    margin: 5px 0;
                                }

                                /* Mobile responsiveness */
                                @media (max-width: 768px) {
                                    .modalMenuItem-content {
                                        width: 90%;
                                        max-width: none;
                                        height: 80vh;
                                    }

                                    #modal-image {
                                        max-width: 100%;
                                        max-height: 40vh;
                                    }
                                }
                            </style>

                            <!-- JavaScript -->
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const carouselContainer = document.getElementById("carousel-menu-{{ $menu_item['id'] }}-{{ $categories[$categories_product_key]->id }}");
                                    const images = carouselContainer.querySelectorAll(".carousel-image");
                                    const leftNav = carouselContainer.querySelector(".left-nav");
                                    const rightNav = carouselContainer.querySelector(".right-nav");
                                    let currentIndex = 0;

                                    // Show the first image initially
                                    images[currentIndex].classList.add("active");

                                    // Function to update carousel visibility
                                    function updateCarousel(newIndex) {
                                        images[currentIndex].classList.remove("active");
                                        images[newIndex].classList.add("active");
                                        currentIndex = newIndex;
                                    }

                                    // Left navigation button
                                    leftNav.addEventListener("click", function() {
                                        const newIndex = (currentIndex - 1 + images.length) % images.length;
                                        updateCarousel(newIndex);
                                    });

                                    // Right navigation button
                                    rightNav.addEventListener("click", function() {
                                        const newIndex = (currentIndex + 1) % images.length;
                                        updateCarousel(newIndex);
                                    });

                                    // Image click event for modal
                                    carouselContainer.addEventListener("click", function(event) {
                                        if (event.target.classList.contains("carousel-image")) {
                                            const modal = document.getElementById("modalMenuItem");
                                            const modalImage = document.getElementById("modal-image");
                                            const modalName = document.getElementById("modal-name");
                                            const modalPrice = document.getElementById("modal-price");
                                            const modalDescription = document.getElementById("modal-description"); // Description element

                                            // Set the modal content
                                            const price = parseFloat(event.target.getAttribute("data-price"));
                                            const description = event.target.getAttribute("data-description"); // Fetch description

                                            modalImage.src = event.target.src;
                                            modalName.textContent = event.target.alt;

                                            // Show price only if greater than 0
                                            if (price > 0) {
                                                modalPrice.textContent = "Price: ₹" + price;
                                                modalPrice.style.display = 'block'; // Show price
                                            } else {
                                                modalPrice.style.display = 'none'; // Hide price if zero or less
                                            }

                                            // Set description content
                                            modalDescription.innerHTML = description || "No description available"; // Handle missing description

                                            // Display the modal
                                            modal.style.display = "flex"; // Changed from "block" to "flex" for centering
                                        }
                                    });

                                    // Close the modal
                                    document.querySelector(".close").addEventListener("click", function() {
                                        document.getElementById("modalMenuItem").style.display = "none";
                                    });

                                    // Close the modal when clicking outside of it
                                    window.addEventListener("click", function(event) {
                                        const modal = document.getElementById("modalMenuItem");
                                        if (event.target === modal) {
                                            modal.style.display = "none";
                                        }
                                    });
                                });
                            </script>




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

                                .menu-item-details {
                                    border: 1px solid #ddd;
                                    padding: 15px;
                                    border-radius: 5px;
                                    background-color: #f9f9f9;
                                    margin-top: 20px;
                                }

                                .rating-summary p {
                                    margin: 0;
                                    font-size: 14px;
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

                                .reviews-section p {
                                    font-size: 14px;
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

                            <div id="popup-overlay-{{ $menu_item['id'] }}" class="overlay popup-overlay" style="display: none;">
                                <div class="popup-form-container">



                                    <h5 style="
                                                        font-size: 16px;
                                                        font-weight: 700;
                                                    ">{{ $menu_item['name'] }}</h5>

                                    <div class="menu-item-details">
                                        <!-- Display Average Rating and Total Reviews -->
                                        <div class="rating-summary">
                                            <strong>
                                                <p>Average Rating: {{ $menu_item['average_rating'] }}</p>
                                            </strong>
                                            <strong>
                                                <p>Total Reviews: {{ $menu_item['total_reviews'] }}</p>
                                            </strong>
                                        </div>

                                        <!-- Display Each Review -->
                                        <div class="reviews-section">
                                            <p><strong>Customer Reviews:</strong></p>
                                            @if($menu_item['review']->isNotEmpty())
                                            @foreach($menu_item['review'] as $rating)
                                            <div class="review-item">
                                                <p> {{ $rating['review'] }}

                                                    @php
                                                    $ratingReview = round($rating['rating'] ); // Round the rating to the nearest integer
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <=$ratingReview)
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
                                                    <div class="sub-rating-title"><strong>{{ __('frontend.review') }}</strong>
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
                                                                color: #ccc;
                                                                /* Gray color for unselected stars */
                                                                font-size: 17px;
                                                                /* Adjust the size of the stars */
                                                                cursor: pointer;
                                                                transition: color 0.2s ease-in-out;
                                                            }

                                                            /* Change color for all stars from left to the selected one */
                                                            .leave-rating2 input[type="radio"]:checked~label {
                                                                color: #ccc;
                                                                /* Reset the color of unselected stars */
                                                            }

                                                            .leave-rating2 label:hover,
                                                            .leave-rating2 label:hover~label,
                                                            .leave-rating2 input[type="radio"]:checked~label,
                                                            .leave-rating2 input[type="radio"]:checked~label~label {
                                                                color: #ffcc00;
                                                                /* Yellow color for selected and hovered stars */
                                                            }

                                                            /* Change color for stars before the selected one */
                                                            .leave-rating2 label:hover~label {
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
                                            <div class="form-group mt-2 pt-2" style="border: 2px solid grey;
                                                                position: relative;
                                                                border-radius: 10px;
                                                                padding: 20px;
                                                                margin-bottom: 10px;">

                                                <textarea name="review" type="text" style="width:100%" rows="3" aria-label="With textarea" placeholder="{{ __('frontend.write_review') }}">{{ old('review') }}</textarea>
                                            </div>
                                            <button type="submit" class="rest-book-btn">{{ __('frontend.submit_review') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <div onclick="triggerLink(event, {{ $menu_item['id'] }})" class="product-card-content" id="product-card-{{ $menu_item['id'] }}">

                                @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime)
                                    <!-- <h4 class="product-card-title ">
                                    {{ \Illuminate\Support\Str::limit($menu_item['name'], 100) }}
                                    </h4> -->
                                    <h4 class="product-card-title "
                                        data-id="{{ optional($menu_item)['id'] }}"
                                        data-name="{{ $menu_item['name'] }}"
                                        data-price="{{ $menu_item['unit_price'] }}"
                                        data-description="{{ $menu_item['description'] }}"
                                        data-image="{{ optional($menu_item->media->first())['original_url'] }}">
                                        {{ \Illuminate\Support\Str::limit($menu_item['name'], 40) }}
                                    </h4>
                                    @else
                                    <!-- <a href="#variation-{{ $menu_item['id'] }}" wire:click.prevent="addToCartModal({{ $menu_item['id'] }})" id="link-{{ $menu_item['id'] }}" style="display: none;"></a> -->
                                    <!-- <h4 class="product-card-title">
                                        {{ \Illuminate\Support\Str::limit($menu_item['name'], 100) }}
                                    </h4> -->
                                    <h4 class="product-card-title "
                                        data-id="{{ optional($menu_item)['id'] }}"
                                        data-name="{{ $menu_item['name'] }}"
                                        data-price="{{ $menu_item['unit_price'] }}"
                                        data-description="{{ $menu_item['description'] }}"
                                        data-image="{{ optional($menu_item->media->first())['original_url'] }}">
                                        {{ \Illuminate\Support\Str::limit($menu_item['name'], 40) }}
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
                                            @if ($i <=$rating)
                                            <label class="fa fa-star" style="color: orange;"></label>
                                            @else
                                            <label class="fa fa-star" style="color: #ccc;"></label> <!-- Gray out the stars not filled -->
                                            @endif
                                            @endfor
                                            <p class="totalReview">{{ $menu_item['total_reviews'] }}</p>

                                    </div>

                                    <style>
                                        .totalReview {
                                            justify-content: center;
                                            font-weight: 1000;
                                            width: 22px;
                                            height: 20px;
                                            background-color: #e86121;
                                            border-radius: 50%;
                                            color: white;
                                            display: flex;
                                            align-items: center;

                                        }
                                    </style>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            // Get all the product names
                                            const productNames = document.querySelectorAll('.product-card-title');

                                            // Add click event listeners to product names
                                            productNames.forEach(function(productName) {
                                                productName.addEventListener('click', function() {
                                                    const modal = document.getElementById("modalMenuItem");
                                                    const modalImage = document.getElementById("modal-image");
                                                    const modalName = document.getElementById("modal-name");
                                                    const modalPrice = document.getElementById("modal-price");
                                                    const modalDescription = document.getElementById("modal-description");

                                                    // Set modal content from clicked product details
                                                    const name = productName.getAttribute("data-name");
                                                    const price = parseFloat(productName.getAttribute("data-price")); // Convert price to a float
                                                    const description = productName.getAttribute("data-description");
                                                    const image = productName.getAttribute("data-image");

                                                    modalImage.src = image;
                                                    modalName.textContent = name;

                                                    // Show price only if greater than 0
                                                    if (price > 0) {
                                                        modalPrice.textContent = "Price: ₹" + price;
                                                        modalPrice.style.display = 'block'; // Make sure the price is visible
                                                    } else {
                                                        modalPrice.style.display = 'none'; // Hide the price if it's 0 or less
                                                    }

                                                    modalDescription.innerHTML = description;

                                                    // Display the modal
                                                    modal.style.display = "flex";
                                                });
                                            });

                                            // Close the modal
                                            document.querySelector(".close").addEventListener("click", function() {
                                                document.getElementById("modalMenuItem").style.display = "none";
                                            });

                                            // Close the modal when clicking outside of it
                                            window.addEventListener("click", function(event) {
                                                const modal = document.getElementById("modalMenuItem");
                                                if (event.target === modal) {
                                                    modal.style.display = "none";
                                                }
                                            });
                                        });


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
                                            @if ($menu_item['unit_price'] > 0)
                                            @if ($menu_item['discount_price'] > 0)
                                            <del>
                                                ₹{{ $menu_item['unit_price'] }}
                                            </del>
                                            <span>
                                                ₹{{ $menu_item['unit_price'] - $menu_item['discount_price'] }}
                                            </span>
                                            @else
                                            <span>
                                                ₹{{ $menu_item['unit_price'] }}
                                            </span>
                                            @endif
                                            @endif
                                        </div>

                                        @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime)
                                            <!-- Closed button logic here -->
                                            @else
                                            <!-- Add to cart button logic here -->
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
                            <div onclick="triggerLink(event, {{ optional($menu_item)['id'] }})" class="product-card-content">
                                @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime)
                                    <h4 class="product-card-title showClosedNotification">
                                    {{ \Illuminate\Support\Str::limit($menu_item['name'], 40) }}
                                    </h4>
                                    @else
                                    <a href="#variation-{{optional($menu_item)['id'] }}"
                                        wire:click.prevent="addToCartModal({{ optional($menu_item)['id'] }})">
                                        <h4 class="product-card-title">
                                            {{ \Illuminate\Support\Str::limit($other_product['name'], ) }}
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
                                            <!-- <a href="#variation-{{ $other_product['id'] }}"
                                                    wire:key="{{ $other_product['id'] }}" class="product-card-add"
                                                    wire:click.prevent="addToCartModal({{ $other_product['id'] }})">
                                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.6433 5.22689C11.2525 4.79523 10.6633 4.54439 9.84668 4.45689V4.01356C9.84668 3.21439 9.50835 2.44439 8.91335 1.90773C8.31251 1.35939 7.53085 1.10273 6.72001 1.17856C5.32585 1.31273 4.15335 2.66023 4.15335 4.11856V4.45689C3.33668 4.54439 2.74751 4.79523 2.35668 5.22689C1.79085 5.85689 1.80835 6.69689 1.87251 7.28023L2.28085 10.5294C2.40335 11.6669 2.86418 12.8336 5.37251 12.8336H8.62751C11.1358 12.8336 11.5967 11.6669 11.7192 10.5352L12.1275 7.27439C12.1917 6.69689 12.2033 5.85689 11.6433 5.22689ZM6.80168 1.98939C7.38501 1.93689 7.93918 2.11773 8.37085 2.50856C8.79668 2.89356 9.03585 3.44189 9.03585 4.01356V4.42189H4.96418V4.11856C4.96418 3.08023 5.82168 2.08273 6.80168 1.98939ZM4.91168 7.67106H4.90585C4.58501 7.67106 4.32251 7.40856 4.32251 7.08773C4.32251 6.76689 4.58501 6.50439 4.90585 6.50439C5.23251 6.50439 5.49501 6.76689 5.49501 7.08773C5.49501 7.40856 5.23251 7.67106 4.91168 7.67106ZM8.99501 7.67106H8.98918C8.66835 7.67106 8.40585 7.40856 8.40585 7.08773C8.40585 6.76689 8.66835 6.50439 8.98918 6.50439C9.31585 6.50439 9.57835 6.76689 9.57835 7.08773C9.57835 7.40856 9.31585 7.67106 8.99501 7.67106Z" />
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
                item.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
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