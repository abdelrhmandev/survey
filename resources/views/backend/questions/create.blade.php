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
                                <input placeholder="Example : Which country is hosting the 1998 World Cup" type="text"
                                    id="title_" name="title" class="form-control mb-2" required
                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'title' . '&nbsp;']) }}" />
                            </div>

                            <div class="fs-3 fw-bold mb-n2">Question Answers</div>
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="fv-row fl">
                                    <label class="required form-label"
                                        for="answer{{ $i }}">{{ __('answer.title') }} {{ $i }}</label>
                                        <input type="text" id="answer{{ $i }}"
                                            name="answers[{{ $i }}]" class="form-control mb-5" required
                                            data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'answer']) }}"
                                         />
                                </div>
                            @endfor


                            <div class="fs-3 fw-bold mb-n2">Score and Time Duration</div>
                            <div class="d-flex flex-column flex-md-row gap-5">


                                <div class="fv-row fl flex-row-fluid">
                                    <label class="required form-label" for="score">Score</label>
                                    <input placeholder="Example 20" maxlength="3" type="text" id="score"
                                        name="score" class="form-control mb-2" required data-fv-numeric="true"
                                        type="textbox" data-fv-numeric___message="score must be a number"
                                        data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'score' . '&nbsp;']) }}" />
                                </div>

                                <div class="flex-row-fluid">
                                    <div class="fv-row fl flex-row-fluid">
                                        <label class="required form-label" for="time">Time</label>
                                        <input placeholder="Example 120" type="text" id="time" name="time"
                                            class="form-control mb-2" maxlength="3" required data-fv-numeric="true"
                                            type="textbox" data-fv-numeric___message="time must be a number"
                                            data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'time' . '&nbsp;']) }}" />
                                    </div>

                                    <div class="text-muted fs-7">by seconds</div>

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
