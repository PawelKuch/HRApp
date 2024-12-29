document.addEventListener('DOMContentLoaded', function() {
    $('#from_date_datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });
});

$('#to_date_picker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    todayHighlight: true
})
