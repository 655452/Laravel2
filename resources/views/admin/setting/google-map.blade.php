@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('google-map-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.google-map') }}">
                     @csrf
                     @method('PUT')
                     <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.google_map_setting') }}</legend>
                         <div class="row">
                             <div class="col-sm-12">
                                 <div class="form-group">
                                     <label for="google_map_api_key">{{ __('levels.google_map_api_key') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="google_map_api_key" id="google_map_api_key" type="text"
                                         class="form-control @error('google_map_api_key') is-invalid @enderror"
                                         value="@if(!env('DEMO_MODE')){{ old('google_map_api_key',setting('google_map_api_key')) }}@endif">
                                     @error('google_map_api_key')
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
                                <span>{{ __('setting.update_google_map_setting') }}</span>
                            </button>
                        </div>
                     </div>
                 </form>
            </div>
        </div>
    </div>
@endsection
