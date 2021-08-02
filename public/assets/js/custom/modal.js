$(function() {
    $('button[data-bs-toggle="modal"]').on('click', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastModal', $(this).attr('data-bs-target'));
        console.log('ok')
    });
    let lastModal = localStorage.getItem('lastModal');
    if (lastModal) {
        $(lastModal).modal('show');
    }
});