<div class="item-list">
    <div class="col-md-12">
        @if(!blank(Cart::content()))
            @foreach(Cart::content() as $content)
                <table class="table cart-table">
                    <tr>
                        <td>
                            <button class="cart-item-delete-button"><i class="fa fa-trash"></i></button>
                        </td>
                        <td class="product-style">
                            {{ $content->name }}
                        </td>
                        <td class="float-right">
                            {{ currencyName($content->price) }}
                        </td>
                    </tr>
                    <tr> 
                        <td>
                        </td>
                        <td class="variation-option-style">
                            @if(isset($content->options->variation['name']) && isset($content->options->variation['price']))
                                <b>{{ $content->options->variation['name'] }}</b>
                            @endif
                            @if(!blank($content->options->options))
                                <br>
                                @foreach ($content->options->options as $option)
                                    <span>+ {{ $option['name'] }}</span><br>
                                @endforeach
                            @endif
                        </td>
                        <td class="float-right">
                            <div class="plusminus horiz custom-style">
                                <button class="quantity-change-btn" id="button-minus"></button>
                                <input type="number" class="quantity-change" name="slot-qty" id="{{ $content->rowId }}" value="{{ $content->qty }}" min="1" max="99">
                                <button class="quantity-change-btn" id="button-plus"></button>
                            </div>
                        </td>
                    </tr>
                </table>
            @endforeach
        @endif
    </div>
</div>

<div class="col-md-12">
    <hr class="hr-cart-style">
    <table class="table cart-table subtotal">
        <tr>
            <td>{{ __('frontend.subtotal') }}</td>
            <td class="float-right">{{ currencyName(Cart::totalFloat()) }}</td>
        </tr>
        <tr>
            <td>{{ __('frontend.total') }}</td>
            <td class="float-right">{{ currencyName(Cart::totalFloat()) }}</td>
        </tr>
    </table>
    <a href="{{ route('checkout.index') }}" class="btn btn-checkout">{{ __('frontend.go_to_checkout') }}</a>
</div>
