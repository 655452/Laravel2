@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('banner.banners') }}</h1>
        {{ Breadcrumbs::render('banners/edit') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.banner.update', $banner) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="area">{{ __('levels.restaurant') }}</label> <span class="text-danger">*</span>
                                    <select name="restaurant_id" id="area"
                                            class="select2 form-control @error('restaurant_id') is-invalid red-border @enderror">
                                        <option value="">{{ __('levels.select_restaurant') }}</option>
                                        @if(!blank($restaurants))
                                            @foreach($restaurants as $restaurant)
                                                <option value="{{ $restaurant->id }}"
                                                    {{ (old('restaurant_id', $banner->restaurant_id) == $restaurant->id) ? 'selected' : '' }}> {{ $restaurant->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('restaurant_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label>{{ __('levels.title') }}</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $banner->title) }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.url') }}</label>
                                    <input type="text" name="url"
                                        class="form-control @error('url') is-invalid @enderror"
                                        value="{{ old('url', $banner->link) }}">
                                    @error('url')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(trans('statuses') as $key => $status)
                                        <option value="{{ $key }}"
                                            {{ (old('status', $banner->status) == $key) ? 'selected' : '' }}>
                                            {{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="customFile">{{ __('levels.image') }}</label> <span class="text-danger">*</span>
                                    <div class="custom-file">
                                        <input name="image" type="file"
                                            class="custom-file-input @error('image') is-invalid @enderror"
                                            id="customFile" onchange="readURL(this);">
                                        <label class="custom-file-label"
                                            for="customFile">{{ __('levels.choose_file') }}</label>
                                    </div>
                                    @if ($errors->has('image'))
                                        <div class="help-block text-danger">
                                            {{ $errors->first('image') }}
                                        </div>
                                    @endif
                                    <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                        src="{{ $banner->image }}" alt="your image" />
                                </div>

                                <div class="form-group col">
                                    <label>{{ __('levels.description') }}</label>
                                    <textarea name="description"
                                        class="summernote-simple form-control height-textarea @error('description') is-invalid @enderror"
                                        id="description" cols="30"
                                        rows="10">{{ old('description', $banner->short_description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">

@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/banner/edit.js') }}"></script>
@endsection
