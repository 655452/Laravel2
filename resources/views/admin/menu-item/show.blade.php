@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('restaurant.menu_item') }}</h1>
            {{ Breadcrumbs::render('menu-items/view') }}
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card profile-widget mt-0">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item profile-widget-item-header">
                                <strong>{{ $menuItem->name }}</strong>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.description') }}</dt>
                                <dd class="col-sm-8">{{ strip_tags($menuItem->description) }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.status') }}</dt>
                                <dd class="col-sm-8">{{ trans('statuses.'.$menuItem->status) }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('levels.created_date') }}</dt>
                                <dd class="col-sm-8">{{ $menuItem->created_at->diffForHumans() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
  
                @if(!blank($menuItem->image))
                    <div class="col-lg-4">
                        <div class="card p-1">
                            <img class="d-block w-100 h-232" src="{{ $menuItem->image }}">
                        </div>  
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
