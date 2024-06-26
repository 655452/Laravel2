@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('levels.reservations') }}</h1>
            {{ Breadcrumbs::render('reservations/view') }}
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card profile-widget mt-0">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item profile-widget-item-header">
                                <strong>{{ $reservation->restaurant->name }}</strong>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.name') }}</dt>
                                <dd class="col-sm-8">{{ $reservation->first_name . ' ' . $reservation->last_name }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.email') }}</dt>
                                <dd class="col-sm-8">{{ $reservation->email }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.phone') }}</dt>
                                <dd class="col-sm-8">{{ $reservation->phone }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.date') }}</dt>
                                <dd class="col-sm-8">
                                    {{ \Carbon\Carbon::parse($reservation->created_at)->format('d M Y, h:i A') }}</dd>
                            </dl>

                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.slot') }}</dt>
                                <dd class="col-sm-8">
                                    {{ date('h:i A', strtotime($reservation->timeSlot->start_time)) . '-' . date('h:i A', strtotime($reservation->timeSlot->end_time)) }}
                                </dd>
                            </dl>

                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.table') }}</dt>
                                <dd class="col-sm-8">{{ $reservation->table->name }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.guest') }}</dt>
                                <dd class="col-sm-8">{{ $reservation->guest_number }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('Status') }}</dt>
                                <dd class="col-sm-8">{{ trans('reservation_status.' . $reservation->status) }}</dd>
                            </dl>

                        </div>
                    </div>
                </div>


                <div class="col-lg-5">
                    <div class="card">
                        <div class="profile-widget-description">
                            <img class="d-block w-100 h-232" src="{{ asset('images/reservation-table.png') }}">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
