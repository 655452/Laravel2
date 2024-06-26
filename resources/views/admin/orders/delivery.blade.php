@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('order.orders') }}</h1>
            {{ Breadcrumbs::render('orders/delivery') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-4 col-md-4 col-lg-4">
			    	<div class="card">
					    <div class="card-body card-profile">
					        <img class="profile-user-img img-responsive img-circle" src="{{ $order->delivery->image }}" alt="User profile picture">
					        <h3 class="text-center">{{ $order->delivery->name }}</h3>
					        <p class="text-center">
					        	{{ $order->delivery->getrole->name }}
					        </p>
					    </div>
					    <!-- /.box-body -->
					</div>
				</div>
	   			<div class="col-8 col-md-8 col-lg-8">
			    	<div class="card">
			    		<div class="card-body">
			    			<div class="profile-desc">
			    				<div class="single-profile">
			    					<p><b>{{ __('levels.first_name') }}: </b> {{ $order->delivery->first_name}}</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('levels.last_name') }}: </b> {{ $order->delivery->last_name}}</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('levels.email') }}: </b> {{ $order->delivery->email}}</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('levels.phone') }}: </b> {{ $order->delivery->phone}}</p>
			    				</div>
			    				<div class="single-full-profile">
			    					<p><b>{{ __('levels.address') }}: </b> {{ $order->delivery->address}}</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('levels.status') }}: </b>
										@php
							        		$status = $order->delivery->status;
							        		echo trans('user_statuses.'.$status);
							        	@endphp
			    					</p>
			    				</div>
			    				<div class="single-profile">
			    					<p><b>{{ __('levels.username') }}: </b> {{ $order->delivery->username}}</p>
			    				</div>
			    			</div>
			    		</div>
			    	</div>
				</div>
        	</div>
        </div>
    </section>

@endsection
