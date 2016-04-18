@extends('layouts.master')

@section('title', 'Create Lead')

@section('content')

    <div class="panel-group">
    <form action='/store' method="POST">
        {!! csrf_field() !!}
        <div class="row row-extra-pad">
            <h2>Lead Info</h2>
        </div>
    <div class="row">
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label for="customer">Customer Name</label>
            <input type="text" class="form-control" name="customer" id="customer" placeholder="Customer's Name">
        </div>
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label for="contact">Contact Name</label>
            <input type="text" class="form-control" id="contact" name="contact" value="" placeholder="Contact Name">
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone"  name="phone" value="" placeholder="Phone #">
        </div>
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email"  value="" placeholder="Email">
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="street">Street Address</label>
                <input type="text" class="form-control" id="street" name="street" value="" placeholder="Address">
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" value="" placeholder="City">
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" class="form-control" id="zip" name="zip" value="" placeholder="84601">
            </div>
        </div>
    </div>
        <div class="row">
        <div class="col-lg-3 col-md-3">
        <div class="form-group">
            <label for="takenby">Taken by</label>
                <select class="form-control" id="takenby" name="takenby">
                @foreach($takenbies as $taker)
                    <option value="{{$taker->id}}" >{{$taker->name}}</option>
                @endforeach
                </select>
        </div>
        </div>
        <div class="col-lg-3 col-md-3">
        <div class="form-group">
            <label for="source">Source</label>
            <select class="form-control" id="source" name="source">
               @foreach($sources as $source)
                    <option value="{{$source->id}}">{{$source->name}}</option>
               @endforeach
            </select>
        </div>
        </div>
        <div class="col-lg-3 col-md-3">
        <div class="form-group">
            <label for="salesrep">Sales Rep</label>
            <select class="form-control" id="salesrep" name="salesrep">
              @foreach($salesreps as $rep)
                <option value="{{ $rep->id }}">{{$rep->name}}</option>
              @endforeach
            </select>
        </div>
        </div>
        <div class="col-lg-3 col-md-3">
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
               @foreach($statuses as $status)
                <option value="{{ $status->id }}">{{$status->name}}</option>
              @endforeach
            </select>
        </div>
        </div>
    </div>
        <div class="row">
        <div class="col-lg-3 col-md-3">
            <div class="form-group">
                <label for="appointment">Appointment Date</label>
                <input type="text" class="form-control date" id="appointment" name="appointment" value="">
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="form-group">
                <label for="apptime">Time</label>
                <input type="text" class="form-control" id="apptime" name="apptime" value="" placeholder="H:M">
            </div>
        </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6 col-md-6">
                <label for="note">Note</label>
                <input type="text" class="form-control" id="note" name="note" value="" placeholder="Note...">
            </div>
        </div>

        <div class="row row-extra-pad">
            <input type="hidden" id="leadid" name="leadid" value="" />
            <button type="submit" class="btn btn-primary" id="saveleadbt">Create New Lead</button>
        </div>
    </form>
    </div>
@stop
