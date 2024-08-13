@extends('frontend.layouts.app')
<!-- @push('style')
    <link rel="stylesheet" href="{{ asset('frontend/lib/inttelinput/css/intlTelInput.css') }}">
@endpush -->

@section('main-content')
    <!--========= REGISTER PART START =======-->
    <section class="auth">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-7">
                    <div class="auth-content">
                        <nav class="auth-navs">
                            <a class="nav-link" href="{{ route('login') }}"> {{ __('login') }} </a>
                            <a id="reg" class="nav-link " href="{{ route('register') }}"> {{ __('register') }}</a>
                           
                        </nav>
                        <div class="auth-tabs">
                            <form id="registerForm" method="POST" class="register" action="{{ route('register') }}">
                                @csrf
                                <ul class="auth-types">
                                    <li style="display: none;"d="resCustomer" >
                                        <input type="radio" id="CustomerRegister" name="roles" value="2"
                                        {{ old('roles', 2)== 2 ? 'checked' : 'checked'}}>
                                        <label for="CustomerRegister">{{ __('Customer') }}</label>
                                    </li>
                                    <li id="resOwner" >
                                        <input type="radio" id="RestaurantOwnerRegister" name="roles" value="3"
                                        {{ old('roles')== 3 ? 'checked' : ''}}>
                                        <label for="RestaurantOwnerRegister">{{ __('seller') }}</label>
                                    </li>
                                    <!-- <li>
                                        <input type="radio" id="DeliveryRegister" name="roles" value="4"
                                        {{ old('roles')== 4 ? 'checked' : ''}}>
                                        <label for="DeliveryRegister">{{ __('Delivery Man') }}</label>
                                    </li> -->
                                </ul>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name"
                                                class="form-label required">{{ __('First name') }}</label>
                                            <input name="first_name" value="First Name" type="text"
                                                class="form-control @if ($errors->has('first_name')) is-invalid @endif"
                                                placeholder="John">
                                            @if ($errors->has('first_name'))
                                                <div class="invalid-feadback text-danger" role="alert">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name"
                                                class="form-label required">{{ __('Last Name') }}</label>
                                            <input name="last_name" value="Last Name" type="text"
                                                class="form-control @if ($errors->has('last_name')) is-invalid @endif"
                                                placeholder="Doe">
                                            @if ($errors->has('last_name'))
                                                <div class="invalid-feadback text-danger" role="alert">
                                                    {{ $errors->first('last_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="username" class="form-label required">{{ __('Username') }}</label>
                                            <input id="username" name="username" value="Username"
                                                type="text"
                                                class="form-control @if ($errors->has('username')) is-invalid @endif"
                                                placeholder="john">
                                            @if ($errors->has('username'))
                                                <div class="invalid-feadback text-danger" role="alert">
                                                    {{ $errors->first('username') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="register_email"
                                                class="form-label required">{{ __('Email Address') }} </label>
                                            <input name="register_email" value="Email" type="email"
                                                class="form-control @if ($errors->has('register_email')) is-invalid @endif"
                                                placeholder="johndoe@example.com">
                                            @if ($errors->has('register_email'))
                                                <span class="is-invalid" role="alert">
                                                    <strong
                                                        class="text-danger">{{ $errors->first('register_email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label required">{{ __('frontend.phone') }} </label>
                                            <!-- <input
                                                class="form-control mobilenumber @error('mobile') is-invalid @enderror phone"
                                                type="tel" id="number" name="phone" onkeypress='validate(event)'> -->
                                                <input
                                                class="form-control mobilenumber @error('mobile') is-invalid @enderror phone"
                                                type="tel" id="number2" name="phone" onkeypress='validate(event)' placeholder="Phone number">

                                            <input type="hidden" id="code" name="countrycode" value="91">
                                            <input type="hidden" id="code_name" name="countrycodename" value="in">

                                            @error('phone')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const phoneInputField = document.getElementById("number2");
                                            const iti = window.intlTelInput(phoneInputField, {
                                                initialCountry: "in", // Set the default country to India
                                                preferredCountries: ["in"], // Optionally, make India the preferred country
                                                separateDialCode: true, // This will display the country code next to the flag
                                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                                            });
                                        
                                            // Update the hidden inputs when the country is changed
                                            phoneInputField.addEventListener('countrychange', function() {
                                                const selectedCountryData = iti.getSelectedCountryData();
                                                document.getElementById("code").value = selectedCountryData.dialCode;
                                                document.getElementById("code_name").value = selectedCountryData.iso2;
                                            });
                                        });
                                    </script>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address" class="form-label required">{{ __('Address') }}</label>
                                            <input id="address" name="address" value="Address"
                                                type="text"
                                                class="form-control @if ($errors->has('address')) is-invalid @endif"
                                                placeholder="House#10, Section#1, Dhaka 1216, Bangladesh">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="password"
                                                class="form-label required">{{ __('Password') }}</label>
                                            <input name="password" id="password"
                                                class="form-control @if ($errors->has('password')) is-invalid @endif"
                                                type="password" placeholder="Create password">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="password2"
                                                class="form-label required">{{ __('Repeat Password') }}</label>
                                            <input name="password_confirmation"
                                                class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif"
                                                type="password" placeholder="Repeat password">
                                            @if ($errors->has('password_confirmation'))
                                                <span class="is-invalid" role="alert">
                                                    <strong
                                                        class="text-danger">{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                        <div style="
                                                    display: flex;
                                                    width: 200px;
                                                        margin-bottom: 12px;
                                                    justify-content: space-evenly;
                                                ">
                                                    <input type="checkbox" id="Terms"  style="
                                                    border: 2px solid black;
                                                    width: 20px;
                                                    height: 20px;
                                                "><a href="http://woich.in/page/terms-and-condition" style="
                                                    font-size: 13px;
                                                    color: black;
                                                "> Terms &amp; Conditions </a>
                                        </div>
                                    <div class="col-12">
                                        <input type="submit" class="form-btn mt-2" name="register" value="Register" />
                                    </div>
                                </div>
                            </form>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                    const urlParams = new URLSearchParams(window.location.search);
                                    const role = urlParams.get('role');

                                    if (role === 'restaurant_owner') {
                                        document.getElementById('resCustomer').style.display  = "none";
                                        document.getElementById('RestaurantOwnerRegister').checked = true;
                                        document.getElementById("seller").className="nav-link active"
                                    } else {
                                        document.getElementById('CustomerRegister').checked = true;
                                        document.getElementById("reg").className="nav-link active"
                                        document.getElementById('resOwner').style.display  = "none";
                                        
                                    }
                                });
                                    document.getElementById('registerForm').addEventListener('submit', function(event) {
                                        var termsCheckbox = document.getElementById('Terms');
                                        if (!termsCheckbox.checked) {
                                            alert('Please check the Terms and Conditions.');
                                            event.preventDefault(); // Prevent the form from submitting
                                        }
                                    });
                                </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="auth-banner" src="{{ asset('frontend/images/auth.jpg') }}" alt="auth">
    </section>
    <!--======== REGISTER PART END ======-->
@endsection

@push('js')
<script>
    var country_code_name ='';
</script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput-jquery.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/utils.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/data.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/init.js') }}"></script>
    <script src="{{ asset('js/phone_validation/index.js') }}"></script>
@endpush
