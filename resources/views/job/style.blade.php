@extends('layouts.master')

@section('title', 'Pavers Style')

@section('content')
<div class="container">
    @include('partials.feedback')

<div class="panel-group">
    <form id="{{$job->id}}">
        <div class="row row-extra-pad">
            <h3>Pavers for Job: {{$job->id}} @if(count($job->code > 0)) ({{ $job->code }}) @endif</h3>
        </div>
        <div class="stylesgroups">
            @if($count = 1) @endif
            <div class="style-sheets">
                @foreach($job->stylegroups as $stylegroup)
                    @include('partials.stylegr', compact('stylegroup', 'count'))
                    @if($count++) @endif
                @endforeach
            </div>
            <div class="row-extra-bm-pad row-extra-pad">
                <input type="hidden" id="jobid" value="{{ $job->id }}">
                <button type="button" class="btn btn-primary add-style-group" id="add-style-group">Create New Group</button>
                @if(count($job->stylegroups) > 0)
                <button class="btn btn-warning" id="update-all-groups">Update All</button>
                @endif
            </div>
        </div>
    </form>
</div>
</div>
    @include('partials.templates')
@stop