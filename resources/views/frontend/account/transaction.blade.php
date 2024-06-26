@extends('frontend.layouts.app')

@section('main-content')
    <!--======== SETTINGS PART START =======-->
    <section class="settings">
        <div class="container">
            <div class="row">

                @include('frontend.account.partials._sidebar')

                <div class="col-12 col-lg-8 col-xl-9">
                    <h3 class="settings-title">{{ __('frontend.my_latest_transaction') }}</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th>{{ __('frontend.id') }}</th>
                                    <th>{{ __('frontend.type') }}</th>
                                    <th>{{ __('frontend.date') }}</th>
                                    <th>{{ __('frontend.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (!blank($transactions))
                                    @php $i = 0 @endphp
                                    @foreach ($transactions as $transaction)
                                        @php $i++ @endphp
                                        <tr>
                                            <td data-title="uid"><a href="order-details.html">{{ $i }} </a></td>
                                            <td data-title="type">{{ trans('transaction_types.' . $transaction->type) }} </td>
                                            <td data-title="date">{{ food_date_format_with_day($transaction->created_at) }}
                                            </td>
                                            <td data-title="pay">{{ transactionCurrencyFormat($transaction) }} </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <h5 class="mb-3">{{ __('frontend.transaction_yet') }}</h5>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="custormpaginate mt-3">
                        {!! $transactions->onEachSide(0)->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--======= SETTINGS PART END ====-->
@endsection
