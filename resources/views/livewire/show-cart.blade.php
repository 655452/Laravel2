<div>
    <!--======= PRODUCT MODAL PART START ========-->
    <div wire:ignore.self class="modal fade product-modal" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @if (!blank($menuItem))
                    <div class="product-modal-media">
                        <img src="{{ $menuItem->image }}" alt="modal">
                        <button class="fa-regular fa-circle-xmark" type="button" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="product-modal-group">
                        <h3 class="product-modal-title">{{ $menuItem->name }} </h3>
                        <p class="product-modal-describe">{!! $menuItem->description !!} </p>
                    </div>

                    <form wire:submit.prevent="submit({{ $restaurant->id }},{{ $menuItem->id }})">

                        @if (!blank($menuItem->variations))
                            <div class="product-modal-group">
                                <dl class="product-modal-subset">
                                    <dt>{{ __('frontend.combo') }} </dt>
                                    <dd class="require"> {{ __('frontend.required') }} </dd>
                                </dl>
                                <ul class="product-modal-list">
                                    @if (!blank($menuItem->variations))
                                        @foreach ($menuItem->variations as $index => $variation)
                                            <li>
                                                <input
                                                    wire:model.live="variationID{{ isset($menuItem->variations->menu_item_id) ? $menuItem->variations->menu_item_id : '' }}"
                                                    id="{{ $variation->name }}" name="variationID" type="radio"
                                                    value="{{ $variation->id }}" class="form-radio"
                                                    @if ($index === 0) checked @endif>
                                                <label for="{{ $variation->name }}"> {{ $variation->name }}</label>
                                                <span> {{ setting('currency_code') }}
                                                    {{ $variation->price - $variation->discount_price }} </span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        @else
                            <div class="product-modal-group">
                                <dl class="product-modal-subset mb-0">
                                    <dt>{{ __('frontend.price') }} </dt>
                                    <span class="fw-bold"> {{ setting('currency_code') }}
                                        {{ $menuItem->unit_price - $menuItem->discount_price }}</span>
                                </dl>
                            </div>
                        @endif

                        @if (!blank($menuItem->options))
                            <div class="product-modal-group">
                                <dl class="product-modal-subset">
                                    <dt>{{ __('frontend.addon') }}</dt>
                                    <dd class="option">{{ __('frontend.optional') }}</dd>
                                </dl>
                                <ul class="product-modal-list">
                                    @foreach ($menuItem->options as $option)
                                        <li>
                                            <input wire:model.live="options"
                                                id="check-option-{{ __('other') }}-{{ $menuItem->id }}-{{ $option->id }}"
                                                type="checkbox" value="{{ $option->id }}" name="options[]"
                                                class="form-checkbox">
                                            <label
                                                for="check-option-{{ __('other') }}-{{ $menuItem->id }}-{{ $option->id }}">{{ $option->name }}
                                            </label>
                                            <span> + {{ setting('currency_code') }}
                                                {{ $option->price }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="product-modal-group">
                            <dl class="product-modal-subset">
                                <dt>{{ __('frontend.special_instructions') }} </dt>
                                <dd class="option">{{ __('frontend.optional') }}</dd>
                            </dl>
                            <input class="product-modal-instruct WYSIWYG" name="instructions" cols="40"
                                rows="3" id="instructions" wire:model.live="instructions" spellcheck="true"
                                placeholder="Ex: Special Instructions">
                        </div>

                        <div class="product-modal-footer">
                            <div class="cart-counter">
                                <button type="button" wire:click.prevent="removeItemQty()"
                                    class="fa-solid fa-minus cart-counter-minus" id="qut-button-minus"></button>
                                <input type="number" step=".01" name="product_quantity" id="quantity"
                                    wire:model.live="quantity" value="{{ $quantity }}" min="1"
                                    max="99" class="cart-counter-value pppQty">
                                <button type="button" wire:click.prevent="addItemQty()" id="qut-button-plus"
                                    class="fa-solid fa-plus cart-counter-plus"></button>
                            </div>

                            <button class="cart-btn" data-bs-dismiss="modal">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.6333 7.4665C16.075 6.84984 15.2333 6.4915 14.0666 6.3665V5.73317C14.0666 4.5915 13.5833 3.4915 12.7333 2.72484C11.875 1.9415 10.7583 1.57484 9.59995 1.68317C7.60828 1.87484 5.93328 3.79984 5.93328 5.88317V6.3665C4.76662 6.4915 3.92495 6.84984 3.36662 7.4665C2.55828 8.3665 2.58328 9.5665 2.67495 10.3998L3.25828 15.0415C3.43328 16.6665 4.09162 18.3332 7.67495 18.3332H12.325C15.9083 18.3332 16.5666 16.6665 16.7416 15.0498L17.325 10.3915C17.4166 9.5665 17.4333 8.3665 16.6333 7.4665ZM9.71662 2.8415C10.55 2.7665 11.3416 3.02484 11.9583 3.58317C12.5666 4.13317 12.9083 4.9165 12.9083 5.73317V6.3165H7.09162V5.88317C7.09162 4.39984 8.31662 2.97484 9.71662 2.8415ZM7.01662 10.9582H7.00828C6.54995 10.9582 6.17495 10.5832 6.17495 10.1248C6.17495 9.6665 6.54995 9.2915 7.00828 9.2915C7.47495 9.2915 7.84995 9.6665 7.84995 10.1248C7.84995 10.5832 7.47495 10.9582 7.01662 10.9582ZM12.85 10.9582H12.8416C12.3833 10.9582 12.0083 10.5832 12.0083 10.1248C12.0083 9.6665 12.3833 9.2915 12.8416 9.2915C13.3083 9.2915 13.6833 9.6665 13.6833 10.1248C13.6833 10.5832 13.3083 10.9582 12.85 10.9582Z"
                                        fill="white" />
                                </svg>
                                <span>{{ __('frontend.add_to_cart') }} </span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <!--======= PRODUCT MODAL PART END =====-->
</div>
