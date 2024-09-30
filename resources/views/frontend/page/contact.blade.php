@extends('frontend.layouts.app')


@section('main-content')
    <section class="contact ">
        <!-- <div class="container">
            <div class="row">
                <div class="col-md-6 pr-5">
                    <h2> {{ __('frontend.contact_us') }} </h2>
                    <p class="pt-2"> {{ __('frontend.our_team_love_top_hear_form_you') }}</p>

                    {!! $page->description !!}
                </div>
                <div class="col-md-6 pl-5">
                    <div class="auth-content p-3">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        {!! Form::open(['route' => 'contact.store']) !!}
                        <div class="form-group mb-1 {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="form-label required">{!! Form::label(trans('frontend.name')) !!} </label>
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                                'placeholder' => trans('frontend.name'),
                            ]) !!}
                            <span class="text-danger fs-12">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group mb-1 {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="form-label required">{!! Form::label(trans('frontend.email')) !!} </label>
                            {!! Form::text('email', old('email'), [
                                'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                                'placeholder' => trans('frontend.email'),
                            ]) !!}
                            <span class="text-danger fs-12"> {{ $errors->first('email') }}</span>
                        </div>

                        <div class="form-group mb-1 {{ $errors->has('subject') ? 'has-error' : '' }}">
                            <label class="form-label required">{!! Form::label(trans('frontend.subject')) !!} </label>
                            {!! Form::text('subject', old('subject'), [
                                'class' => 'form-control' . ($errors->has('subject') ? ' is-invalid' : ''),
                                'placeholder' => trans('frontend.subject'),
                            ]) !!}
                            <span class="text-danger fs-12">{{ $errors->first('subject') }}</span>
                        </div>

                        <div class="form-group mb-1 {{ $errors->has('message') ? 'has-error' : '' }}">
                            <label class="form-label required"> {!! Form::label(trans('frontend.message')) !!}</label>
                            {!! Form::textarea('message', old('message'), [
                                'class' => 'form-control' . ($errors->has('message') ? ' is-invalid' : ''),
                                'placeholder' => trans('frontend.message'),
                            ]) !!}
                            <span class="text-danger fs-12"> {{ $errors->first('message') }}</span>
                        </div>

                        <div class="form-group">
                            <button class=" form-btn">{{ __('frontend.submit') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div> -->
        
        <center style="display: flex;justify-content:center;height:50vh; align-items:center;flex-direction:column;">
        <h3>
        Email - 
<a href="#" style="color: gray;">
support@woich.in</a>
        </h3>
<h3>
Call us -<a style="color: gray;" href="#"> 9833891281</a></h3>

        </center>
    </section>
@endsection


