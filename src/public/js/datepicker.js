$.getScript("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js", function(){
    $.getScript("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/locales/bootstrap-datepicker.ja.min.js", function(){
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja',
            autoclose: true,
            startDate: '0'
        });
    });
});