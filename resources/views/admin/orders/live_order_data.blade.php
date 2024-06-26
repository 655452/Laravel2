<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="far fa-plus-square"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('order.total_order') }}</h4>
                </div>
                <div class="card-body">
                    {{ $total_order }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="far fa-paper-plane"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('order.order_pending') }}</h4>
                </div>
                <div class="card-body">
                    {{ $pending_order }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="far fa-star"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('order.order_process') }}</h4>
                </div>
                <div class="card-body">
                    {{ $process_order }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-check"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('order.order_completed') }}</h4>
                </div>
                <div class="card-body">
                    {{ $completed_order }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body live-order">
                <div class="row ">
                    <div class="col-md-4">
                        <div class="list">
                            <h3 class="">{{__('order.new_order')}}</h3>

                            <hr>
                            @if($new_orders)
                            @foreach($new_orders as $order)
                            <div class="row p-3 ticket">
                                <div class="list-info col-8">
                                    <p>{{__('order.just_created')}}</p>
                                    <p>{{food_date_format($order->created_at)}}</p>
                                    <h5>#{{$order->id}} {{$order->restaurant->name}}</h5>
                                    <p>{{__('levels.order_type')}}: {{ $order->getOrderType }}</p>
                                    <p>{{ $order->user->name ?? null }}</p>
                                    <p>{{currencyFormat($order->total)}}</p>
                                </div>
                                <div class="col-4 align-self-center text-center">
                                    <a href="{{route('admin.orders.edit',$order)}}" class="btn btn-sm btn-primary">{{__('order.details')}}</a>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="list">
                            <h3 class="text-success">{{__('order.accepted')}}</h3>
                            <hr>
                            @if($accepted_orders)
                            @foreach($accepted_orders as $order)
                            <div class="row p-3 ticket">
                                <div class="list-info col-8">
                                    <p><b>{{__('order.accepted_by')}}&nbsp;</b>{{$order->restaurant->user->name}}</p>
                                    <p>{{food_date_format($order->created_at)}}</p>
                                    <h5>#{{$order->id}} {{$order->restaurant->name}}</h5>
                                    <p>{{__('levels.order_type')}}: {{ $order->getOrderType }}</p>
                                    <p>{{ $order->user->name ?? null }}</p>
                                    <p>{{currencyFormat($order->total)}}</p>
                                </div>
                                <div class="col-4 align-self-center text-center">
                                    <a href="{{route('admin.orders.edit',$order)}}" class="btn btn-sm btn-primary">{{__('order.details')}}</a>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="list">
                            <h3 class="text-primary">{{__('order.done')}}</h3>
                            <hr>
                            @if($done_orders)
                            @foreach($done_orders as $order)
                            <div class="row p-3 ticket">
                                <div class="list-info col-8">
                                    <p>{{ trans('order_status.'.$order->status)}}</p>
                                    <p>{{food_date_format($order->created_at)}}</p>
                                    <h5>#{{$order->id}} {{$order->restaurant->name}}</h5>
                                    <p>{{__('levels.order_type')}}: {{ $order->getOrderType }}</p>
                                    <p>{{ $order->user->name ?? null }}</p>
                                    <p>{{currencyFormat($order->total)}}</p>
                                </div>
                                <div class="col-4 align-self-center text-center">
                                    <a href="{{route('admin.orders.edit',$order)}}" class="btn btn-sm btn-primary">{{__('order.details')}}</a>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
