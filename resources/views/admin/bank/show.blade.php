@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('bank.bank') }}</h1>
        {{ Breadcrumbs::render('bank/show') }}
    </div>
    <div class="section-body">
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card profile-widget mt-0">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item profile-widget-item-header">
                            <strong> {{ __('levels.details') }} {{ '('. $bank->user->name .')' }}</strong>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <dl class="row">
                            <dt class="col-sm-3">{{ __('bank.bank_name') }}:</dt>
                            <dd class="col-sm-3">{{ strip_tags($bank->bank_name) }}</dd>
                            <dt class="col-sm-3">{{ __('bank.bank_code') }}:</dt>
                            <dd class="col-sm-3">{{ strip_tags($bank->bank_code) }}</dd>
                        </dl>

                        <dl class="row">
                            <dt class="col-sm-3">{{ __('bank.recipient_name') }}:</dt>
                            <dd class="col-sm-3">{{ strip_tags($bank->recipient_name) }}</dd>
                            <dt class="col-sm-3">{{ __('bank.account_number') }}:</dt>
                            <dd class="col-sm-3">{{ strip_tags($bank->account_number) }}</dd>
                        </dl>
                        <dl class="row">

                            <dt class="col-sm-3">{{ __('bank.mobile_agent_name') }}:</dt>
                            <dd class="col-sm-3">{{ strip_tags($bank->mobile_agent_name) }}</dd>
                            <dt class="col-sm-3">{{ __('bank.mobile_agent_number') }}:</dt>
                            <dd class="col-sm-3">{{ strip_tags($bank->mobile_agent_number) }}</dd>
                        </dl>

                        <dl class="row">
                            <dt class="col-sm-3">{{ __('bank.paypal_id') }}:</dt>
                            <dd class="col-sm-3">{{ strip_tags($bank->paypal_id) }}</dd>
                            <dt class="col-sm-3">{{ __('bank.upi_id') }}:</dt>
                            <dd class="col-sm-3">{{ strip_tags($bank->upi_id) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
