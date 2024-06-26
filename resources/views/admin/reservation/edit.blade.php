@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">

@endsection

@section('main-content')

<section class="section">
    <div class="section-header">
    <h1>{{ __('levels.reservations') }}</h1>
        {{ Breadcrumbs::render('reservations/edit') }}
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.reservation.update',$reservation) }}" method="POST"   enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                @if(auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
                                    <div class="form-group col">
                                        <label for="area">{{ __('levels.restaurant') }}</label> <span class="text-danger">*</span>
                                        <select name="restaurant_id" id="restaurant_id"
                                                class="select2 form-control @error('restaurant_id') is-invalid red-border @enderror">
                                            <option value="">{{ __('levels.restaurant') }}</option>
                                            @if(!blank($restaurants))
                                                @foreach($restaurants as $restaurant)
                                                    <option value="{{ $restaurant->id }}"
                                                        {{ (old('restaurant_id', $reservation->restaurant_id) == $restaurant->id) ? 'selected' : '' }}> {{ $restaurant->name }}
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
                                    <input type="hidden" id="restaurant_id" name="restaurant_id" value="{{auth()->user()->restaurant->id ?? 0}}">
                                @endif
                                    <div class="form-group col">
                                        <label for="user_id">{{ __('levels.user') }}</label> <span class="text-danger">*</span>
                                        <select name="user_id" id="user_id"
                                                class="select2 form-control @error('user_id') is-invalid red-border @enderror">
                                            <option value="">{{ __('levels.select_user') }}</option>
                                            @if(!blank($users))
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ (old('user_id',$reservation->user_id) == $user->id) ? 'selected' : '' }}>{{ $user->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('user_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col">
                                    <label>{{ __('levels.first_name') }}</label> <span class="text-danger">*</span>
                                    <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name',$reservation->first_name) }}">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label>{{ __('levels.last_name') }}</label> <span class="text-danger">*</span>
                                    <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name',$reservation->last_name) }}">
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
                                    <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$reservation->email) }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label>{{ __('levels.phone') }}</label> <span class="text-danger">*</span>
                                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$reservation->phone) }}" onkeypress='validate(event)'>
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-3 input-daterange" id="date-picker">
                                    <label>{{ __('levels.date') }}</label> <span class="text-danger">*</span>
                                    <input type="text" autocomplete="off" id="reservation_date" name="reservation_date" class="form-control @error('reservation_date') is-invalid @enderror" value="{{$reservation->reservation_date }}">
                                    @error('reservation_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-3">
                                    <label>{{ __('levels.guest') }}</label> <span class="text-danger">*</span>
                                    <input type="number" step=".01" name="guest" id="guest" class="form-control @error('guest') is-invalid @enderror" value="{{ old('guest',$reservation->guest_number) }}">
                                    @error('guest')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-6" id="timeSlotList">
                                    <label for="timeSlot">{{ __('levels.timeSlot') }}</label> <span class="text-danger">*</span>
                                    <select id="timeSlot" name="time_slot" class="form-control select2 {{ $errors->has('timeSlot') ? " is-invalid " : '' }}">
                                        @if(!blank($timeSlots))
                                                <option value="{{$timeSlots->id}}"  selected>{{ date('h:i A', strtotime($timeSlots->start_time)) }} - {{ date('h:i A', strtotime($timeSlots->end_time)) }}</option>
                                        @endif
                                    </select>
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
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        var Url = '{{ route('admin.reservation.timeSlot') }}'
        var UserUrl = '{{ route('admin.reservation.user') }}'

    </script>
    <script src="{{ asset('js/reservation/edit.js') }}"></script>
    <script src="{{ asset('js/phone_validation/index.js') }}"></script>

@endsection
