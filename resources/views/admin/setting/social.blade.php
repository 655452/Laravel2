@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('social-setting') }}
@endsection

@section('admin.setting.layout')
     <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.social-update') }}">
                    @csrf
                    <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.social_setting') }}</legend>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="facebook">{{ __('setting.facebook') }}</label>
                                    <input name="facebook" id="facebook" type="text"
                                        class="form-control {{ $errors->has('facebook') ? ' is-invalid ' : '' }}"
                                        value="{{ old('facebook', setting('facebook')) }}">
                                    @if ($errors->has('facebook'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('facebook') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="instagram">{{ __('levels.instagram') }}</label>
                                    <input name="instagram" id="instagram" type="text"
                                        class="form-control {{ $errors->has('instagram') ? ' is-invalid ' : '' }}"
                                        value="{{ old('instagram', setting('instagram')) }}">
                                    @if ($errors->has('instagram'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('instagram') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="youtube">{{ __('levels.youtube') }}</label>
                                    <input name="youtube" id="youtube" type="text"
                                        class="form-control {{ $errors->has('youtube') ? ' is-invalid ' : '' }}"
                                        value="{{ old('youtube', setting('youtube')) }}">
                                    @if ($errors->has('youtube'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('youtube') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="twitter">{{ __('levels.twitter') }}</label>
                                    <input name="twitter" id="twitter" type="text"
                                        class="form-control {{ $errors->has('twitter') ? ' is-invalid ' : '' }}"
                                        value="{{ old('twitter', setting('twitter')) }}">
                                    @if ($errors->has('twitter'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('twitter') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <button class="btn btn-primary">
                                <span>{{ __('setting.update_social_setting') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

