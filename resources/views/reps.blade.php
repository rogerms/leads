@extends('layouts.master')

@section('title', 'Update Reps Info')

@section('content')
    @include('partials.feedback')
<div class="row">
    <div class="row">
        <h4>Sales Reps</h4>
    </div>
    <form class="form-inline reps-update" action="">
        <div class="row">
            <div class="form-group col-sm-2">
                <label for="exampleInputName2">Name</label>
            </div>
            <div class="form-group col-sm-2">
                <label for="phone">Phone</label>
            </div>
            <div class="form-group col-sm-1">
                <label for="active">Active</label>
            </div>
        </div>
        @foreach($reps as $rep)
        <div class="row">
            <div class="form-group col-sm-2">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control" id="name" value="{{ $rep->name }}" placeholder="Jane Doe">
            </div>
            <div class="form-group col-sm-2">
                <label class="sr-only" for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" value="{{ $rep->phone }}" placeholder="800-700-0000">
            </div>
            <div class="form-group col-sm-1">
                <label class="sr-only" for="active">Active</label>
                <input type="checkbox" class="form-control reps-active" {{ $rep->active? 'checked': '' }} id="active">
            </div>
            <button type="button" id="{{ $rep->id }}" class="btn btn-default update-rep">Update</button>
        </div>
        @endforeach
        <div class="row reps-add">
            <div class="form-group col-sm-2">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control" id="name"  placeholder="Jane Doe">
            </div>
            <div class="form-group col-sm-2">
                <label class="sr-only" for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" placeholder="800-700-0000">
            </div>
            <div class="form-group col-sm-1">
                <label class="sr-only" for="active">Active</label>
                <input type="checkbox" class="form-control float-right reps-active"  id="active" checked>
            </div>
            <button type="button" id="0" class="btn btn-info update-rep">Add</button>
        </div>
    </form>
</div>
@endsection
