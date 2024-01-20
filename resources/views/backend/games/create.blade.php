@extends('backend.base.base')
@section('title', __($trans . '.plural').' - '.__($trans .'.add'))
@section('breadcrumbs')
<h1 class="d-flex align-items-center text-gray-900 fw-bold my-1 fs-3">{{ __($trans . '.plural') }}</h1>
<span class="h-20px border-gray-200 border-start mx-3"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">{{ __('site.home') }}</a></li>
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
            data-form-submit-error-message="{{ __('site.form_submit_error')}}"
            data-form-agree-label="{{ __('site.agree') }}" 
            enctype="multipart/form-data">   
            
            <div class="d-flex flex-column gap-3 gap-lg-7 w-100 mb-2 me-lg-5">
                <!--begin::General options-->
                
                <div class="card card-flush py-0">
                    <div class="card-body pt-5">                        
                        <div class="d-flex flex-column gap-5">
                            <div class="fv-row fl">
                                <label class="required form-label"
                                    for="title">{{ __('site.title') }}</label>
                                <input placeholder="{{ __('site.title') }}" type="text" id="title_"
                                    name="title" class="form-control mb-2" required
                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'title' . '&nbsp;']) }}"
                                    />
                            </div>

                            <div class="d-flex flex-column">
                                <label class="form-label" for="description-en">Description</label>
                                <textarea  class="form-control form-control-solid" rows="4" id="description"
                                    name="description"></textarea>
                            </div>

                            <div class="fv-row fl">
                                <label class="required form-label"
                                    for="event">{{ __('event.select') }}</label>
                                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                    data-placeholder="{{ __('event.select') }}" name="event_id">
                                    <option value="">{{ __('event.select') }}</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                                    @endforeach
                                  </select>                              
                                  <div class="text-muted fs-7">upcoming events only</div>                                    
                            </div>


                            <div class="fv-row fl">
                                <label class="required form-label"
                                    for="attendees">{{ __('game.attendees') }}</label>
                                <input placeholder="{{ __('game.attendees') }}" id="attendees"
                                    name="attendees" class="form-control mb-2" required
                                    data-fv-numeric="true"
                                    type="textbox" 
                                    data-fv-numeric___message="attendees must be a number"
                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'attendees' . '&nbsp;']) }}"
                                    />
                            </div>


                            <div class="fv-row fl">
                                <label class="required form-label"
                                    for="type">{{ __('type.select') }}</label>
                                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                    data-placeholder="{{ __('type.select') }}" name="type_id">
                                    <option value="">{{ __('type.select') }}</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                                    @endforeach
                                  </select>                                
                            </div>
                            
                            <div class="d-flex flex-column fv-row rounded-3 p-7 border border-dashed border-gray-300">
                                <div class="fs-5 fw-bold form-label mb-3">Play With Team</div>
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" name="play_with_team" id="play_with_team" type="checkbox" value="1" />
                                    <span class="form-check-label text-gray-600">Allow Play With Team , must set the number of teams player</span>
                                </label>
                            </div>

                            

                            <div class="fv-row fl" id="team_playersDiv">
                                <label class="required form-label"
                                    for="team_players">{{ __('game.team_players') }}</label>
                                <input type="textbox" placeholder="{{ __('game.team_players') }}" 
                                    id="team_players"
                                    name="team_players" class="form-control mb-2" 
                                    />
                            </div>
                        </div>
                    </div>
                </div>
                <x-backend.btns.button />
            </div>            
            <div class="d-flex flex-column flex-row-fluid gap-0 w-lg-400px gap-lg-5">                                 
                <x-backend.cms.image/>  
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


$('#team_playersDiv').hide();
$('input[type="checkbox"]').on('change', function() {
if($("#play_with_team").is(':checked')){
    $("#team_playersDiv").show();  // checked
}else{
    $('#team_playersDiv').hide();
}
});

///////////////////////////////////
document.addEventListener('DOMContentLoaded', function (e) {

    
    FormValidation.formValidation(document.getElementById('AddGame'), {
        fields: {
            team_players: {
                validators: {
                    callback: {
                        message: 'ssssss answer',
                        callback: function (input) {
                            return input.value;
                        },
                    },
                },
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap(),
            submitButton: new FormValidation.plugins.SubmitButton(),
            icon: new FormValidation.plugins.Icon({
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh',
            }),
        },
    });
});
//////////////////////////////////////


KTUtil.onDOMContentLoaded(function() {
   handleFormSubmitFunc('Add{{ $trans }}');
});
</script>
@stop