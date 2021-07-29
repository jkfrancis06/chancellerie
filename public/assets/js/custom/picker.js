$(document).ready(function() {
    // you may need to change this code if you are not using Bootstrap Datepicker
    $('.js-datepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        locale: {
            format: 'DD-MM-YYYY',
            "firstDay": 1,
            "applyLabel": "Appliquer",
            "cancelLabel": "Annuler",
            "fromLabel": "De",
            "toLabel": "A",
            "weekLabel": "W",
            "daysOfWeek": [
                "Dim",
                "Lun",
                "Mar",
                "Mer",
                "Jeu",
                "Ven",
                "Sam"
            ],
            "monthNames": [
                "Janvier",
                "Fevrier",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Aout",
                "Septembre",
                "Octobre",
                "Novembre",
                "Decembre"
            ],

        },
        maxYear: parseInt(moment().format('YYYY'),10),
        maxDate: moment()
    });
});