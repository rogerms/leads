@extends('layouts.master')

@section('title', 'Update Selection Lists')

@section('content')
    @include('partials.feedback')
<div class="row">
    <form class="form-inline" action="">
    <div class="col-sm-4">
    <div class="row">
        <h4>Taken By</h4>
    </div>
        @foreach($takers as $taker)
        <div class="row update-row">
            <div class="form-group">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control" id="name" value="{{ $taker->name }}">
            </div>
            <button type="button" id="{{ $taker->id }}" class="btn btn-default update-lists" data-type="takenby">Update</button>
        </div>
        @endforeach
        <div class="row reps-add">
            <div class="form-group">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control" id="name"  placeholder="Mary">
            </div>
            <button type="button" id="0" class="btn btn-info update-lists" data-type="takenby">Add</button>
        </div>
    </div>

{{--sources--}}
    <div class="col-sm-4">
        <div class="row">
            <h4>Sources</h4>
        </div>
        @foreach($sources as $source)
            <div class="row update-row">
                <div class="form-group">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name" value="{{ $source->name }}" >
                </div>
                <button type="button" id="{{ $source->id }}" class="btn btn-default update-lists" data-type="source">Update</button>
            </div>
        @endforeach
        <div class="row reps-add">
            <div class="form-group">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control" id="name"  placeholder="Sun">
            </div>
            <button type="button" id="0" class="btn btn-info update-lists" data-type="source">Add</button>
        </div>
        </div>
        {{--statuses--}}
        <div class="col-sm-4">
        <div class="row">
            <h4>Status</h4>
        </div>
        @foreach($statuses as $status)
            <div class="row update-row">
                <div class="form-group">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name" value="{{ $status->name }}">
                </div>
                <button type="button" id="{{ $status->id }}" class="btn btn-default update-lists" data-type="status">Update</button>
            </div>
        @endforeach
        <div class="row reps-add">
            <div class="form-group">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control" id="name"  placeholder="Alive">
            </div>
            <button type="button" id="0" class="btn btn-info update-lists" data-type="status">Add</button>
        </div>
        </div>
    </form>
</div>
@endsection
