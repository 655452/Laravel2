@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('order.orders') }}</h1>
        {{ Breadcrumbs::render('orders/edit') }}
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
                                    <strong>{{ __('order.billed_to') }}:</strong><br>
                                    {{ $order->user->name ?? null }}<br>
                                    {{ __('Mobile : '). $order->user->phone ?? null }}<br>
                                    {{ orderAddress($order->address) }}
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
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
                                    <th>{{ __('Item') }}</th>
                                    <th class="text-center">{{ __('levels.price') }}</th>
                                    <th class="text-center">{{ __('levels.quantity') }}</th>
                                    <th class="text-right">{{ __('levels.total') }}</th>
                                </tr>
                                @foreach($items as $itemKey => $item)
                                <tr>
                                    <td>{{ $itemKey+1 }}</td>
                                    <td>{{ $item->menuItem->name ?? null }}
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
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">{{ currencyFormat($item->item_total) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-4">
                                @if($showStatus && !blank($orderStatusArray))
                                <div class="section-title">{{ __('levels.change_your_status') }}</div>
                                <div class="order card">
                                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                                    <option value="0">{{ __('levels.select_your_status') }}</option>
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
                                @endif

                                @if($showReceive)
                                <div class="section-title">{{ __('order.change_product_receive') }}</div>
                                <div class="order card">
                                    <form action="{{ route('admin.orders.product-receive', $order) }}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="product_received">{{ __('order.product_received') }}</label> <span class="text-danger">*</span>
                                                <select id="product_received" name="product_received" class="form-control @error('product_received') is-invalid @enderror">
                                                    <option value="10">{{ __('levels.not_receive') }}</option>
                                                    <option value="5">{{ __('levels.receive') }}</option>
                                                </select>
                                                @error('product_received')
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
                                @endif
                            </div>
                            <div class="col-lg-4 offset-4 text-right">
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
        </div>
    </div>
</section>
@endsection
