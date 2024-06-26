@extends('admin.layouts.master')


@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('levels.coupon') }}</h1>
        {{ Breadcrumbs::render('coupons/show') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-4 col-md-4 col-lg-4 p-2">
                <div class="card">
                    <div class="card-body card-profile">
                        <div class="d-flex align-items-center mb-3">
                            <img class="coupon-logo ml-5 mr-4" src="{{ asset("images/".setting('site_logo')) }}" alt="">
                            <h3 class="text-center mb-3 text-warning font-weight-bold">{{ $coupon->name }}</h3>
                        </div>

                        <ul class="list-group">
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.name') }}</span>
                                <span class="float-right">{{ $coupon->name }}</span>
                            </li>
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.code') }}</span>
                                <span class="float-right">{{ $coupon->slug }}</span>
                            </li>
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.amount') }}</span>
                                <span class="float-right">{{ $coupon->discount_type == 5 ? currencyFormat($coupon->amount) : $coupon->amount.'%' }}</span>
                            </li>
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.minimum_order_amount') }}</span>
                                <span class="float-right">{{ currencyFormat($coupon->minimum_order_amount) }}</span>
                            </li>

                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.discount_type') }}</span>
                                <span class="float-right">{{ trans('discount_types.'.$coupon->discount_type) }}</span>
                            </li>
                            @if(auth()->user()->myrole == 1)
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.coupon_type') }}</span>
                                <span class="float-right">{{ trans('coupon_types.'.$coupon->discount_type) }}</span>
                            </li>
                            @endif
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.limit') }}</span>
                                <span class="float-right">{{ $coupon->limit }}</span>
                            </li>
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.used') }}</span>
                                <span class="float-right">{{ $coupon->discounts->count() }}</span>
                            </li>
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.left') }}</span>
                                <span class="float-right">{{ $coupon->limit-$coupon->discounts->count() }}</span>
                            </li>

                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.starts_at') }}</span>
                                <span class="float-right">{{ date('h:i A d/m/Y',strtotime($coupon->from_date)) }}</span>
                            </li>
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.ends_at') }}</span>
                                <span class="float-right">{{ date('h:i A d/m/Y',strtotime($coupon->to_date)) }}</span>
                            </li>


                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-8 col-md-8 col-lg-8 p-2">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Code</th>
                            <th scope="col">Discounted Amount</th>
                            <th scope="col">Order ID</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if( !blank($coupon->discounts))
                        @foreach($coupon->discounts as $discount)
                        <tr>
                            <th scope="row">{{$loop->index}}</th>
                            <td>{{$coupon->slug}}</td>
                            <td>{{$discount->amount}}</td>
                            <td>{{$discount->order_id}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                {{__('levels.not_used_yet')}}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection