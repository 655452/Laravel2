@extends('vendor.installer.layouts.master')



@section('template_title')
    {{ trans('installer_messages.purchase-code.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-magic fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.purchase-code.title') !!}
@endsection

@section('container')
    <form method="post" action="{{ route('LaravelInstaller::purchase_code.check') }}" class="tabs-wrap">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group {{ $errors->has('purchase_code') ? ' has-error ' : '' }}">
            <label for="purchase_code" class="ml-3">
                {{ trans('installer_messages.purchase-code.form.purchase_code_label') }} <a class="" data-toggle="modal" data-target="#myModal" title="Click"> <i class="fa fa-question-circle"></i> <span class="text-danger">({{ __(' Please click to see License activation process') }})</span></a>
            </label>
            <input type="text" name="purchase_code" id="purchase_code" value="{{ old('purchase_code') }}" placeholder="{{ trans('installer_messages.purchase-code.form.purchase_code_label') }}" />
            @if ($errors->has('purchase_code'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('purchase_code') }}
                </span>
            @endif
        </div>

        <div class="buttons">
            <button class="button" onclick="showDatabaseSettings();return false">
                {{ trans('installer_messages.purchase-code.form.buttons.verify') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </button>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Activate license code process. ') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <section class="mb-5">
                        <h4 class="mb-2">{{ __('Step1: ') }} <a href="{{ config('installer.upgradeLicenseCodeUrl') }}" target="_blank">{{ __(' Go to iNilabs') }}</a></h4>
                        <picture>
                            <img src="{{asset('installer/img/home.png')}}" class="img-fluid img-thumbnail image-css"  alt="...">
                        </picture>
                    </section>
                    <section class="mb-5">
                        <h4 class="mb-2">{{ __('Step2: ') }} <a href="{{ config('installer.upgradeLicenseCodeUrl') }}" target="_blank">{{ __(' Login to iNilabs') }}</a></h4>
                        <picture>
                            <img src="{{asset('installer/img/login.png')}}" class="img-fluid img-thumbnail image-css"  alt="...">
                        </picture>
                    </section>
                    <section class="mb-5">
                        <h4>{{ __('Step3: ') }} <a href="{{ config('installer.upgradeLicenseCodeUrl') }}" target="_blank">{{ __(' Active your license code') }} </a></h4>
                        <h6>{{ __('You can easily get the activation code and try to install your product by this code.') }}</h6>
                        <picture class="mt-1">
                            <img src="{{asset('installer/img/active.png')}}" class="img-fluid img-thumbnail image-css"  alt="...">
                        </picture>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <link href="{{ asset('installer/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{asset('themes/scripts/jquery-3.4.1.min.js')}}"></script>
    <link href="{{ asset('installer/css/bootstrap.bundle.min.js') }}" rel="stylesheet" type="text/css" />
@endsection
