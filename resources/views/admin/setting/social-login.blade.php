@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('social-login-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="paymentheader text-center">{{ __('setting.social_login_setting') }}</h4>
                        <hr>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ ((old('settingtypesocial', setting('settingtypesocial')) == 'facebook') || (old('settingtypesocial', setting('settingtypesocial')) == '')) ? 'active' : '' }}"
                                    id="facebook" data-toggle="pill" href="#facebooktab" role="tab" aria-controls="facebooktab"
                                    aria-selected="true">{{ __('setting.facebook') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (old('settingtypesocial', setting('settingtypesocial')) == 'google') ? 'active' : '' }}"
                                    id="google" data-toggle="pill" href="#googletab" role="tab" aria-controls="googletab"
                                    aria-selected="false">{{ __('setting.google') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade {{ ((old('settingtypesocial', setting('settingtypesocial')) == 'facebook') || (old('settingtypesocial', setting('settingtypesocial')) == '')) ? 'show active' : '' }}"
                                id="facebooktab" role="tabpanel" aria-labelledby="facebook">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.social-login-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.facebook_setting') }}</legend>
                                        <input type="hidden" name="settingtypesocial" value="facebook">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="facebook_key">{{ __('setting.facebook_client_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="facebook_key" id="facebook_key" type="text"
                                                        class="form-control @error('facebook_key') is-invalid @enderror"
                                                        value="{{ old('facebook_key', setting('facebook_key') ?? '') }}">
                                                    @error('facebook_key')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="facebook_secret">{{ __('setting.facebook_client_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="facebook_secret" id="facebook_secret" type="text"
                                                        class="form-control @error('facebook_secret') is-invalid @enderror"
                                                        value="{{ old('facebook_secret', setting('facebook_secret') ?? '') }}">
                                                    @error('facebook_secret')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="facebook_url">{{ __('setting.facebook_url') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="facebook_url" id="facebook_url" type="text"
                                                        class="form-control @error('facebook_url') is-invalid @enderror"
                                                        value="{{ old('facebook_url', setting('facebook_url') ?? '') }}">
                                                    @error('facebook_url')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary"><span>{{ __('setting.update_facebook_setting') }}</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ (old('settingtypesocial', setting('settingtypesocial')) == 'google') ? 'show active' : '' }}" id="googletab" role="tabpanel" aria-labelledby="google">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.social-login-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.google_setting') }}</legend>
                                        <input type="hidden" name="settingtypesocial" value="google">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="google_key">{{ __('setting.googel_client_id') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="google_key" id="google_key" type="text"
                                                        class="form-control @error('google_key')is-invalid @enderror"
                                                        value="{{ old('google_key', setting('google_key') ?? '') }}">
                                                    @error('google_key')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="google_secret">{{ __('setting.googel_client_sceret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="google_secret" id="google_secret" type="text"
                                                        class="form-control @error('google_secret') is-invalid @enderror"
                                                        value="{{ old('google_secret', setting('google_secret') ?? '') }}">
                                                    @error('google_secret')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="google_url">{{ __('setting.googel_url') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input name="google_url" id="google_url" type="text"
                                                        class="form-control @error('google_url') is-invalid @enderror"
                                                        value="{{ old('google_url', setting('google_url') ?? '') }}">
                                                    @error('google_url')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary">
                                                        <span>{{ __('setting.update_google_setting') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection