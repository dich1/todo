$('#submit').on('click',function(e){
    transform();
    $('#submit').submit();
});

function transform() {
    if (!document.getElementById('limit-field').checkValidity()) {
        return;
    }
    var text  = document.getElementById('commit-group').value.replace(/\r\n|\r/g, "\n");
    var lines = text.split('\n');

    for (var i = 0; i < lines.length; i++) {
        if (lines[i] == '') {
            continue;
        }
        createHidden("status[]", '0');
        createHidden("priority[]", String(i));
        createHidden("content[]", lines[i]);
    }
}

function createHidden(name, value) {
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    document.forms['create'].appendChild(input);
}

let MAX_LINE = 100;
let textarea = document.getElementById("commit-group");
textarea.addEventListener("input", function() {
    let lines = textarea.value.split("\n");
    if (lines.length > MAX_LINE) {
      var result = "";
      for (var i = 0; i < MAX_LINE; i++) {
        result += lines[i] + "\n";
      }
      textarea.value = result;
    }
}, false);