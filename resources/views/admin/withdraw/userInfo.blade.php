@if(!blank($user))
<div class="card profile-widget margin-hidden">
    <div class="profile-widget-header">
        <img alt="image" src="{{ $user->image }}" class="rounded-circle profile-picture center ">
    </div>
    <div class="profile-widget-description">
        <dl class="row">
            <dt class="col-sm-5">{{ __('levels.name') }} <strong class="float-right">:</strong></dt>
            <dd class="col-sm-7">{{ $user->name }}</dd>
            <dt class="col-sm-5">{{ __('levels.phone') }} <strong class="float-right">:</strong></dt>
            <dd class="col-sm-7">{{ $user->phone }}</dd>
            <dt class="col-sm-5">{{ __('levels.email') }} <strong class="float-right">:</strong></dt>
            <dd class="col-sm-7">{{ $user->email }}</dd>
            @if($user->myrole == 4)
            <dt class="col-sm-5">{{ __('levels.order_balance') }} <strong class="float-right">:</strong></dt>
            <dd class="col-sm-7">{{ currencyFormat( $user->deliveryBoyAccount->balance) }}</dd>
            @endif
            <dt class="col-sm-5">{{ __('levels.credit') }} <strong class="float-right">:</strong></dt>
            <dd class="col-sm-7">{{ currencyFormat($user->balance->balance ) }}</dd>
            <dt class="col-sm-5">{{ __('levels.address') }} <strong class="float-right">:</strong></dt>
            <dd class="col-sm-7">{{ $user->address }}</dd>
            <dt class="col-sm-5">{{ __('withdraw.role') }} <strong class="float-right">:</strong></dt>
            <dd class="col-sm-7">{{ trans('user_roles.'.$user->myrole) }}</dd>
            <dt class="col-sm-5">{{ __('levels.status') }} <strong class="float-right">:</strong></dt>
            <dd class="col-sm-7">{{ $user->mystatus }}</dd>
        </dl>
    </div>
</div>
@endif
