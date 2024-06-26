@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('reports.reservation_report') }}</h1>
        {{ Breadcrumbs::render('reservation-report') }}
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">

                <form action="<?= route('admin.reservation-report.index') ?>" method="POST">
                    @csrf
                    <div class="row">

                        @if(auth()->user()->myrole == 3)

                        <input type="hidden" name="restaurant_id" class="form-control" value="{{ auth()->user()->restaurant->id ?? 0 }}">

                        @else
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>{{ __('levels.restaurant') }}</label> 
                                <select name="restaurant_id" class="form-control @error('restaurant_id') is-invalid @enderror">
                                    <option value="">{{ __('levels.select_restaurant') }}</option>
                                    @if(!blank($restaurants))
                                    @foreach($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}" {{ (old('restaurant_id', $set_restaurant_id) == $restaurant->id) ? 'selected' : '' }}>{{ $restaurant->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('restaurant_id')
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
                <h5>{{ __('reports.reservation_report') }}</h5>
                @if(!blank($reservations))
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{__('levels.id')}}</th>
                                <th>{{ __('levels.restaurant_name') }}</th>
                                <th>{{ __('levels.table') }}</th>
                                <th>{{ __('levels.date') }}</th>
                                <th>{{ __('levels.slot') }}</th>
                                <th>{{ __('levels.guest') }}</th>
                                <th>{{ __('levels.name') }}</th>
                            </tr>
                            
                            @php $i=0; @endphp
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $i+=1 }}</td>
                                <td>{{ $reservation->table->restaurant->name }}</td>
                                <td>{{ $reservation->table->name }}</td>
                                <td>{{ date('d M Y', strtotime($reservation->created_at))}}</td>
                                <td>{{date('h:i A', strtotime($reservation->timeSlot->start_time)).'-'.date('h:i A', strtotime($reservation->timeSlot->end_time))}}</td>
                                <td>{{ $reservation->guest_number}}</td>
                                <td>{{ $reservation->first_name.' '.$reservation->last_name}}</td>
                            </tr>
                            @endforeach
                        </thead>
                    </table>
                </div>
                @else
                <h4 class="text-danger">{{ __('reports.reservation_report_not_found') }}</h4>
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
<script src="{{ asset('js/reservationreport/index.js') }}"></script>
@endsection