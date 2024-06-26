@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('order.live_orders') }}</h1>
        {{ Breadcrumbs::render('live-orders') }}
    </div>
    <div class="section-body">
        
    </div>
</section>

@endsection


@section('scripts')
<script>
    const liveOrderRoute = "{{ route('admin.orders.get-live-Order') }}";
</script>

<script src="{{ asset('js/live-orders/index.js') }}"></script>
@endsection