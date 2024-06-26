@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Settings') }}</h1>

            @yield('admin.setting.breadcrumbs')
        </div>
    </section>

    <div class="row">
        <div class="col-md-3">
            <div class="bg-light card">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.setting.index') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting')) ? 'active' : '' }} ">{{ __('setting.site_setting') }}</a>
                    <a href="{{ route('admin.setting.sms') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/sms')) ? 'active' : '' }}">{{ __('setting.sms_setting') }}</a>
                    <a href="{{ route('admin.setting.payment') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/payment')) ? 'active' : '' }}">{{ __('setting.payment_setting') }}</a>
                    <a href="{{ route('admin.setting.email') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/email')) ? 'active' : '' }}">{{ __('setting.email_setting') }}</a>
                    <a href="{{ route('admin.setting.notification') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/notification')) ? 'active' : '' }}">{{ __('setting.notification_setting') }}</a>
                    <a href="{{ route('admin.setting.social-login') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/social-login')) ? 'active' : '' }}">{{ __('setting.social_login_setting') }}</a>
                    <a href="{{ route('admin.setting.otp') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/otp')) ? 'active' : '' }}">{{ __('setting.otp_setting') }}</a>
                    <a href="{{ route('admin.setting.social') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/social')) ? 'active' : '' }}">{{ __('setting.social_setting') }}</a>
                    <a href="{{ route('admin.setting.google-map') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/google-map')) ? 'active' : '' }}">{{ __('setting.google_map_setting') }}</a>
                    <a href="{{ route('admin.setting.app') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/app-setting')) ? 'active' : '' }}">{{ __('setting.app_setting') }}</a>
                    <a href="{{ route('admin.setting.support') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/support-setting')) ? 'active' : '' }}">{{ __('setting.support_setting') }}</a>
                    @if(env('DEMO_MODE') == false)
                    <a href="{{ route('admin.setting.purchasekey') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/setting/purchasekey')) ? 'active' : '' }}">{{ __('setting.purchase_key_setting') }}</a>
                    @endif
                </div>
            </div>
        </div>

        @yield('admin.setting.layout')
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/setting/create.js') }}"></script>
@endsection
