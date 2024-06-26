@extends('frontend.layouts.app')

@push('meta')
    <meta property="og:url" content="{{ route('checkout.index') }}">
    <meta property="og:type" content="Foodbank">
    <meta property="og:title" content="{{ setting('banner_title') }}">
    <meta property="og:description" content="Explore top-rated attractions, activities and more">
    <meta property="og:image" content="{{ asset('images/' . setting('site_logo')) }}">
@endpush

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/lib/inttelinput/css/intlTelInput.css') }}">
@endpush


@section('main-content')

    <!--=========  CHECKOUT PART Start =========-->
    <section class="checkout">
        <div class="container">

            <a href="#" class="booking-paginate">
                <i class="fa-solid fa-arrow-left"></i>
                <span>{{ __('frontend.checkout') }}</span>
            </a>

            <form id="payment-form" action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="checkout-group">
                    <div class="checkout-delivery">
                        <div class="checkout-card">
                            @if (!session()->get('cart')['delivery_type'])

                                <div class="checkout-card-head">
                                    <h3>{{ __('frontend.delivery_address') }}</h3>
                                    <button type="button" data-bs-toggle="modal" id="add-new"
                                        data-bs-target="#address-modal" data-attr="{{ route('address.store') }}">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.00016 1.33301C4.32683 1.33301 1.3335 4.32634 1.3335 7.99967C1.3335 11.673 4.32683 14.6663 8.00016 14.6663C11.6735 14.6663 14.6668 11.673 14.6668 7.99967C14.6668 4.32634 11.6735 1.33301 8.00016 1.33301ZM10.6668 8.49967H8.50016V10.6663C8.50016 10.9397 8.2735 11.1663 8.00016 11.1663C7.72683 11.1663 7.50016 10.9397 7.50016 10.6663V8.49967H5.3335C5.06016 8.49967 4.8335 8.27301 4.8335 7.99967C4.8335 7.72634 5.06016 7.49967 5.3335 7.49967H7.50016V5.33301C7.50016 5.05967 7.72683 4.83301 8.00016 4.83301C8.2735 4.83301 8.50016 5.05967 8.50016 5.33301V7.49967H10.6668C10.9402 7.49967 11.1668 7.72634 11.1668 7.99967C11.1668 8.27301 10.9402 8.49967 10.6668 8.49967Z" />
                                        </svg>
                                        <span>{{ __('levels.add_new_address') }} </span>
                                    </button>
                                </div>

                                <div class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <fieldset class="checkout-fieldset">
                                    @if (!blank($lastAddress))
                                        <label class="checkout-label" for="address">
                                            <input type="radio" value="{{ $lastAddress->id }}" class="form-radio"
                                                onChange="deliveryAddress({{ $lastAddress->latitude }},{{ $lastAddress->longitude }})"
                                                checked name="address" id="address">
                                            <dl>
                                                <dt> {{ $lastAddress->label != \App\Enums\AddressType::OTHER
                                                    ? trans('address_types.' . $lastAddress->label)
                                                    : $lastAddress->label_name }}
                                                </dt>
                                                <dd>
                                                    {{ $lastAddress->address }}
                                                </dd>
                                                <dd>
                                                    {{ __('levels.apartment') }} : {{ $lastAddress->apartment }}
                                                </dd>
                                            </dl>
                                            <div>
                                                <a id="edit{{ $lastAddress->id }}"
                                                    onclick="editBtn('{{ $lastAddress->id }}')" data-bs-toggle="modal"
                                                    data-bs-target="#address-modal" class="action-btn mr-3"
                                                    data-url="{{ route('address.edit', $lastAddress->id) }}"
                                                    data-attr="{{ route('address.update', $lastAddress->id) }}">

                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M4.25093 11.3519L10.1085 3.77696C10.4269 3.36847 10.5401 2.8962 10.4339 2.41533C10.342 1.97817 10.0731 1.56251 9.66991 1.24719L8.68657 0.466042C7.83057 -0.214774 6.76941 -0.143109 6.16102 0.638038L5.5031 1.49157C5.41821 1.59835 5.43943 1.75601 5.54554 1.84201C5.54554 1.84201 7.20802 3.17497 7.2434 3.20364C7.35659 3.31114 7.44148 3.45447 7.4627 3.62646C7.49807 3.96329 7.26462 4.27861 6.91797 4.32161C6.75526 4.34311 6.59963 4.29295 6.48644 4.19978L4.73906 2.80948C4.65417 2.7457 4.52683 2.75932 4.45609 2.84532L0.303426 8.22018C0.034599 8.55701 -0.057368 8.99416 0.034599 9.41698L0.565178 11.7174C0.593475 11.8393 0.699591 11.9253 0.82693 11.9253L3.16148 11.8966C3.58594 11.8894 3.98211 11.6959 4.25093 11.3519ZM7.51979 10.6355H11.3265C11.6979 10.6355 12 10.9415 12 11.3178C12 11.6947 11.6979 12 11.3265 12H7.51979C7.14839 12 6.84631 11.6947 6.84631 11.3178C6.84631 10.9415 7.14839 10.6355 7.51979 10.6355Z"
                                                            fill="#EE1D48" />
                                                    </svg>
                                                </a>

                                                <a id="delete{{ $lastAddress->id }}"
                                                    onclick="deleteBtn(this,'{{ $lastAddress->id }}')"
                                                    data-url="{{ route('address.delete', $lastAddress->id) }}"
                                                    class="action-btn">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14.0466 3.48634C12.9733 3.37967 11.8999 3.29967 10.8199 3.23967V3.23301L10.6733 2.36634C10.5733 1.75301 10.4266 0.833008 8.86661 0.833008H7.11994C5.56661 0.833008 5.41994 1.71301 5.31328 2.35967L5.17328 3.21301C4.55328 3.25301 3.93328 3.29301 3.31328 3.35301L1.95328 3.48634C1.67328 3.51301 1.47328 3.75967 1.49994 4.03301C1.52661 4.30634 1.76661 4.50634 2.04661 4.47967L3.40661 4.34634C6.89994 3.99967 10.4199 4.13301 13.9533 4.48634C13.9733 4.48634 13.9866 4.48634 14.0066 4.48634C14.2599 4.48634 14.4799 4.29301 14.5066 4.03301C14.5266 3.75967 14.3266 3.51301 14.0466 3.48634Z"
                                                            fill="#E93C3C" />
                                                        <path
                                                            d="M12.8202 5.42699C12.6602 5.26033 12.4402 5.16699 12.2135 5.16699H3.78683C3.56016 5.16699 3.33349 5.26033 3.18016 5.42699C3.02683 5.59366 2.94016 5.82033 2.95349 6.05366L3.36683 12.8937C3.44016 13.907 3.53349 15.1737 5.86016 15.1737H10.1402C12.4668 15.1737 12.5602 13.9137 12.6335 12.8937L13.0468 6.06033C13.0602 5.82033 12.9735 5.59366 12.8202 5.42699ZM9.10682 11.8337H6.88683C6.61349 11.8337 6.38683 11.607 6.38683 11.3337C6.38683 11.0603 6.61349 10.8337 6.88683 10.8337H9.10682C9.38016 10.8337 9.60682 11.0603 9.60682 11.3337C9.60682 11.607 9.38016 11.8337 9.10682 11.8337ZM9.66683 9.16699H6.33349C6.06016 9.16699 5.83349 8.94033 5.83349 8.66699C5.83349 8.39366 6.06016 8.16699 6.33349 8.16699H9.66683C9.94016 8.16699 10.1668 8.39366 10.1668 8.66699C10.1668 8.94033 9.94016 9.16699 9.66683 9.16699Z"
                                                            fill="#E93C3C" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </label>
                                    @endif
                                    <button type="button" id="moreAddressShow" class="checkout-morebtn">
                                        <span>{{ __('frontend.show_more') }} </span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    @if (count($addresses) > 1)
                                        @foreach ($addresses as $address)
                                            @if ($address->id != (isset($lastAddress) ? $lastAddress->id : 0))
                                                <div class="moreAddress hide">
                                                    <label class="checkout-label" for="{{ $address->id }}">
                                                        <input type="radio" class="form-radio"
                                                            onChange="deliveryAddress({{ $address->latitude }},{{ $address->longitude }})"
                                                            value="{{ $address->id }}" name="address" id="{{ $address->id }}">
                                                        <dl>
                                                            <dt>{{ $address->label != \App\Enums\AddressType::OTHER
                                                                ? trans('address_types.' . $address->label)
                                                                : $address->label_name }}
                                                            </dt>
                                                            <dd> {{ $address->address }} </dd>
                                                            <dd> {{ __('levels.apartment') }} :
                                                                {{ $address->apartment }} </dd>
                                                        </dl>
                                                        <div>
                                                            <a id="edit{{ $address->id }}"
                                                                onclick="editBtn('{{ $address->id }}')"
                                                                data-bs-toggle="modal" data-bs-target="#address-modal"
                                                                class="action-btn mr-3"
                                                                data-url="{{ route('address.edit', $address->id) }}"
                                                                data-attr="{{ route('address.update', $address->id) }}">

                                                                <svg width="12" height="12" viewBox="0 0 12 12"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M4.25093 11.3519L10.1085 3.77696C10.4269 3.36847 10.5401 2.8962 10.4339 2.41533C10.342 1.97817 10.0731 1.56251 9.66991 1.24719L8.68657 0.466042C7.83057 -0.214774 6.76941 -0.143109 6.16102 0.638038L5.5031 1.49157C5.41821 1.59835 5.43943 1.75601 5.54554 1.84201C5.54554 1.84201 7.20802 3.17497 7.2434 3.20364C7.35659 3.31114 7.44148 3.45447 7.4627 3.62646C7.49807 3.96329 7.26462 4.27861 6.91797 4.32161C6.75526 4.34311 6.59963 4.29295 6.48644 4.19978L4.73906 2.80948C4.65417 2.7457 4.52683 2.75932 4.45609 2.84532L0.303426 8.22018C0.034599 8.55701 -0.057368 8.99416 0.034599 9.41698L0.565178 11.7174C0.593475 11.8393 0.699591 11.9253 0.82693 11.9253L3.16148 11.8966C3.58594 11.8894 3.98211 11.6959 4.25093 11.3519ZM7.51979 10.6355H11.3265C11.6979 10.6355 12 10.9415 12 11.3178C12 11.6947 11.6979 12 11.3265 12H7.51979C7.14839 12 6.84631 11.6947 6.84631 11.3178C6.84631 10.9415 7.14839 10.6355 7.51979 10.6355Z"
                                                                        fill="#EE1D48" />
                                                                </svg>
                                                            </a>

                                                            <a id="delete{{ $address->id }}"
                                                                onclick="deleteBtn(this,'{{ $address->id }}')"
                                                                data-url="{{ route('address.delete', $address->id) }}"
                                                                class="action-btn">
                                                                <svg width="16" height="16" viewBox="0 0 16 16"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M14.0466 3.48634C12.9733 3.37967 11.8999 3.29967 10.8199 3.23967V3.23301L10.6733 2.36634C10.5733 1.75301 10.4266 0.833008 8.86661 0.833008H7.11994C5.56661 0.833008 5.41994 1.71301 5.31328 2.35967L5.17328 3.21301C4.55328 3.25301 3.93328 3.29301 3.31328 3.35301L1.95328 3.48634C1.67328 3.51301 1.47328 3.75967 1.49994 4.03301C1.52661 4.30634 1.76661 4.50634 2.04661 4.47967L3.40661 4.34634C6.89994 3.99967 10.4199 4.13301 13.9533 4.48634C13.9733 4.48634 13.9866 4.48634 14.0066 4.48634C14.2599 4.48634 14.4799 4.29301 14.5066 4.03301C14.5266 3.75967 14.3266 3.51301 14.0466 3.48634Z"
                                                                        fill="#E93C3C" />
                                                                    <path
                                                                        d="M12.8202 5.42699C12.6602 5.26033 12.4402 5.16699 12.2135 5.16699H3.78683C3.56016 5.16699 3.33349 5.26033 3.18016 5.42699C3.02683 5.59366 2.94016 5.82033 2.95349 6.05366L3.36683 12.8937C3.44016 13.907 3.53349 15.1737 5.86016 15.1737H10.1402C12.4668 15.1737 12.5602 13.9137 12.6335 12.8937L13.0468 6.06033C13.0602 5.82033 12.9735 5.59366 12.8202 5.42699ZM9.10682 11.8337H6.88683C6.61349 11.8337 6.38683 11.607 6.38683 11.3337C6.38683 11.0603 6.61349 10.8337 6.88683 10.8337H9.10682C9.38016 10.8337 9.60682 11.0603 9.60682 11.3337C9.60682 11.607 9.38016 11.8337 9.10682 11.8337ZM9.66683 9.16699H6.33349C6.06016 9.16699 5.83349 8.94033 5.83349 8.66699C5.83349 8.39366 6.06016 8.16699 6.33349 8.16699H9.66683C9.94016 8.16699 10.1668 8.39366 10.1668 8.66699C10.1668 8.94033 9.94016 9.16699 9.66683 9.16699Z"
                                                                        fill="#E93C3C" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </fieldset>
                            @else
                                <div class="checkout-card-head">
                                    <h3>{{ __('frontend.pickup_location') }} </h3>
                                </div>

                                <label class="checkout-label d-block" for="address">
                                    <h6 class="mb-1">{{ $restaurant->name }}</h6>
                                    <dl>
                                        <dd> {{ __('frontend.address') }} : {{ $restaurant->address }} </p>
                                        </dd>
                                    </dl>
                                </label>
                            @endif
                        </div>

                        <div class="checkout-card mb-0">
                            <div class="form-group">
                                <label class="form-label required">{{ __('frontend.phone_number') }}</label>
                                <input class="form-control mobilenumber @error('mobile') is-invalid @enderror phone"
                                    type="tel" id="number" name="mobile" onkeypress='validate(event)'>

                                <input type="hidden" id="code" name="countrycode" value="1">

                                @error('mobile')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <input type="hidden" name="total_delivery_charge" id="total_delivery_charge"
                                value="0">

                            <div class="form-group mb-0">
                                <label class="form-label required">{{ __('frontend.payment_type') }}</label>

                                <select class="form-select" name="payment_type" id="payment_type"
                                    onchange="myPaymentFunction()"
                                    class="form-control @error('payment_type') is-invalid @enderror ">

                                    <option value="{{ App\Enums\PaymentMethod::CASH_ON_DELIVERY }}"
                                        @if (old('payment_type') == App\Enums\PaymentMethod::CASH_ON_DELIVERY) selected="selected" @endif>
                                        {{ __('frontend.cash_on_delivery') }}
                                    </option>

                                    @if (auth()->user()->balance->balance >= $totalPayment)
                                        <option value="{{ App\Enums\PaymentMethod::WALLET }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::WALLET) selected="selected" @endif>
                                            {{ __('frontend.pay_with_credit_balance') . currencyFormatWithName(auth()->user()->balance->balance) }}
                                        </option>
                                    @endif

                                    @if (setting('stripe_key') && setting('stripe_secret'))
                                        <option value="{{ App\Enums\PaymentMethod::STRIPE }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::STRIPE) selected="selected" @endif>

                                            {{ __('frontend.stripe') }}
                                        </option>
                                    @endif

                                    @if (setting('paystack_key') && setting('paystack_secret'))
                                        <option value="{{ App\Enums\PaymentMethod::PAYSTACK }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::PAYSTACK) selected="selected" @endif>
                                            {{ __('frontend.paystack') }}
                                        </option>
                                    @endif

                                    @if (setting('paypal_client_id') && setting('paypal_client_secret'))
                                        <option value="{{ App\Enums\PaymentMethod::PAYPAL }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::PAYPAL) selected="selected" @endif>
                                            {{ __('frontend.paypal') }}
                                        </option>
                                    @endif

                                    @if (setting('razorpay_key') && setting('razorpay_secret'))
                                        <option value="{{ App\Enums\PaymentMethod::RAZORPAY }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::RAZORPAY) selected="selected" @endif>
                                            {{ __('frontend.razorpay') }}
                                        </option>
                                    @endif

                                    @if (setting('paytm_merchant_id') && setting('paytm_merchant_key'))
                                        <option value="{{ App\Enums\PaymentMethod::PAYTM }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::PAYTM) selected="selected" @endif>
                                            {{ __('frontend.paytm') }}
                                        </option>
                                    @endif

                                    @if (setting('phonepe_merchant_id') && setting('phonepe_merchant_user_id') && setting('phonepe_salt_key'))
                                        <option value="{{ App\Enums\PaymentMethod::PHONEPE }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::PHONEPE) selected="selected" @endif>
                                            {{ __('frontend.phonePe') }}
                                        </option>
                                    @endif


                                    @if (setting('sslcommerz_store_id') && setting('sslcommerz_store_password'))
                                    <option value="{{ App\Enums\PaymentMethod::SSLCOMMERZ }}"
                                        @if (old('payment_type') == App\Enums\PaymentMethod::SSLCOMMERZ) selected="selected" @endif>
                                        {{ __('frontend.sslcommerz') }}
                                    </option>
                                @endif

                                </select>
                                @error('payment_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="row no-margin-row ms-2">
                            <div class="w-100 form-group col-sm-6 stripe-payment-method-div">
                                <label class="form-label">{{ __('frontend.credit_or_debit_card') }}</label>
                                <div id="card-element"></div>
                                <div id="card-errors" class="text-danger" role="alert"></div>
                            </div>
                        </div>

                        <button type="submit" class="form-btn booking-confirmation-btn"
                            @if ($menuitems['totalAmount'] <= 0) disabled @endif>
                            {{ __('frontend.place_order') }}
                        </button>

                    </div>

                    <div class="checkout-summary">
                        <div class="checkout-summary-head">
                            <h3>{{ __('frontend.order_summary') }} </h3>
                            <p>
                                {{ __('frontend.your_order_from') . ' ' . $restaurant->name }}
                            </p>
                        </div>
                        <ul class="checkout-summary-list">
                            @if (!blank($menuitems))
                                @foreach ($menuitems['items'] as $item)
                                    <li class="checkout-summary-item">
                                        <h3>
                                            <span>{{ $item['qty'] }}</span>
                                            <i class="fa-solid fa-xmark"></i>
                                        </h3>
                                        <dl>
                                            <dt>{{ $item['name'] }} </dt>
                                            @if (isset($item['variation']['name']) && isset($item['variation']['price']))
                                                <dd class="fw-bold">{{ $item['variation']['name'] }} </dd>
                                            @endif
                                            @if (!blank($item['options']))
                                                @foreach ($item['options'] as $option)
                                                    <dd>+ {{ $option['name'] }}</dd>
                                                @endforeach
                                            @endif
                                        </dl>
                                        <h4>{{ setting('currency_code') }}{{ $item['totalPrice'] }} </h4>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <ul class="checkout-summary-price-list">
                            <li>
                                <span>{{ __('frontend.subtotal') }}</span>
                                <span> {{ setting('currency_code') }}{{ $menuitems['subTotalAmount'] }}</span>
                            </li>

                            @if ($menuitems['delivery_type'] != true)
                                <li>
                                    <span>{{ __('frontend.delivery_charge') }}</span>
                                    <span>{{ setting('currency_code') }}<span id="delivery_chearge"></span>
                                    </span>
                                </li>
                            @endif
                            @if (Schema::hasColumn('coupons', 'slug'))
                                <li>
                                    <span>{{ __('frontend.discount') }}</span>
                                    <span> {{ setting('currency_code') }}{{ $menuitems['coupon_amount'] }} </span>
                                </li>
                            @endif

                            <li>
                                <span>{{ __('frontend.total') }}</span>
                                <span>{{ setting('currency_code') }}<span id="total"></span></span>
                            </li>
                        </ul>
                    </div>

                </div>
            </form>
        </div>
    </section>
    <!--======= CHECKOUT PART END =========-->


    <!--===== ADDRESS MODAL PART START =======-->
    <div class="modal fade address-modal" id="address-modal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addressForm" method="post">
                    <input id="formMethod" type="hidden" name="_method" value="POST">
                    @csrf
                    <input type="hidden" name="lat" id="lat" value="">
                    <input type="hidden" name="long" id="long" value="">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="address-modal-header">
                        <h3> {{ __('levels.add_new_address') }}</h3>
                        <button class="fa-regular fa-circle-xmark" type="button" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="address-modal-search modalAddressSearch justify-content-between">
                        <i class="lni lni-search-alt"></i>

                        <div id="autocomplete-container" class="w-100">
                            <input id="autocomplete-input"
                                class="address autocomplete-input @error('new_address') is-invalid @enderror"
                                name="new_address" type="text" placeholder="{{ __('frontend.search') }}">
                        </div>
                        <a href="javascript:void(0)">
                            <button id="locationIcon" onclick="getLocation()" class="lni lni-target iconSearch"></button>
                        </a>
                    </div>
                    <div class="">
                        <div id="googleMap" class="custom-map">

                        </div>
                    </div>
                    <div class="address-modal-details">
                        <label> {{ __('levels.apartment_flat') }}</label>
                        <input id="apartment" type="text"
                            class="form-control @error('apartment') is-invalid @enderror apartment"
                            placeholder="{{ __('levels.apartment') }}" name="apartment" value="{{ old('apartment') }}">
                        @error('apartment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="address-modal-label-group">
                        <h4 class="address-modal-label-title">{{ __('levels.select_label') }}</h4>

                        <select name="label" id="label" class="w-100 border-1">
                            <option value="" disabled selected>{{ __('levels.select_label') }}</option>

                            @foreach (trans('address_types') as $key => $value)
                                <option value="{{ $key }}" <?= old('label') ? 'selected' : '' ?>>
                                    {{ $value }}</option>
                            @endforeach
                        </select>

                        @error('label')
                            <div class="text-danger check-errors1">
                                {{ $message }}
                            </div>
                        @enderror

                        <div id="other">
                            <input id="label_name" type="text"
                                class="address-modal-label-input label-name @error('label_name') is-invalid @enderror"
                                placeholder="{{ __('levels.label_example') }}" name="label_name"
                                value="{{ old('label_name') }}">

                            @error('label_name')
                                <div class="text-danger check-errors2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-danger jsalert">

                        </div>
                    </div>

                    <button class="form-btn"
                        id="address-btn">{{ __('levels.confirm_location') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!--======== ADDRESS MODAL PART END ===========-->

@endsection


@push('js')
    <!-- INTTELINPUT for frontend -->
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput-jquery.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/utils.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/data.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/init.js') }}"></script>


    <!-- For backend Js -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key={{ setting('google_map_api_key') }}&libraries=places&callback=initMap">
    </script>
    <script src="{{ asset('frontend/js/checkout/map.js') }}"></script>

    <script>
        function deleteBtn(e, id) {
            let url = $(e).attr('data-url');
            var token = $("meta[name='csrf-token']").attr("content");
            if (confirm("Are you sure you want to delete this address ?")) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function() {
                        iziToast.success({
                            title: 'Success',
                            message: 'Address Successfully Deleted.',
                            position: 'topRight'
                        });
                        window.location.reload();
                    }
                });
            }
        }

        let totalAmount = 0;

        function myPaymentFunction() {
            totalAmount = Number($('#total').text());
        }

        const siteName = "{{ setting('site_name') }}";
        let orderType = "{{ session()->get('cart')['delivery_type'] }}";
        const siteLogo = "{{ asset('images/' . setting('site_logo')) }}";
        const currencyName = "{{ setting('currency_name') }}";
        const razorpayKey = "{{ env('RAZORPAY_KEY') }}";
        const stripeKey = "{{ setting('stripe_key') }}";
        const subtotal = "{{ $menuitems['subTotalAmount'] }}";
        const couponAmount = "{{ $menuitems['coupon_amount'] }}";
        const locationLat = parseFloat("{{ $restaurant->lat }}");
        const locationLong = parseFloat("{{ $restaurant->long }}");
        const freeZone = "{{ setting('free_delivery_radius') }}";
        const basicCharge = "{{ setting('basic_delivery_charge') }}";
        const chragePerKilo = "{{ setting('charge_per_kilo') }}";
        const delivery_type = "{{ $menuitems['delivery_type'] }}";

        const lastAddress = "{{ !blank($lastAddress) ? true : false }}";
        const lastAddress_latitude = parseFloat("{{ optional($lastAddress)->latitude }}");
        const lastAddress_longitude = parseFloat("{{ optional($lastAddress)->longitude }}");
    </script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('frontend/js/checkout/stripe.js') }}"></script>
    <script src="{{ asset('frontend/js/image-upload.js') }}"></script>
    <script src="{{ asset('js/phone_validation/index.js') }}"></script>
@endpush

