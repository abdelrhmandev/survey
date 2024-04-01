@extends('backend.base.base')
@section('title', __($trans . '.plural') . ' - ' . __($trans . '.edit'))
@section('breadcrumbs')
    <h1 class="d-flex align-items-center text-gray-900 fw-bold my-1 fs-3">{{ __($trans . '.plural') }}</h1>
    <span class="h-20px border-gray-200 border-start mx-3"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
        <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}"
                class="text-muted text-hover-primary">{{ __('site.home') }}</a></li>
        <li class="breadcrumb-item"><span class="bullet bg-gray-200 w-5px h-2px"></span></li>
        <li class="breadcrumb-item text-dark">Game Questions Reordering</li>
    </ul>
@stop
@section('style')
    <link href="{{ asset('assets/backend/css/custom.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="col-xl-12 mb-5 mb-xl-10">
      <!--begin::Tables widget 16-->
      <div class="card card-flush h-xl-100">
        <!--begin::Header-->
        <div class="card-header pt-5">
          <!--begin::Title-->
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">Questions ({{  $GroupQuestions->count() }})</span>
          </h3>
       
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-6">
          <!--begin::Nav-->
         
          <!--end::Nav-->
          <!--begin::Tab Content-->
          <div class="tab-content">
            <!--begin::Tap pane-->
            <div class="tab-pane fade show active" id="kt_stats_widget_16_tab_1">
              <!--begin::Table container-->
              <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                  <!--begin::Table head-->
                  <thead>
                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                      <th class="p-0 pb-3 w-125px pe-7">Reorder</th>
                      <th class="p-0 pb-3 min-w-150px text-start">Question</th>
                      <th class="p-0 pb-3 min-w-100px text-end pe-13">Time (by seconds)</th>
                    </tr>
                  </thead>
                
                  <tbody id="tablecontents" class="fw-bold">
                    @foreach ($GroupQuestions as $GroupQuestion)
                    <tr class="row1" data-id="{{ $GroupQuestion->id }}">  
                      <td><a class="btn btn-default" href="#" title="{{ trans('site.reorder') }}" style="padding: 1px 7px;"><i style="color:rgb(27, 173, 125) !important" class="fa fa-ellipsis-v"></i> <i style="color:rgb(27, 173, 125) !important" class="fa fa-ellipsis-v"></i></a></td>
                      <td>{{ $GroupQuestion->question->title }}</td>
                      <td class="text-end pe-13"><span class="text-gray-600 fw-bold fs-6">
                        {{ $GroupQuestion->question->time }}
                      </span></td>
                    </tr>
                    @endforeach   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!--end::Tab Content-->
        </div>
        <!--end: Card Body-->
      </div>
      <!--end::Tables widget 16-->
    </div>
  
 
 
</div>
    
@stop
@section('scripts')
<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script src="{{ asset('assets/backend/js/custom/Tachyons.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/custom/es6-shim.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/backend/js/widgets.bundle.js') }}"></script>



<script type="text/javascript">
    $(function () {  
      $("#tablecontents").sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6,
        update: function() {
            sendReorderLisingsToServer();
        }
      });
  
      function sendReorderLisingsToServer() {
  
        var order = [];
        $('tr.row1').each(function(index,element) {
          order.push({
            id: $(this).attr('data-id'),                   
            position: index + 1
          });
        });
  
        $.ajax({
          type: "POST", 
          dataType: "json", 
          url: "{!! route('admin.ReorderLisings') !!}",
           data: {
               order:order,
               table_name: 'group_question', 
               _token: '{{csrf_token()}}'
              }, 
              success: function(data) {
                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-center",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
              };
              toastr.success(data['msg']);
              return false;
              }
        });
       $("#reorder").removeClass('hidden');
      }
    });
  
  </script>
 
@stop
