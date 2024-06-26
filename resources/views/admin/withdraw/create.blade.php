@extends('admin.layouts.master')

@section('main-content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('withdraw.withdraw') }}</h1>
        {{ Breadcrumbs::render('withdraw/add') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <form action="{{ route('admin.withdraw.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <input name="request_withdraw_id" type="hidden" value="{{ $requestWithdraw->id }}">
                                <label>{{ __('levels.user') }}</label> <span class="text-danger">*</span>
                                <select name="user_id" id="user_id"
                                    class="form-control select2 @error('user_id') is-invalid @enderror"
                                    data-url="{{ route('admin.withdraw.get-user-info') }}">
                                    <option value="">{{ __('levels.select_user') }}</option>
                                    <?php $selectUser = []; ?>
                                    @if(!blank($users))
                                    @foreach($users as $user)
                                    @if($user->id == old('user_id'))
                                    <?php  $selectUser = $user; ?>
                                    @endif
                                    <option value="{{ $user->id }}"
                                        {{ (old('user_id', $requestWithdraw->user_id) == $user->id || auth()->user()->id == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{  trans('user_roles.'.$user->myrole) }}
                                        {{ !blank($user->phone)  ? ' '.$user->phone : '' }})</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('user_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('levels.amount') }}</label> <span class="text-danger">*</span>
                                <input type="number" step=".01" name="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $requestWithdraw->amount) }}">
                                @error('amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('withdraw.payment_type') }}</label> <span class="text-danger">*</span>
                                <select name="payment_type" id="payment_type" class="form-control select2 @error('payment_type') is-invalid @enderror">
                                    <option value="">{{ __('withdraw.select_payment_type') }}</option>
                                  @if(trans('payment_type'))
                                  @foreach(trans('payment_type') as $key=> $value)
                                    <option {{ old('payment_type') == $key ? 'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                                  @endforeach
                                  @endif
                                </select>
                                @error('payment_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>


            <div id="userInfo" class="col-12 col-md-12 col-lg-4">
                @if(!blank($selectUser))

                <div class="card profile-widget margin-hidden">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ $selectUser->image }}" class="rounded-circle profile-picture center ">
                    </div>
                    <div class="profile-widget-description">
                        <dl class="row">
                            <dt class="col-sm-5">{{ __('levels.name') }} <strong class="float-right">:</strong></dt>
                            <dd class="col-sm-7">{{ $selectUser->name }}</dd>
                            <dt class="col-sm-5">{{ __('levels.phone') }} <strong class="float-right">:</strong></dt>
                            <dd class="col-sm-7">{{ $selectUser->phone }}</dd>
                            <dt class="col-sm-5">{{ __('levels.email') }} <strong class="float-right">:</strong></dt>
                            <dd class="col-sm-7">{{ $selectUser->email }}</dd>
                            @if ($selectUser->myrole == 4)
                            <dt class="col-sm-5">{{ __('levels.order_balance') }} <strong class="float-right">:</strong></dt>
                            <dd class="col-sm-7">{{ currencyFormat($selectUser->deliveryBoyAccount->balance) }}</dd>
                            @endif
                            <dt class="col-sm-5">{{ __('levels.credit') }} <strong class="float-right">:</strong></dt>
                            <dd class="col-sm-7">
                                {{ currencyFormat($selectUser->balance->balance ) }}
                            </dd>
                            <dt class="col-sm-5">{{ __('levels.address') }} <strong class="float-right">:</strong></dt>
                            <dd class="col-sm-7">{{ $selectUser->address }}</dd>
                            <dt class="col-sm-5">{{ __('withdraw.role') }} <strong class="float-right">:</strong></dt>
                            <dd class="col-sm-7">{{ trans('user_roles.'.$selectUser->myrole) }}</dd>
                            <dt class="col-sm-5">{{ __('levels.status') }} <strong class="float-right">:</strong></dt>
                            <dd class="col-sm-7">{{ $selectUser->mystatus }}</dd>
                        </dl>
                    </div>
                </div>
                @endif
            </div>



        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/withdraw/create.js') }}"></script>
@endsection
