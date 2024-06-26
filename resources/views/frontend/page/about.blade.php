@extends('frontend.layouts.app')

@section('main-content')
    <section class="terms">
        <div class="container">
            <h3> {{ $page->title }} </h3>

            <article>
                {!! $page->description !!}
            </article>
        </div>
    </section>
@endsection
