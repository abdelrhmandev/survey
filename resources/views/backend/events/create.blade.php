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
                                <label class="required form-label" for="title">{{ __('site.title') }}</label>
                                <input placeholder="{{ __('site.title') }}" type="text" id="title_" name="title"
                                    class="form-control mb-2" required
                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'title' . '&nbsp;']) }}" />
                            </div>

                            <div class="d-flex flex-column">
                                <label class="form-label" for="description-en">Description</label>
                                <textarea class="form-control form-control-solid" rows="4" id="description" name="description"></textarea>
                            </div>

                            <div class="fv-row fl">
                                <label class="required form-label"
                                    for="event_date_range">{{ __('event.date_range') }}</label>
                                <div class="position-relative d-flex align-items-center">
                                    <i class="ki-outline ki-calendar-8 fs-2 position-absolute mx-4"></i>
                                    <input placeholder="{{ __('event.date_range') }}" type="text" id="event_date_range"
                                        name="event_date_range"
                                        class="form-control form-control-solid ps-12 flatpickr-input active"
                                        readonly="readonly" required
                                        data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'event date range' . '&nbsp;']) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-backend.btns.button />
            </div>
            <div class="d-flex flex-column flex-row-fluid gap-0 w-lg-400px gap-lg-5">
                <x-backend.cms.image />
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
    

    <script>
        $("#event_date_range").daterangepicker({
            drops: 'up',
            minDate:new Date(),
            separator: " - ",
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        KTUtil.onDOMContentLoaded(function() {
            handleFormSubmitFunc('Add{{ $trans }}');
        });
    </script>
@stop
