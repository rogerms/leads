@extends('layouts.master')

@section('title', 'Pavers')

@section('content')
<div class="container">
    @include('partials.feedback')

<div class="panel-group">
    <form id="{{$job->id}}">
        <div class="row row-extra-pad">
            <h3>Pavers for Job: {{$job->id}} @if(count($job->code > 0)) ({{ $job->code }}) @endif</h3>
        </div>
        <div class="paversgroups">
            @if($count = 1) @endif
            <div class="paver-sheets">
                @foreach($job->pavergroups as $pavergroup)
                    @include('partials.pavergr', compact('pavergroup', 'count'))
                    @if($count++) @endif
                @endforeach
            </div>
            <div class="row-extra-bm-pad row-extra-pad">
                <input type="hidden" id="jobid" value="{{ $job->id }}">
                <button type="button" class="btn btn-primary add-paver-group" id="add-paver-group">Create New Group</button>
                @if(count($job->pavergroups) > 0)
                <button class="btn btn-warning" id="update-all-groups">Update All</button>
                @endif
            </div>
        </div>
    </form>
</div>
</div>
    @include('partials.templates')
@stop