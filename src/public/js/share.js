$.getScript("//cdn.jsdelivr.net/clipboard.js/1.5.13/clipboard.min.js", function(){
    var clipboard = new Clipboard('#copy');
    var copy = $('#copy');
    $('#copy').click(function(){
        $(this).addClass('copied');
        $(this).text('コピーしました');
    });
});
$('#twitter').attr('href', '//twitter.com/share?url=' + location.href);
$('#facebook').attr('href', '//www.facebook.com/sharer/sharer.php?u=' + location.href);