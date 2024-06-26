@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('homepage-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.homepage-update') }}">
                     @csrf
                     <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.step_one') }}</legend>
                         <div class="row">
                             <div class="col-sm-3">
                                 <div class="form-group">
                                     <label for="step_one_icon">{{ __('setting.icon') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_one_icon" id="step_one_icon" type="text"
                                         class="form-control @error('step_one_icon') is-invalid @enderror"
                                         value="{{ old('step_one_icon', setting('step_one_icon')) }}">
                                     @error('step_one_icon')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>

                             <div class="col-sm-3">
                                 <div class="form-group">
                                     <label for="step_one_title">{{ __('setting.title') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_one_title" id="step_one_title" type="text"
                                         class="form-control @error('step_one_title') is-invalid @enderror"
                                         value="{{ old('step_one_title', setting('step_one_title')) }}">
                                     @error('step_one_title')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>


                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="step_one_description">{{ __('setting.description') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_one_description" id="step_one_description" type="text"
                                         class="form-control @error('step_one_description') is-invalid @enderror"
                                         value="{{ old('step_one_description', setting('step_one_description')) }}">
                                     @error('step_one_description')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                    </fieldset>

                    <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.step_two') }}</legend>
                         <div class="row">
                             <div class="col-sm-3">
                                 <div class="form-group">
                                     <label for="step_two_icon">{{ __('setting.icon') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_two_icon" id="step_two_icon" type="text"
                                         class="form-control @error('step_two_icon') is-invalid @enderror"
                                         value="{{ old('step_two_icon', setting('step_two_icon')) }}">
                                     @error('step_two_icon')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>

                             <div class="col-sm-3">
                                 <div class="form-group">
                                     <label for="step_two_title">{{ __('setting.title') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_two_title" id="step_two_title" type="text"
                                         class="form-control @error('step_two_title') is-invalid @enderror"
                                         value="{{ old('step_two_title', setting('step_two_title')) }}">
                                     @error('step_two_title')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>


                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="step_two_description">{{ __('setting.description') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_two_description" id="step_two_description" type="text"
                                         class="form-control @error('step_two_description') is-invalid @enderror"
                                         value="{{ old('step_two_description', setting('step_two_description')) }}">
                                     @error('step_two_description')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                    </fieldset>

                    <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.step_three') }}</legend>
                         <div class="row">
                             <div class="col-sm-3">
                                 <div class="form-group">
                                     <label for="step_three_icon">{{ __('setting.icon') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_three_icon" id="step_three_icon" type="text"
                                         class="form-control @error('step_three_icon') is-invalid @enderror"
                                         value="{{ old('step_three_icon', setting('step_three_icon')) }}">
                                     @error('step_three_icon')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>

                             <div class="col-sm-3">
                                 <div class="form-group">
                                     <label for="step_three_title">{{ __('setting.title') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_three_title" id="step_three_title" type="text"
                                         class="form-control @error('step_three_title') is-invalid @enderror"
                                         value="{{ old('step_three_title', setting('step_three_title')) }}">
                                     @error('step_three_title')
                                     <div class="invalid-feedback">
                                         <strong>{{ $message }}</strong>
                                     </div>
                                     @enderror
                                 </div>
                             </div>


                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="step_three_description">{{ __('setting.description') }}</label>
                                     <span class="text-danger">*</span>
                                     <input name="step_three_description" id="step_three_description" type="text"
                                         class="form-control @error('step_three_description') is-invalid @enderror"
                                         value="{{ old('step_three_description', setting('step_three_description')) }}">
                                     @error('step_three_description')
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
                            <button type="submit" class="btn btn-primary">
                                <span>{{ __('setting.update_step_setting') }}</span>
                            </button>
                         </div>
                     </div>
                </form>
            </div>
        </div>
    </div>
@endsection
