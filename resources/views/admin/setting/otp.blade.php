@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('otp-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.otp') }}">
                    @csrf
                    <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.otp_setting') }}</legend>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="otp_type_checking">{{ __('setting.otp_type') }}</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control @error('otp_type_checking') is-invalid @enderror"
                                        name="otp_type_checking" id="otp_type_checking">
                                        <option value="email"
                                            {{ (old('otp_type_checking', setting('otp_type_checking')) == 'email') ? 'selected' : '' }}>
                                            {{ __('levels.email')}} </option>
                                        <option value="phone"
                                            {{ (old('otp_type_checking', setting('otp_type_checking')) == 'phone') ? 'selected' : '' }}>
                                            {{ __('levels.phone') }}</option>
                                        <option value="both"
                                            {{ (old('otp_type_checking', setting('otp_type_checking')) == 'both') ? 'selected' : '' }}>
                                            {{ __('setting.both') }}</option>
                                    </select>
                                    @error('otp_type_checking')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="otp_digit_limit">{{ __('setting.otp_digit_limit') }}</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control @error('otp_digit_limit') is-invalid @enderror"
                                        name="otp_digit_limit" id="otp_digit_limit">
                                        <option value="4"
                                            {{ (old('otp_digit_limit', setting('otp_digit_limit')) == 4) ? 'selected' : '' }}>
                                            {{ __('setting.4')}} </option>
                                        <option value="6"
                                            {{ (old('otp_digit_limit', setting('otp_digit_limit')) == 6) ? 'selected' : '' }}>
                                            {{ __('setting.6') }}</option>
                                        <option value="8"
                                            {{ (old('otp_digit_limit', setting('otp_digit_limit')) == 8) ? 'selected' : '' }}>
                                            {{ __('setting.8') }}</option>
                                    </select>
                                    @error('otp_digit_limit')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="otp_expire_time">{{ __('setting.expire_time') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="otp_expire_time" id="otp_expire_time" type="number"
                                        class="form-control @error('otp_expire_time') is-invalid @enderror"
                                        value="{{ old('otp_expire_time', setting('otp_expire_time')) }}">
                                    @error('otp_expire_time')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">
                                <span>{{ __('setting.update_otp_aetting') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
