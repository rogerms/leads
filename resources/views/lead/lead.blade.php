@extends('layouts.master')

@section('title', 'Details')

@section('content')
    @include('partials.feedback')
<div class="panel-group">
    <form>
        {!! csrf_field() !!}
        <div class="row row-extra-pad">
            <h2>Customer</h2>
        </div>
    <div class="row">
        <div class="col-md-6">
        <div class="form-group">
            <label for="customer">Customer Name</label>
            <input type="text" class="form-control" id="customer" value="{{$lead->customer_name}}" placeholder="Customer's Name">
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="contact">Contact Name</label>
            <input type="text" class="form-control" id="contact" value="{{$lead->contact_name }}" placeholder="Contact Name">
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <div class="form-group phone-group">
            <label for="phone">Phone</label>
            <div class="input-group">
                <input type="tel" class="form-control" aria-label="phone-number" id="phone" value="{{$lead->phone}}" placeholder="Phone #">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default disabled badge-btn">main</button>
                    <a class="btn btn-default" role="button" href="tel:{{ $lead->phone }}"><span class="glyphicon glyphicon-earphone"></span></a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#" class="icon" id="addphone"><span class="glyphicon glyphicon-plus"></span>Add Phone#</a></li>
                    </ul>
                </div><!-- /btn-group -->
            </div><!-- /input-group -->

            {{--other phone numbers--}}
            @foreach($lead->phones as $phone)
                <div class="input-group extra-phone">
                    <input type="tel" class="form-control extra-phone-num" aria-label="phone-number" value="{{ $phone->number }}" placeholder="Phone #">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default disabled badge-btn">{{ $phone->label }}</button>
                        <a class="btn btn-default" role="button" href="tel:{{ $phone->number }}"><span class="glyphicon glyphicon-earphone"></span></a>
                        <button type="button" data-id="{{ $phone->id }}" class="btn btn-default delete-phone" ><span class="glyphicon glyphicon-trash"></span></button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            @endforeach
        </div>

        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="{{$lead->email}}" placeholder="Email">
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="street">Street Address</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="street" value="{{$lead->street}}" placeholder="Address">
                    <span class="input-group-btn">
                        <a class="btn btn-default" role="button" href="{{ $lead->address }}"><span class="glyphicon glyphicon-globe"></span></a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" value="{{$lead->city}}" placeholder="City">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" class="form-control" id="zip" value="{{$lead->zip}}" placeholder="84601">
            </div>
        </div>
    </div>
        <div class="row">
        <div class="col-md-3">
        <div class="form-group">
            <label for="takenby">Taken by</label>
                <select class="form-control" id="takenby">
                @foreach($takenbies as $taker)
                    <option value="{{$taker->id}}" {{ isSelected($taker->id, $lead->taken_by_id)  }}>{{$taker->name}}</option>
                @endforeach
                </select>
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="source">Source</label>
            <select class="form-control" id="source">
               @foreach($sources as $source)
                    <option value="{{$source->id}}" {{ isSelected($source->id, $lead->source_id) }}>{{$source->name}}</option>
               @endforeach
            </select>
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="salesrep">Sales Rep</label>
            <select class="form-control" id="salesrep">
              @foreach($salesreps as $rep)
                <option value="{{$rep->id}}" {{ isSelected($rep->id, $lead->sales_rep_id) }}>{{$rep->name}}</option>
              @endforeach
            </select>
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" value="$lead->status['name']">
               @foreach($statuses as $status)
                <option value="{{$status->id}}" {{ isSelected($status->id, $lead->status_id) }} >{{$status->name}}</option>
              @endforeach
            </select>
        </div>
        </div>
    </div>
        <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="appointment">Appointment Date </label>
                <input type="text" class="form-control date" id="appointment" value="{{ format_date($lead->appointment) }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="apptime">Time</label>
                <input type="text" class="form-control time" id="apptime" value="{{  format_time($lead->appointment) }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="addtocalendar" class="sr-only">Add to calendar</label>
                <div class="btn-group" role="group">
                    <button type="button" id="addtocalendar"  class="btn btn-default input-btn-margin">
                        Add to Calendar
                    </button>
                    <button type="button" class="btn btn-default dropdown-toggle input-btn-margin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="calendarhash" data-tag="#week" href="#">Add #week</a></li>
                        <li><a class="calendarhash" data-tag="#day" href="#">Add #day</a></li>
                    </ul>
                </div>
            </div>
        </div>
        </div>


        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group note-form">
                    <label>Notes</label>
                    <div style="display: inline-block; margin: 2px 20px;">
                        <select class="form-control  tags-select" >
                            @foreach(all_tags($lead->notes) as $key => $tag)
                                <option value="{{ $key }}"> {{ $tag }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="list-group" id="notes" name="notes">
                        @foreach($lead->notes as $note)
                            <?php
                                $deleted = !empty($note->deleted_at);
                                $tagall = ($deleted)? ' success tag-deleted': ' active tag-all';
                            ?>
                             <a href="#" class="list-group-item  {{ $tagall }} {{ get_tag($note) }}">
                                 @if(!$deleted)
                                    <button type="button" class="delete-note" data-noteid="{{ $note->id }}"><span aria-hidden="true">&times;</span></button>
                                 @endif
                                <h4 class="list-group-item-heading">{{ $note->note }}</h4>
                                <p class="list-group-item-text">Created on: {{ toFormatted($note->created_at) }}</p>
                                 @if($deleted)
                                     <p class="list-group-item-text item-text-deletedat">Deleted on: {{ toFormatted($note->deleted_at) }}</p>
                                 @endif
                              </a>
                        @endforeach
        <!--  diffForHumans() -->
                    </div>
                </div>

                @can('edit')
                <div class="row row-extra-bm-pad">
                    <div class="col-md-12 col-lg-12">
                        <div class="input-group">
                          <span class="input-group-addon" id="leadnotelb">+</span>
                          <input type="text" id="leadnote" data-lead-id="{{ $lead->id }}" class="form-control" placeholder="Add a note" aria-describedby="leadnotelb">
                        </div>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
                @endcan
            </div> <!-- / first column -->
        <div class="col-md-6 col-lg-6"> <!-- second column -->
            <div class="row">
                <div class="form-group">
                    <label>Sketches</label>
                    <div class="list-group sketch-group" id="drawings">
                        @include('partials.drawing', ['drawings' =>$lead->drawings])
                    </div>
                </div>
                <div>
                    <div class="col-md-12">
                    @can('edit')
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addImageModal">Add New Sketch</button>
                    @endcan
                    </div>
                </div>
            </div>
        </div> <!-- /. second column -->
        </div> <!-- /.row -->

        <div class="row row-extra-pad">
            <input type="hidden" id="leadid" value="{{$lead->id}}" />
            @can('edit')
            <button type="button" class="btn btn-primary" id="updatelead">Update</button>
            @endcan
            @can('edit-job')
            <a role="button" href="/job/create/{{ $lead->id }}" class="btn btn-primary" id="addjobbt">Add a Job</a>
            @endcan
            @can('delete-user')
            <button type="button" class="btn btn-primary" id="printlead">Print</button>
            @endcan
        </div>
    </form>
</div>
<!--     Jobs start here ************************************************************************************************************-->
@can('read')
    @foreach($lead->jobs as $job)
        @include('partials.job')
    @endforeach
@endcan
    @include('partials.modals')
    @include('partials.confirmdlg')
    @include('partials.templates')
@stop
