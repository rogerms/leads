@if(Session::has('message'))
    <?php
        $message = Session::get('message');
    ?>
    <div class="bs-example">
        <div class="alert {{ $message['class']  }} fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>{{ $message['title'] }} </strong> {{ $message['text'] }}
        </div>
    </div>
@endif