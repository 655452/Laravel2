@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
{{ Breadcrumbs::render('purchasekey-setting') }}
@endsection

@section('admin.setting.layout')
<div class="col-md-9">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.purchasekey-update') }}">
                @csrf
                <fieldset class="setting-fieldset">
                    <legend class="setting-legend">{{ __('setting.purchase_key_setting') }}</legend>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="license_code">{{ __('setting.purchase_key') }}</label>
                                <span class="text-danger">*</span>
                                <input name="license_code" id="license_code" type="text" class="form-control {{ $errors->has('license_code') ? ' is-invalid ' : '' }}" value="{{ old('license_code', setting('license_code')) }}">
                                @if ($errors->has('license_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('license_code') }}
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </fieldset>
                <div class="row">
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary">
                            <span>{{ __('setting.update_purchase_key_setting') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
