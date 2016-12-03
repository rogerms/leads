@extends('layouts.master')

@section('title', 'Proposal Notes')

@section('content')
<div class="container">

    @foreach($props as $prop)
    <div class="panel panel-default">
        <div class="panel-body" >
           {!!  $prop->text !!}
        </div>
        <div class="panel-footer">
            <span> Created: {{ toFormatted($prop->created_at) }}.</span>
            <span> Modified: {{ toFormatted($prop->updated_at) }}.</span>
        </div>
    </div>
    @endforeach

</div>
@endsection