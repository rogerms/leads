@extends('layouts.master')

@section('content')
    <form action="/report/upload"
          enctype="multipart/form-data" method="post">
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="report">File input</label>
            <input type="file" id="report" name="report">
            {{--<p class="help-block">Example block-level help text here.</p>--}}
        </div>
        {{--<div class="checkbox">--}}
            {{--<label>--}}
                {{--<input type="checkbox"> Check me out--}}
            {{--</label>--}}
        {{--</div>--}}
        <button type="submit" class="btn btn-default">Upload</button>
    </form>
@stop