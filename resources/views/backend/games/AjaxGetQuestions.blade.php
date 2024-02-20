<div class="card card-flush h-xl-100">
    <div class="card-header pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Questions</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-6">Total {{ $questions->count() }} Questions in the
                brand</span>
        </h3>
    </div>
    <div class="card-body">

        @if ($questions->count())
        <span class="text-success">Max Selection Questions is 10</span>

        <table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_5_table">
                <!--begin::Table head-->
                <thead>
                  
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-4">Select</th>
                        <th class="w-400px">Question</th>                      
                        <th>Time (by seconds)</th>
                    </tr>
                  
                </thead>
           
                <tbody class="fw-bold text-gray-600">
                    @foreach ($questions as $question)
                    <tr>                        
                        <td>
                            <div class="form-check form-check-solid form-check-custom form-switch">
                                <input class="form-check-input w-30px h-20px check" type="checkbox" name="question_id[]"
                                    id="question{{ $question->id }}">
                                <label class="form-check-label" for="question{{ $question->id }}"></label>
                            </div>
                        </td>                      
                        <td class="text">{{  $question->title }}</td>
                        <td class="text-center">
                            <span class="text-gray-900 fw-bold">{{ $question->time }}</span>
                        </td>                      
                    </tr>
                    @endforeach

                </tbody>
             
            </table>
            
        @else
            <span class="text-danger">No Questions Founds</span>
        @endif
    </div>
</div>
<script>
    var checks = document.querySelectorAll(".check");
    var max = 10;
    for (var i = 0; i < checks.length; i++)
        checks[i].onclick = selectiveCheck;

    function selectiveCheck(event) {
        var checkedChecks = document.querySelectorAll(".check:checked");
        if (checkedChecks.length >= max + 1){
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
            toastr.error('Max Selection Questions is '+max);
            return false;
        }
    }
</script>