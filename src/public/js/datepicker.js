$.getScript("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js", function(){
  $('.date-picker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    startDate: '0'
  });
});