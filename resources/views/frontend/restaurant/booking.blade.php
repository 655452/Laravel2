@extends('frontend.layouts.app')
@push('style')
<link rel="stylesheet" href="{{ asset('frontend/lib/inttelinput/css/intlTelInput.css') }}">
@endpush

@section('main-content')
<!--======= BOOKING PART START =======-->
<section class="booking">
    <div class="container">
        <a href="#0" class="booking-paginate">
            <i class="fa-solid fa-arrow-left"></i>
            <span>{{ __('frontend.booking') }}</span>
        </a>
        <div class="booking-group">
            <form action="{{ route('restaurant.reservation.store', ['restaurant_id' => $restaurant->id, 'reservation_date' => $reservationDate, 'time_slot' => $timeSlot->id, 'guest' => $guest]) }}"
                method="GET" enctype="multipart/form-data">

                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                <input type="hidden" name="reservation_date" value="{{ $reservationDate }}">
                <input type="hidden" name="guest" value="{{ $guest }}">
                <input type="hidden" name="time_slot" value="{{ $timeSlot->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <fieldset class="booking-fieldset">

                    <legend>{{ __('frontend.personal_details') }} </legend>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (auth()->user())
                    <div class="form-group">
                        <label class="form-label required">{{ __('frontend.first_name') }}</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                            placeholder="{{ __('frontend.first_name') }}" name="first_name"
                            value="{{ old('first_name', auth()->user()->first_name) }}">
                        @error('first_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label required">{{ __('frontend.last_name') }} </label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                            placeholder="{{ __('frontend.last_name') }}" name="last_name"
                            value="{{ old('last_name', auth()->user()->last_name) }}">
                        @error('last_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label required">{{ __('frontend.email_address') }} </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="{{ __('frontend.email_address') }}" name="email"
                            value="{{ old('email', auth()->user()->email) }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label required">{{ __('frontend.phone_number') }} </label>
                        <input class="form-control mobilenumber @error('mobile') is-invalid @enderror phone" type="tel"
                        id="number" name="phone"  onkeypress='validate(event)'>

                        <input type="hidden" id="code" name="countrycode" value="1">

                        @error('phone')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    @else
                    <div class="form-group">
                        <label class="form-label required">{{ __('frontend.first_name') }}</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                            placeholder="{{ __('frontend.first_name') }}" name="first_name"
                            value="{{ old('first_name') }}">
                        @error('first_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label required">{{ __('frontend.last_name') }} </label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                            placeholder="{{ __('frontend.last_name') }}" name="last_name"
                            value="{{ old('last_name') }}">
                        @error('last_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label required">{{ __('frontend.email_address') }} </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="{{ __('frontend.email_address') }}" name="email" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label required">{{ __('frontend.phone_number') }} </label>

                        <input class="form-control mobilenumber @error('mobile') is-invalid @enderror phone" type="tel"
                        id="number"  name="phone"  onkeypress='validate(event)'>

                        <input type="hidden" id="code" name="countrycode" value="1">

                        @error('phone')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    @endif

                    <button class="form-btn mt-3" type="submit">{{ __('frontend.confirm_booking') }} </button>
                </fieldset>
            </form>

            <div class="booking-card">
                <figure class="booking-card-figure">
                    <img class="restturnt" src="{{ asset($restaurant->image) }}" alt="restaurant">
                    <figcaption class="booking-card-figcaption">
                        <dl>
                            <dt> {{ $restaurant->name }} </dt>
                            <dd>
                                <i class="fa-solid fa-star"></i>
                                <span>{{ $restaurant->avgRating($restaurant->id)['countUser'] }}</span>
                            </dd>
                        </dl>
                        <p>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.99992 8.95346C9.14867 8.95346 10.0799 8.02221 10.0799 6.87346C10.0799 5.7247 9.14867 4.79346 7.99992 4.79346C6.85117 4.79346 5.91992 5.7247 5.91992 6.87346C5.91992 8.02221 6.85117 8.95346 7.99992 8.95346Z"
                                    stroke="white" stroke-width="1.5" />
                                <path
                                    d="M2.41379 5.66016C3.72712 -0.113169 12.2805 -0.106502 13.5871 5.66683C14.3538 9.0535 12.2471 11.9202 10.4005 13.6935C9.06046 14.9868 6.94046 14.9868 5.59379 13.6935C3.75379 11.9202 1.64712 9.04683 2.41379 5.66016Z"
                                    stroke="white" stroke-width="1.5" />
                            </svg>
                            <span> {{ $restaurant->address }} </span>
                        </p>
                    </figcaption>
                </figure>
                <div class="booking-card-details">
                    <dl>
                        <dt>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.7502 3.56V2C16.7502 1.59 16.4102 1.25 16.0002 1.25C15.5902 1.25 15.2502 1.59 15.2502 2V3.5H8.75023V2C8.75023 1.59 8.41023 1.25 8.00023 1.25C7.59023 1.25 7.25023 1.59 7.25023 2V3.56C4.55023 3.81 3.24023 5.42 3.04023 7.81C3.02023 8.1 3.26023 8.34 3.54023 8.34H20.4602C20.7502 8.34 20.9902 8.09 20.9602 7.81C20.7602 5.42 19.4502 3.81 16.7502 3.56Z"
                                    fill="#00749B" />
                                <path
                                    d="M19 15C16.79 15 15 16.79 15 19C15 19.75 15.21 20.46 15.58 21.06C16.27 22.22 17.54 23 19 23C20.46 23 21.73 22.22 22.42 21.06C22.79 20.46 23 19.75 23 19C23 16.79 21.21 15 19 15ZM21.07 18.57L18.94 20.54C18.8 20.67 18.61 20.74 18.43 20.74C18.24 20.74 18.05 20.67 17.9 20.52L16.91 19.53C16.62 19.24 16.62 18.76 16.91 18.47C17.2 18.18 17.68 18.18 17.97 18.47L18.45 18.95L20.05 17.47C20.35 17.19 20.83 17.21 21.11 17.51C21.39 17.81 21.37 18.28 21.07 18.57Z"
                                    fill="#00749B" />
                                <path
                                    d="M20 9.83984H4C3.45 9.83984 3 10.2898 3 10.8398V16.9998C3 19.9998 4.5 21.9998 8 21.9998H12.93C13.62 21.9998 14.1 21.3298 13.88 20.6798C13.68 20.0998 13.51 19.4598 13.51 18.9998C13.51 15.9698 15.98 13.4998 19.01 13.4998C19.3 13.4998 19.59 13.5198 19.87 13.5698C20.47 13.6598 21.01 13.1898 21.01 12.5898V10.8498C21 10.2898 20.55 9.83984 20 9.83984ZM9.21 18.2098C9.02 18.3898 8.76 18.4998 8.5 18.4998C8.24 18.4998 7.98 18.3898 7.79 18.2098C7.61 18.0198 7.5 17.7598 7.5 17.4998C7.5 17.2398 7.61 16.9798 7.79 16.7898C7.89 16.6998 7.99 16.6298 8.12 16.5798C8.49 16.4198 8.93 16.5098 9.21 16.7898C9.39 16.9798 9.5 17.2398 9.5 17.4998C9.5 17.7598 9.39 18.0198 9.21 18.2098ZM9.21 14.7098C9.16 14.7498 9.11 14.7898 9.06 14.8298C9 14.8698 8.94 14.8998 8.88 14.9198C8.82 14.9498 8.76 14.9698 8.7 14.9798C8.63 14.9898 8.56 14.9998 8.5 14.9998C8.24 14.9998 7.98 14.8898 7.79 14.7098C7.61 14.5198 7.5 14.2598 7.5 13.9998C7.5 13.7398 7.61 13.4798 7.79 13.2898C8.02 13.0598 8.37 12.9498 8.7 13.0198C8.76 13.0298 8.82 13.0498 8.88 13.0798C8.94 13.0998 9 13.1298 9.06 13.1698C9.11 13.2098 9.16 13.2498 9.21 13.2898C9.39 13.4798 9.5 13.7398 9.5 13.9998C9.5 14.2598 9.39 14.5198 9.21 14.7098ZM12.71 14.7098C12.52 14.8898 12.26 14.9998 12 14.9998C11.74 14.9998 11.48 14.8898 11.29 14.7098C11.11 14.5198 11 14.2598 11 13.9998C11 13.7398 11.11 13.4798 11.29 13.2898C11.67 12.9198 12.34 12.9198 12.71 13.2898C12.89 13.4798 13 13.7398 13 13.9998C13 14.2598 12.89 14.5198 12.71 14.7098Z"
                                    fill="#00749B" />
                            </svg>
                        </dt>
                        <dd>{{ __('frontend.booking_summary') }} </dd>
                    </dl>
                    <ul>
                        <li>{{ __('frontend.date') }}<span> {{ $reservationDate }} </span></li>
                        <li>{{ __('frontend.number_of_guests') }} <span>{{ $guest }}
                                {{ __('frontend.adults') }}</span></li>
                        <li>{{ __('frontend.time_slot') }}<span> {{ date('h:i A', strtotime($timeSlot->start_time)) }}
                                - {{ date('h:i A', strtotime($timeSlot->end_time)) }} </span></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
<!--========= BOOKING PART END ==========-->
@endsection


@push('js')
<!-- INTTELINPUT for frontend -->
<script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput-jquery.js') }}"></script>
<script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput.js') }}"></script>
<script defer src="{{ asset('frontend/lib/inttelinput/js/utils.js') }}"></script>
<script defer src="{{ asset('frontend/lib/inttelinput/js/data.js') }}"></script>
<script defer src="{{ asset('frontend/lib/inttelinput/js/init.js') }}"></script>
<script src="{{ asset('js/phone_validation/index.js') }}"></script>
@endpush
