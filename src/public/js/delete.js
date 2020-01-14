$('.message').fadeOut(2000);
$('.delete').click(function(){
    if (!confirm('削除しますか ?')) { 
      return;
    }
    var id = this.id;
    var pathname = (location.pathname.match(/edit/)) ? '/commitGroups/' : '/commits/';
    $.ajax({
        type    : 'POST',
        url     : location.protocol + '//' + location.hostname + pathname + id,
        dataType: 'text',
        data    : { _token: $('#token').val(), _method: 'DELETE' },
        async   : false,
        timeout : 10000
    }).done(function(data){
        var targetElement = '#commit-item-bloc-' + id;
        $(targetElement).remove();
        
        $('.commit-item-bloc').each(function(index, element){
            $(element).find('input[name*="priority"]')[0].value = index;
            $(element).find('.num')[0].innerHTML = String(index + 1);
        });
    }).fail(function(data, textStatus, errorThrown) {
        console.log('エラーステータス：' + data.status);
        console.log('ステータスメッセージ：' + textStatus);
        console.log('エラーメッセージ：' + errorThrown.message);
        alert('通信に失敗しました。');
    });
});