<form method="POST" action="{{ $attributes->get('action') }}" id="payment-form">
    {{ csrf_field() }}
    {{ isset($input) ? $input : '' }}
    <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="col-md-4 control-label">{{__('frontend.name_on_card')}} </label>

        <div class="col-md-6">
            <input id="card-holder-name" type="text"
                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   name="name" value="{{ old('name') }}">

            @if ($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-md-4 control-label">{{__('frontend.card_details')}}</label>

        <div class="col-md-6">
            <div id="card-element"></div>
        </div>
    </div>
    {{ isset($slot) ? $slot : '' }}
</form>

@push('js')
<script type="application/javascript"> let stripe_config = Stripe('{{ config('cashier.key') }}'); </script>
 <script src="{{ asset('js/stripe/stripe.js') }}"></script>
@endpush
