@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('dashboard.dashboard') }}</h1>
            {{ Breadcrumbs::render('dashboard') }}
        </div>
        <div class="row">
		@if (auth()->user()->myrole == 1)
				{{-- total order --}}
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1">
						<div class="card-icon bg-primary">
							<i class="far fa-paper-plane"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>{{ __('dashboard.total_orders') }}</h4>
							</div>
							<div class="card-body">
								{{ $totalOrders }}
							</div>
						</div>
					</div>
				</div>
					{{-- total user --}}
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1">
						<div class="card-icon bg-info">
							<i class="far fa-user"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>{{ __('dashboard.total_customers') }}</h4>
							</div>
							<div class="card-body">
								{{ $totalUsers }}
							</div>
						</div>
					</div>
				</div>
					{{-- total shop --}}
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1">
						<div class="card-icon bg-warning">
							<i class="fas fa-university"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>{{ __('dashboard.total_restaurants') }}</h4>
							</div>
							<div class="card-body">
								{{ $totalRestaurants }}
							</div>
						</div>
					</div>
				</div>
					{{-- total income --}}
				<div class="col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="card card-statistic-1">
						<div class="card-icon bg-success">
							<i class="fas fa-money-bill"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>{{ __('dashboard.total_income') }}</h4>
							</div>
							<div class="card-body">
								{{ number_format($totalIncome, 2) }}
							</div>
						</div>
					</div>
				</div>
		@elseif(auth()->user()->myrole == 3)
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-warning">
						<i class="fas fa-cubes"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>{{ __('dashboard.pending_orders') }}</h4>
						</div>
						<div class="card-body">
							{{ $ownerNotificationOrders }}
						</div>
					</div>
				</div>
			</div>
			{{-- total order --}}
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-primary">
						<i class="far fa-paper-plane"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>{{ __('dashboard.total_orders') }}</h4>
						</div>
						<div class="card-body">
							{{ $ownerTotalOrders }}
						</div>
					</div>
				</div>
			</div>
				{{-- total Booking --}}
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-danger">
						<i class="fas fa-table"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>{{ __('dashboard.total_booking') }}</h4>
						</div>
						<div class="card-body">
							{{ $ownerTotalReservations }}
						</div>
					</div>
				</div>
			</div>
				{{-- total income --}}
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-success">
						<i class="fas fa-money-bill"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>{{ __('dashboard.available_credit') }}</h4>
						</div>
						<div class="card-body">
							{{ $userCredit}}
						</div>
					</div>
				</div>
			</div>
		@elseif(auth()->user()->myrole == 4)
					{{-- Notification order --}}
			<div class="col-lg-4 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-primary">
						<i class="fas fa-cubes"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>{{ __('dashboard.total_notification_order') }}</h4>
						</div>
						<div class="card-body">
							{{ $notificationOrders }}
						</div>
					</div>
				</div>
			</div>
				{{-- total Order --}}
			<div class="col-lg-4 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-danger">
						<i class="far fa-paper-plane"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>{{ __('dashboard.total_orders') }}</h4>
						</div>
						<div class="card-body">
							{{ $totalDaliveryOrders }}
						</div>
					</div>
				</div>
			</div>
				{{-- total income --}}
			<div class="col-lg-4 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-success">
						<i class="fas fa-money-bill"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>{{ __('dashboard.available_credit') }}</h4>
						</div>
						<div class="card-body">
							{{ $userCredit}}
						</div>
					</div>
				</div>
			</div>

		@endif

        </div>

		<div class="row">
		    <div class="col-md-12">
		        <div class="card">
			        <div class="card-body">
			        	<div id="earningGraph"></div>
			        </div>
			    </div>
			</div>
		</div>

        <div class="row">
			@can('orders')
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
							<h4>{{ __('dashboard.recent_orders') }} <span class="badge badge-primary">{{ $recentOrders->count() }}</span></h4>
							<div class="card-header-action">
								<a href="{{ route('admin.orders.index') }}" class="btn btn-primary">{{ __('dashboard.view_more') }} <i class="fas fa-chevron-right"></i></a>
							</div>
						</div>
						<div class="card-body p-0">
							<div class="table-responsive table-invoice">
								<table class="table table-striped">
									<tr>
										<th>{{ __('levels.name') }}</th>
										<th>{{ __('levels.status') }}</th>
										<th>{{ __('levels.total') }}</th>
										<th>{{ __('levels.action') }}</th>
									</tr>
									@if(!blank($recentOrders))
										@foreach($recentOrders as $order)
												@if($loop->index > 4)
													@break
												@endif
											<tr>
												<td>{{ $order->user->name }}</td>
												<td>{{ trans('order_status.' . $order->status) }}</td>
												<td>{{ number_format($order->total, 2) }}</td>
												<td>
													<a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-icon btn-primary"><i class="far fa-eye"></i></a>
												</td>
											</tr>
										@endforeach
									@endif
								</table>
							</div>
						</div>
					</div>
				</div>
			@endcan
		    <div class="col-md-4">
				<div class="card">
				    <div class="profile-dashboard bg-maroon-light">
					    <a href="{{ route('admin.profile') }}">
					        <img src="{{ auth()->user()->image }}" alt="">
					    </a>
					    <h1>{{ auth()->user()->name }}</h1>
					    <p>
			            	{{ auth()->user()->getrole->name ?? '' }}
					    </p>
					</div>
			        <div class="list-group">
			            <li class="list-group-item list-group-item-action"><i class="fa fa-user"></i> {{ auth()->user()->username }}</li>
			            <li class="list-group-item list-group-item-action"><i class="fa fa-envelope"></i> {{ auth()->user()->email }}</li>
			            <li class="list-group-item list-group-item-action"><i class="fa fa-phone"></i> {{ auth()->user()->phone }}</li>
			            <li class="list-group-item list-group-item-action"><i class="fa fa-map"></i> {{ auth()->user()->address }}</li>
			        </div>
				</div>
		    </div>
		</div>
    </section>

@endsection

@section('scripts')
	<script src="{{ asset('assets/modules/highcharts/highcharts.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/highcharts-more.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/data.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/drilldown.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/exporting.js') }}"></script>
	@include('vendor.installer.update.OrderIncomeGraph')
@endsection
