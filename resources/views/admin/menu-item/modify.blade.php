@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('restaurant.menu_item') }}</h1>
        {{ Breadcrumbs::render('menu-items/edit', $menuItem) }}
    </div>
    <div class="section-body">
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.menu-items.modify', $menuItem) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="float-left">{{ __('restaurant.product_variation') }}</h3>
                                <button class="btn btn-primary btn-sm float-right" id="variation-add">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('levels.name') }}</th>
                                                <th>{{ __('levels.price') }}</th>
                                                <th>{{ __('levels.discount') }}</th>
                                                <th>{{ __('levels.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="variationTbody">
                                            @if(!blank(session('variation')))
                                                @foreach(session('variation') as $variation)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="variation[<?=$variation?>][name]" placeholder="{{__('levels.name')}}" class="form-control form-control-sm @error("variation.$variation.name") is-invalid @enderror" value="{{ old("variation.$variation.name") }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="variation[<?=$variation?>][price]" placeholder="{{__('levels.price')}}" class="form-control form-control-sm change-productprice @error("variation.$variation.price") is-invalid @enderror" value="{{ old("variation.$variation.price") }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="variation[<?=$variation?>][discount_price]" placeholder="{{__('levels.discount_price')}}" class="form-control form-control-sm change-productdiscountprice @error("variation.$variation.discount_price") is-invalid @enderror" value="{{ old("variation.$variation.discount_price") }}">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm removeBtn">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @elseif(!blank($menu_item_variations))
                                                @foreach($menu_item_variations as $menu_item_variation)
                                                    @php
                                                        $variation = $menu_item_variation->id;
                                                        $loopindex = $loop->index + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="variation[<?=$variation?>][name]" placeholder="{{__('levels.name')}}" class="form-control form-control-sm @error("variation.$variation.name") is-invalid @enderror" value="{{ old("variation.$variation.name", $menu_item_variation->name) }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="variation[<?=$variation?>][price]" placeholder="{{__('levels.price')}}" class="form-control form-control-sm change-productprice @error("variation.$variation.price") is-invalid @enderror" value="{{ old("variation.$variation.price", $menu_item_variation->price) }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="variation[<?=$variation?>][discount_price]" placeholder="{{__('levels.discount_price')}}" class="form-control form-control-sm change-productdiscountprice @error("variation.$variation.discount_price") is-invalid @enderror" value="{{ old("variation.$variation.discount_price",$menu_item_variation->discount_price) }}">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm removeBtn">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <h3 class="float-left">{{ __('levels.product_options') }}</h3>
                                <button class="btn btn-primary btn-sm float-right" id="option-add">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('levels.name') }}</th>
                                                <th>{{ __('levels.price') }}</th>
                                                <th>{{ __('levels.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="optionTbody">
                                            @if(!blank(session('option')))
                                                @foreach(session('option') as $option)
                                                     <tr>
                                                        <td>
                                                            <input type="text" name="option[<?=$option?>][name]" placeholder="{{__('levels.name')}}" class="form-control form-control-sm @error("option.$option.name") is-invalid @enderror" value="{{ old("option.$option.name") }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="option[<?=$option?>][price]" placeholder="{{__('levels.price')}}" class="form-control form-control-sm change-productprice @error("option.$option.price") is-invalid @enderror" value="{{ old("option.$option.price") }}">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm removeBtn">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                             @elseif(!blank($menu_item_options))
                                                @foreach($menu_item_options as $menu_item_option)
                                                    @php
                                                        $option = $loop->index + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="option[<?=$option?>][name]" placeholder="Na{{__('levels.name')}}me" class="form-control form-control-sm @error("option.$option.name") is-invalid @enderror" value="{{ old("option.$option.name", $menu_item_option->name) }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="option[<?=$option?>][price]" placeholder="{{__('levels.price')}}" class="form-control form-control-sm change-productprice @error("option.$option.price") is-invalid @enderror" value="{{ old("option.$option.price", $menu_item_option->price) }}">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm removeBtn">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-primary" id="saveMenuItem" type="submit"> {{ __('levels.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        @php
            $menu_item_variation_count = 0;
            if(!blank(session('variation'))) {
                $menu_item_variation_count = count(session('variation'));
            } else {
                $menu_item_variation_count = $menu_item_variations->count();
            }

            $menu_item_option_count = 0;
            if(!blank(session('option'))) {
                $menu_item_option_count = count(session('option'));
            } else {
                $menu_item_option_count = $menu_item_options->count();
            }
        @endphp

        var menu_item_variation_count  = <?=$menu_item_variation_count?>;
        var menu_item_option_count     = <?=$menu_item_option_count?>;
    </script>
    <script src="{{ asset('js/menu-item/modify.js') }}"></script>
@endsection
