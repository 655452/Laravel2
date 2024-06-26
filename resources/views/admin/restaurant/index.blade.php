@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('levels.restaurants') }}</h1>
        {{ Breadcrumbs::render('restaurants') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    @can('restaurants_create')
                    <div class="card-header d-flex justify-content-between">
                        <a href="{{ route('admin.restaurants.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                class="fas fa-plus"></i> {{ __('restaurant.add_restaurant') }}</a>
                        @if (auth()->user()->myrole == 1)
                        <a href="{{ route('admin.import-restaurant') }}" class="btn btn-icon icon-left btn-success">
                            {{ __('restaurant.import_restaurant') }}</a>
                        @endif
                    </div>
                    @endcan

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 offset-sm-3">
                                <div class="input-group input-daterange" id="date-picker">
                                    <select class="form-control" id="status" name="status">
                                        @foreach (trans('restaurant_statuses') as $key => $status)
                                        <option value="{{ $key }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" id="applied" name="applied">
                                        <option value="">{{ __('levels.select_applied') }}</option>
                                        @foreach (trans('restaurant_applieds') as $key => $restaurant_applied)
                                        <option value="{{ $key }}">{{ $restaurant_applied }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="refresh">
                                            {{ __('levels.refresh') }}</button>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="date-search">{{
                                            __('levels.search') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable"
                                data-url="{{ route('admin.restaurant.get-restaurant') }}"
                                data-status="{{ \App\Enums\RestaurantStatus::ACTIVE }}"
                                data-hidecolumn="{{ auth()->user()->can('restaurants_show') ||auth()->user()->can('restaurants_edit') ||auth()->user()->can('restaurants_delete') }}">
                                <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.name') }}</th>
                                        <th>{{ __('levels.user') }}</th>
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
<script src="{{ asset('js/restaurant/index.js') }}"></script>
@endsection
