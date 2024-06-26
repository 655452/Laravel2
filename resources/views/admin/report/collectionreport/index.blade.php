@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('reports.delivery_boy_collection_report') }}</h1>
        {{ Breadcrumbs::render('delivery-boy-collection-report') }}
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">

                <form action="<?= route('admin.delivery-boy-collection-report.index') ?>" method="POST">
                    @csrf
                    <div class="row">

                        @if(auth()->user()->myrole == 4)

                        <input type="hidden" name="user_id" class="form-control" value="{{ auth()->user()->id ?? 0 }}">

                        @else
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>{{ __('levels.delivery_boy') }}</label>
                                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                    <option value=0>{{ __('levels.select_delivery_boy') }}</option>
                                    @if(!blank($users))
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (old('user_id', $set_user_id) == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
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
                        @endif

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>{{ __('reports.from_date') }}</label>
                                <input type="text" name="from_date" class="form-control @error('from_date') is-invalid @enderror datepicker" value="{{ old('from_date', $set_from_date) }}">
                                @error('from_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>{{ __('reports.to_date') }}</label>
                                <input type="text" name="to_date" class="form-control @error('to_date') is-invalid @enderror datepicker" value="{{ old('to_date', $set_to_date) }}">
                                @error('to_date')
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
                <button class="btn btn-success btn-sm report-print-button" onclick="printDiv('printablediv')">{{ __('Print') }}</button>
            </div>
            <div class="card-body" id="printablediv">
                <h5>{{ __('reports.delivery_boy_collection_report') }}</h5>
                @if(!blank($collections))
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('levels.id') }}</th>
                                <th>{{ __('levels.name') }}</th>
                                <th>{{ __('levels.date') }}</th>
                                <th>{{ __('levels.amount') }}</th>
                            </tr>
                            @php $i=0; @endphp
                            @foreach($collections as $collection)
                            <tr>
                                <td>{{ $i+=1 }}</td>
                                <td>{{ $collection->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($collection->date)->format('d M Y') }}</td>
                                <td>{{ $collection->amount}}</td>

                            </tr>
                            @endforeach
                        </thead>
                    </table>
                </div>
                @else
                <h4 class="text-danger">{{ __('reports.delivery_boy_collection_report_not_found') }}</h4>
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
<script src="{{ asset('js/collectionreport/index.js') }}"></script>
@endsection
