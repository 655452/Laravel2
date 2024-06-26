@extends('admin.layouts.master')

@section('main-content')
	<section class="section">
        <div class="section-header">
            <h1>{{ __('withdraw.withdraw') }}</h1>
            {{ Breadcrumbs::render('withdraw/edit') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-6 col-lg-6">
				    <div class="card">
				    	<form action="{{ route('admin.withdraw.update', $withdraw) }}" method="POST">
				    		@csrf
				    		@method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('levels.user') }}</label> <span class="text-danger">*</span>
                                    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                        <option value="">{{ __('levels.select_user') }}</option>
                                        @if(!blank($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ (old('user_id',$withdraw->user_id) == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('levels.date') }}</label>
                                    <input type="text" name="date" class="form-control @error('date') is-invalid @enderror datepicker" value="{{ old('date',\Carbon\Carbon::parse($withdraw->date)->format('d-m-yy')) }}">
                                    @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('levels.amount') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount',$withdraw->amount) }}">
                                    @error('amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

					        <div class="card-footer">
		                    	<button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
		                  	</div>
		                </form>
					</div>
				</div>
			</div>
        </div>
    </section>

@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">

@endsection
@section('scripts')
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ asset('js/withdraw/create.js') }}"></script>
@endsection
