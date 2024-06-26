@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('notification-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.notification-update') }}">
                     @csrf
                     <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.notification_setting') }}</legend>
                         <div class="row">
                             <div class="col-sm-12">
                                 <div class="form-group">
                                     <label for="fcm_secret_key">{{ __('levels.firebase_secret_key') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="fcm_secret_key" id="fcm_secret_key" type="text"
                                         class="form-control @error('fcm_secret_key') is-invalid @enderror"
                                         value="{{ old('fcm_secret_key', setting('fcm_secret_key')) }}">
                                     @error('fcm_secret_key')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="firebase_api_key">{{ __('setting.firebase_api_key') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="firebase_api_key" id="firebase_api_key" type="text"
                                        class="form-control @error('firebase_api_key') is-invalid @enderror"
                                        value="{{ old('firebase_api_key', setting('firebase_api_key')) }}">
                                    @error('firebase_api_key')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="firebase_authDomain">{{ __('setting.firebase_authDomain') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="firebase_authDomain" id="firebase_authDomain" type="text"
                                        class="form-control @error('firebase_authDomain') is-invalid @enderror"
                                        value="{{ old('firebase_authDomain', setting('firebase_authDomain')) }}">
                                    @error('firebase_authDomain')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="projectId">{{ __('setting.projectId') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="projectId" id="projectId" type="text"
                                        class="form-control @error('projectId') is-invalid @enderror"
                                        value="{{ old('projectId', setting('projectId')) }}">
                                    @error('projectId')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="storageBucket">{{ __('setting.storageBucket') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="storageBucket" id="storageBucket" type="text"
                                        class="form-control @error('storageBucket') is-invalid @enderror"
                                        value="{{ old('storageBucket', setting('storageBucket')) }}">
                                    @error('storageBucket')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="messagingSenderId">{{ __('setting.messagingSenderId') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="messagingSenderId" id="messagingSenderId" type="text"
                                        class="form-control @error('messagingSenderId') is-invalid @enderror"
                                        value="{{ old('messagingSenderId', setting('messagingSenderId')) }}">
                                    @error('messagingSenderId')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="appId">{{ __('setting.appId') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="appId" id="appId" type="text"
                                        class="form-control @error('appId') is-invalid @enderror"
                                        value="{{ old('appId', setting('appId')) }}">
                                    @error('appId')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="measurementId">{{ __('setting.measurementId') }}</label>
                                    <span class="text-danger">*</span>
                                    <input name="measurementId" id="measurementId" type="text"
                                        class="form-control @error('measurementId') is-invalid @enderror"
                                        value="{{ old('measurementId', setting('measurementId')) }}">
                                    @error('measurementId')
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
                            <button type="submit" class="btn btn-primary btn-sm">
                                <span>{{ __('setting.update_notification_setting') }}</span>
                            </button>
                        </div>
                     </div>
                 </form>
            </div>
        </div>
    </div>
@endsection
