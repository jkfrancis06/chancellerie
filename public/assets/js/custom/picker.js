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


    $('.js-datepicker-form').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: parseInt(moment().format('YYYY'),10),
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
        minDate: moment()
    });


    $('.js-datepicker-formation').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
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

        }
    });


    $('.js-datepicker-formation').val('')
    $('.js-datepicker-form').val('')
    $('.js-datepicker').val('')

    $('.search-picker').daterangepicker({
        autoUpdateInput: false,
        showDropdowns: true,
        opens: 'left',
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

        }
    });

    $('.search-picker').on('apply.daterangepicker', function(ev, picker) {
        console.log(picker.startDate)
        console.log(picker.endDate)
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('.search-picker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });




    // Gijgo

    $('#piece-picker').datepicker()

});