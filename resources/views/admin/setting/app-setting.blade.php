@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
{{ Breadcrumbs::render('app-setting') }}
@endsection

@section('admin.setting.layout')
<div class="col-md-9">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.app-update') }}" enctype="multipart/form-data">
                @csrf


                <fieldset class="setting-fieldset">
                    <legend class="setting-legend">{{ __('setting.customer_app_setting') }}</legend>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="customer_app_name">{{ __('setting.app_name') }}</label>
                                <span class="text-danger">*</span>
                                <input name="customer_app_name" id="customer_app_name" type="text" class="form-control @error('customer_app_name') is-invalid @enderror" value="{{ old('customer_app_name', setting('customer_app_name')) }}">
                                @error('customer_app_name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="customer_app_logo">{{ __('setting.app_logo') }}</label>
                                <div class="custom-file">
                                    <input name="customer_app_logo" type="file" class="file-upload-input custom-file-input @error('customer_app_logo') is-invalid @enderror" id="customer_app_logo" onchange="readURL(this,'previewImage1');">
                                    <label class="custom-file-label" for="customer_app_logo">{{ __('setting.choose_file') }}</label>
                                </div>
                                @error('customer_app_logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if(setting('customer_app_logo'))
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage1" src="{{ asset('images/app/'.setting('customer_app_logo')) }}" alt="{{ __('Food Express Logo') }}" />
                                @else
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage1" src="{{ asset('images/app/logo.png') }}" alt="{{ __('Food Express Logo') }}" />
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="customer_splash_screen_logo">{{ __('setting.splash_screen_logo') }}</label>
                                <div class="custom-file">
                                    <input name="customer_splash_screen_logo" type="file" class="file-upload-input custom-file-input @error('customer_splash_screen_logo') is-invalid @enderror" id="customer_splash_screen_logo" onchange="readURL(this,'previewImage2');">
                                    <label class="custom-file-label" for="customer_splash_screen_logo">{{ __('setting.choose_file') }}</label>
                                </div>
                                @error('customer_splash_screen_logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if(setting('customer_splash_screen_logo'))
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage2" src="{{ asset('images/app/'.setting('customer_splash_screen_logo')) }}" alt="{{ __('Food Express Logo') }}" />
                                @else
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage2" src="{{ asset('images/app/logo.png') }}" alt="{{ __('Food Express Logo') }}" />
                                @endif
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="setting-fieldset">
                    <legend class="setting-legend">{{ __('setting.vendor_app_setting') }}</legend>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="vendor_app_name">{{ __('setting.app_name') }}</label>
                                <span class="text-danger">*</span>
                                <input name="vendor_app_name" id="vendor_app_name" type="text" class="form-control @error('vendor_app_name') is-invalid @enderror" value="{{ old('vendor_app_name', setting('vendor_app_name')) }}">
                                @error('vendor_app_name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="vendor_app_logo">{{ __('setting.app_logo') }}</label>
                                <div class="custom-file">
                                    <input name="vendor_app_logo" type="file" class="file-upload-input custom-file-input @error('vendor_app_logo') is-invalid @enderror" id="vendor_app_logo" onchange="readURL(this,'previewImage3');">
                                    <label class="custom-file-label" for="vendor_app_logo">{{ __('setting.choose_file') }}</label>
                                </div>
                                @error('vendor_app_logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if(setting('vendor_app_logo'))
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage3" src="{{ asset('images/app/'.setting('vendor_app_logo')) }}" alt="{{ __('Food Express Logo') }}" />
                                @else
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage3" src="{{ asset('images/app/logo.png') }}" alt="{{ __('Food Express Logo') }}" />
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="vendor_splash_screen_logo">{{ __('setting.splash_screen_logo') }}</label>
                                <div class="custom-file">
                                    <input name="vendor_splash_screen_logo" type="file" class="file-upload-input custom-file-input @error('vendor_splash_screen_logo') is-invalid @enderror" id="vendor_splash_screen_logo" onchange="readURL(this,'previewImage4');">
                                    <label class="custom-file-label" for="vendor_splash_screen_logo">{{ __('setting.choose_file') }}</label>
                                </div>
                                @error('vendor_splash_screen_logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if(setting('vendor_splash_screen_logo'))
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage4" src="{{ asset('images/app/'.setting('vendor_splash_screen_logo')) }}" alt="{{ __('Food Express Logo') }}" />
                                @else
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage4" src="{{ asset('images/app/logo.png') }}" alt="{{ __('Food Express Logo') }}" />
                                @endif
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="setting-fieldset">
                    <legend class="setting-legend">{{ __('setting.delivery_app_setting') }}</legend>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="delivery_app_name">{{ __('setting.app_name') }}</label>
                                <span class="text-danger">*</span>
                                <input name="delivery_app_name" id="delivery_app_name" type="text" class="form-control @error('delivery_app_name') is-invalid @enderror" value="{{ old('delivery_app_name', setting('delivery_app_name')) }}">
                                @error('delivery_app_name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="delivery_app_logo">{{ __('setting.app_logo') }}</label>
                                <div class="custom-file">
                                    <input name="delivery_app_logo" type="file" class="file-upload-input custom-file-input @error('delivery_app_logo') is-invalid @enderror" id="delivery_app_logo" onchange="readURL(this,'previewImage5');">
                                    <label class="custom-file-label" for="delivery_app_logo">{{ __('setting.choose_file') }}</label>
                                </div>
                                @error('delivery_app_logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if(setting('delivery_app_logo'))
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage5" src="{{ asset('images/app/'.setting('delivery_app_logo')) }}" alt="{{ __('Food Express Logo') }}" />
                                @else
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage5" src="{{ asset('images/app/logo.png') }}" alt="{{ __('Food Express Logo') }}" />
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="delivery_splash_screen_logo">{{ __('Splash Screen Logo') }}</label>
                                <div class="custom-file">
                                    <input name="delivery_splash_screen_logo" type="file" class="file-upload-input custom-file-input @error('delivery_splash_screen_logo') is-invalid @enderror" id="delivery_splash_screen_logo" onchange="readURL(this,'previewImage6');">
                                    <label class="custom-file-label" for="delivery_splash_screen_logo">{{ __('setting.choose_file') }}</label>
                                </div>
                                @error('delivery_splash_screen_logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if(setting('delivery_splash_screen_logo'))
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage6" src="{{ asset('images/app/'.setting('delivery_splash_screen_logo')) }}" alt="{{ __('Food Express Logo') }}" />
                                @else
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage6" src="{{ asset('images/app/logo.png') }}" alt="{{ __('Food Express Logo') }}" />
                                @endif
                            </div>
                        </div>
                    </div>
                </fieldset>



                <div class="row">
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary">
                            <span>{{ __('setting.update_app_setting') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
