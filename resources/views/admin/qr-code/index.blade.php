@extends('admin.layouts.master')

@push('extra-css')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endpush

@section('scripts')
    <!-- include FilePond library -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <!-- include FilePond jQuery adapter -->
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <!-- Qr Code Module Js -->
    <script src="{{ asset('js/qrBuilder/index.js') }}"></script>
@endsection

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('qr_builder.qr_builder') }}</h1>
        </div>

        <div class="section-body">
        	<div class="row">
                <div class="col-12 col-md-7 col-lg-7">
                    <div class="card">
                        <form id="qrCodeFrom" action="{{ route('admin.qr-code.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-0">
                                    <label class="form-label">{{ __("qr_builder.qr_block_style") }}</label>
                                    <div class="row gutters-sm">
                                        <div class="col-4 col-sm-3">
                                          <label class="imagecheck mb-4">
                                            <input name="style" type="radio" value="square" class="imagecheck-input qr-input" {{ $restaurant->qrCode->style == "square" ? 'checked=""' : "" }}>
                                            <figure class="imagecheck-figure">
                                              <img src="{{ asset('images/qr/200-pixels.png') }}" alt="}" class="imagecheck-image">
                                            </figure>
                                          </label>
                                        </div>
                                        <div class="col-4 col-sm-3">
                                          <label class="imagecheck mb-4">
                                            <input name="style" type="radio" value="dot" class="imagecheck-input qr-input" {{ $restaurant->qrCode->style == "dot" ? 'checked=""' : "" }}>
                                            <figure class="imagecheck-figure">
                                              <img src="{{ asset('images/qr/dot.png') }}" alt="}" class="imagecheck-image">
                                            </figure>
                                          </label>
                                        </div>
                                        <div class="col-4 col-sm-3">
                                          <label class="imagecheck mb-4">
                                            <input name="style" type="radio" value="round" class="imagecheck-input qr-input" {{ $restaurant->qrCode->style == "round" ? 'checked=""' : "" }}>
                                            <figure class="imagecheck-figure">
                                              <img src="{{ asset('images/qr/round.png') }}" alt="}" class="imagecheck-image">
                                            </figure>
                                          </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form-label">{{ __("qr_builder.eye_style") }}</label>
                                    <div class="row gutters-sm">
                                        <div class="col-4 col-sm-3">
                                          <label class="imagecheck mb-4">
                                            <input name="eye_style" type="radio" value="square" class="imagecheck-input qr-input" {{ $restaurant->qrCode->eye_style == "square" ? 'checked=""' : "" }}>
                                            <figure class="imagecheck-figure">
                                              <img src="{{ asset('images/qr/200-pixels.png') }}" alt="}" class="imagecheck-image">
                                            </figure>
                                          </label>
                                        </div>
                                        <div class="col-4 col-sm-3">
                                          <label class="imagecheck mb-4">
                                            <input name="eye_style" type="radio" value="circle" class="imagecheck-input qr-input" {{ $restaurant->qrCode->eye_style == "circle" ? 'checked=""' : "" }}>
                                            <figure class="imagecheck-figure">
                                              <img src="{{ asset('images/qr/circle-eye.png') }}" alt="}" class="imagecheck-image">
                                            </figure>
                                          </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                          <label class="form-label">{{ __("qr_builder.color") }}</label>
                                          <div class="row gutters-xs">
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="0, 0, 0"  class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "0, 0, 0" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-black"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="255, 255, 255" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "255, 255, 255" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-white"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="205, 211, 216" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "205, 211, 216" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-secondary"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="255, 164, 38" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "255, 164, 38" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-warning"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="255, 193, 7" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "255, 193, 7" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-yellow"></span>
                                              </label>
                                            </div>
                                          </div>
                                          <div class="row gutters-xs">
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="71, 195, 99" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "71, 195, 99" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-success"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="103, 119, 239" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "103, 119, 239" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-primary"></span>
                                              </label>
                                            </div>

                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="58, 186, 244" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "58, 186, 244" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-info"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="232, 62, 140" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "232, 62, 140" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-pink"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="color" type="radio" value="252, 84, 75" class="colorinput-input qr-input" {{ $restaurant->qrCode->color == "252, 84, 75" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-danger"></span>
                                              </label>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <label class="form-label">{{ __("qr_builder.background_color") }}</label>
                                          <div class="row gutters-xs">
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="255, 255, 255" class="colorinput-input qr-input"  {{ $restaurant->qrCode->color == "252, 84, 75" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-white"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="0, 0, 0"  class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "0, 0, 0" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-black"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="205, 211, 216" class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "205, 211, 216" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-secondary"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="255, 164, 38" class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "255, 164, 38" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-warning"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="255, 193, 7" class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "255, 193, 7" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-yellow"></span>
                                              </label>
                                            </div>
                                          </div>
                                          <div class="row gutters-xs">
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="71, 195, 99" class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "71, 195, 99" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-success"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="103, 119, 239" class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "103, 119, 239" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-primary"></span>
                                              </label>
                                            </div>

                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="58, 186, 244" class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "58, 186, 244" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-info"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="232, 62, 140" class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "232, 62, 140" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-pink"></span>
                                              </label>
                                            </div>
                                            <div class="col-auto">
                                              <label class="colorinput">
                                                <input name="background_color" type="radio" value="252, 84, 75" class="colorinput-input qr-input"
                                                    {{ $restaurant->qrCode->background_color == "252, 84, 75" ? 'checked=""' : "" }}>
                                                <span class="colorinput-color bg-danger"></span>
                                              </label>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="seeAnotherField">{{ __("qr_builder.qr_code_mode") }}</label>
                                    <select class="form-control qr-input" id="seeAnotherField" name="mode">
                                          <option value="none">{{ __("qr_builder.none") }}</option>
                                          <option value="logo" {{ $restaurant->qrCode->mode == "logo" ? 'selected' : "" }}>{{ __("Logo") }}</option>
                                    </select>
                                </div>
                                <!-- Hidden fields -->
                                <div class="form-group" id="qrCodeLogoDiv">
                                    <label for="filepond">{{ __("qr_builder.logo") }}</label>
                                    <div class="row gutters-sm">
                                        <div class="col-6 col-sm-9">
                                            <input id="qrCodeLogo" type="file" class="my-pond" name="file"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Hidden fields -->
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary mr-1 " type="submit">{{ __('qr_builder.save_changes') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col">
                  <div class="card shadow-sm" id="qrPreview">
                    <div class="card-body m-0">
                        <img id="qrImage" width="100%" class="bd-placeholder-img card-img-top img-fluid" src="data:image/png;base64,
                                {!! $qrCode !!} ">
                    </div>
                      <div class="card-footer">
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="data:image/png;base64, {!! $qrCode !!}" class="btn btn-sm btn-outline-secondary" id="download" download>
                                    {{ __("levels.download") }}
                                </a>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
			</div>
        </div>
    </section>

@endsection
