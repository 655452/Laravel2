@extends('admin.layouts.master')

@section('main-content')
	
	<section class="section">
        <div class="section-header">
            <h1>{{ __('levels.restaurant_owners') }}</h1>
            {{ Breadcrumbs::render('restaurant-owners/edit') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-12 col-lg-12">
			    	<form action="{{ route('admin.restaurant-owners.update', $user) }}" method="POST" enctype="multipart/form-data">
			    		@csrf
			    		@method('PUT')
				    	<div class="card">
					    	<div class="card-body">
					    		<div class="form-row">
							        <div class="form-group col">
				                        <label>{{ __('levels.first_name') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}">
				                        @error('first_name')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('levels.last_name') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}">
				                        @error('last_name')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

				                <div class="form-row">
							        <div class="form-group col">
				                        <label>{{ __('levels.email') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
				                        @error('email')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('levels.phone') }}</label>
				                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" onkeypress='validate(event)'>
				                        @error('phone')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

								<div class="form-row">
							        <div class="form-group col">
				                        <label>{{ __('levels.username') }}</label>
				                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}">
				                        @error('username')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('levels.password') }}</label>
				                        <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
				                        @error('password')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

				                <div class="form-row">
							        <div class="form-group col">
	                                    <label for="customFile">{{ __('levels.image') }}</label>
	                                    <div class="custom-file">
	                                        <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
	                                        <label  class="custom-file-label" for="customFile">{{ __('levels.choose_file') }}</label>
	                                    </div>
										@if ($errors->has('image'))
											<div class="help-block text-danger">
												{{ $errors->first('image') }}
											</div>
										@endif
										@if($user->getFirstMediaUrl('user'))
											<img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset($user->getFirstMediaUrl('user')) }}" alt="your image"/>
										@else
											<img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/user.png') }}" alt="your image"/>
										@endif
	                                </div>
							        <div class="form-group col">
				                        <label>{{ __('levels.address') }}</label>
				                        <textarea name="address" class="form-control small-textarea-height" id="address" cols="30" rows="10">{{ old('address', $user->address) }}</textarea>
				                        @error('address')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

				                <div class="form-row">
				                	<div class="form-group col-md-6">
							            <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
							            <select name="status" class="form-control @error('status') is-invalid @enderror">
							            	@foreach(trans('user_statuses') as $key => $status)
							                	<option value="{{ $key }}" {{ (old('status', $user->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
							                @endforeach
							            </select>
							            @error('status')
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
						</div>
		            </form>
				</div>
        	</div>
        </div>
    </section>

@endsection


@section('scripts')
	<script src="{{ asset('js/customer/edit.js') }}"></script>
	<script src="{{ asset('js/phone_validation/index.js') }}"></script>
@endsection