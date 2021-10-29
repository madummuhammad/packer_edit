blockUI();

$(function() {

    $.validator.setDefaults({
        debug: false,
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            element.parents('.form-group').append(label);
        },
        highlight: function(element, errorClass) {
            return;
        },
        unhighlight: function(element, errorClass, validClass) {
            return;
        }
    });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Input Mask
    $(":input").inputmask();

    // Select2
    if ($(".select2-single").length) $(".select2-single").select2();
    if ($(".select2-multiple").length) $(".select2-multiple").select2();

    // Flatpickr
    if ($(".flatpickr").length) $(".flatpickr").flatpickr();

    setTimeout(function() {
        unblockUI();
    }, 1000);

});

function blockUI() {
    $.blockUI({
        message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
        fadeIn: 800, 
        overlayCSS: {
            backgroundColor: '#1b2024',
            opacity: 0.8,
            zIndex: 1200,
            cursor: 'wait'
        },
        css: {
            border: 0,
            color: '#fff',
            zIndex: 1201,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}

function unblockUI() {
    $.unblockUI();
}

function imgError(image) {
    image.onerror = "";
    image.src = "/assets/apps/img/default_image.png";
    return true;
}
