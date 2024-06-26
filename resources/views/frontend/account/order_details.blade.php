@extends('frontend.layouts.app')

@section('main-content')
    <!--======== SETTINGS PART START =======-->
    <section class="settings">
        <div class="container">
            <div class="row">

                @include('frontend.account.partials._sidebar')

                <div class="col-12 col-lg-8 col-xl-9">
                    <h3 class="order-details-title">
                        <a href="{{ route('account.order') }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.57 5.92969L3.5 11.9997L9.57 18.0697" stroke="#EE1D48" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M20.4999 12H3.66992" stroke="#EE1D48" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        <span>{{ __('frontend.tracking') }} </span>
                    </h3>
                    <div class="pt-3">
                        <ul class="order-track">
                            @if ($order->status == \App\Enums\OrderStatus::CANCEL)
                                <li class="tracked active">
                                    <span class="line"></span>
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span class="title"> {{ __('frontend.order_cancel') }}</span>
                                </li>
                            @else
                                <li
                                    class=" {{ $order->status >= \App\Enums\OrderStatus::PENDING ? 'tracked active' : '' }}">
                                    <span class="line"></span>
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span class="title">{{ __('frontend.order_pending') }}</span>
                                </li>
                            @endif

                            @if ($order->status == \App\Enums\OrderStatus::REJECT)
                                <li class="tracked active">
                                    <span class="line"></span>
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span class="title">{{ __('frontend.order_reject') }}</span>
                                </li>
                            @else
                                <li class="{{ $order->status >= \App\Enums\OrderStatus::ACCEPT ? 'tracked active' : '' }}">
                                    <span class="line"></span>
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span class="title">{{ __('frontend.order_accept') }}</span>
                                </li>
                            @endif

                            <li class=" {{ $order->status >= \App\Enums\OrderStatus::PROCESS ? 'tracked active' : '' }}">
                                <span class="line"></span>
                                <i class="fa-solid fa-circle-check"></i>
                                <span class="title">{{ __('frontend.order_process') }} </span>
                            </li>

                            <li
                                class=" {{ $order->status >= \App\Enums\OrderStatus::ON_THE_WAY ? 'tracked active' : '' }}">
                                <span class="line"></span>
                                <i class="fa-solid fa-circle-check"></i>
                                <span class="title">{{ __('frontend.on_the_way') }} </span>
                            </li>
                            <li class="{{ $order->status == \App\Enums\OrderStatus::COMPLETED ? 'tracked active' : '' }}">
                                <span class="line"></span>
                                <i class="fa-solid fa-circle-check"></i>
                                <span class="title">{{ __('frontend.order_completed') }} </span>
                            </li>
                        </ul>
                    </div>

                    <div class="order-details" id="invoice-print">
                        <ul class="order-meta ps-3 pe-3">
                            <li><span>{{ __('frontend.order') }}:</span><a>#{{ $order->order_code }}</a></li>
                            <li><span> {{ __('frontend.order_date') }}
                                    :</span><span>{{ $order->created_at->format('d M Y, h:i A') }}</span></li>
                        </ul>
                        <div class="order-group">
                            <div class="order-box address">
                                <h4 class="order-box-title">{{ __('frontend.billing_to') }} </h4>
                                <ul class="order-box-list">
                                    <li class="order-box-item"><b>{{ __('frontend.name') }} :</b>
                                        <p>{{ $order->user->name ?? '' }} </p>
                                    </li>
                                    <li class="order-box-item"><b>{{ __('frontend.phone') }} :</b>
                                        <p>{{ $order->mobile ?? '' }}</p>
                                    </li>
                                    <li class="order-box-item"><b>{{ __('frontend.address') }} :</b>
                                        <p> {{ orderAddress($order->address) }} </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="order-box status">
                                <h4 class="order-box-title">{{ __('frontend.delivery_status') }} </h4>
                                <ul class="order-box-list">
                                    <li class="order-box-item"><b> {{ __('frontend.order_status') }} :</b><span
                                            class="badge-text blue"> {{ trans('order_status.' . $order->status) }}</span>
                                    </li>
                                    <li class="order-box-item"><b>{{ __('levels.order_type') }} :</b>
                                        <p> {{ $order->getOrderType }}</p>
                                    </li>
                                    <li class="order-box-item"><b>{{ __('frontend.payment_status') }} :</b>
                                        @if ($order->payment_status == \App\Enums\PaymentStatus::PAID)
                                            <span class="badge-text green">
                                                {{ trans('payment_status.' . $order->payment_status) ?? null }}</span>
                                        @else
                                            <span class="badge-text red">
                                                {{ trans('payment_status.' . $order->payment_status) ?? null }}</span>
                                        @endif
                                    </li>
                                    <li class="order-box-item"><b>{{ __('frontend.payment_method') }} :</b>
                                        <p> {{ trans('payment_method.' . $order->payment_method) ?? null }} </p>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-order">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">{{ __('frontend.item') }}</th>
                                    <th scope="col">{{ __('frontend.price') }}</th>
                                    <th scope="col">{{ __('frontend.quantity') }}</th>
                                    <th scope="col">{{ __('frontend.totals') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $itemKey => $item)


                                    <tr>
                                        <td data-title="item">
                                            <dl class="order-table-item">
                                                <dt>
                                                    {{ $item->menuItem->name }}
                                                    {{ $item->variation ? ' ( ' . $item->variation['name'] . ' )' : '' }}
                                                </dt>
                                                @if ($item->options)
                                                    <dd>
                                                        @foreach (json_decode($item->options, true) as $option)
                                                            <span>{{ $option['name'] }}</span>
                                                        @endforeach
                                                    </dd>
                                                @endif
                                            </dl>
                                        </td>
                                        <td data-title="price">
                                            <div class="order-table-price">
                                                <span> {{ currencyFormat($item->unit_price) }}</span>
                                            </div>
                                        </td>
                                        <td data-title="qnty">{{ $item->quantity }} </td>
                                        <td data-title="total">{{ currencyFormat($item->item_total) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <ul class="order-price-list">
                            @if ($order->discount->amount > 0 && Schema::hasColumn('coupons', 'slug'))
                                <li>
                                    <span>{{ __('frontend.discount') }}</span>
                                    <span class="pe-xxl-5 pe-xl-4 pe-lg-1 pe-md-2">{{ currencyFormat($order->discount->amount) }}</span>
                                </li>
                            @endif

                            <li><span>{{ __('frontend.subtotal') }}</span>
                                <span class="pe-xxl-5 pe-xl-4 pe-lg-1 pe-md-2">{{ currencyFormat($order->sub_total) }}</span></li>

                            <li><span>{{ __('frontend.delivery_charge') }}</span>
                                <span class="pe-xxl-5 pe-xl-4 pe-lg-1 pe-md-2">{{ currencyFormat($order->delivery_charge) }}</span></li>
                            <li>
                                <span>{{ __('frontend.total') }}</span>
                                <span class="pe-xxl-5 pe-xl-4 pe-lg-1 pe-md-2">{{ currencyFormat($order->total) }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="order-btns pt-4">
                        @if ($order->status == \App\Enums\OrderStatus::PENDING)
                            <a href="{{ route('account.order.cancel', $order) }}"
                                onclick="return confirm('{{ __('frontend.cancel_message') }}')">
                                <button class="cancel" type="button">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM13.36 12.3C13.65 12.59 13.65 13.07 13.36 13.36C13.21 13.51 13.02 13.58 12.83 13.58C12.64 13.58 12.45 13.51 12.3 13.36L10 11.06L7.7 13.36C7.55 13.51 7.36 13.58 7.17 13.58C6.98 13.58 6.79 13.51 6.64 13.36C6.35 13.07 6.35 12.59 6.64 12.3L8.94 10L6.64 7.7C6.35 7.41 6.35 6.93 6.64 6.64C6.93 6.35 7.41 6.35 7.7 6.64L10 8.94L12.3 6.64C12.59 6.35 13.07 6.35 13.36 6.64C13.65 6.93 13.65 7.41 13.36 7.7L11.06 10L13.36 12.3Z"
                                            fill="white"></path>
                                    </svg>
                                    <span> {{ __('frontend.cancel_order') }}</span>
                                </button>
                            </a>
                        @endif
                        @if ($order->attachment)
                            <a href="{{ route('account.order.file', $order->id) }}">
                                <button class="print" type="button">
                                    <span> {{ __('frontend.download') }}</span>
                                </button>
                            </a>
                        @endif

                        @if (!$order->attachment)
                            <button class="print" type="button" onclick="printDiv('invoice-print')">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7 5C7 3.34 8.34 2 10 2H14C15.66 2 17 3.34 17 5C17 5.55 16.55 6 16 6H8C7.45 6 7 5.55 7 5Z"
                                        fill="white"></path>
                                    <path
                                        d="M17.75 15C17.75 15.41 17.41 15.75 17 15.75H16V19C16 20.66 14.66 22 13 22H11C9.34 22 8 20.66 8 19V15.75H7C6.59 15.75 6.25 15.41 6.25 15C6.25 14.59 6.59 14.25 7 14.25H17C17.41 14.25 17.75 14.59 17.75 15Z"
                                        fill="white"></path>
                                    <path
                                        d="M18 7H6C4 7 3 8 3 10V15C3 17 4 18 6 18H6.375C6.72018 18 7 17.7202 7 17.375C7 17.0298 6.71131 16.7604 6.38841 16.6384C5.72619 16.3882 5.25 15.7453 5.25 15C5.25 14.04 6.04 13.25 7 13.25H17C17.96 13.25 18.75 14.04 18.75 15C18.75 15.7453 18.2738 16.3882 17.6116 16.6384C17.2887 16.7604 17 17.0298 17 17.375C17 17.7202 17.2798 18 17.625 18H18C20 18 21 17 21 15V10C21 8 20 7 18 7ZM10 11.75H7C6.59 11.75 6.25 11.41 6.25 11C6.25 10.59 6.59 10.25 7 10.25H10C10.41 10.25 10.75 10.59 10.75 11C10.75 11.41 10.41 11.75 10 11.75Z"
                                        fill="white"></path>
                                </svg>
                                <span>{{ __('frontend.print') }}</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--======= SETTINGS PART END ====-->
@endsection
