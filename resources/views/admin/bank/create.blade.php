@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('bank.bank') }}</h1>
        {{ Breadcrumbs::render('bank/add') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card"> 
                    <form action="{{ route('admin.bank.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                @if (auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
                                <div class="form-group col-lg-6">
                                    <label>{{ __('levels.user') }}</label> <span class="text-danger">*</span>
                                    <select name="user_id" id="user_id"
                                        class="form-control select2 @error('user_id') is-invalid @enderror">
                                        <option value="">{{ __('levels.select_user') }}</option>
                                        <?php $selectUser = []; ?>
                                        @if(!blank($users))
                                        @foreach($users as $user)
                                        @if($user->id == old('user_id'))
                                        <?php  $selectUser = $user; ?>
                                        @endif
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected':'' }}>
                                            {{ $user->name }} ({{  trans('user_roles.'.$user->myrole) }}
                                            {{ !blank($user->phone)  ? ' '.$user->phone : '' }})</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                @else
                                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                                @endif
                                <div class="form-group col-lg-6">
                                    <label>{{ __('bank.bank_name') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror"
                                        value="{{ old('bank_name') }}">
                                    @error('bank_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('bank.bank_code') }}</label>
                                    <input type="text" name="bank_code"
                                        class="form-control @error('bank_code') is-invalid @enderror"
                                        value="{{ old('bank_code') }}">
                                    @error('bank_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('bank.recipient_name') }}</label>
                                    <input type="text" name="recipient_name"
                                        class="form-control @error('recipient_name') is-invalid @enderror"
                                        value="{{ old('recipient_name') }}">
                                    @error('recipient_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('bank.account_number') }}</label>
                                    <input type="text" name="account_number"
                                        class="form-control @error('account_number') is-invalid @enderror"
                                        value="{{ old('account_number') }}">
                                    @error('account_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('bank.mobile_agent_name') }}</label>
                                    <input type="text" name="mobile_agent_name"
                                        class="form-control @error('mobile_agent_name') is-invalid @enderror"
                                        value="{{ old('mobile_agent_name') }}">
                                    @error('mobile_agent_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('bank.mobile_agent_number') }}</label>
                                    <input type="text" name="mobile_agent_number"
                                        class="form-control @error('mobile_agent_number') is-invalid @enderror"
                                        value="{{ old('mobile_agent_number') }}" onkeypress="validate(event)">
                                    @error('mobile_agent_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('bank.paypal_id') }}</label>
                                    <input type="text" name="paypal_id"
                                        class="form-control @error('paypal_id') is-invalid @enderror"
                                        value="{{ old('paypal_id') }}">
                                    @error('paypal_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('bank.upi_id') }}</label>
                                    <input type="text" name="upi_id"
                                        class="form-control @error('upi_id') is-invalid @enderror"
                                        value="{{ old('upi_id') }}">
                                    @error('upi_id')
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/phone_validation/index.js') }}"></script>
<script src="{{ asset('js/bank/create.js') }}"></script>
@endsection
