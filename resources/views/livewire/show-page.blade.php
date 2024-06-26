<div class="">

    @php
        $currenttime = \Carbon\Carbon::now()->format('H:i:s');
    @endphp
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
                                    <div class="col-md-6 " wire:key="{{ $menu_item['id'] }}">
                                        <div class="product-card">
                                            <figure
                                                class="product-card-media d-flex justify-content-center align-items-center">

                                                <img data-src="{{ $menu_item['image'] }}" class="lazy" alt="product">

                                                <div class="loader-container">
                                                    <img src="{{ asset('frontend/images/default/loader.gif') }}"
                                                        class="loader" alt="loading">
                                                </div>
                                            </figure>

                                            <div class="product-card-content">

                                                @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime)
                                                    <h4 class="product-card-title showClosedNotification">
                                                        {{ \Illuminate\Support\Str::limit($menu_item['name'], 20) }}
                                                    </h4>
                                                @else
                                                    <a href="#variation-{{ $menu_item['id'] }}"
                                                        wire:click.prevent="addToCartModal({{ $menu_item['id'] }})">
                                                        <h4 class="product-card-title">
                                                            {{ \Illuminate\Support\Str::limit($menu_item['name'], 20) }}
                                                        </h4>
                                                    </a>
                                                @endif

                                                <p class="product-card-text">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($menu_item['description']), 70) !!}
                                                </p>

                                                <div class="product-card-info">
                                                    <div class="product-card-price">
                                                        @if ($menu_item['discount_price'] > 0)
                                                            <del>{{ setting('currency_code') }}{{ $menu_item['unit_price'] }}
                                                            </del>
                                                            <span>
                                                                {{ setting('currency_code') }}{{ $menu_item['unit_price'] - $menu_item['discount_price'] }}
                                                            </span>
                                                        @else
                                                            <span>
                                                                {{ setting('currency_code') }}{{ $menu_item['unit_price'] - $menu_item['discount_price'] }}
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
                                                        <a href="#variation-{{ $menu_item['id'] }}"
                                                            wire:key="{{ $menu_item['id'] }}" class="product-card-add"
                                                            wire:click.prevent="addToCartModal({{ $menu_item['id'] }})">
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
                                    <div class="product-card-content">
                                        @if ($restaurant->opening_time > $currenttime || $restaurant->closing_time < $currenttime)
                                            <h4 class="product-card-title showClosedNotification">
                                                {{ \Illuminate\Support\Str::limit($menu_item['name'], 20) }}
                                            </h4>
                                        @else
                                            <a href="#variation-{{ $menu_item['id'] }}"
                                                wire:click.prevent="addToCartModal({{ $menu_item['id'] }})">
                                                <h4 class="product-card-title">
                                                    {{ \Illuminate\Support\Str::limit($menu_item['name'], 20) }}
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
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
