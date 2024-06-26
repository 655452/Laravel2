@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('main-content')

<section class="section">
	<div class="section-header">
		<h1>{{ __('levels.coupon') }}</h1>
		{{ Breadcrumbs::render('coupons/edit') }}
	</div>

	<div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
				<div class="card">
					<form action="{{ route('admin.coupon.update', $coupon) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
						@csrf
						@method('PUT')
						<div class="card-body">
							<div class="form-row">
								@if(auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
								<div class="form-group col">
									<label for="area">{{ __('levels.restaurants') }}</label> <span class="text-danger">*</span>
									<select name="restaurant_id" id="area" class="select2 form-control @error('restaurant_id') is-invalid red-border @enderror">
										<option value="0">{{ __('levels.select_restaurant') }}</option>
										@if(!blank($restaurants))
										@foreach($restaurants as $restaurant)
										<option value="{{ $restaurant->id }}" {{ (old('restaurant_id',$coupon->restaurant_id) == $restaurant->id) ? 'selected' : '' }}>{{ $restaurant->name }}
										</option>
										@endforeach
										@endif
									</select>
									@error('restaurant_id')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
								@else
								<input type="hidden" name="restaurant_id" value="{{auth()->user()->restaurant_id}}">
								@endif


                                @if(auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
                                <div class="form-group col-6">
									<label>{{ __('levels.name') }}</label> <span class="text-danger">*</span>
									<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$coupon->name) }}">
									@error('name')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>

                                @else
                                <div class="form-group col-12">
									<label>{{ __('levels.name') }}</label> <span class="text-danger">*</span>
									<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$coupon->name) }}">
									@error('name')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>

                                @endif


							</div>
							<div class="form-row">

								<div class="form-group col">
									<label>{{ __('levels.discount_type') }}</label> <span class="text-danger">*</span>
									<select name="discount_type" class="form-control @error('discount_type') is-invalid @enderror">
										<option value="">{{ __('levels.select_coupon_type') }}</option>
										@foreach(trans('discount_types') as $key => $discount_type)
										<option value="{{ $key }}" {{ (old('discount_type',$coupon->discount_type) == $key) ? 'selected' : '' }}>
											{{ $discount_type }}
										</option>
										@endforeach
									</select>
									@error('discount_type')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
								<div class="form-group col">
									<label>{{ __('levels.amount') }}</label> <span class="text-danger">*</span>
									<input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount',$coupon->amount) }}">
									@error('amount')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>

							</div>
							<div class="form-row">

								<div class="form-group col">
									<label>{{ __('levels.minimum_order_amount') }}</label>
									<input type="number" name="minimum_order_amount" class="form-control @error('minimum_order_amount') is-invalid @enderror" value="{{ old('minimum_order_amount',$coupon->minimum_order_amount) }}">
									@error('minimum_order_amount')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
								<div class="form-group col">
									<label>{{ __('levels.limit') }}</label> <span class="text-danger">*</span>
									<input type="number" name="limit" class="form-control @error('limit') is-invalid @enderror" value="{{ old('limit',$coupon->limit) }}">
									@error('limit')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
								<div class="form-group col">
									<label>{{ __('levels.per_user_limit') }}</label> <span class="text-danger">*</span>
									<input type="number" name="user_limit" class="form-control @error('user_limit') is-invalid @enderror" value="{{ old('user_limit',$coupon->user_limit) }}">
									@error('user_limit')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>{{ __('levels.starts_at') }}</label> <span class="text-danger">*</span>
									<input type="text" name="from_date" class=" datepicker form-control @error('from_date') is-invalid @enderror" value="{{ old('from_date',$coupon->from_date) }}">
									@error('from_date')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
								<div class="form-group col">
									<label>{{ __('levels.ends_at') }}</label> <span class="text-danger">*</span>
									<input type="text" name="to_date" class="form-control datepicker @error('to_date') is-invalid @enderror" value="{{ old('to_date',$coupon->to_date) }}">
									@error('to_date')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>
						</div>

						<div class="card-footer">
							<button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.full.min.js" integrity="sha512-hDFt+089A+EmzZS6n/urree+gmentY36d9flHQ5ChfiRjEJJKFSsl1HqyEOS5qz7jjbMZ0JU4u/x1qe211534g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/coupon/edit.js') }}"></script>
@endsection
