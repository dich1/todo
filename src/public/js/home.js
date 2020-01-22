function loadMore(type) {
    $.ajax({
        url:'/home/get-more-commit',
        type:'POST',
        data:{
            'type': type,
            'skip': $('.' + type + '-ul li.block').length
        }
    }).done( (data) => {
        const commits = data.commits;
        // 要素の生成、反映
        $.each(commits, function(i, commit) {
            const blockLi = $('<li>', { class: 'block' });
            const blockLink = $('<a>', { href: '/commits/' + commit.id });
            // コミット内容がある場合は生成
            const commitGroupOl = $('<ol>');
            $.each(commit.commit_groups, function(j, commitGroup) {
                if (j === 2) {
                    return;
                }
                $('<li>').text(commitGroup.content).appendTo(commitGroupOl);
            });
            // 要素を組み立てる
            const content = $('<div>')
                                .append('<h3>' + formatDate(commit.limit) + 'までの' + 1 + 'コミット' + '</h3>');
            const element = blockLi.append(blockLink.append(content.append(commitGroupOl)).append('<span class="arrow"></span>'));
            // ここでDOMに要素を追加
            $('.' + type + '-ul li.button').before(element);
        });
        // もう読み込むデータがない場合はボタンを隠す
        if (!data.isMore) {
            $('.' + type + '-ul li.button').hide();
        }
    })
    .fail( (data) => {
        if (data.status === 500) {
            alert('システムエラーが発生しました。');
        } else if (data.status === 400) {
            alert('リクエストが不正です。');

        } else if (data.status === 404) {
            alert('データが存在しません。');
        }
    });
}

function formatDate(date) {
    const formattedDate = new Date(date);
    const d = formattedDate.getDate();
    let m =  formattedDate.getMonth();
    m += 1;  // JavaScript months are 0-11
    const y = formattedDate.getFullYear();

    return y + "/" + m + "/" + d;
}
