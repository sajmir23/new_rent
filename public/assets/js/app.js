// import './bootstrap';
//
// import Alpine from 'alpinejs';
//
// window.Alpine = Alpine;
//
// Alpine.start();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    let $float_nr = $(".float-nr");
    let $integer_nr = $(".integer-nr");
    let $ajax_form = $("form.ajax-form");

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $float_nr.on("keypress keyup blur", function (event) {
        $(this).val($(this).val().replace(/[^0-9.]/g,''));
        if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $integer_nr.on("keypress keyup blur", function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $ajax_form.attr('novalidate', 'novalidate');

    $ajax_form.submit(function (event) {
        event.preventDefault();
        formAjax($(this));
    });

    $('.hover-btn').popover({ trigger: 'hover' });

    $('body').on('click', '.action-button', function (event) {
        event.preventDefault();

        let $this = $(this),
            $actionModal = $('#action-modal'),
            $actionFormModal = $('#action-form-modal'),
            $actionFormButton = $('#action-form-button'),
            $actionFormInputs = $('#action-form-inputs'),
            $actionModalTitle = $('#action-title'),
            $actionModalMessage = $('#action-message'),
            method = $this.data('method'),
            action = $this.data('action'),
            title = $this.data('title'),
            message = $this.data('message'),
            isDanger = $this.data('is-danger') === 'true' || $this.data('is-danger') === true;

        if (method === 'PUT' || method === 'PATCH' || method === 'DELETE') {
            $actionFormModal.attr('method', 'POST');
            $actionFormInputs.html(`<input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}"><input type="hidden" name="_method" value="${method}">`);
        } else if (method === 'POST') {
            $actionFormModal.attr('method', 'POST');
            $actionFormInputs.html(`<input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">`);
        } else {
            $actionFormModal.attr('method', 'GET');
            $actionFormInputs.html('');
        }

        if (isDanger) {
            $actionFormButton.removeClass('btn-success');
            $actionFormButton.addClass('btn-danger');
        } else {
            $actionFormButton.addClass('btn-success');
            $actionFormButton.removeClass('btn-danger');
        }

        $actionModalTitle.html(title);
        $actionModalMessage.html(message);
        $actionFormModal.attr('action', action);
        $actionModal.modal('show');
    });
});

function formAjax($form, $submit_btn = null, async = true) {
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: new FormData($form[0]),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        async: async,
        beforeSend: function() {
            showLoadSubmitButton($form, $submit_btn);
            clearFormErrors($form);
        },
        success: function(response){

            let data = response.data;

            if (! data.success) {
                toastr.error('Error!');
            }
            if(data.success !== undefined && data.success){

                if(data.redirect_to !== undefined && data.redirect_to !== null && data.redirect_to.length > 0){
                    window.location.href = data.redirect_to;
                }
            }
        },
        error: function(data){
            handleSubmitFormErrors(data);
        },
        complete: function () {
            hideLoadSubmitButton($form, $submit_btn);
        }
    });
}

function handleSubmitFormErrors(response) {
    let data = response.responseJSON;

    if (response.status === 422) {
        toastr.error('', data.message);

        $.each(data.errors, function(input, errorMessage){
            let inputName = input;

            if (input.indexOf(".") !== -1) {
                let inputParts = input.split(".");

                if (inputParts.length === 2 && ! isNaN(parseInt(inputParts[1]))) {
                    input = `[name="${inputParts[0]}[]"]:eq(${inputParts[1]})`;
                } else if (inputParts.length === 2 && isNaN(parseInt(inputParts[1]))) {
                    input = `[name="${inputParts[0]}[${inputParts[1]}]"]`;
                } else if (inputParts.length === 3) {
                    input = `[name="${inputParts[0]}[${inputParts[1]}][${inputParts[2]}]"]`;
                } else if (inputParts.length === 4) {
                    input = `[name="${inputParts[0]}[${inputParts[1]}][${inputParts[2]}][${inputParts[3]}]"]`;
                }
            } else {
                if (input.includes('answer')) {
                    input = `[name=${input}]`;
                } else {
                    input = `[name^=${input}]`;
                }
            }

            let $input = $(input),
                $inputMediaWrapper = $(`.${inputName}-wrapper`),
                $parent = $input.parents().closest('.tab-pane'),
                $mediaParent = $inputMediaWrapper.parents().closest('.tab-pane');

            $input.addClass('is-invalid');
            $input.siblings('span.invalid-feedback').text(errorMessage[0]);
            $input.parent().next('span.invalid-feedback').text(errorMessage[0]);

            $inputMediaWrapper.find('.livewire-list-error.media-library-hidden').addClass('media-library-listerrors');
            $inputMediaWrapper.find('.livewire-list-error.media-library-listerrors').removeClass('media-library-hidden');
            $inputMediaWrapper.find('.media-library-listerror-title').text(errorMessage[0]);

            if ($parent) {
                let $tabLink = $(`a[href="#${$parent.attr('id')}"]`);
                $tabLink.find('span.text-danger.asterisk').remove();
                $tabLink.append('<span class="text-danger asterisk ms-1">*</span>');
            }

            if ($mediaParent) {
                let $mediaTabLink = $(`a[href="#${$mediaParent.attr('id')}"]`);
                $mediaTabLink.find('span.text-danger.asterisk').remove();
                $mediaTabLink.append('<span class="text-danger asterisk ms-1">*</span>');
            }
        });
    } else {
        toastr.error(data.message, response.status);
    }
}

function showLoadSubmitButton($form, $submit_btn = null) {
    if ($submit_btn !== null) {
        $submit_btn.attr('disabled', true);
        $submit_btn.find('i.fa').removeClass('d-none');
    } else {
        $form.find('button.submit-btn').attr('disabled', true);
        $form.find('button.submit-btn i.fa').removeClass('d-none');
    }
}

function hideLoadSubmitButton($form, $submit_btn = null) {
    if ($submit_btn !== null) {
        $submit_btn.attr('disabled', false);
        $submit_btn.find('i.fa').addClass('d-none');
    } else {
        $form.find('button.submit-btn').attr('disabled', false);
        $form.find('button.submit-btn i.fa').addClass('d-none');
    }
}

function clearFormErrors($form) {
    $form.find('input').next('span.invalid-feedback').html('');
    $form.find('input').parent().next('span.invalid-feedback').html('');
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('span.text-danger.asterisk').remove();

    $('.livewire-list-error.media-library-listerrors').addClass('media-library-hidden');
    $('.livewire-list-error.media-library-hidden').addClass('media-library-listerrors');
    $('.media-library-listerror-title').html('');
}

function addIndexesToArrayInputs(selector) {
    $(selector).each(function (i) {
        $(this).find('input, select, textarea').each(function () {
            $(this).attr('name', $(this).attr('name').replace('[]', `[${i}]`));
            $(this).attr('name', $(this).attr('name').replace(/[[][0-9]{1,2}[\]]/g, `[${i}]`));
            $(this).attr('id', $(this).attr('id').replace('[]', `[${i}]`));
            $(this).attr('id', $(this).attr('id').replace(/[[][0-9]{1,2}[\]]/g, `[${i}]`));

            if ($(this).siblings('label').length > 0) {
                $(this).siblings('label').attr('for', $(this).siblings('label').attr('for').replace('[]', `[${i}]`));
                $(this).siblings('label').attr('for', $(this).siblings('label').attr('for').replace(/[[][0-9]{1,2}[\]]/g, `[${i}]`));
            }
        });
    });
}

function nl2br(str, is_xhtml) {
    let breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
