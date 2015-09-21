$(document).ready(function() {
    $('form').validate({
        onKeyup : true,
        eachValidField : function() {

            $(this).closest('div').removeClass('error').addClass('has-success');
        },
        eachInvalidField : function() {

            $(this).closest('div').removeClass('success').addClass('has-error');
        }
    });


    $('#delivery_date').datetimepicker({
        formatTime:'H:i',
        formatDate:'d.m.Y',
        format:'Y-m-d H:i',
        defaultDate:'30.08.2014', // it's my birthday
        defaultTime:'10:00',
        lang:'ru',
        startDate:	'2015/04/30'
    });

});