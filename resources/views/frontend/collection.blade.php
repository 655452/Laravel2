@extends('frontend.layouts.app')

@section('main-content')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #e86121;
            text-align: center;
            margin-bottom: 30px;
        }

        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .filters label {
            margin-right: 10px;
            font-weight: bold;
        }

        .filters select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .card {
            border: 1px solid #ddd;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: grid;
            grid-template-columns: 1fr 2fr;
            align-items: center;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-img-container {
            height: 20vh;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .card-body {
            padding: 10px;
            font-size: 14px;
        }

        .card-title {
            font-size: 14px;
            color: black;
            margin-bottom: 10px;
        }

        .card-text {
            margin-bottom: 5px;
            font-size: 12px;
            color: var(--text);
        }

        .btn {
            background-color: #e86121;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            display: block;
            margin: 0 auto;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #d4541b;
        }

        .carousel {
            position: relative;
            width: 100%;
            overflow: hidden;
            height: 100%;
        }

        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: none;
        }

        .carousel img.active {
            display: block;
        }

        .carousel-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .carousel-prev, .carousel-next {
            width: 30px;
            background: rgba(0, 0, 0, 0.2);
            color: white;
            padding: 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .stars {
            display: flex;
        }

        .stars i {
            color: #FFD700;
            font-size: 14px;
            margin-right: 2px;
        }

        .wrap-card {
            width: 100%;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        @media (max-width: 768px) {
            .card-img-container {
            height: 25vh;
        }
            .card {
                grid-template-columns: 1fr;
            }

            .row {
                gap: 0px;
                grid-template-columns: 1fr 1fr;
            }
            .row>* {
                padding-right:0px;
                padding-left:0px;
            }
        }

   
        /* filters section */
        .filters {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f7f7f7;
    margin-bottom: 20px;
}

.filters div {
    flex: 1 1 30%; /* Each filter will take 30% of the width on larger screens */
    max-width: 300px; /* Limit the maximum width */
}

.filters label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

.filters select {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 25px;
    background-color: white;
    color: #333;
    transition: all 0.3s ease;
    appearance: none; /* Remove default arrow */
    background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23333" d="M2 0L0 2h4z"/></svg>'); /* Custom dropdown arrow */
    background-repeat: no-repeat;
    background-position: right 10px top 50%;
    background-size: 10px;
}

.filters select:focus, .filters select:hover {
    border-color: #e86121;
    background-color: #ffe4d1; /* Light orange background on focus */
    outline: none;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
}

.filters select option:checked {
    background-color: #e86121; /* Orange background for selected option */
    color: white; /* White text for selected option */
}
@media (max-width: 768px) {
    .filters {
        flex-direction: column;
        align-items: flex-start;
        display: none; /* Hide filters on mobile by default */
    }

    .filters.show { 
        display: flex; /* Show filters when the button is clicked */
    }

    .filters div {
        width: 100%; /* Full width for filters on mobile */
    }
}

#filter-toggle-button {
    display: none;
    background-color: #e86121;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    border: none;
    cursor: pointer;
    
}

#filter-toggle-button:hover {
    background-color: #d4541b;
}
.filters select {
    /* Other styles */
    background-color: white;  /* Change background color of the dropdown */
    color: #333;  /* Text color */
}

.filters select option {
    background-color: white;  /* Default background for options */
    color: #333;  /* Text color for options */
}

.filters select option:hover,
.filters select option:focus {
    background-color: #ffe4d1; /* Light orange on hover */
    color: #e86121;  /* Orange text on hover */
}

@media (max-width: 768px) {
    #filter-toggle-button {
        display: block; /* Show filter button only on mobile */
        width: 50%; /* Full width for button on mobile */
        margin-bottom: 20px;
    }
}


    </style>

    <div class="container">
        <h1 style="margin-top: 20px;">Menu Collection</h1>
        
        <!-- Filters Section -->
        
    <!-- Toggle Button for Filters on Mobile -->
    <button id="filter-toggle-button">Show Filters</button>
    
    <!-- Filters Section -->
    <div class="filters" id="filters-box">
        <!-- Category Filter -->
        <div class="filter-category">
            <label for="category-filter">Filter by Category:</label>
            <select id="category-filter">
                <option value="all">All</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Price Filter -->
        <div class="filter-price">
            <label for="price-filter">Filter by Price:</label>
            <select id="price-filter">
                <option value="all">All</option>
                <option value="0-100">₹0 - ₹100</option>
                <option value="0-500">₹0 - ₹500</option>
                <option value="0-1000">₹0 - ₹1000</option>
                <option value="1000-10000">₹1000 - ₹10000</option>
            </select>
        </div>

        <!-- Rating Filter -->
        <div class="filter-rating">
            <label for="rating-filter">Filter by Rating:</label>
            <select id="rating-filter">
                <option value="all">All</option>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
        </div>
    </div>

        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif

        <div class="row" id="menu-list">
            @foreach ($menuItems as $menuItem)
            <script>
                console.log("{{$menuItem}}")
            </script>
            
                <div class="wrap-card menu-item" 
                     data-price="{{ $menuItem->unit_price }}" 
                     data-rating="{{ $menuItem->average_rating }}"
                     data-category="{{ $menuItem->categories->pluck('id')->implode(',') }}"> <!-- Handle multiple categories -->
                    
                    <div class="card h-100">
                        <div class="card-img-container">
                            @if($menuItem->media && $menuItem->media->isNotEmpty())
                                <div class="carousel" id="carousel-{{ $menuItem->id }}">
                                    @foreach ($menuItem->media as $key => $media)
                                        <img src="{{ $media['original_url'] }}" alt="{{ $media['file_name'] }}" class="{{ $key == 0 ? 'active' : '' }}">
                                    @endforeach
                                    <div class="carousel-controls">
                                        <div class="carousel-prev" onclick="prevSlide('carousel-{{ $menuItem->id }}')">&#10094;</div>
                                        <div class="carousel-next" onclick="nextSlide('carousel-{{ $menuItem->id }}')">&#10095;</div>
                                    </div>
                                </div>
                            @else
                                <img src="/path/to/default-image.jpg" class="card-img-top" alt="Default Image">
                            @endif
                        </div>
                        <a href="{{ route('restaurant.show', [$menuItem->restaurant->slug]) }}" >
                        <div class="card-body">
                            <h5 class="card-title">{{ $menuItem->name }}</h5>
                            <p class="card-text">{!! \Illuminate\Support\Str::limit(strip_tags($menuItem['description']), 40) !!}</p>
                            <p class="card-text">
                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= $menuItem->average_rating ? '#FFD700' : '#D3D3D3' }};"></i>
                                    @endfor
                                    <p style="background-color: #d4541b; border-radius:20px; width:20px; height:20px; text-align:center; color:white; font-weight:500;">{{ $menuItem->total_reviews }}</p>
                                </div>
                            </p>
                            @if($menuItem->unit_price > 0)
    <p class="card-text">Price: <strong>₹{{ number_format($menuItem->unit_price, 2) }}</strong></p>
