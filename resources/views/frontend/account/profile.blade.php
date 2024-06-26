@extends('frontend.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/lib/inttelinput/css/intlTelInput.css') }}">
@endpush

@section('main-content')
    <!--======== SETTINGS PART START =======-->
    <section class="settings">
        <div class="container">
            <div class="row">

                @include('frontend.account.partials._sidebar')

                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="profile-user">
                        <div class="profile-meta">
                            <img alt="image" src="{{ $user->image }}">
                            <dl>
                                <dt> {{ $user->name }} </dt>
                                <dd>
                                    <span><small>{{ __('levels.limit') }}</small>
                                        {{ isset($user->deposit->limit_amount) ? currencyFormat($user->deposit->limit_amount) : '' }}
                                    </span>
                                    <span><small>{{ __('levels.deposit') }}</small>
                                        {{ isset($user->deposit->deposit_amount) ? currencyFormat($user->deposit->deposit_amount) : '' }}
                                    </span>
                                    <span><small>{{ __('levels.credit') }} </small>
                                        {{ currencyFormat($user->balance->balance) }}
                                    </span>

                                    @if (auth()->user()->myrole == \App\Enums\UserRole::DELIVERYBOY)
                                        <span><small>{{ __('C.O.D. Amount') }} </small>
                                            {{ currencyFormat($user->deliveryBoyAccount->balance > 0 ? $user->deliveryBoyAccount->balance : 0) }}
                                        </span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                        <ul class="profile-data">
                            <li><span>{{ __('levels.username') }} </span>{{ $user->username }} </li>
                            <li><span>{{ __('levels.phone') }}</span>+{{ $user->country_code }} {{ $user->phone }}</li>
                            <li><span>{{ __('levels.email') }}</span>{{ $user->email }}</li>
                            <li><span>{{ __('levels.address') }}</span>{{ $user->address }}</li>
                        </ul>
                    </div>
                    <fieldset class="form-fieldset">
                        <legend class="form-legend"> {{ __('frontend.edit_profile') }}</legend>
                        <form class="row" action="{{ route('account.profile.update', $user) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-12 col-sm-6 form-group">
                                <label for="fname" class="form-label required">{{ __('levels.first_name') }} </label>
                                <input id="fname" type="text" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name', $user->first_name) }}">
                                @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="lname" class="form-label required">{{ __('levels.last_name') }} </label>
                                <input id="lname" type="text" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name', $user->last_name) }}">
                                @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="email" class="form-label required">{{ __('levels.email') }} </label>
                                <input id="email" type="text" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="number" class="form-label required">{{ __('levels.phone') }} </label>
                                    <input class="form-control mobilenumber @error('phone') is-invalid @enderror phone" type="tel"
                                    id="number" name="phone" placeholder="" value="{{ old('phone', $user->phone) }}" onkeypress='validate(event)'>

                                <input type="hidden" id="code" name="countrycode" value="{{$user->country_code}}">
                                <input type="hidden" id="code_name" name="countrycodename" value="{{$user->country_code_name}}">

                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 form-group">
                                <label for="uname" class="form-label required">{{ __('levels.username') }}</label>
                                <input id="uname" type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username', $user->username) }}">
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 form-group">
                                <label for="address" class="form-label required">{{ __('levels.address') }}</label>
                                <textarea name="address" class="form-control " id="address">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 form-group isolate">
                                <label class="form-label required">{{ __('levels.image') }} </label>
                                <div class="form-uploader">
                                    <img id="previewImage" src="{{$user->image }}"  alt="{{ $user->name }} {{ __('profile image') }}"/>

                                    <span>{{ __('levels.upload_profile_image') }}</span>

                                    <label for="uploader">{{ __('levels.choose_file') }} </label>

                                    <input name="image" type="file"
                                        class="custom-file-input @error('image') is-invalid @enderror" id="uploader"
                                        onchange="readURL(this);" hidden>

                                    @if ($errors->has('image'))
                                        <div class="help-block text-danger">
                                            {{ $errors->first('image') }}
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button class="form-btn-inline" type="submit">
                                    {{ __('frontend.update_profile') }}</button>
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
    <script>
        var country_code_name = "{{$user->country_code_name}}";
    </script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput-jquery.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/utils.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/data.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/init.js') }}"></script>


    <script src="{{ asset('js/profile/index.js') }}"></script>
    <script src="{{ asset('js/phone_validation/index.js') }}"></script>
@endpush
