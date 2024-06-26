@extends('frontend.layouts.app')

@section('main-content')
    <!--======== SETTINGS PART START =======-->
    <section class="settings">
        <div class="container">
            <div class="row">

                @include('frontend.account.partials._sidebar')

                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="settings-title">
                            <a href="{{ route('account.order') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.57 5.92969L3.5 11.9997L9.57 18.0697" stroke="#EE1D48" stroke-width="1.5"
                                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M20.4999 12H3.66992" stroke="#EE1D48" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                              </a>
                            {{ __('frontend.report_any_issue') }}
                        </h3>
                        <h3 class="settings-title text-danger">{{ $order->order_code }} </h3>
                    </div>

                    <form action="{{ route('account.store-report') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="col-12 form-group">
                            <label for="address" class="form-label required"> {{ __('frontend.description') }}</label>
                            <textarea rows="4" placeholder="Write your complain here...." name="description"
                                class="form-control
                             @error('description') is-invalid @enderror"
                                value="{{ old('description') }}">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 form-group isolate">
                            <label for="customFile" class="form-label required"> {{ __('levels.image') }} </label> 
                            <div class="form-uploader">
                                <img id="previewImage" src="{{ asset('frontend/images/file.jpg') }}" alt="{{ __('profile image') }}"/>

                                <span>{{ __('levels.upload_image') }}</span>

                                <label for="customFile">{{ __('levels.choose_file') }}</label>

                                <input name="image" type="file"
                                    class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);" hidden>


                                @if ($errors->has('image'))
                                    <div class="help-block text-danger">
                                        {{ $errors->first('image') }}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="form-btn-inline" type="submit">
                                <i class="sl sl-icon-docs"></i>
                                {{ __('frontend.report') }}
                            </button>
                        </div>
                    </form>
                    </fieldset>
                </div>

            </div>
        </div>
    </section>
    <!--======= SETTINGS PART END ====-->
@endsection


@push('js')
    <script src="{{ asset('js/profile/index.js') }}"></script>
@endpush
