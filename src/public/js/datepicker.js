$('head link:last').after('<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/pepper-grinder/jquery-ui.css">');
$.getScript("//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js", function(){
    $.getScript("//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery-ui-i18n.min.js", function(){
        $.datepicker.setDefaults($.datepicker.regional["ja"]);
        $('.date-picker').datepicker({
            dateFormat     : 'yy-mm-dd',
            minDate        : '0'
        });
    });
});