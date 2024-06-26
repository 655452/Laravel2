@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('user.profile') }}</h1>
        {{ Breadcrumbs::render('profile') }}
    </div>
    <div class="section-body">
        <h2 class="section-title">{{ $user->name }}</h2>
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ $user->image }}" class="rounded-circle profile-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">{{ __('order.order') }}</div>
                                <div class="profile-widget-item-value">{{ $ordercount }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">
                            {{ $user->name }}
                            <div class="text-muted d-inline font-weight-normal">
                                <div class="slash"></div>
                                {{ $user->email }}
                            </div>
                        </div>
                        <dl class="row">
                            <dt class="col-sm-4">{{ __('levels.username') }}</dt>
                            <dd class="col-sm-8">{{ $user->username }}</dd>
                            <dt class="col-sm-4">{{ __('levels.phone') }}</dt>
                            <dd class="col-sm-8">{{ $user->phone }}</dd>
                            <dt class="col-sm-4">{{ __('levels.address') }}</dt>
                            <dd class="col-sm-8">
                                <p>{{ $user->address }}</p>
                            </dd>
                            <dt class="col-sm-4">{{ __('levels.limit') }}</dt>
                            <dd class="col-sm-8">
                                {{ isset($user->deposit->limit_amount) ? currencyFormat($user->deposit->limit_amount) : '' }}
                            </dd>
                            <dt class="col-sm-4">{{ __('levels.deposit') }}</dt>
                            <dd class="col-sm-8">
                                {{ isset($user->deposit->deposit_amount) ? currencyFormat($user->deposit->deposit_amount) : '' }}
                            </dd>
                            <dt class="col-sm-4">{{ __('levels.credit') }}</dt>
                            <dd class="col-sm-8">
                                {{ currencyFormat($user->balance->balance ) }}</dd>
                            @if(auth()->user()->myrole == \App\Enums\UserRole::DELIVERYBOY)
                            <dt class="col-sm-4">{{ __('C.O.D. Amount') }}</dt>
                            <dd class="col-sm-8">
                                {{ currencyFormat($user->deliveryBoyAccount->balance > 0 ? $user->deliveryBoyAccount->balance : 0 ) }}
                                </p>
                            </dd>
                            @endif
                        </dl>
                    </div>
                </div>
                <div class="card">
                    <form method="post" action="{{ route('admin.profile.change') }}">
                        @csrf
                        @method('put')
                        <div class="card-header">
                            <h4>{{ __('user.change_password') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12 col-12">
                                    <label for="old_password">{{ __('user.old_password') }}</label> <span
                                        class="text-danger">*</span>
                                    <input id="old_password" name="old_password" type="password"
                                        class="form-control @error('old_password') is-invalid @enderror">
                                    @error('old_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 col-12">
                                    <label for="password">{{ __('levels.password') }}</label> <span
                                        class="text-danger">*</span>
                                    <input id="password" name="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" />
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 col-12">
                                    <label for="password_confirmation">{{ __('user.password_confirmation') }}</label> <span
                                        class="text-danger">*</span>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror" />
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary">{{ __('user.save_password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <form action="{{ route('admin.profile.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.first_name') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name', $user->first_name) }}">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label>{{ __('levels.last_name') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name', $user->last_name) }}">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.email') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label>{{ __('levels.phone') }}</label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.username') }}</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username', $user->username) }}">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="customFile">{{ __('levels.image') }}</label>
                                    <div class="custom-file">
                                        <input name="image" type="file"
                                            class="custom-file-input @error('image') is-invalid @enderror"
                                            id="customFile" onchange="readURL(this);">
                                        <label class="custom-file-label"
                                            for="customFile">{{ __('levels.choose_file') }}</label>
                                    </div>
                                    @if ($errors->has('image'))
                                    <div class="help-block text-danger">
                                        {{ $errors->first('image') }}
                                    </div>
                                    @endif
                                    <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                        src="{{ $user->image }}" alt="{{ $user->name }} {{ __('profile image') }}" />
                                </div>
                                <div class="form-group col">
                                    <label>{{ __('levels.address') }}</label>
                                    <textarea name="address" class="form-control small-textarea-height" id="address"
                                        cols="30" rows="10">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                        </div>
                    </div>
                </form>

                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary resetForm" data-toggle="modal" data-target="#openAddressModal">
                            <i class="fas fa-plus"></i>
                            {{ __('levels.add_address') }}
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('levels.label') }}</th>
                                    <th>{{ __('levels.street') }}</th>
                                    <th>{{ __('levels.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!blank($user->addresses))
                                @foreach($user->addresses as $address)
                                <tr>
                                    <td>{{ $address->customLabel }}</td>
                                    <td>{{ $address->street }}</td>
                                    <td>
                                        <button data-toggle="modal" data-target="#openAddressModal"
                                            class="btn btn-sm btn-icon float-left btn-primary edit-address"
                                            data-id="{{ $address->id }}" data-label="{{ $address->label }}"
                                            data-street="{{ $address->street }}" data-note="{{ $address->note }}"
                                            data-latitude="{{ $address->latitude }}"
                                            data-longitude="{{ $address->longitude }}">
                                            <i class="far fa-edit" data-toggle="tooltip" data-placement="top"
                                                data-original-title="Edit"></i>

                                        </button>

                                        <form class="float-left pl-2"
                                            action="{{ route('admin.profile.delete-address', $address) }}"
                                            method="POST">
                                            {!! method_field('DELETE') . csrf_field() !!}
                                            <button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip"
                                                data-placement="top" title="Delete"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @if(!blank($bank))
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __("bank.bank_details")}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile-bank',$bank) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">

                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label>{{ __('bank.bank_name') }}</label> <span class="text-danger">*</span>
                                        <input type="text" name="bank_name"
                                            class="form-control @error('bank_name') is-invalid @enderror"
                                            value="{{ old('bank_name',$bank->bank_name) }}">
                                        @error('bank_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>{{ __('bank.bank_code') }}</label>
                                        <input type="text" name="bank_code"
                                            class="form-control @error('bank_code') is-invalid @enderror"
                                            value="{{ old('bank_code',$bank->bank_code) }}">
                                        @error('bank_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>{{ __('bank.recipient_name') }}</label>
                                        <input type="text" name="recipient_name"
                                            class="form-control @error('recipient_name') is-invalid @enderror"
                                            value="{{ old('recipient_name',$bank->recipient_name) }}">
                                        @error('recipient_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>{{ __('bank.account_number') }}</label>
                                        <input type="text" name="account_number"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            value="{{ old('account_number',$bank->account_number) }}">
                                        @error('account_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>{{ __('bank.mobile_agent_name') }}</label>
                                        <input type="text" name="mobile_agent_name"
                                            class="form-control @error('mobile_agent_name') is-invalid @enderror"
                                            value="{{ old('mobile_agent_name',$bank->mobile_agent_name) }}">
                                        @error('mobile_agent_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>{{ __('bank.mobile_agent_number') }}</label>
                                        <input type="text" name="mobile_agent_number"
                                            class="form-control @error('mobile_agent_number') is-invalid @enderror"
                                            value="{{ old('mobile_agent_number',$bank->mobile_agent_number) }}">
                                        @error('mobile_agent_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>{{ __('bank.paypal_id') }}</label>
                                        <input type="text" name="paypal_id"
                                            class="form-control @error('paypal_id') is-invalid @enderror"
                                            value="{{ old('paypal_id',$bank->paypal_id) }}">
                                        @error('paypal_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>{{ __('bank.upi_id') }}</label>
                                        <input type="text" name="upi_id"
                                            class="form-control @error('upi_id') is-invalid @enderror"
                                            value="{{ old('upi_id',$bank->upi_id) }}">
                                        @error('upi_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif


</section>

<div class="modal fade" tabindex="-1" role="dialog" id="openAddressModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('levels.add_address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="hidden" name="street" id="id">
                            <label>{{ __('levels.label') }}</label>
                            <span class="text-danger">*</span>
                            <select class="form-control form-control-sm-custom" name="label" id="label">
                                @foreach(trans('address_types') as $addressTypeKey => $addressType)
                                <option value="{{ $addressTypeKey }}">{{ $addressType }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>{{ __('levels.street') }}</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control form-control-sm" placeholder="{{__('levels.enter_street')}}"
                                name="street" id="street">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>{{ __('levels.note') }}</label>
                            <input type="text" class="form-control form-control-sm" placeholder="{{__('levels.enter_note')}}" name="note"
                                id="note">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{ __('levels.latitude') }}</label>
                            <input type="text" class="form-control form-control-sm" placeholder="{{__('levels.enter_latitude')}}"
                                name="latitude" id="latitude">
                        </div>
                        <div class="form-group">
                            <label>{{ __('levels.longitude') }}</label>
                            <input type="text" class="form-control form-control-sm" placeholder="{{__('levels.enter_longitude')}}"
                                name="longitude" id="longitude">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="googleMapAddress">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" id="save-address">{{ __('levels.save_address') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ setting('google_map_api_key') }}&libraries=places&callback=initMap">
</script>

<script type="text/javascript">
    let setUrl = "{{ route('admin.profile.save-address') }}";

</script>

<script src="{{ asset('js/profile/index.js') }}"></script>
@endsection
