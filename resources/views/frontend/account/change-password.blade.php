@extends('frontend.layouts.app')

@section('main-content')
    <!--======== SETTINGS PART START =======-->
    <section class="settings">
        <div class="container">
            <div class="row">

                @include('frontend.account.partials._sidebar')

                <div class="col-12 col-lg-8 col-xl-9">
                    <h3 class="settings-title">{{ __('frontend.change_password') }} </h3>
                    <fieldset class="form-fieldset">
                        <form method="post" class="row" action="{{ route('account.password.update') }}">
                            @csrf
                            @method('put')

                            <div class="col-12 form-group">
                                <label for="old_password" class="form-label required">{{ __('frontend.old_password') }}
                                </label>
                                <input id="old_password" name="old_password" type="password"
                                    class="form-control @error('old_password') is-invalid @enderror">
                                @error('old_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="password" class="form-label required">{{ __('frontend.password') }} </label>
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" />
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="password_confirmation"
                                    class="form-label required">{{ __('frontend.password_confirmation') }} </label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror" />
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <button class="form-btn-inline" type="submit"> {{ __('frontend.update_password') }}
                                </button>
                            </div>
                        </form>
                    </fieldset>
                </div>

            </div>
        </div>
    </section>
    <!--======= SETTINGS PART END ====-->
@endsection
