@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('payment-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-4 col-sm-8">
                        <h4 class="paymentheader text-center">{{ __('setting.payment_type') }}</h4>
                        <hr>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ old('settingtypepayment', setting('settingtypepayment')) == 'stripe' || old('settingtypepayment', setting('settingtypepayment')) == '' ? 'active' : '' }}"
                                    id="stripe" data-toggle="pill" href="#stripetab" role="tab"
                                    aria-controls="stripetab" aria-selected="true">{{ __('setting.stripe') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ old('settingtypepayment', setting('settingtypepayment')) == 'razorpay' ? 'active' : '' }}"
                                    id="razorpay" data-toggle="pill" href="#razorpaytab" role="tab"
                                    aria-controls="razorpaytab" aria-selected="false">{{ __('setting.razorpay') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ old('settingtypepayment', setting('settingtypepayment')) == 'paystack' ? 'active' : '' }}"
                                    id="paystack" data-toggle="pill" href="#paystacktab" role="tab"
                                    aria-controls="paystacktab" aria-selected="false">{{ __('setting.paystack') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ old('settingtypepayment', setting('settingtypepayment')) == 'paypal' ? 'active' : '' }}"
                                    id="paypal" data-toggle="pill" href="#paypaltab" role="tab"
                                    aria-controls="paypaltab" aria-selected="false">{{ __('setting.paypal') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ old('settingtypepayment', setting('settingtypepayment')) == 'paytm' ? 'active' : '' }}"
                                    id="paytm" data-toggle="pill" href="#paytmtab" role="tab"
                                    aria-controls="paytmtab" aria-selected="false">{{ __('setting.paytm') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ old('settingtypepayment', setting('settingtypepayment')) == 'phonePe' ? 'active' : '' }}"
                                    id="phonePe" data-toggle="pill" href="#phonePetab" role="tab"
                                    aria-controls="phonePetab" aria-selected="false">{{ __('setting.phonePe') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ old('settingtypepayment', setting('settingtypepayment')) == 'sslcommerz' ? 'active' : '' }}"
                                    id="sslcommerz" data-toggle="pill" href="#sslcommerztab" role="tab"
                                    aria-controls="sslcommerztab" aria-selected="false">{{ __('setting.sslcommerz') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-9 col-md-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade {{ old('settingtypepayment', setting('settingtypepayment')) == 'stripe' || old('settingtypepayment', setting('settingtypepayment')) == '' ? 'show active' : '' }}"
                                id="stripetab" role="tabpanel" aria-labelledby="stripe">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.stripe_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="stripe">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="stripe_key">{{ __('levels.stripe_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="stripe_key" id="stripe_key" type="text"
                                                        class="form-control @error('stripe_key') is-invalid @enderror"
                                                        value="{{ old('stripe_key', setting('stripe_key') ?? '') }}">
                                                    @error('stripe_key')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="stripe_secret">{{ __('levels.stripe_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="stripe_secret" id="stripe_secret" type="text"
                                                        class="form-control @error('stripe_secret') is-invalid @enderror"
                                                        value="{{ old('stripe_secret', setting('stripe_secret') ?? '') }}">
                                                    @error('stripe_secret')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_stripe_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ old('settingtypepayment', setting('settingtypepayment')) == 'razorpay' ? 'show active' : '' }}"
                                id="razorpaytab" role="tabpanel" aria-labelledby="razorpay">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.razorpay_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="razorpay">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="razorpay_key">{{ __('levels.razorpay_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="razorpay_key" id="razorpay_key" type="text"
                                                        class="form-control @error('razorpay_key')is-invalid @enderror"
                                                        value="{{ old('razorpay_key', setting('razorpay_key') ?? '') }}">
                                                    @error('razorpay_key')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="razorpay_secret">{{ __('levels.razorpay_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="razorpay_secret" id="razorpay_secret" type="text"
                                                        class="form-control @error('razorpay_secret') is-invalid @enderror"
                                                        value="{{ old('razorpay_secret', setting('razorpay_secret') ?? '') }}">
                                                    @error('razorpay_secret')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_razorpay_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ old('settingtypepayment', setting('settingtypepayment')) == 'paystack' ? 'show active' : '' }}"
                                id="paystacktab" role="tabpanel" aria-labelledby="paystack">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.paystack_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="paystack">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paystack_key">{{ __('setting.paystack_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paystack_key" id="paystack_key" type="text"
                                                        class="form-control @error('paystack_key')is-invalid @enderror"
                                                        value="{{ old('paystack_key', setting('paystack_key') ?? '') }}">
                                                    @error('paystack_key')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paystack_secret">{{ __('setting.paystack_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paystack_secret" id="paystack_secret" type="text"
                                                        class="form-control @error('paystack_secret')is-invalid @enderror"
                                                        value="{{ old('paystack_secret', setting('paystack_secret') ?? '') }}">
                                                    @error('paystack_secret')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_paystack_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ old('settingtypepayment', setting('settingtypepayment')) == 'paypal' ? 'show active' : '' }}"
                                id="paypaltab" role="tabpanel" aria-labelledby="paypal">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.paypal_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="paypal">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paypal_client_id">{{ __('setting.paypal_client_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paypal_client_id" id="paypal_client_id" type="text"
                                                        class="form-control @error('paypal_client_id')is-invalid @enderror"
                                                        value="{{ old('paypal_client_id', setting('paypal_client_id') ?? '') }}">
                                                    @error('paypal_client_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="paypal_client_secret">{{ __('setting.paypal_client_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paypal_client_secret" id="paypal_client_secret"
                                                        type="text"
                                                        class="form-control @error('paypal_client_secret')is-invalid @enderror"
                                                        value="{{ old('paypal_client_secret', setting('paypal_client_secret') ?? '') }}">
                                                    @error('paypal_client_secret')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paypal_mode">{{ __('setting.paypal_mode') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paypal_mode" id="paypal_mode" type="text"
                                                        class="form-control @error('paypal_mode')is-invalid @enderror"
                                                        value="{{ old('paypal_mode', setting('paypal_mode') ?? '') }}">
                                                    @error('paypal_mode')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paypal_app_id">{{ __('setting.paypal_app_id') }}</label>
                                                    <input name="paypal_app_id" id="paypal_app_id" type="text"
                                                        class="form-control @error('paypal_app_id')is-invalid @enderror"
                                                        value="{{ old('paypal_app_id', setting('paypal_app_id') ?? '') }}">
                                                    @error('paypal_app_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_paypal_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
 

                            <div class="tab-pane fade {{ old('settingtypepayment', setting('settingtypepayment')) == 'paytm' ? 'show active' : '' }}"
                                id="paytmtab" role="tabpanel" aria-labelledby="paytm">

                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.paytm') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="paytm">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paytm_environment">{{ __('setting.paytm_environment') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paytm_environment" id="paytm_environment" type="text"
                                                        class="form-control @error('paytm_environment')is-invalid @enderror"
                                                        value="{{ old('paytm_environment', setting('paytm_environment') ?? '') }}">
                                                    @error('paytm_environment')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paytm_merchant_id">{{ __('setting.paytm_merchant_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paytm_merchant_id" id="paytm_merchant_id" type="text"
                                                        class="form-control @error('paytm_merchant_id')is-invalid @enderror"
                                                        value="{{ old('paytm_merchant_id', setting('paytm_merchant_id') ?? '') }}">
                                                    @error('paytm_merchant_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paytm_merchant_key">{{ __('setting.paytm_merchant_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="paytm_merchant_key" id="paytm_merchant_key"
                                                        type="text"
                                                        class="form-control @error('paytm_merchant_key')is-invalid @enderror"
                                                        value="{{ old('paytm_merchant_key', setting('paytm_merchant_key') ?? '') }}">
                                                    @error('paytm_merchant_key')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="paytm_merchant_website">{{ __('setting.paytm_merchant_website') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input name="paytm_merchant_website" id="paytm_merchant_website"
                                                        type="text"
                                                        class="form-control @error('paytm_merchant_website')is-invalid @enderror"
                                                        value="{{ old('paytm_merchant_website', setting('paytm_merchant_website') ?? '') }}">
                                                    @error('paytm_merchant_website')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="paytm_channel">{{ __('setting.paytm_channel') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input name="paytm_channel" id="paytm_channel" type="text"
                                                        class="form-control @error('paytm_channel')is-invalid @enderror"
                                                        value="{{ old('paytm_channel', setting('paytm_channel') ?? '') }}">
                                                    @error('paytm_channel')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="paytm_industry_type">{{ __('setting.paytm_industry_type') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input name="paytm_industry_type" id="paytm_industry_type"
                                                        type="text"
                                                        class="form-control @error('paytm_industry_type')is-invalid @enderror"
                                                        value="{{ old('paytm_industry_type', setting('paytm_industry_type') ?? '') }}">
                                                    @error('paytm_industry_type')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_paytm_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ old('settingtypepayment', setting('settingtypepayment')) == 'phonePe' ? 'show active' : '' }}"
                                id="phonePetab" role="tabpanel" aria-labelledby="phonePe">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.phonePe') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="phonepe">
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="phonepe_merchant_id">{{ __('setting.phonepe_merchant_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="phonepe_merchant_id" id="phonepe_merchant_id"
                                                        type="text"
                                                        class="form-control @error('phonepe_merchant_id')is-invalid @enderror"
                                                        value="{{ old('phonepe_merchant_id', setting('phonepe_merchant_id') ?? '') }}">
                                                    @error('phonepe_merchant_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="phonepe_merchant_user_id">{{ __('setting.phonepe_merchant_user_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="phonepe_merchant_user_id" id="phonepe_merchant_user_id"
                                                        type="text"
                                                        class="form-control @error('phonepe_merchant_user_id')is-invalid @enderror"
                                                        value="{{ old('phonepe_merchant_user_id', setting('phonepe_merchant_user_id') ?? '') }}">
                                                    @error('phonepe_merchant_user_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="phonepe_env">{{ __('setting.phonepe_env') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="phonepe_env" id="phonepe_env" type="text"
                                                        class="form-control @error('phonepe_env')is-invalid @enderror"
                                                        value="{{ old('phonepe_env', setting('phonepe_env') ?? '') }}">
                                                    @error('phonepe_env')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="phonepe_salt_index">{{ __('setting.phonepe_salt_index') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input name="phonepe_salt_index" id="phonepe_salt_index"
                                                        type="text"
                                                        class="form-control @error('phonepe_salt_index')is-invalid @enderror"
                                                        value="{{ old('phonepe_salt_index', setting('phonepe_salt_index') ?? '') }}">
                                                    @error('phonepe_salt_index')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="phonepe_salt_key">{{ __('setting.phonepe_salt_key') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input name="phonepe_salt_key" id="phonepe_salt_key" type="text"
                                                        class="form-control @error('phonepe_salt_key')is-invalid @enderror"
                                                        value="{{ old('phonepe_salt_key', setting('phonepe_salt_key') ?? '') }}">
                                                    @error('phonepe_salt_key')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_phonepe_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ old('settingtypepayment', setting('settingtypepayment')) == 'sslcommerz' ? 'show active' : '' }}"
                                id="sslcommerztab" role="tabpanel" aria-labelledby="sslcommerz">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.sslcommerz') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="sslcommerz">
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="sslcommerz_store_name">{{ __('setting.sslcommerz_store_name') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="sslcommerz_store_name" id="sslcommerz_store_name"
                                                        type="text"
                                                        class="form-control @error('sslcommerz_store_name')is-invalid @enderror"
                                                        value="{{ old('sslcommerz_store_name', setting('sslcommerz_store_name') ?? '') }}">
                                                    @error('sslcommerz_store_name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="sslcommerz_store_id">{{ __('setting.sslcommerz_store_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="sslcommerz_store_id" id="sslcommerz_store_id"
                                                        type="text"
                                                        class="form-control @error('sslcommerz_store_id')is-invalid @enderror"
                                                        value="{{ old('sslcommerz_store_id', setting('sslcommerz_store_id') ?? '') }}">
                                                    @error('sslcommerz_store_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="sslcommerz_store_password">{{ __('setting.sslcommerz_store_password') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="sslcommerz_store_password" id="sslcommerz_store_password"
                                                        type="text"
                                                        class="form-control @error('sslcommerz_store_password')is-invalid @enderror"
                                                        value="{{ old('sslcommerz_store_password', setting('sslcommerz_store_password') ?? '') }}">
                                                    @error('sslcommerz_store_password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="sslcommerz_mode">{{ __('setting.sslcommerz_mode') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input name="sslcommerz_mode" id="sslcommerz_mode" type="text"
                                                        class="form-control @error('sslcommerz_mode')is-invalid @enderror"
                                                        value="{{ old('sslcommerz_mode', setting('sslcommerz_mode') ?? '') }}">
                                                    @error('sslcommerz_mode')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_sslcommerz_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
