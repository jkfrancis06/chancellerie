$(function() {
    // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
    $('button[role="tab"]').on('shown.bs.tab', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastTab', $(this).attr('data-bs-target'));
    });


    $('button[data-bs-toggle="modal"]').on('click', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastModal', $(this).attr('data-bs-target'));
        console.log('ok')
    });
    // go to the latest tab, if it exists:
    let lastTab = localStorage.getItem('lastTab');
    let lastModal = localStorage.getItem('lastModal');
    if (lastTab) {
        $('[data-bs-target="' + lastTab + '"]').tab('show');
    }
    if (lastModal) {
        $('[data-bs-target="' + lastModal + '"]').show('show');
    }
});