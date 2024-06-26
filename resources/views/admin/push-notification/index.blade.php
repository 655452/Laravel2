@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('push_notification.push_notification') }}</h1>
        {{ Breadcrumbs::render('push-notification') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('push-notification_create')
                    <div class="card-header">
                        <a href="{{ route('admin.push-notification.create') }}"
                            class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i>
                            {{ __('push_notification.add_push_notification') }}
                        </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable"
                                data-url="{{ route('admin.push-notification.get-notification') }}"
                                data-status="{{ \App\Enums\Status::ACTIVE }}"
                                data-hidecolumn="{{ auth()->user()->can('push-notification_delete') }}">
                                <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.title') }}</th>
                                        <th>{{ __('levels.description') }}</th>
                                        <th>{{ __('levels.type') }}</th>
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
    <script src="{{ asset('js/push-notification/index.js') }}"></script>
@endsection
