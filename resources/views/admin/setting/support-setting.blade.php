@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('support-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.support') }}">
                     @csrf
                     <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.support_setting') }}</legend>
                         <div class="row">
                             <div class="col-sm-12">
                                 <div class="form-group">
                                     <label for="support_phone">{{ __('setting.support_phone') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="support_phone" id="support_phone" type="text"
                                         class="form-control @error('support_phone') is-invalid @enderror"
                                         value="{{ old('support_phone', setting('support_phone')) }}">
                                     @error('support_phone')
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
                                <span>{{ __('setting.update_support_setting') }}</span>
                            </button>
                        </div>
                     </div>
                 </form>
            </div>
        </div>
    </div>
@endsection
