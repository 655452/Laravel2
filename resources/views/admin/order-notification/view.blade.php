@extends('admin.layouts.master')

@section('main-content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('order.pending_orders') }}</h1>
        {{ Breadcrumbs::render('order-notification/view') }}
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
                                    <strong>{{ $order->shop->name }}:</strong><br>
                                    {{ $order->shop->location->name ?? null }},
                                    {{ $order->shop->area->name ?? null }}<br>
                                    {{ $order->shop->address ?? null }}<br>
                                    {{ __('restaurant.opens_at').' '.date('h:i A', strtotime($order->shop->opening_time)) .' - '. __('restaurant.closes_at').' '.date('h:i A', strtotime($order->shop->closing_time))  }}
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>{{ __('order.billed_to') }}:</strong><br>
                                    {{ $order->user->name ?? null }}<br>
                                    {{ __('levels.phone : '). $order->user->phone ?? null }}<br>
                                    {{ orderAddress($order->address) }}
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
                                    <th class="text-right">{{ __('level.totals') }}</th>
                                </tr>
                                @foreach($items as $itemKey => $item)
                                <tr>
                                    <td>{{ $itemKey+1 }}</td>
                                    <td>{{ $item->product->name }}
                                        <?php $options = json_decode($item->options);
                                        if (isset($options->variation) && !blank($options->variation)) { ?>
                                            <br>
                                            <small><b>-- &nbsp;{{ $options->variation->name }}</b></small>
                                            <?php }
                                        if (isset($options->options) && !blank($options->options)) {
                                            foreach ($options->options as $option) { ?>
                                                <br>
                                                <small><span>-- &nbsp; &nbsp;{{ $option->name }}</span></small>
                                        <?php }
                                        } ?>
                                    </td>
                                    <td class="text-center">{{ currencyFormat($item->unit_price) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">{{ currencyFormat($item->item_total) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6">

                                <div class="section-title">
                                    {{ __('order.order_status') }} : {{ trans('order_status.'.$order->status) }}
                                </div>

                                <div class="section-title">
                                    {{ __('order.payment_status') }} : {{ trans('payment_status.'.$order->payment_status) }}
                                </div>

                                <div class="order card">
                                    <form action="{{ route('admin.order-notification.update', $order) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                                    @if(!blank($orderStatusArray))
                                                    @foreach($orderStatusArray as $key => $status)
                                                    <option value="{{ $key }}" {{ (old('status', $order->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                @error('status')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="card-footer text-left">
                                            <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 text-right">
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
                <button onclick="printDiv('invoice-print')" class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> {{ __('levels.print') }}</button>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/print.js') }}"></script>
@endsection
