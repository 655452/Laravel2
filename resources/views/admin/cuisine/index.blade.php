@extends('admin.layouts.master')

@section('main-content')

  <section class="section">
        <div class="section-header">
        <h1>{{ __('cuisine.cuisines') }}</h1>
            {{ Breadcrumbs::render('cuisines') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('cuisine_create')
                            <div class="card-header">
                                <a href="{{ route('admin.cuisine.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('cuisine.add_cuisine') }}</a>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 offset-sm-3">
                                    <div class="input-group input-daterange" id="date-picker">
                                        <select class="form-control" id="status" name="status">
                                            <option value="">{{ __('levels.select_status') }}</option>
                                            @foreach(trans('statuses') as $key => $status)
                                                <option value="{{ $key }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" id="requested" name="requested">
                                            <option value="">{{ __('levels.select_request') }}</option>
                                            @foreach(trans('category_requests') as $key => $requested)
                                                <option value="{{ $key }}">{{ $requested }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="refresh"> {{ __('levels.refresh') }}</button>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="date-search">{{ __('levels.search') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable" data-url="{{ route('admin.cuisine.index') }}" data-status="{{ \App\Enums\Status::ACTIVE }}" data-hidecolumn="{{ auth()->user()->can('cuisine_edit') || auth()->user()->can('cuisine_delete') }}">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            <th>{{ __('levels.image') }}</th>
                                            <th>{{ __('levels.name') }}</th>
                                            <th>{{ __('levels.created_by') }}</th>
                                            <th>{{ __('levels.status') }}</th>
                                            <th>{{ __('levels.actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/cuisine/index.js') }}"></script>
@endsection
