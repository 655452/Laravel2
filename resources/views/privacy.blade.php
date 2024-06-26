@extends('layouts.app')

@section('search')
    <div class="col-lg-6 col-12 col-sm-12">
        <x-search-params/>
    </div>
@endsection

@section('main-content')
    <!-- ========================= SECTION FEATURE ========================= -->
    <section class="section-content padding-y-sm">
        <div class="container">
            <article>
                <div class="row">
                    <div class="col">
                        <h3>{{ __('Privacy') }}</h3>
                        <p class="text-body">
                            {{ setting('privacy') }}
                        </p>
                    </div>
                </div>
            </article>
        </div>
    </section>

@endsection
