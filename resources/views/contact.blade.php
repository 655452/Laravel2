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
                    <div class="col-md-6">
                        <h3>{{ __('Contact') }} </h3>
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {!! Form::open(['route'=>'contact.store']) !!}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('Name') !!}<span><span class="text-danger">*</span>
                            {!! Form::text('name', old('name'), ['class'=>'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'placeholder'=>'Enter  Name']) !!}
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            {!! Form::label('Email') !!}<span><span class="text-danger">*</span>
                            {!! Form::text('email', old('email'), ['class'=>'form-control'.($errors->has('email') ? ' is-invalid' : ''), 'placeholder'=>'Enter Email']) !!}
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            {!! Form::label('Message') !!}<span><span class="text-danger">*</span>
                            {!! Form::textarea('message', old('message'), ['class'=>'form-control'.($errors->has('message') ? ' is-invalid' : ''), 'placeholder'=>'Enter Message']) !!}
                            <span class="text-danger">{{ $errors->first('message') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">{{ __('Contact US!') }}</button>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </article>
        </div>
    </section>

@endsection
