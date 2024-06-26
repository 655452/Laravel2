@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('levels.coupon') }}</h1>
        {{ Breadcrumbs::render('coupons') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- @can('coupon_create') --}}
                    <div class="card-header">
                        <a href="{{ route('admin.coupon.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('levels.add_coupon') }}</a>
                    </div>
                    {{-- @endcan --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 offset-sm-3">
                                <div class="input-group input-daterange" id="date-picker">
                                    <select class="form-control" id="discount_type" name="discount_type">
                                        <option value="">{{ __('levels.discount_type') }}</option>
                                        @foreach(trans('discount_types') as $key => $status)
                                        <option value="{{ $key }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @if(auth()->user()->myrole == 1)
                                    <select class="form-control" id="coupon_type" name="coupon_type">
                                        <option value="">{{ __('levels.coupon_type') }}</option>
                                        @foreach(trans('coupon_types') as $key => $coupon_type)
                                        <option value="{{ $key }}">{{ $coupon_type }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <input type="hidden" name="coupon_type" value="0">
                                    @endif
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="refresh"> {{ __('levels.refresh') }}</button>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="date-search">{{ __('levels.search') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable" data-url="{{ route('admin.coupon.index') }}" data-status="{{ \App\Enums\Status::ACTIVE }}"
                            data-hidecolumn="{{ auth()->user()->can('coupon_edit') || auth()->user()->can('coupon_delete') || auth()->user()->can('coupon_show') }}" >
                                <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.name') }}</th>
                                        <th>{{ __('levels.code') }}</th>
                                        <th>{{ __('levels.coupon_type') }}</th>
                                        <th>{{ __('levels.limit') }}</th>
                                        <th>{{ __('levels.status') }}</th>
                                        <th>{{ __('levels.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection



@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/coupon/index.js') }}"></script>
@endsection
