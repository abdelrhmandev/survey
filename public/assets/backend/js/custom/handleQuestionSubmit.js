function handleQFunc(formId) {
 
    // Define all elements for quill editor
    // Submit form handler
    let validator;
    let parentId;
    let icon;
    let keys;
    // Get elements
    const form = document.getElementById(formId);
    const submitButton = document.getElementById('btn-submit');
    // Init form validation rules. For more info check the FormValidation plugin's official
    documentation: https: //formvalidation.io/

        validator = FormValidation.formValidation(form, {
            plugins: {
                declarative: new FormValidation.plugins.Declarative({
                    html5Input: true,
                }),
                trigger: new FormValidation.plugins.Trigger(),
                tachyons: new FormValidation.plugins.Tachyons(),
                submitButton: new FormValidation.plugins.SubmitButton(),

                tachyons: new FormValidation.plugins.Tachyons({
                    rowInvalidClass: 'my-field-error',
                    // rowValidClass: 'my-field-success',
                }),

                icon: new FormValidation.plugins.Icon({
                    // valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                }),
            }
        }).on('core.field.invalid', function(data) {
            parentId = $("#" + data).parents('.tab-pane').attr("id");
            icon = $('a[href="#' + parentId + '"][data-bs-toggle="tab"]').parent().find('i');
            icon.removeClass('fa-check').addClass('fa-times');
            icon.attr('style', 'padding:5px; color:#f1416c !important');
        }).on('core.field.valid', function(data) {

            parentId = $("#" + data).parents('.tab-pane').attr("id");
            icon = $('a[href="#' + parentId + '"][data-bs-toggle="tab"]').parent().find('i');
            icon.removeClass('fa-times').addClass('fa-check');
            icon.attr('style', 'padding:5px; color:#00afaf !important');
        });
    // Handle submit button
    submitButton.addEventListener('click', e => {
        e.preventDefault();        
        // Validate form before submit
        if (validator) {
            validator.validate().then(function(status) {
                //console.log('validated!');
                if (status == 'Valid') {
                   //https://ckeditor.com/docs/ckeditor5/latest/installation/getting-started/getting-and-setting-data.html
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    // Disable submit button whilst loading
                    // submitButton.disabled = true;
                    setTimeout(function() {
                        submitButton.removeAttribute('data-kt-indicator');
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                        });
                        $.ajax({
                            type: "post",
                            enctype: "multipart/form-data",
                            url: $("#" + formId).data("route-url"),
                            data: new FormData($("#" + formId)[0]),
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function(response, textStatus, xhr) {
                                if (response["status"] == true) {

/////////////
        let answersArr = "";
        $.each(response["answers"], function(key, value) {
                answersArr+='<label class="d-flex align-items-center mb-5"><span class="form-check form-check-custom form-check-solid me-5"><input class="form-check-input answer" type="radio" name="answer_id" id="'+value.id+'" value="'+value.id+'"/></span><span class="d-flex flex-column me-3"><span class="fw-bold">'+value.title+'</span></span></label>'; 
        });

Swal.fire({
    title: response["msg"]+'<br/><br/><span class="text-success">'+response["QT"]+'</span>',    
    html: answersArr+'<span class="text-danger">You need to choose Correct Question Answer!</span>',  
    icon: 'success',  
    buttonsStyling: false,
    showLoaderOnConfirm: true,
    confirmButtonText: 'Save',   
    customClass: {
        confirmButton: "btn btn-light-success",                                             
    }
 
}).then(function(result) {
    if (result.value) { // Yes Delete
        $.ajax({
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: response["action"],
            data: {
                 'question_id':response["Qid"],
                 'answer_id': $('.answer:checked').val(),
                '_method': 'post',
            },
            success: function(response, textStatus, xhr) {
                Swal.fire({
                    html: 'saving correct answers !!!',
                    icon: "info",
                    buttonsStyling: false,
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    if (response["status"] == true) {
                        Swal.fire({
                            text: response['msg'], // respose from controller
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: "btn btn-light-primary"
                            }
                        }).then(function() {
                            // delete row data from server and re-draw datatable
                            document.location.href = window.location.href;
                        });
                    } 
                    else if (response["status"] == false) {
                        Swal.fire({
                            html: response["msg"], // respose from controller
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: 'move to question details to assign the correct answer',
                            customClass: {
                                confirmButton: "btn btn-light-danger"
                            }
                        }).then(function() {
                            document.location.href = response["editQRoute"];
                        });
                    }
                });
            }
        });
    }  
});
 
                                    
                               ///////////
                                      

                                  
                                }
                                else if (response["status"] == 'RequestValidation') {
                                    let msgError = "";
                                    $.each(response["msg"], function(key, value) {
                                        msgError += "<p>" + value + "</p>";
                                        parentId = $("#" + key).parents('.tab-pane').attr("id");
                                        icon = $('a[href="#' + parentId + '"][data-bs-toggle="tab"]').parent().find('i');
                                        icon.removeClass('fa-check').addClass('fa-times');
                                        icon.attr('style', 'padding:5px; color:#f1416c !important');
                                    });
                                    Swal.fire({
                                        html: msgError, // respose from controller
                                        icon: "warning",
                                        buttonsStyling: false,
                                        confirmButtonText: form.getAttribute("data-form-agree-label"),
                                        customClass: {
                                            confirmButton: "btn btn-light-warning"
                                        }
                                    })
                                }else if (response["status"] == false) {                                    
                                    Swal.fire({
                                        html: response["msg"], // respose from controller
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: form.getAttribute("data-form-agree-label"),
                                        customClass: {
                                            confirmButton: "btn btn-light-danger"
                                        }
                                    })
                                }
                            },
                        });
                    }, 2000);
                } else {
                    Swal.fire({
                        text: form.getAttribute('data-form-submit-error-message'),
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: form.getAttribute("data-form-agree-label"),
                        customClass: {
                            confirmButton: "btn btn-light-danger"
                        }
                    });
                }
            });
        }
    })
}


    
