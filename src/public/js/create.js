$('#submit').on('click',function(e){
    transform();
    $('#submit').submit();
});

function transform() {
    var text  = document.getElementById('commit-group').value.replace(/\r\n|\r/g, "\n");
    var lines = text.split('\n');

    for (var i = 0; i < lines.length; i++) {
        if (lines[i] == '') {
            continue;
        }
        if (i === 0) {
            document.getElementById('commit-group').value = lines[i];
        } else {
            createHidden("content[]", lines[i]);
        }
        createHidden("status[]", '0');
        createHidden("priority[]", String(i));
    }
}

function createHidden(name, value) {
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    document.forms['create'].appendChild(input);
}