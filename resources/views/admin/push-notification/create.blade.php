@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('push_notification.push_notification') }}</h1>
            {{ Breadcrumbs::render('push-notification/add') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-12 col-lg-12">
				    <div class="card">
						<form action="{{ route('admin.push-notification.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="card-body">
								<div class="form-row">
									<div class="col-6">
										@if(auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
										<div class="form-group ">
											<label for="restaurant_id">{{ __('levels.restaurant') }}</label>
											<select name="restaurant_id" id="restaurant_id" class="select2 form-control @error('restaurant_id') is-invalid red-border @enderror">
												<option value="">{{ __('Select Restaurant') }}</option>
												@if(!blank($restaturants))
												@foreach($restaturants as $restaturant)
												<option value="{{ $restaturant->id }}" {{ (old('restaturant_id') == $restaturant->id) ? 'selected' : '' }}>{{ $restaturant->name }}</option>
												@endforeach
												@endif
											</select>
											@error('restaturant_id')
											<div class="invalid-feedback">
												{{ $message }}
											</div>
											@enderror
										</div>
										@else
										<input type="hidden" name="restaurant_id" value="{{ auth()->user()->restaurant->id ?? 0 }}">
										@endif

										<div class="form-group">
											<label>{{ __('levels.title') }}</label> <span class="text-danger">*</span>
											<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
											@error('title')
											<div class="invalid-feedback">
												{{ $message }}
											</div>
											@enderror
										</div>

										<div class="form-group">
											<label for="customFile">{{ __('levels.image') }}</label>
											<div class="custom-file">
												<input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this,'previewImage');">
												<label class="custom-file-label" for="customFile">{{ __('levels.choose_file') }}</label>
											</div>
											@if ($errors->has('image'))
											<div class="help-block text-danger">
												{{ $errors->first('image') }}
											</div>
											@endif
											<img class="img-thumbnail mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/notification.png') }}" alt="your image" style="width: 120px" />
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label>{{ __('Select Customer') }}</label>
											<select name="customer_id" id="area" class="select2 form-control @error('customer_id') is-invalid red-border @enderror">
												<option value="0">{{ __('All Customer') }}</option>
												@if(!blank($customers))
												@foreach($customers as $customer)
												<option value="{{ $customer->id }}" {{ (old('customer_id') == $customer->id) ? 'selected' : '' }}>{{ $customer->name }}
												</option>
												@endforeach
												@endif
											</select>
											@error('customer_id')
											<div class="invalid-feedback">
												{{ $message }}
											</div>
											@enderror
										</div>
										<div class="form-group ">
											<label>{{ __('levels.description') }}</label><span class="text-danger">*</span>
											<textarea name="description" class="summernote-simple form-control height-textarea @error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
											@error('description')
											<div class="invalid-feedback">
												{{ $message }}
											</div>
											@enderror
										</div>
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


@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
	<script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script>
        function readURL(input,previewImage) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+previewImage).attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            let fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
