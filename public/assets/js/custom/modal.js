$(function() {
    $('button[data-toggle="modal"]').on('click', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastModal', $(this).attr('data-target'));
        console.log('ok')
    });
    let lastModal = localStorage.getItem('lastModal');
    let lastBtn = localStorage.getItem('lastBtn');
    if (lastModal) {
        $(lastModal).modal('show');
        if (lastBtn){
            $('#militaire_formation_statut').val(lastBtn)
        }
    }
});