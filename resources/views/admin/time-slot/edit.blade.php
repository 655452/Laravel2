@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('time_slot.time_slot') }}</h1>
            {{ Breadcrumbs::render('time-slots/edit') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-6 col-lg-6">
				    <div class="card">
				    	<form action="{{ route('admin.time-slots.update', $timeSlot) }}" method="POST">
				    		@csrf
				    		@method('PUT')
						    <div class="card-body">
                                @if(auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
                                    <div class="form-group">
                                        <label for="area">{{ __('levels.restaurant') }}</label> <span class="text-danger">*</span>
                                        <select name="restaurant_id" id="area"
                                                class="select2 form-control @error('restaurant_id') is-invalid red-border @enderror">
                                            <option value="">{{ __('levels.select_restaurant') }}</option>
                                            @if(!blank($restaurants))
                                                @foreach($restaurants as $restaurant)
                                                    <option value="{{ $restaurant->id }}"
                                                        {{ (old('restaurant_id', $timeSlot->restaurant_id) == $restaurant->id) ? 'selected' : '' }}> {{ $restaurant->name }}
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
                                    <input type="hidden" name="restaurant_id" value="{{auth()->user()->restaurant->id ?? 0}}">
                                @endif
						        <div class="form-group">
			                        <label>{{ __('levels.start_time') }}</label> <span class="text-danger">*</span>
			                        <input type="text" name="start_time" class="form-control timepicker @error('start_time') is-invalid @enderror" value="{{ old('start_time', $timeSlot->start_time) }}">
			                        @error('start_time')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>

						        <div class="form-group">
			                        <label>{{ __('levels.end_time') }}</label> <span class="text-danger">*</span>
			                        <input type="text" name="end_time" class="form-control timepicker @error('end_time') is-invalid @enderror" value="{{ old('end_time', $timeSlot->end_time) }}">
			                        @error('end_time')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>

						        <div class="form-group">
						            <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
						            <select name="status" class="form-control @error('status') is-invalid @enderror">
						            	@foreach(trans('statuses') as $key => $status)
						                	<option value="{{ $key }}" {{ (old('status', $timeSlot->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
						                @endforeach
						            </select>
						            @error('status')
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
			</div>
        </div>
    </section>

@endsection


@section('css')
	<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endsection

@section('scripts')
	<script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
	<script src="{{ asset('js/time-slot/create.js') }}"></script>
@endsection
