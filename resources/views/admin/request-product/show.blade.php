@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
    <section class="section">
        <div class="section-header">
        <h1>{{ __('levels.request_product') }}</h1>
            {{ Breadcrumbs::render('request-products/view') }}
        </div>
        <div class="section-body">
            <h2 class="section-title">{{ $product->name }}</h2>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            @foreach($product->getMedia('products') as $key => $media)
                                <img alt="image" src="{{ asset($media->getUrl()) }}" class="rounded-circle profile-picture">
                            @endforeach
                        </div>
                        <div class="profile-widget-description">
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.description') }}</dt>
                                <dd class="col-sm-8">{{ strip_tags($product->description) }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.price') }}</dt>
                                <dd class="col-sm-8">{{ currencyFormat($product->unit_price) }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.status') }}</dt>
                                <dd class="col-sm-8">{{ trans('statuses.'.$product->status) }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.created_date') }}</dt>
                                <dd class="col-sm-8">{{ $product->created_at->diffForHumans() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
