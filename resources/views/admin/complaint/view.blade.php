@extends('admin.layouts.master')

@section('main-content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('levels.complaints') }}</h1>
        {{ Breadcrumbs::render('complaints/view') }}
    </div>

    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print" id="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2>{{ __('levels.complaints') }}</h2>
                            <div class="invoice-number">{{ __('order.order') }} # <span class="basic-color">{{ $report->order->order_code }}</span></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="card">
                                    <div class="card-body card-profile restaurant-edit-button">
                                        <img class="profile-user-img img-responsive img-circle" src="{{ $report->user->image }}" alt="User profile picture">
                                        <h3 class="text-center">{{ $report->user->name }}</h3>
                                        <p class="text-center">
                                            {{ $report->user->phone }}
                                        </p>
                                        <p class="text-center">
                                            {{ $report->user->email }}
                                        </p>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-body card-profile">
                                        <ul class="list-group">
                                            <li class="list-group-item profile-list-group-item">
                                                <span class="float-left font-weight-bold">{{ __('order.order_amount') }}</span>
                                                <span class="float-right">{{ currencyFormat($report->order->total)}}</span>
                                            </li>
                                            <li class="list-group-item profile-list-group-item">
                                                <span class="float-left font-weight-bold">{{ __('levels.restaurant_name') }}</span>
                                                <span class="float-right">{{ $report->order->restaurant->name }}</span>
                                            </li>
                                            <li class="list-group-item profile-list-group-item">
                                                <span class="float-left font-weight-bold">{{ __('levels.restaurant_phone') }}</span>
                                                <span class="float-right">{{ $report->order->restaurant->user->phone }}</span>
                                            </li>
                                            @if(!blank($report->order->delivery))
                                            <li class="list-group-item profile-list-group-item">
                                                <span class="float-left font-weight-bold">{{ __('levels.delivery_boy') }}</span>
                                                <span class="float-right">{{ $report->order->delivery->name }}</span>
                                            </li>
                                            <li class="list-group-item profile-list-group-item">
                                                <span class="float-left font-weight-bold">{{ __('levels.delivery_boy_phone') }}</span>
                                                <span class="float-right">{{ $report->order->delibery->phone }}</span>
                                            </li>
                                            @endif

                                        </ul>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                            <div class="col-8 col-md-8 col-lg-8">

                                <div class="card">
                                    <div class="card-body">
                                        <div >
                                            <h3>{{ __('levels.description')}}</h3>
                                            <div>{{ $report->description}}</div>
                                        </div>
                                        <div class="mt-5">
                                        <h3 class="mb-3">{{ __('levels.product_image')}}</h3>
                                            <img class="profile-user-img img-responsive img-circle" src="{{ $report->image }}" alt="User profile picture">
                                        </div>
                                    </div>
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