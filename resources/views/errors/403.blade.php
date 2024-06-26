@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                            	<div class="col-sm-12 text-center text-danger">
	                            	<h2>{{__('403')}}</h2>
	                            	<h5>{{__('User does not have the right permissions.')}}</h5>
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
