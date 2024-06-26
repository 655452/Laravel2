<div>

    @if (!blank($carts))
        <!--~~~~~~ WHEN CART IS ORDER CODE START ~~~~~~~~-->
        <h2 class="cart-title">{{ __('frontend.mycart') }}
            (<span class="cartCount" id="carTNumber">
               @if (!blank(session()->get('cart')))
                    {{ session()->get('cart')['totalQty'] }}
                @else
                    0
                @endif
            </span>)
        </h2>

        <div class="cart-scroll-group">
            <div class="d-flex justify-content-center aligjn-items-center mt-3 mb-3">
                @if (
                    $restaurant->pickup_status == \App\Enums\Status::ACTIVE &&
                        $restaurant->delivery_status == \App\Enums\Status::ACTIVE)
                  <div class="deliver_type my_toggle">
                    <div class="d_delivery{{ $isActive ? '' : ' active' }}">
                        {{ __('frontend.delivery') }}
                    </div>
                    <div class="delivery_toglle">
                        <label class="switch" style="color: #f91942 !important">
                            <input type="checkbox" wire:model="isActive" wire:click="isUpdating"
                                {{ !blank($delivery_type) && $delivery_type == \App\Enums\DeliveryType::PICKUP ? 'checked' : '' }}>
                            <span class="slider slider-color btn-top round"></span>
                        </label>
                    </div>
                    <div class="d_pickup{{ $isActive ? ' active' : '' }}">
                        {{ __('frontend.pickup') }}
                    </div>
                </div>

                @elseif(
                    $restaurant->delivery_status == \App\Enums\Status::INACTIVE &&
                        $restaurant->pickup_status == \App\Enums\Status::ACTIVE)
                    <p class="delivery_status m-0 fw-semibold">{{ __('frontend.only_pickup') }}</p>
                @elseif(
                    $restaurant->pickup_status == \App\Enums\Status::INACTIVE &&
                        $restaurant->delivery_status == \App\Enums\Status::ACTIVE)
                    <p class="delivery_status m-0  fw-semibold">{{ __('frontend.only_delivery') }}</p>
                @endif
            </div>

            <h3
                class="cart-heading {{ $restaurant->delivery_status == \App\Enums\Status::INACTIVE || $restaurant->pickup_status == \App\Enums\Status::INACTIVE ? 'mt-0' : '' }} ">
                {{ __('frontend.your_order_from') . ' ' . \Illuminate\Support\Str::limit($restaurant->name, 26) }}
            </h3>

            <ul class="cart-list">

                @foreach ($carts['items'] as $key => $content)
                    <li class="cart-item">
                        <button class="cart-delete"  wire:key="{{ $key }}" wire:click.prevent="removeItem('{{ $key }}')"
                            type="button">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.0466 3.48634C12.9733 3.37967 11.8999 3.29967 10.8199 3.23967V3.23301L10.6733 2.36634C10.5733 1.75301 10.4266 0.833008 8.86661 0.833008H7.11994C5.56661 0.833008 5.41994 1.71301 5.31328 2.35967L5.17328 3.21301C4.55328 3.25301 3.93328 3.29301 3.31328 3.35301L1.95328 3.48634C1.67328 3.51301 1.47328 3.75967 1.49994 4.03301C1.52661 4.30634 1.76661 4.50634 2.04661 4.47967L3.40661 4.34634C6.89994 3.99967 10.4199 4.13301 13.9533 4.48634C13.9733 4.48634 13.9866 4.48634 14.0066 4.48634C14.2599 4.48634 14.4799 4.29301 14.5066 4.03301C14.5266 3.75967 14.3266 3.51301 14.0466 3.48634Z"
                                    fill="#E93C3C" />
                                <path
                                    d="M12.8199 5.42699C12.6599 5.26033 12.4399 5.16699 12.2132 5.16699H3.78658C3.55991 5.16699 3.33325 5.26033 3.17991 5.42699C3.02658 5.59366 2.93991 5.82033 2.95325 6.05366L3.36658 12.8937C3.43991 13.907 3.53325 15.1737 5.85991 15.1737H10.1399C12.4666 15.1737 12.5599 13.9137 12.6332 12.8937L13.0466 6.06033C13.0599 5.82033 12.9732 5.59366 12.8199 5.42699ZM9.10658 11.8337H6.88658C6.61325 11.8337 6.38658 11.607 6.38658 11.3337C6.38658 11.0603 6.61325 10.8337 6.88658 10.8337H9.10658C9.37991 10.8337 9.60658 11.0603 9.60658 11.3337C9.60658 11.607 9.37991 11.8337 9.10658 11.8337ZM9.66658 9.16699H6.33325C6.05991 9.16699 5.83325 8.94033 5.83325 8.66699C5.83325 8.39366 6.05991 8.16699 6.33325 8.16699H9.66658C9.93991 8.16699 10.1666 8.39366 10.1666 8.66699C10.1666 8.94033 9.93991 9.16699 9.66658 9.16699Z"
                                    fill="#E93C3C" />
                            </svg>
                        </button>

                        <div class="cart-meta-group">
                            <h4 class="cart-name">
                                {{ $content['name'] }}
                            </h4>
                            @if (isset($content['variation']['name']) && isset($content['variation']['price']))
                                <h5 class="cart-size">{{ $content['variation']['name'] }} </h5>
                            @endif
                            @if (!blank($content['options']))
                                @foreach ($content['options'] as $option)
                                    <h6 class="cart-extra pt-2" wire:key="{{ $option['id'] }}">+ {{ $option['name'] }}</h6>
                                @endforeach
                            @endif
                        </div>
                        <div class="cart-action-group">
                            <h5 class="cart-price"> {{ setting('currency_code') }}{{ $content['totalPrice'] }} </h5>

                            <div class="cart-counter">
                                <button wire:click.prevent="removeItemQty('{{ $key }}')"
                                    class="fa-solid fa-minus cart-counter-minus"></button>
                                <input type="number" step=".01" wire:model="carts.items.{{ $key }}.qty"
                                    id="carts.items.{{ $key }}.qty" class="cart-counter-value"
                                    wire:keyup="changeEvent('{{ $key }}')" value="{{ $content['qty'] }}"
                                    min="1" max="99">
                                <button wire:click.prevent="addItemQty('{{ $key }}')"
                                    class="fa-solid fa-plus cart-counter-plus"></button>
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
            <div class="cart-price-group">
                @if (Schema::hasColumn('coupons', 'slug'))
                    <div class="cart-coupon m-0">
                        <input wire:ignore wire:key="coupon" type="text" wire:model="coupon"
                            placeholder="{{ __('frontend.apply_coupon') }}">
                        <button wire:click.prevent="addCoupon()">{{ __('frontend.apply') }}</button>
                    </div>
                    <span class="coupon-message fs-12 text-danger d-block mb-3 mt-2">{{ $msg }}</span>
                @endif

                <ul class="cart-amount-list">
                    <li class="cart-amount-item">
                        <span>{{ __('frontend.subtotal') }}</span>
                        <span>{{ setting('currency_code') }}{{ $subTotalAmount }}</span>
                    </li>

                    @if ($delivery_type == \App\Enums\DeliveryType::DELIVERY)
                        <li class="cart-amount-item">
                            <span>{{ __('frontend.delivery_charge') }}</span>
                            @if (setting('free_delivery') == 1 && $branch->postalCode()->max_order <= $subTotalAmount)
                                <span> {{ __('levels.free') }}</span>
                            @else
                                <span>{{ setting('currency_code') }}{{ $delivery_charge }}</span>
                            @endif
                        </li>
                    @endif

                    @if (Schema::hasColumn('coupons', 'slug'))
                        <li class="cart-amount-item">
                            <span>{{ __('frontend.discount') }}</span>
                            <span>{{ setting('currency_code') }}{{ $discountAmount }} </span>
                        </li>
                    @endif

                    <li class="cart-amount-item">
                        <span>{{ __('frontend.total') }}</span>
                        <span>{{ setting('currency_code') }}{{ $totalPayAmount }} </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="cart-amount-btn-div">
            <a href="{{ route('checkout.index') }}"
                class="cart-amount-btn @if (!blank($carts) && !blank($carts['items']) && $isActiveCheckout) btn-checkout @else btn-checkout-disabled @endif"
                @if (!blank($carts) && !blank($carts['items']) && $isActiveCheckout) onclick="return true;"
            @else onclick="return false;" @endif>
                {{ __('frontend.proceed_checkout') }}
            </a>



        </div>
        <!--~~~~~~  WHEN CART IS ORDER CODE END ~~~~~~~~~~~~-->
    @else
        <!--~~~~~  WHEN CART IS EMPTY CODE START ~~~~~~-->
        <div class="cart-empty">
            <h2 class="cart-title">{{ __('frontend.mycart') }}
                (<span class="cartCount" id="carTNumber">
                    @if (!blank(session()->get('cart')))
                        {{ session()->get('cart')['totalQty'] }}
                    @else
                        0
                    @endif
                </span>)
            </h2>
            <img src="{{ asset('frontend/images/gif/empty.gif') }}" alt="gif">
            <p> {{ __('frontend.cart_description') }} </p>
        </div>
        <!--~~~~ WHEN CART IS EMPTY CODE END ~~~~~~-->
    @endif
</div>
