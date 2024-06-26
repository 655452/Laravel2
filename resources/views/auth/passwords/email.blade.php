@extends('frontend.layouts.app')

@section('main-content')
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row  justify-content-center">
                <div class="col-lg-6">
                    <div class="card mx-auto reset-email-card">
                        <div class="card-body text-center p-lg-4 p-2">
                            <h4 class="card-title mb-4">{{ __('Reset Password') }}</h4>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group">
                                    <input id="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif"
                                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="form-btn-inline">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <p class="text-center mt-4">{{ __("Don't have account?") }} <a class="linkTxt" href="{{ route('register') }}">{{ __('Sign up') }}</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection
