$('#unsubscribe').click(function(){
    var id = $("#unsubscribe").data('id');
    if (id === "") {
        alert('登録者のみが退会できます。');
        return;
    }
    if (!confirm('退会するとデータは全てなくなります。よろしいですか ?')) { 
      return;
    }
    var pathname = '/unsubscribe/';
    $.ajax({
        type    : 'POST',
        url     : location.protocol + '//' + location.hostname + pathname + id,
        dataType: 'text',
        data    : { _token: $('#token').val(), _method: 'DELETE' },
        async   : false,
        timeout : 10000
    }).done(function(data){
        location.href = location.protocol + '//' + location.hostname;
    }).fail(function(data, textStatus, errorThrown) {
        console.log('エラーステータス：' + data.status);
        console.log('ステータスメッセージ：' + textStatus);
        console.log('エラーメッセージ：' + errorThrown.message);
        alert('通信に失敗しました。');
    });
});