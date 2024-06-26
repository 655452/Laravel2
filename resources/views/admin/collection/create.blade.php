@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('collection.collections') }}</h1>
            {{ Breadcrumbs::render('collection/add') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-6 col-lg-6">
				    <div class="card">
				    	<form action="{{ route('admin.collection.store') }}" method="POST" autocomplete="off">
				    		@csrf
						    <div class="card-body">

						        <div class="form-group">
						            <label>{{ __('levels.name') }}</label> <span class="text-danger">*</span>
						            <select id="user_id" name="user_id" class="form-control select2 @error('user_id') is-invalid @enderror" data-url="{{ route('admin.collection.get-delivery-boy') }}">
						            	<option value="0">{{ __('Select Delivery Boy') }}</option>
						            	<?php $selectUser = []; ?>
						            	@if(!blank($users))
							            	@foreach($users as $user)
						            			@if($user->id == old('user_id'))
						            				<?php  $selectUser = $user; ?>
						            			@endif
							                	<option value="{{ $user->id }}" {{ (old('user_id') == $user->id) ? 'selected' : '' }}>{{ $user->name }} {{ !blank($user->phone)  ? ' ('.$user->phone.')' : '' }}</option>
							                @endforeach
							            @endif
						            </select>
						            @error('user_id')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
						        </div>

						        <div class="form-group">
			                        <label>{{ __('levels.date') }}</label> <span class="text-danger">*</span>
			                        <input type="text" name="date" class="form-control datepicker @error('date') is-invalid @enderror" value="{{ old('date') }}">
			                        @error('date')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>

			                    <div class="form-group">
			                        <label>{{ __('levels.amount') }}</label> <span class="text-danger">*</span>
			                        <input type="number" step=".01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
			                        @error('amount')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>
						    </div>

					        <div class="card-footer">
		                    	<button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
		                  	</div>
		                </form>
					</div>
				</div>


                <div id="userInfo" class="col-12 col-md-12 col-lg-4">
                    @if(!blank($selectUser))
                        <div class="card profile-widget margin-hidden">
                            <div class="profile-widget-header">
                                <img alt="image" src="{{ $selectUser->image }}" class="rounded-circle profile-picture center ">
                            </div>
                            <div class="profile-widget-description">
                                <dl class="row">
                                    <dt class="col-sm-5">{{ __('levels.name') }} <strong class="float-right">:</strong></dt>
                                    <dd class="col-sm-7">{{ $selectUser->name }}</dd>
                                    <dt class="col-sm-5">{{ __('levels.phone') }} <strong class="float-right">:</strong></dt>
                                    <dd class="col-sm-7">{{ $selectUser->phone }}</dd>
                                    <dt class="col-sm-5">{{ __('levels.email') }} <strong class="float-right">:</strong></dt>
                                    <dd class="col-sm-7">{{ $selectUser->email }}</dd>
                                    <dt class="col-sm-5">{{ __('levels.order_balance') }} <strong class="float-right">:</strong></dt>
                                    <dd class="col-sm-7">{{ currencyFormat($selectUser->deliveryBoyAccount->balance) }}</dd>
                                    <dt class="col-sm-5">{{ __('levels.credit') }} <strong class="float-right">:</strong></dt>
                                    <dd class="col-sm-7">{{ currencyFormat($selectUser->balance->balance > 0 ? $selectUser->balance->balance : 0 ) }}</dd>
                                    <dt class="col-sm-5">{{ __('levels.address') }} <strong class="float-right">:</strong></dt>
                                    <dd class="col-sm-7">{{ $selectUser->address }}</dd>
                                    <dt class="col-sm-5">{{ __('levels.status') }} <strong class="float-right">:</strong></dt>
                                    <dd class="col-sm-7">{{ $selectUser->mystatus }}</dd>
                                </dl>
                            </div>
                        </div>
                    @endif
                </div>
			</div>
        </div>
    </section>

@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/collection/create.js') }}"></script>
@endsection
