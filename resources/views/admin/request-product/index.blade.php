@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
    <h1>{{ __('levels.request_product') }}</h1>
        {{ Breadcrumbs::render('request-products') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    @can('request-products_create')
                        <div class="card-header">
                            <a href="{{ route('admin.request-products.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('levels.add_request_product') }}</a>
                        </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable"
                                data-url="{{ route('admin.request-products.get-request-product') }}" data-hidecolumn="{{ auth()->user()->can('request-products_show') || auth()->user()->can('request-products_edit') || auth()->user()->can('request-products_delete') }}">
                                <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.name') }}</th>
                                        <th>{{ __('levels.categories') }}</th>
                                        <th>{{ __('levels.status') }}</th>
                                        <th>{{ __('levels.created_date') }}</th>
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
<script src="{{ asset('js/request-product/index.js') }}"></script>
@endsection
