@extends('frontend.layouts.app')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="booking-confirmation-page text-center">
                    <i class="fa fa-check-circle"></i>
                    <h2 class="mt-3 fw-bold">{{ __('frontend.thanks_for_your_booking') }}</h2>
                    <p>{{ __('frontend.confirmation_email') }}
                        <span class="text-danger">
                        {{ $reservation->email }}
                    </span>
                    </p>
                    <a href="{{ route('account.reservations') }}"
                        class="button form-btn-inline mt-3 d-inline-flex align-items-center justify-content-center">
                        {{ __('frontend.check_your_reservation') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
