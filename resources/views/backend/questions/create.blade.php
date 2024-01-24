@extends('backend.base.base')
@section('title', __($trans . '.plural') . ' - ' . __($trans . '.add'))
@section('breadcrumbs')
    <h1 class="d-flex align-items-center text-gray-900 fw-bold my-1 fs-3">{{ __($trans . '.plural') }}</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}"
                class="text-muted text-hover-primary">{{ __('site.home') }}</a></li>
        <li class="breadcrumb-item"><span class="bullet bg-gray-200 w-5px h-2px"></span></li>
        <li class="breadcrumb-item text-dark">{{ __($trans . '.add') }}</li>
    </ul>
@stop
@section('style')
    <link href="{{ asset('assets/backend/css/custom.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <form id="Add{{ $trans }}" data-route-url="{{ $storeRoute }}" class="form d-flex flex-column flex-lg-row"
            data-form-submit-error-message="{{ __('site.form_submit_error') }}"
            data-form-agree-label="{{ __('site.agree') }}" enctype="multipart/form-data">

            <div class="d-flex flex-column gap-3 gap-lg-7 w-100 mb-2 me-lg-5">
                <!--begin::General options-->

                <div class="card card-flush py-0">
                    <div class="card-body pt-5">
                        <div class="d-flex flex-column gap-5">

                            <div class="fv-row fl">
                                <label class="required form-label" for="game">{{ __('game.select') }}</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="{{ __('game.select') }}" name="game_id">
                                    <option value="">{{ __('game.select') }}</option>
                                    @foreach ($games as $game)
                                        <option value="{{ $game->id }}" {{ $game->id == $GameId ? 'selected' : '' }}>
                                            {{ $game->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="fv-row fl">
                                <label class="required form-label" for="title">{{ __('question.title') }}</label>
                                <input placeholder="{{ __('site.title') }}" type="text" id="title_" name="title"
                                    class="form-control mb-2" required
                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'title' . '&nbsp;']) }}" />
                            </div>

                            <div class="fs-3 fw-bold mb-n2">Question Answers Choices</div>

                            <div class="d-flex flex-column flex-md-row gap-5">


                                <div class="fv-row fl flex-row-fluid">
                                    <label class="required form-label" for="choice1">Choice 1</label>
                                    <input type="text" id="choice1" name="choices[1]" class="form-control mb-2"
                                        required
                                        data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'choice 1' . '&nbsp;']) }}" />
                                </div>

                                <div class="flex-row-fluid">
                                    <div class="fv-row fl flex-row-fluid">
                                        <label class="required form-label" for="choice2">Choice 2</label>
                                        <input type="text" id="choice2" name="choices[2]" class="form-control mb-2"
                                            required
                                            data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'choice 2' . '&nbsp;']) }}" />
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex flex-column flex-md-row gap-5">
                                <div class="fv-row fl flex-row-fluid">
                                    <label class="required form-label" for="choice3">Choice 3</label>
                                    <input type="text" id="choice3" name="choices[3]" class="form-control mb-2"
                                        required
                                        data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'choice 3' . '&nbsp;']) }}" />
                                </div>

                                <div class="flex-row-fluid">
                                    <div class="fv-row fl flex-row-fluid">
                                        <label class="required form-label" for="choice4">Choice 4</label>
                                        <input type="text" id="choice4" name="choices[4]" class="form-control mb-2"
                                            required
                                            data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'choice 4' . '&nbsp;']) }}" />
                                    </div>
                                </div>
                            </div>


                            <div class="fv-row mb-10">
                                <label class="fs-2 fw-semibold mb-2">Difficulty Level
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        title="Select a Difficulty type for this game question">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span></label>
                                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-5 g-9"
                                    data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                    <div class="col">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6"
                                            data-kt-button="true">
                                            <span
                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                <input class="form-check-input" type="radio" name="difficulty"
                                                    value="normal" checked="checked" />
                                            </span>
                                            <span class="ms-5">
                                                <span class="fs-4 fw-bold text-gray-800 d-block">Normal</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                            data-kt-button="true">
                                            <span
                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                <input class="form-check-input" type="radio" name="difficulty"
                                                    value="hard" />
                                            </span>
                                            <span class="ms-5">
                                                <span class="fs-4 fw-bold text-gray-800 d-block">Hard</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                            data-kt-button="true">
                                            <span
                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                <input class="form-check-input" type="radio" name="difficulty"
                                                    value="expert" />
                                            </span>
                                            <span class="ms-5">
                                                <span class="fs-4 fw-bold text-gray-800 d-block">Expert</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                            data-kt-button="true">
                                            <span
                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                <input class="form-check-input" type="radio" name="difficulty"
                                                    value="easy" />
                                            </span>
                                            <span class="ms-5">
                                                <span class="fs-4 fw-bold text-gray-800 d-block">Easy</span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                            data-kt-button="true">
                                            <span
                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                <input class="form-check-input" type="radio" name="difficulty"
                                                    value="medium" />
                                            </span>
                                            <span class="ms-5">
                                                <span class="fs-4 fw-bold text-gray-800 d-block">Medium</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="fs-3 fw-bold mb-n2">Score and Time Duration</div>
                            <div class="d-flex flex-column flex-md-row gap-5">


                                <div class="fv-row fl flex-row-fluid">
                                    <label class="required form-label" for="score">Score</label>
                                    <input type="text" id="score" name="score" class="form-control mb-2"
                                        required data-fv-numeric="true" type="textbox"
                                        data-fv-numeric___message="score must be a number"
                                        data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'score' . '&nbsp;']) }}" />
                                </div>

                                <div class="flex-row-fluid">
                                    <div class="fv-row fl flex-row-fluid">
                                        <label class="required form-label" for="time">Time</label>
                                        <input type="text" id="time" name="time" class="form-control mb-2"
                                            required data-fv-numeric="true" type="textbox"
                                            data-fv-numeric___message="time must be a number"
                                            data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'time' . '&nbsp;']) }}" />
                                    </div>

                                    <div class="text-muted fs-7">By Seconds</div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <x-backend.btns.button />
            </div>
        </form>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('assets/backend/js/custom/Tachyons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/es6-shim.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/backend/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom/handleQuestionSubmit.js') }}"></script>
    <script>
 

        ///////////////////////////////////
 


        KTUtil.onDOMContentLoaded(function() {
            handleQFunc('Add{{ $trans }}');          
        });
    </script>
@stop
