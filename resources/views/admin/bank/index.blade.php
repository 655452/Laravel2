@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('bank.bank') }}</h1>
            {{ Breadcrumbs::render('bank') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('bank_create')
                            <div class="card-header">
                                <a href="{{ route('admin.bank.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                        class="fas fa-plus"></i> {{ __('bank.add_bank') }}</a>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8 offset-sm-2">

                                    <div class="input-group input-daterange" id="date-picker">
                                        @if (auth()->user()->myrole != App\Enums\UserRole::RESTAURANTOWNER)
                                            <select class="form-control" id="user_id" name="user_id">
                                                <option value=0>{{ __('levels.all') }}</option>
                                                @foreach ($restaurants as $restaurant)
                                                    <option value="{{ $restaurant->user->id }}">{{ $restaurant->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="date-search">{{ __('levels.search') }}</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable" data-url="{{ route('admin.get-bank') }}">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            <th>{{ __('bank.bank_name') }}</th>
                                            <th>{{ __('bank.account_number') }}</th>
                                            <th>{{ __('bank.mobile_agent_name') }}</th>
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
    <script src="{{ asset('js/bank/index.js') }}"></script>
@endsection
