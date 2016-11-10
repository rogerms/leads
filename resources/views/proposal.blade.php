<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proposal</title>
</head>
<body style='margin:0; padding: 0'>
<input type="hidden" id="job-id" value="{{ $proposal->job_id }}" />
<input type="hidden" id="id" value="{{ $proposal->id }}" />
<input type="hidden" id="host"  value="{{ $url }}" />
<input type="hidden" id="token" value="{{ $token }}" />
<textarea class="proposal-note" data-id="{{ $proposal->id }}">{{ $proposal->text }}</textarea>
<div id="results"></div>
<!-- Placed at the end of the document so the pages load faster -->

<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>

<script>
    var token;


    function tinymceInit () {
        tinymce.init({
            selector: 'textarea.proposal-note',
            width: 835,
            height: 300,
            max_height: 270,
            browser_spellcheck: true,
            contextmenu: false,
            menubar: false,
            resize: false,
            elementpath: false,
            custom_undo_redo_levels: 10,
            statusbar: false,

            setup: customRTEButtons,

            plugins: [
                'advlist lists print preview hr',
                'save table contextmenu template textcolor'
            ],
            toolbar: 'undo redo |newdoc save | fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | forecolor | autosum',

            save_onsavecallback: saveProposalNote
        });
    }
    function customRTEButtons (editor) {
        editor.addButton('autosum', {
            icon: 'sigma',
            title: 'Add numbers',
            image: '/images/icons/360-sigma.png',
            onclick: function () {

                var re = /(-)?\$(\d+[\d\.,]*)/ig;
                var str = editor.getContent();
                var matches;
                var sum = 0;
                while ((matches = re.exec(str)) !== null) {
                    var res = matches[2].replace(/,/g, '');
                    sum += parseFloat(res)*(matches[1]? -1: 1);
                }
                // console.log(sum);
                if(sum % 1 != 0)
                {
                    sum = sum.toFixed(2);
                }
                showResult('Total $'+sum);
                amount.val(sum);
            }
        });
    }

    function saveProposalNote(editor){
        var jobid = document.getElementById('job-id').value;
        var id = document.getElementById('id').value;
        var host = document.getElementById('host').value;
        var token = document.getElementById('token').value;
        event.preventDefault();
        id = (id != "")? id: 0;
        var url = host+'/api/proposal/edit/'+id;
        var text = "&text="+encodeURIComponent(editor.getContent());
        var data  = "?api_token="+token+"&jobid="+jobid;
        url = url + data + text;
//
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("results").innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", url, true);
        xhttp.send(data);
    }
    function showResult(str)
    {
        document.getElementById("results").innerHTML = str;
    }
    function setValues(){
        token = '0YAui1hxvzeCkk4i48fyIEAe6e1mO7tNNU3XXUvwMLzKOCx0sFGeCAvbJ8cf';
    }
    tinymceInit ();
</script>
</body>
</html>