@endif

                        </div>
                        </a>
                    </div>

                
                </div>
            @endforeach
        </div>
    </div>

    <script>
    // JavaScript for Carousel remains unchanged

    // Filtering Functionality remains unchanged

    // Toggle filter box on mobile
    document.getElementById('filter-toggle-button').addEventListener('click', function() {
        const filterBox = document.getElementById('filters-box');
        filterBox.classList.toggle('show');

        if (filterBox.classList.contains('show')) {
            this.textContent = 'Hide Filters';
        } else {
            this.textContent = 'Show Filters';
        }
    });
</script>

    <script>
        // JavaScript for Carousel
        function nextSlide(carouselId) {
            const carousel = document.getElementById(carouselId);
            const images = carousel.querySelectorAll('img');
            let activeIndex = [...images].findIndex(img => img.classList.contains('active'));

            images[activeIndex].classList.remove('active');
            activeIndex = (activeIndex + 1) % images.length;
            images[activeIndex].classList.add('active');
        }

        function prevSlide(carouselId) {
            const carousel = document.getElementById(carouselId);
            const images = carousel.querySelectorAll('img');
            let activeIndex = [...images].findIndex(img => img.classList.contains('active'));

            images[activeIndex].classList.remove('active');
            activeIndex = (activeIndex - 1 + images.length) % images.length;
            images[activeIndex].classList.add('active');
        }

        // Filtering Functionality
        document.getElementById('category-filter').addEventListener('change', filterMenu);
        document.getElementById('price-filter').addEventListener('change', filterMenu);
        document.getElementById('rating-filter').addEventListener('change', filterMenu);

        function filterMenu() {
            const categoryFilter = document.getElementById('category-filter').value;
            const priceFilter = document.getElementById('price-filter').value;
            const ratingFilter = document.getElementById('rating-filter').value;

            const menuItems = document.querySelectorAll('.menu-item');

            menuItems.forEach(item => {
                const itemPrice = parseFloat(item.getAttribute('data-price'));
                const itemRating = parseFloat(item.getAttribute('data-rating'));
                const itemCategories = item.getAttribute('data-category').split(',');

                // Filter by category
                let categoryMatch = categoryFilter === 'all' || itemCategories.includes(categoryFilter);

                // Filter by price
                let priceMatch = false;
                if (priceFilter === 'all') {
                    priceMatch = true;
                } else {
                    const [minPrice, maxPrice] = priceFilter.split('-').map(Number);
                    console.log("minPrice,maxPrice")
                    console.log(minPrice,maxPrice)
                    priceMatch = itemPrice >= minPrice && itemPrice <= maxPrice;
                }

                // Filter by rating
                let ratingMatch = ratingFilter === 'all' || itemRating >= ratingFilter;

                // Display or hide the item based on all filters
                if (categoryMatch && priceMatch && ratingMatch) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
@endsection
