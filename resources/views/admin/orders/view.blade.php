@extends('admin.layouts.master')

@section('main-content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('order.orders') }}</h1>
        {{ Breadcrumbs::render('orders/view') }}
    </div>

    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print" id="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2>{{ __('order.invoice') }}</h2>
                            <div class="invoice-number">{{ __('order.order') }} #{{ $order->order_code }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    {{ $order->restaurant->name }}<br>
                                    {{ $order->restaurant->address ?? null }}<br>
                                    {{ __('restaurant.opens_at').' '.date('h:i A', strtotime($order->restaurant->opening_time)) .' - '. __('restaurant.closes_at').' '.date('h:i A', strtotime($order->restaurant->closing_time)) }}
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>{{ __('order.billed_to') }}:</strong><br>
                                    {{ $order->user->name ?? null }}<br>
                                    @if(auth()->user()->myrole !=3)
                                    {{ __('levels.phone').':'. $order->user->phone ?? null }}<br>
                                    {{ orderAddress($order->address) }}
                                    @else
                                    {{ __('levels.email').':'. substr($order->user->email, 0, 2).'****'.substr($order->user->email, strpos($order->user->email, "@"))}}<br>
                                    {{ __('levels.phone').':'. substr($order->user->phone, 0, 2).'********'.substr($order->user->phone, -2)}}<br>
                                    {{ orderAddress($order->address) }}
                                    @endif
                                </address>

                                <address>
                                    <strong>{{ __('order.order_date') }}:</strong><br>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}<br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">{{ __('order.order_summary') }}</div>
                        <p class="section-lead">{{ __('order.all_items_here_cannot_be_deleted') }}</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th data-width="40">{{ __('#') }}</th>
                                    <th>{{ __('order.item') }}</th>
                                    <th class="text-center">{{ __('levels.price') }}</th>
                                    <th class="text-center">{{ __('levels.quantity') }}</th>
                                    <th class="text-right">{{ __('levels.totals') }}</th>
                                </tr>
                                @foreach($items as $itemKey => $item)
                                <tr>
                                    <td>{{ $itemKey+1 }}</td>
                                    <td>{{ $item->menuItem->name }}
                                        @if(!blank($item->variation))
                                        <small class="basic-color">{{ ' ( '.json_decode($item->variation,true)['name'].' )'}}</small>
                                        @endif

                                        @if(!blank($item->options))
                                        @foreach (json_decode($item->options,true) as $option)
                                        <br>
                                        <small><span>-- &nbsp; &nbsp;{{ $option['name'] }}</span></small>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td class="text-center">{{ currencyFormat($item->unit_price) }}</td>
                                    <td class="text-center">{{ $item->quantity }} </td>
                                    <td class="text-right">{{ currencyFormat($item->item_total) }}</td>
                                </tr>
                                @if(!blank($item->instructions))
                                    <tr>
                                        <td class="pt-0 pb-4" colspan="5"><strong> {{ __('levels.instructions') }}</strong>  {{ $item->instructions}}  </td>
                                    </tr>
                                @endif

                                @endforeach
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-8">
                                <div class="section-title">{{ __('levels.delivery') }} : {{ trans('order_status.'.$order->status) }}</div>
                                <div class="section-title">{{ __('levels.order_type') }} : {{ $order->getOrderType }}</div>
                                <div class="section-title">{{ __('levels.payment_status') }} : {{ trans('payment_status.'.$order->payment_status) }}</div>
                                <div class="section-title">{{ __('order.payment_method') }} : {{ trans('payment_method.'.$order->payment_method) }}</div>
                            </div>
                            <div class="col-lg-4 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">{{ __('levels.sub_total') }}</div>
                                    <div class="invoice-detail-value">{{ currencyFormat($order->sub_total) }}</div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">{{ __('levels.delivery_charge') }}</div>
                                    <div class="invoice-detail-value">{{ currencyFormat($order->delivery_charge) }}</div>
                                </div>
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name"> {{ __('levels.total') }}</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">{{ currencyFormat($order->total) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-md-right">
                @if($order->attachment)
                <a class="btn btn-info m-2" href="{{ route('admin.orders.order-file', $order->id) }}"><i class="fa fa-arrow-circle-down"></i> {{ __('levels.download') }}</a>
                @endif

                <button onclick="printDiv('invoice-print')" class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> {{ __('levels.print') }}</button>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/print.js') }}"></script>
@endsection
