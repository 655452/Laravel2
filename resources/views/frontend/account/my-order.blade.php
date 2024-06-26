@extends('frontend.layouts.app')

@section('main-content')
    <!--======== SETTINGS PART START =======-->
    <section class="settings">
        <div class="container">
            <div class="row">

                @include('frontend.account.partials._sidebar')

                <div class="col-12 col-lg-8 col-xl-9">
                    <h3 class="settings-title"> {{ __('frontend.my_recent_orders') }} </h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">{{ __('frontend.order') }} </th>
                                    <th scope="col">{{ __('frontend.date_purchased') }} </th>
                                    <th scope="col">{{ __('frontend.status') }}</th>
                                    <th scope="col">{{ __('levels.order_type') }} </th>
                                    <th scope="col">{{ __('frontend.total') }}</th>
                                    <th scope="col">{{ __('frontend.details') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!blank($orders))
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td data-title="uid">
                                                <a
                                                    href="{{ route('account.order.show', $order->id) }}">{{ $order->order_code }}</a>
                                            </td>
                                            <td data-title="date">
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}
                                            </td>

                                            @if ($order->status == \App\Enums\OrderStatus::PENDING)
                                                @php($statusColor = 'yellow')
                                            @elseif($order->status == \App\Enums\OrderStatus::CANCEL)
                                                @php($statusColor = 'red')
                                            @elseif($order->status == \App\Enums\OrderStatus::REJECT)
                                                @php($statusColor = 'maroon')
                                            @elseif($order->status == \App\Enums\OrderStatus::ACCEPT)
                                                @php($statusColor = 'blue')
                                            @elseif($order->status == \App\Enums\OrderStatus::PROCESS)
                                                @php($statusColor = 'orange')
                                            @elseif($order->status == \App\Enums\OrderStatus::ON_THE_WAY)
                                                @php($statusColor = 'yellow')
                                            @else
                                                @php($statusColor = 'green')
                                            @endif

                                            <td data-title="status">
                                                <span class="badge-text {{ $statusColor }}">
                                                    {{ trans('order_status.' . $order->status) }}
                                                </span>
                                            </td>

                                            <td data-title="type">{{ $order->getOrderType }}</td>
                                            <td data-title="total"> {{ currencyFormat($order->total) }} </td>

                                            <td data-title="action">
                                                <div class="table-action">
                                                    <a href="{{ route('account.order.show', $order->id) }}"  type="button"  title="View Details"
                                                        class="fa-solid fa-eye button"></a>

                                                    @if ($order->status == app\Enums\OrderStatus::COMPLETED)
                                                        <a href="{{ route('account.report', $order->id) }}" type="button"  title="Report"
                                                            class="fa-solid fa-circle-exclamation button
                                                            {{ array_key_exists($order->id, $reports) ? 'bg-warning' : 'bg-danger' }}">
                                                        </a>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="custormpaginate mt-3">
                        {!! $orders->onEachSide(0)->links() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--======= SETTINGS PART END ====-->
@endsection
