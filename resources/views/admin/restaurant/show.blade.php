@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('levels.restaurant') }}</h1>
            {{ Breadcrumbs::render('restaurant/view') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-plus-square"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('order.total_order') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $total_order }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-paper-plane"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('order.order_pending') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $pending_order }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-star"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('order.order_process') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $process_order }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('order.order_completed') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $completed_order }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body card-profile restaurant-edit-button">
                            <img class="profile-user-img img-responsive img-circle" src="{{ $restaurant->logo }}"
                                alt="User profile picture">
                            <h3 class="text-center">{{ $restaurant->name }}</h3>
                            <p class="text-center">
                                {{ $restaurant->address }}
                            </p>
                            @isset(auth()->user()->restaurant->id)
                                <a href="{{ route('admin.restaurant.restaurant-edit', auth()->user()->restaurant->id) }}"
                                    class="btn btn-sm btn-icon btn-primary restaurant-edit-icon" data-toggle="tooltip"
                                    data-placement="top" data-original-title="Edit"> <i class="far fa-edit"></i></a>
                            @endisset
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body card-profile">
                            <img class="profile-user-img img-responsive img-circle" src="{{ $user->image }}"
                                alt="User profile picture">
                            <h3 class="text-center">{{ $user->name }}</h3>
                            <p class="text-center">
                                {{ $user->getrole->name ?? '' }}
                            </p>

                            <ul class="list-group">
                                <li class="list-group-item profile-list-group-item">
                                    <span class="float-left font-weight-bold">{{ __('levels.username') }}</span>
                                    <span class="float-right">{{ $user->name }}</span>
                                </li>
                                <li class="list-group-item profile-list-group-item">
                                    <span class="float-left font-weight-bold">{{ __('levels.phone') }}</span>
                                    <span class="float-right">{{ $user->phone }}</span>
                                </li>
                                <li class="list-group-item profile-list-group-item">
                                    <span class="float-left font-weight-bold">{{ __('levels.email') }}</span>
                                    <span class="float-right">{{ $user->email }}</span>
                                </li>
                                <li class="list-group-item profile-list-group-item">
                                    <span class="float-left font-weight-bold">{{ __('levels.address') }}</span>
                                    <span class="float-right profile-list-group-item-addresss">{{ $user->address }}</span>
                                </li>
                                <li class="list-group-item profile-list-group-item">
                                    <span class="float-left font-weight-bold">{{ __('levels.deposit_amount') }}</span>
                                    <span class="float-right profile-list-group-item-addresss">
                                        {{ isset($user->deposit->deposit_amount) ? currencyFormat($user->deposit->deposit_amount) : '' }}
                                    </span>
                                </li>
                                <li class="list-group-item profile-list-group-item">
                                    <span class="float-left font-weight-bold">{{ __('levels.limit_amount') }}</span>
                                    <span class="float-right profile-list-group-item-addresss">
                                        {{ isset($user->deposit->limit_amount) ? currencyFormat($user->deposit->limit_amount) : '' }}
                                    </span>
                                </li>
                                <li class="list-group-item profile-list-group-item">
                                    <span class="float-left font-weight-bold">{{ __('levels.credit') }}</span>
                                    <span class="float-right profile-list-group-item-addresss">
                                        {{ currencyFormat($user->balance->balance) }}
                                    </span>
                                </li>
                                <li class="list-group-item profile-list-group-item">
                                    <span class="float-left font-weight-bold">{{ __('levels.status') }}</span>
                                    <span class="float-right profile-list-group-item-addresss">{{ $user->mystatus }}</span>
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-8 col-md-8 col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <div class="profile-desc">
                                <div class="single-profile">
                                    <p><b>{{ __('levels.name') }}: </b> {{ $restaurant->name }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.latitude') }}: </b> {{ $restaurant->lat }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.longitude') }}: </b> {{ $restaurant->long }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.current_status') }}: </b>
                                        {{ trans('current_statuses.' . $restaurant->current_status) }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.waiter_status') }}: </b>
                                        {{ trans('waiter_statuses.' . $restaurant->waiter_status) }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.status') }}: </b> {{ trans('statuses.' . $restaurant->status) }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.delivery_status') }}: </b>
                                        {{ trans('delivery_statuses.' . $restaurant->delivery_status) }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.pickup_status') }}: </b>
                                        {{ trans('pickup_statuses.' . $restaurant->pickup_status) }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.table_status') }}: </b>
                                        {{ trans('table_statuses.' . $restaurant->table_status) }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.opening_time') }}: </b>
                                        {{ date('h:i A', strtotime($restaurant->opening_time)) }}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.closing_time') }}: </b>
                                        {{ date('h:i A', strtotime($restaurant->closing_time)) }}</p>
                                </div>
                                @if (isset($restaurant->cuisines))
                                    <div class="single-full-profile">
                                        <p><b>{{ __('cuisine.cuisines') }}: </b>
                                            @foreach ($restaurant->cuisines as $cuisine)
                                                <span>{{ $cuisine->name }}</span>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </p>
                                    </div>
                                @endif
                                <div class="single-full-profile">
                                    <p><b>{{ __('levels.address') }}: </b> {{ $restaurant->address }}</p>
                                </div>
                                <div class="single-full-profile">
                                    <p><b>{{ __('levels.description') }}: </b> {!! $restaurant->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3>{{ __('restaurant.menu_items') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable"
                                    data-restaurantid="{{ $restaurant->id }}"
                                    data-url="{{ route('admin.restaurant.get-menu-items') }}"
                                    data-hidecolumn="">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            <th>{{ __('levels.name') }}</th>
                                            <th>{{ __('levels.price') }}</th>
                                            <th>{{ __('levels.discount') }}</th>
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
    <script src="{{ asset('js/restaurant/menu-item.js') }}"></script>
@endsection
