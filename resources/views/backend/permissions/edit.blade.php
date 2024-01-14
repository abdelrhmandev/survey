@extends('backend.base.base')
@section('title', __($trans . '.plural').' - '.__($trans .'.edit'))
@section('breadcrumbs')
<h1 class="d-flex align-items-center text-gray-900 fw-bold my-1 fs-3">{{ __($trans . '.plural') }}</h1>
<span class="h-20px border-gray-200 border-start mx-3"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">{{ __('site.home') }}</a></li>
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

            <input type="hidden" name="id" value="{{ $row->id}}" />                                                
            @method('PUT')
            
            <div class="d-flex flex-column gap-3 gap-lg-7 w-100 mb-2 me-lg-5">
                <div class="card card-flush py-0">
                    <div class="card-body pt-0">
                        <div class="d-flex flex-column gap-5 mt-2">                                            
                          <x-backend.langs.ulTabs/>
                            <div class="tab-content">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <div class="tab-pane fade {{ LaravelLocalization::getCurrentLocaleName() == $properties['name'] ? 'show active' : '' }}"
                                        id="{{ substr($properties['regional'], 0, 2) }}" role="tabpanel">
                                        <div class="d-flex flex-column gap-5">
                                            <div class="fv-row fl">
                                                <label class="required form-label"
                                                    for="title-{{ substr($properties['regional'], 0, 2) }}">{{ __('site.title') }}</label>
                                                <input placeholder="{{ __('site.title') . ' ' . $properties['name'] }}"
                                                    type="text" id="title_{{ substr($properties['regional'], 0, 2) }}"
                                                    name="title_{{ substr($properties['regional'], 0, 2) }}"
                                                    class="form-control mb-2" required
                                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'title' . '&nbsp;' . substr($properties['regional'], 0, 2)]) }}"
                                                    value="@foreach (json_decode($row->trans, true) as $per){{ isset($per[substr($properties['regional'], 0, 2)]) ? $per[substr($properties['regional'], 0, 2)] : '' }}@endforeach" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="fv-row fl">
                                <label class="required form-label" for="name">{{ __('site.name')}}</label>
                                <input type="text" id="name" name="name" class="form-control mb-2" placeholder="Example posts-create" required
                                    data-fv-not-empty___message="{{ __('validation.required', ['attribute' => 'name' . '&nbsp;']) }}"
                                    value="{{ $row->name }}" />
                                    <small class="fs-7 fw-semibold text-danger">English Only No Spaces</small>
                            </div>
                        </div>
                    </div>

                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('permission.associated_roles')}} [{{  $row->roles->count() }}]</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">      
                                <div class="row row-cols-1 row-cols-md-0 row-cols-lg-1 row-cols-xl-5 g-2" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">

                                


                                @forelse($row->roles as $role)

                                    @foreach (json_decode($role->trans,true) as $rol)

                                    @if(isset($rol[app()->getLocale()]))
                                    <div class="badge py-3 px-4 fs-7 badge-light-primary">
                                        <span class="text-primary">{{ $rol[app()->getLocale()] }}</span>
                                    </div>
                                    <br>
                                    @endif		

                                    @endforeach
                                    @empty
                                    <span class="text-danger">{{ __('permission.no_associated_role') }} </span>
                                    @endforelse

                                    
                                </div>       
                        </div>
                    </div>

                  
                    
                </div>
                <x-backend.btns.button :destroyRoute="$destroyRoute" :redirectRoute="$redirect_after_destroy" :row="$row" :trans="$trans" />
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
