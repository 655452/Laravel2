@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('restaurant.menu_item') }}</h1>
            {{ Breadcrumbs::render('menu-items/add') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    @if(auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
                                    <div class="form-group col">
                                        <label for="area">{{ __('levels.restaurant') }}</label> <span class="text-danger">*</span>
                                        <select name="restaurant_id" id="area"
                                                class="select2 form-control @error('restaurant_id') is-invalid red-border @enderror">
                                            <option value="">{{ __('levels.select_restaurant') }}</option>
                                            @if(!blank($restaurants))
                                                @foreach($restaurants as $restaurant)
                                                    <option value="{{ $restaurant->id }}"
                                                        {{ (old('restaurant_id') == $restaurant->id) ? 'selected' : '' }}>{{ $restaurant->name }}
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
                                        @else
                                        <input type="hidden" name="restaurant_id" value="{{auth()->user()->restaurant->id ?? 0}}">
                                    @endif

                                    <div class="form-group col">
                                        <label for="name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                        <input id="name" type="text" name="name" class="form-control {{ $errors->has('name') ? " is-invalid " : '' }}" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col {{ $errors->has('categories') ? " has-error " : '' }}">
                                        <label for="categories">{{ __('restaurant.categories') }}</label>
                                        <select id="categories" name="categories[]" class="form-control select2 {{ $errors->has('categories') ? " is-invalid " : '' }}" multiple="multiple">
                                            @if(!blank($categories))
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('categories'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('categories') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-sm-4">
                                        <label for="unit_price">{{ __('levels.unit_price') }}</label> <span class="text-danger">*</span>
                                        <input id="unit_price" type="text" name="unit_price" class="form-control {{ $errors->has('unit_price') ? " is-invalid " : '' }}" value="{{ old('unit_price') }}">
                                        @error('unit_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="discount_price">{{ __('levels.discount_price') }}</label>
                                        <input id="discount_price" type="text" name="discount_price" class="form-control {{ $errors->has('discount_price') ? " is-invalid " : '' }}" value="{{ old('discount_price') }}">
                                        @error('discount_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                            @foreach(trans('statuses') as $key => $status)
                                                <option value="{{ $key }}" {{ (old('status') == $key) ? 'selected' : '' }}>{{ $status }}</option>
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
                                        <label for="description">{{ __('levels.description') }}</label>
                                        <textarea name="description"
                                                  class="summernote-simple form-control height-textarea @error('description')
                                                  is-invalid @enderror"
                                                  id="description" >
                                            {{ old('description') }}
                                        </textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col">
                                        <label for="customFile">{{ __('levels.image') }}</label>
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
                                            <label  class="custom-file-label" for="customFile">{{ __('levels.choose_file') }}</label>
                                        </div>
                                        @if ($errors->has('image'))
                                            <div class="help-block text-danger">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                        <img class="img-thumbnail mt-4 mb-3 default-img img-width" id="previewImage" src="{{ asset('frontend/images/default/menuitem.png') }}" alt="your image"/>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer ">
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
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/menu-item/create.js') }}"></script>
@endsection
