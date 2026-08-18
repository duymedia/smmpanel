// Show Toast Notification — wraps toastr library
function showToast(message, type = 'success') {
    if (typeof toastr === 'undefined') {
        console.warn('toastr is not loaded');
        return;
    }

    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: 'toastr-bottom-center',
        preventDuplicates: false,
        onclick: null,
        showDuration: '300',
        hideDuration: '1000',
        timeOut: '5000',
        extendedTimeOut: '1000',
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
    };

    toastr[type](message);
}
