@extends('frontend.layouts.app')

@section('main-content')

    <!--======== SETTINGS PART START =======-->
    <section class="settings">
        <div class="container">
            <div class="row">

                @include('frontend.account.partials._sidebar')

                <div class="col-12 col-lg-8 col-xl-9">
                    <h3 class="settings-title">{{ __('frontend.my_reservations') }} </h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">{{ __('levels.name') }} </th>
                                    <th scope="col">{{ __('levels.restaurants') }} </th>
                                    <th scope="col">{{ __('frontend.reservation_date') }}</th>
                                    <th scope="col">{{ __('levels.slot') }}</th>
                                    <th scope="col">{{ __('levels.table') }}</th>
                                    <th scope="col">{{ __('levels.guest') }}</th>
                                    <th scope="col">{{ __('levels.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (!blank($reservations))
                                    @foreach ($reservations as $reservation)
                                        <tr>

                                            <td data-title="name">
                                                {{ Str::of($reservation->first_name . ' ' . $reservation->last_name,)->limit(15, '..') }}
                                            </td>

                                            <td data-title="shop">{{ $reservation->restaurant->name }}</td>
                                            <td data-title="date">
                                                {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}
                                            </td>
                                            <td data-title="slot">
                                                {{ date('h:i A', strtotime($reservation->timeSlot->start_time)) . '-' . date('h:i A', strtotime($reservation->timeSlot->end_time)) }}
                                            </td>
                                            <td data-title="table">{{ $reservation->table->name }} </td>
                                            <td data-title="guest">{{ $reservation->guest_number }}</td>

                                            <td data-title="status">
                                                <span class="badge-text {{ isset($statusClasses[$reservation->status]) ? $statusClasses[$reservation->status] : ''  }}">{{__('reservation_status.' . $reservation->status) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="custormpaginate mt-3">
                        {!! $reservations->onEachSide(0)->links() !!}
                    </div>

                </div>

            </div>
        </div>
    </section>
    <!--======= SETTINGS PART END ====-->

@endsection
