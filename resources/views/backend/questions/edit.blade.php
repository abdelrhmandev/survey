@extends('backend.base.base')
@section('title', __($trans . '.plural') . ' - ' . __($trans . '.edit'))
@section('breadcrumbs')
    <h1 class="d-flex align-items-center text-gray-900 fw-bold my-1 fs-3">{{ __($trans . '.plural') }}</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}"
                class="text-muted text-hover-primary">{{ __('site.home') }}</a></li>
        <li class="breadcrumb-item"><span class="bullet bg-gray-200 w-5px h-2px"></span></li>
        <li class="breadcrumb-item text-dark">{{ __($trans . '.edit') }}</li>
    </ul>
@stop
@section('style')
    <link href="{{ asset('assets/backend/css/custom.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <form id="Edit{{ $trans }}" data-route-url="{{ $updateRoute }}" class="form d-flex flex-column flex-lg-row"
            data-form-submit-error-message="{{ __('site.form_submit_error') }}"
            data-form-agree-label="{{ __('site.agree') }}" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{ $row->id }}" />
            @method('PUT')

            <div class="d-flex flex-column gap-3 gap-lg-7 w-100 mb-2 me-lg-5">

                <div class="card card-flush py-0">
                    <div class="card-body pt-5">
                        <div class="d-flex flex-column gap-5">

                            <div class="fv-row fl">
                                <label class="required form-label" for="game">{{ __('game.select') }}</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="{{ __('game.select') }}" name="game_id">
                                    <option value="">{{ __('game.select') }}</option>
                                    @foreach ($games as $game)
                                        <option value="{{ $game->id }}"
                                            {{ $game->id == $row->game_id ? 'selected' : '' }}>
                                            {{ $game->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="fv-row fl">
                                <label class="required form-label" for="title">{{ __('question.title') }}</label>
                                <input placeholder="Example : Which country is hosting the 1998 World Cup" type="text"
                                    id="title" value="{{ $row->title }}" name="title" class="form-control mb-2"
                                    required
                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'title' . '&nbsp;']) }}" />
                            </div>

                            
                            <div class="fs-3 fw-bold mb-n2">Question Answers</div>

                            @if(!(isset($row->correctAnswer->correct_answer_id)))
                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                        <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                        <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-grow-1">
                                    <!--begin::Content-->
                                    <div class="fw-semibold">
                                        <h4 class="text-gray-900 fw-bold">You need to choose Correct Question Answer!</h4>                                         
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            @endif

                            @foreach ($row->answers as $answer)
                                {{ __('answer.singular') }} {{ $loop->index + 1 }}
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <label class="form-check form-check-custom form-check-solid me-1">
                                            <input class="form-check-input sm" id="CorrectAnswer{{ $answer->id }}" value="{{ $answer->id }}" type="radio"
                                                name="correct_answer_check" {{ isset($row->correctAnswer->correct_answer_id) && $answer->id == $row->correctAnswer->correct_answer_id   ? 'checked=checked' : '' }}>
                                        </label>
                                    </span>
                                    <input type="text" value="{{ $answer->title }}" id="answerText{{ $answer->id }}"
                                        name="answers[{{ $answer->id }}]" class="form-control mb"/>

                                </div>
                            @endforeach
                            


                            <div class="fs-3 fw-bold mb-n2">Score and Time Duration</div>
                            <div class="d-flex flex-column flex-md-row gap-5">


                                <div class="fv-row fl flex-row-fluid">
                                    <label class="required form-label" for="score">Score</label>
                                    <input placeholder="Example 20" maxlength="3" type="text" id="score"
                                        name="score" value="{{ $row->score }}" class="form-control mb-2" required
                                        data-fv-numeric="true" type="textbox"
                                        data-fv-numeric___message="score must be a number"
                                        data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'score' . '&nbsp;']) }}" />
                                </div>

                                <div class="flex-row-fluid">
                                    <div class="fv-row fl flex-row-fluid">
                                        <label class="required form-label" for="time">Time</label>
                                        <input placeholder="Example 120" value="{{ $row->time }}" type="text"
                                            id="time" name="time" class="form-control mb-2" maxlength="3" required
                                            data-fv-numeric="true" type="textbox"
                                            data-fv-numeric___message="time must be a number"
                                            data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'time' . '&nbsp;']) }}" />
                                    </div>

                                    <div class="text-muted fs-7">by seconds</div>

                                </div>
                            </div>  

                        </div>
                    </div>
                </div>
                <x-backend.btns.button :destroyRoute="$destroyRoute" :redirectRoute="$redirect_after_destroy" :row="$row" :trans="$trans"/>
            </div>
        </form>
    </div>
@stop
@section('scripts')
<script src="{{ asset('assets/backend/js/custom/Tachyons.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/custom/es6-shim.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/backend/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/backend/js/custom/handleFormSubmit.js') }}"></script>
<script src="{{ asset('assets/backend/js/custom/deleteConfirmSwal.js') }}"></script>
<script>
    KTUtil.onDOMContentLoaded(function() {
        handleFormSubmitFunc('Edit{{ $trans }}');
    });
</script>
@stop
