@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('levels.pages') }}</h1>
        {{ Breadcrumbs::render('pages/add')}}
    </div>

    <div class="section-body">
        <form action="{{ route('admin.page.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-9 col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.title') }}</label><span class="text-danger">*</span>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.description') }}</label><span class="text-danger">*</span>
                                    <textarea name="description"
                                        class="summernote form-control height-textarea @error('description') is-invalid @enderror"
                                        id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.footer_menu_section') }}</label> <span class="text-danger">*</span>
                                    <select name="footer_menu_section_id" class="form-control @error('footer_menu_section_id') is-invalid @enderror">
                                        <option value="">{{ __('levels.select_section') }}</option>
                                        @if(!blank($footer_menu_sections))
                                            @foreach($footer_menu_sections as $footer_menu_section)
                                                <option value="{{ $footer_menu_section->id }}" {{ (old('footer_menu_section_id') == $footer_menu_section->id) ? 'selected' : '' }}>
                                                    {{ $footer_menu_section->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select> 
                                    @error('footer_menu_section_id') <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.template') }}</label> <span class="text-danger">*</span>
                                    <select name="template_id" class="form-control @error('template_id') is-invalid @enderror">
                                        @if(!blank($templates))
                                            @foreach($templates as $template)
                                                <option value="{{ $template->id }}" {{ (old('template_id') == $template->id) ? 'selected' : '' }}>
                                                    {{ ucfirst($template->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select> 
                                    @error('template_id') <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                       
                                            @foreach(trans('statuses') as $statuskey => $status)
                                                <option value="{{ $statuskey }}" {{ (old('status') == $statuskey) ? 'selected' : '' }}>
                                                    {{ $status }}</option>
                                            @endforeach
                                    
                                    </select> 
                                    @error('status') <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <button class="btn btn-primary btn-block" type="submit">{{ __('levels.publish') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/page/create.js') }}"></script>
@endsection
