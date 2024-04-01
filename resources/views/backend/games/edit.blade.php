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
                <!--begin::General options-->

                <div class="card card-flush py-0">
                    <div class="card-body pt-5">


                        <div class="d-flex flex-column gap-5">
                            <div class="card card-custom">
                                <div class="card-header border-0 bg-primary">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="ki-outline ki-calendar fs-2x text-white"></i>
                                        </span>
                                        <span class="text-white">
                                            Event Information
                                        </span>
                                    </div>
                                </div>
                                <div class="separator separator-solid separator-white opacity-20"></div>
                                <div class="card-body text-white">
                                    <div class="d-flex flex-column gap-5">
                                        <div class="fv-row fl">
                                            <label class="required form-label"
                                                for="event_title">{{ __('event.title') }}</label>
                                            <input placeholder="{{ __('event.title') }}" type="text" id="event_title"
                                                value="{{ $row->event_title }}" name="event_title"
                                                class="form-control mb-2" required
                                                data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'Event Title' . '&nbsp;']) }}" />
                                        </div>

                                        <div class="d-flex flex-column">
                                            <label class="form-label"
                                                for="event_location">{{ __('event.location') }}</label>
                                            <textarea class="form-control form-control-solid" rows="4" id="event_location" name="event_location">{{ $row->event_location }}</textarea>
                                        </div>
                                        <div class="fv-row fl">
                                            <label class="required form-label"
                                                for="event_date_range">{{ __('event.date_range') }}</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <i class="ki-outline ki-calendar-8 fs-2 position-absolute mx-4"></i>
                                                <input placeholder="{{ __('event.date_range') }}" type="text"
                                                    id="event_date_range" name="event_date_range"
                                                    class="form-control form-control-solid ps-12 flatpickr-input active"
                                                    readonly="readonly" required
                                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'event date range' . '&nbsp;']) }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="d-flex flex-column gap-5">
                            <div class="card card-custom">
                                <div class="card-header border-0 bg-primary">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="ki-outline ki-joystick fs-2x text-white"></i>
                                        </span>
                                        <span class="text-white">
                                            Game Information
                                        </span>
                                    </div>

                                </div>
                                <div class="separator separator-solid separator-white opacity-20"></div>
                                <div class="card-body text-white">

                                    <div class="d-flex flex-column gap-5">
                                        <div class="fv-row fl">
                                            <label class="required form-label"
                                                for="title">{{ __('site.title') }}</label>
                                            <input placeholder="{{ __('site.title') }}" type="text" id="title"
                                                value="{{ $row->title }}" name="title" class="form-control mb-2"
                                                required
                                                data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'title' . '&nbsp;']) }}" />
                                        </div>


                                        <div class="d-flex flex-column">
                                            <label class="form-label" for="description-en">Description</label>
                                            <textarea class="form-control form-control-solid" rows="4" id="description" name="description">{{ $row->description }}</textarea>
                                        </div>


                                        <div class="fv-row fl">
                                            <label class="form-label" for="color">Color Picker</label>
                                            <input placeholder="{{ __('site.color') }}" type="color" id="color"
                                                name="color" value="{{ $row->color ? $row->color : '#e86824' }}"
                                                class="form-control mb-2" readonly />
                                        </div>


                                        <div class="fv-row fl">
                                            <label class="required form-label"
                                                for="attendees">{{ __('game.attendees') }}</label>
                                            <input placeholder="{{ __('game.attendees') }}" id="attendees"
                                                value="{{ $row->attendees }}" name="attendees" class="form-control mb-2"
                                                required data-fv-numeric="true" type="textbox"
                                                data-fv-numeric___message="attendees must be a number"
                                                data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'attendees' . '&nbsp;']) }}" />
                                        </div>



                                        <div class="fv-row fl">
                                            <label class="required form-label"
                                                for="type">{{ __('type.select') }}</label>
                                            <select class="form-select form-select-solid" data-control="select2"
                                                data-hide-search="false" data-placeholder="{{ __('type.select') }}"
                                                name="type_id">
                                                <option value="">{{ __('type.select') }}</option>
                                                @foreach ($types as $type)
                                                    <<option value="{{ $type->id }}"
                                                        {{ $type->id == $row->type_id ? 'selected' : '' }}>
                                                        {{ $type->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div
                                            class="d-flex flex-column fv-row rounded-3 p-7 border border-dashed border-gray-300">
                                            <div class="fs-5 fw-bold form-label mb-3">Play With Team</div>
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" name="play_with_team" id="play_with_team"
                                                    type="checkbox" value="1"
                                                    {{ $row->play_with_team == '1' ? 'checked' : '' }} />
                                                <span class="form-check-label text-gray-600">Allow Play With Team , must
                                                    set the number of teams player</span>
                                            </label>
                                        </div>




                                        <div class="fv-row fl" id="team_playersDiv">
                                            <label class="required form-label"
                                                for="team_players">{{ __('game.team_players') }}</label>
                                            <input type="textbox" placeholder="{{ __('game.team_players') }}"
                                                id="team_players" value="{{ $row->team_players }}" name="team_players"
                                                class="form-control mb-2" />
                                        </div>





                                    </div>




                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-5">
                            <div class="card card-custom">
                                <div class="card-header border-0 bg-primary">
                                    <div class="card-title">
                                        <span class="card-icon">
                                            <i class="ki-outline ki-message-question fs-2x text-white"></i>
                                        </span>
                                        <span class="text-white">
                                            Question Information
                                        </h3>
                                    </div>
                                </div>
                                <div class="separator separator-solid separator-white opacity-20"></div>
                                <div class="card-body text-white">
                                    <div class="d-flex flex-column gap-5">



                                        <div class="fv-row fl">
                                            <input type="hidden" name="brand_id" value="{{ $row->brand_id}}">
                                            <label class="form-label" for="brand">{{ __('brand.singular') }}</label>
                                            <div class="text-success">{{ $row->brand->title }}                                                
                                            </div>
                                        </div>


                                        <div class="fv-row fl">
                                            <label class="required form-label" for="group">{{ __('group.select') }}</label>
                                            <div class="row mb-8">
                                                <div class="col-xl-12">
                                                    <div class="row g-12" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                                
                                                        @forelse ($groups as $group)
                                                            <div class="col-md-4 col-lg-12 col-xxl-4"> 
                                                                <label
                                                                    class="btn btn-outline btn-outline-dashed btn-{{ $group->id == $row->group_id ? 'active' : '' }}-light-primary {{ $group->id == $row->group_id ? 'active' : '' }} d-flex text-start p-6"
                                                                    data-kt-button="true">
                                                                    <span
                                                                        class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                        <input class="form-check-input" type="radio" name="group_id" value="{{ $group->id}}"
                                                                        {{ $group->id == $row->group_id ? 'checked' : '' }}/>
                                                                    </span>
                                                                    <span class="ms-5">
                                                                        <span class="fs-4 fw-bold mb-1 d-block text-dark">{{ $group->title }}</span>
                                                                        <span class="fw-semibold fs-7 text-gray-600">Questions ({{ $group->questions_count }}) </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @empty
                                                        <div class="col-md-4 col-lg-12 col-xxl-4">       
                                                        no groups
                                                        </div>
                                                        @endforelse
                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                         
                                    </div>
                                </div>
                            </div>
                        </div>

 
                    </div>
                </div>
                <x-backend.btns.button :destroyRoute="$destroyRoute" :redirectRoute="$redirect_after_destroy" :row="$row" :trans="$trans" />
            </div>
            <div class="d-flex flex-column flex-row-fluid gap-0 w-lg-400px gap-lg-5">
                <x-backend.cms.image :image="$row->image" />
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
        var checks = document.querySelectorAll(".check");
        var max = 10;
        for (var i = 0; i < checks.length; i++)
            checks[i].onclick = selectiveCheck;

 
        var event_start_date = '{{ $row->event_start_date }}';
        var event_end_date = '{{ $row->event_end_date }}';
        $('#event_date_range').daterangepicker({
            drops: 'up',
            minDate: new Date(),
            separator: " - ",
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: event_start_date,
            endDate: event_end_date
        });

        var play_with_team = '{{ $row->play_with_team }}';
        if (play_with_team == '1') {
            $('#team_playersDiv').show();
        } else {
            $('#team_playersDiv').hide();
        }

        $('input[type="checkbox"]').on('change', function() {
            if ($("#play_with_team").is(':checked')) {
                $("#team_playersDiv").show(); // checked
            } else {
                $('#team_playersDiv').hide();
            }
        });

        KTUtil.onDOMContentLoaded(function() {
            handleFormSubmitFunc('Edit{{ $trans }}');
        });
    </script>
@stop
