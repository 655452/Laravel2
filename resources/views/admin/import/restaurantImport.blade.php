@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('restaurant.import_restaurant') }}</h1>
        {{ Breadcrumbs::render('file-import-export') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('restaurants_create')
                    <div class="card-header">
                        <a href="{{ route('admin.restaurants.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('restaurant.add_restaurant') }}</a>
                    </div>
                    @endcan
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form action="{{ route('admin.file-import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group ">
                                                <div class="custom-file text-left">
                                                    <input type="file" name="file" class="custom-file-input file-upload-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">{{__('levels.choose_file')}}</label>
                                                </div>
                                                @error('file')
                                                <div class="text-danger ">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-primary form-control">{{ __('restaurant.import') }}</button>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="{{asset('assets/sample/restaurantImportSample.xlsx')}}" download class="btn btn-success form-control">{{ __('restaurant.sample') }} </a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-4 ">
                                @if(session()->has('importErrors'))
                                <h2 class="text-center border-bottom">{{__('restaurant.validation_log')}}</h2>
                                @foreach(session()->get('importErrors') as $key => $values)
                                <div class="text-primary ">{{__('restaurant.in_row_number')}} : {{ $key }}</div>
                                @foreach($values as $value)
                                <div class="text-danger ">{{ $value }}</div>
                                @endforeach
                                @endforeach

                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection