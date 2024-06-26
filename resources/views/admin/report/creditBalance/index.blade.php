@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('reports.credit_balance_report') }}</h1>
            {{ Breadcrumbs::render('credit-balance-report') }}
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="<?=route('admin.credit-balance-report.index')?>" method="POST">
                        @csrf
                        <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>{{ __('levels.user_role') }}</label>
                                        <select name="role_id" id="userRoleID" class="form-control select2 @error('role_id') is-invalid @enderror">
                                            <option value="">{{ __('levels.select_user_role') }}</option>
                                            @if(!blank($roles))
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ (old('role_id', $set_role_id) == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('role_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                <div class="form-group">
                                    <label>{{ __('levels.users') }}</label>
                                    <select name="user_id" id="users" class="form-control select2 @error('user_id') is-invalid @enderror">
                                        <option value="">{{ __('levels.select_user') }}</option>
                                        @if(!blank($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ (old('user_id', $set_user_id) == $user->id) ? 'selected' : '' }}>{{ $user->name }} @if($user->phone) ({{ $user->phone }}) @endif</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-primary form-control" type="submit">{{ __('reports.get_report') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            @if($showView)
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-success btn-sm report-print-button" onclick="printDiv('printablediv')">{{ __('levels.print') }}</button>
                    </div>
                    <div class="card-body" id="printablediv">
                        <h5>{{ __('Credit Balance Report') }}</h5>
                        @if(!blank($creditBalances))
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('User Role') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Credit') }}</th>

                                        </tr>
                                        @php $i=0; @endphp
                                        @foreach($creditBalances as $creditBalance)
                                            <tr>
                                                <td>{{ $i+=1 }}</td>
                                                <td>{{ $creditBalance->name }}</td>
                                                <td>{{ $creditBalance->getrole->name }}</td>
                                                <td>{{ $creditBalance->phone }}</td>
                                                <td>{{ currencyFormat($creditBalance->balance->balance) }}</td>
                                            </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                        @else
                            <h4 class="text-danger">{{ __('The Credit Balance Report data not found') }}</h4>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
         const indexUrl = "{{ route('admin.get-role-user') }}";
    </script>
    <script src="{{ asset('js/creditBalance/index.js') }}"></script>
@endsection
