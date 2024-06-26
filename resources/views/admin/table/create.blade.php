@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('table.table') }}</h1>
            {{ Breadcrumbs::render('tables/add') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-6 col-lg-6">
				    <div class="card">
				    	<form action="{{ route('admin.tables.store') }}" method="POST">
				    		@csrf
						    <div class="card-body">
                                @if(auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
                                    <div class="form-group">
                                        <label for="restaurant_id">{{ __('levels.restaurant') }}</label> <span class="text-danger">*</span>
                                        <select name="restaurant_id" id="restaurant_id"
                                                class="select2 form-control @error('restaurant_id') is-invalid red-border @enderror">
                                            <option value="">{{ __('levels.select_restaurant') }}</option>
                                            @if(!blank($restaurants))
                                                @foreach($restaurants as $restaurant)
                                                    <option value="{{ $restaurant->id }}"
                                                        {{ (old('restaurant_id') == $restaurant->id) ? 'selected' : '' }}>{{ $restaurant->name }}
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
			                        <label>{{ __('levels.name') }}</label> <span class="text-danger">*</span>
			                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
			                        @error('name')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>

						        <div class="form-group">
			                        <label>{{ __('levels.capacity') }}</label> <span class="text-danger">*</span>
			                        <input type="number" step=".01" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity') }}">
			                        @error('capacity')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>

						        <div class="form-group">
						            <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
						            <select name="status" class="form-control @error('status') is-invalid @enderror">
						            	@foreach(trans('statuses') as $key => $status)
						                	<option value="{{ $key }}" {{ (old('status') == $key) ? 'selected' : '' }}>{{ $status }}</option>
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
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
@endsection
