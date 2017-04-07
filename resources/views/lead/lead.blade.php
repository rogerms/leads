@extends('layouts.master')

@section('title', 'Details')

@section('content')
<div class="container">
    @include('partials.feedback')
<div class="panel-group">
    <form>
        {!! csrf_field() !!}
        <div class="row row-extra-pad">
            <div class="col-sm-3"><h2>Customer</h2></div>
            <div class="col-sm-9" >
                <div class="pull-right lead-labels">
                @foreach($lead->labels as $label)
                    <!-- id = job_labels.id  data-label=job_labels.label_id  -->
                        <button type="button" class="btn btn-info btn-xs" id="{{ $label->pivot->id }}" data-label="{{ $label->id }}" >{{ $label->name}}
                            <span class="job-label-btn" aria-hidden="true">X</span>
                        </button>
                    @endforeach
                </div>
            </div>
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
                    @can('edit')
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#" class="icon" id="addphone"><span class="glyphicon glyphicon-plus"></span>Add Phone#</a></li>
                    </ul>
                    @endcan
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
        <div class="form-group email-group">
            <label for="email">Email</label>
            <div class="input-group">
                <input type="email" class="form-control" id="email" value="{{$lead->email}}" placeholder="Email">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default disabled badge-btn">main</button>
                    <a class="btn btn-default" role="button" href="mailto:{{ $lead->email }}"><span class="glyphicon glyphicon-envelope"></span></a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                    @can('edit')
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#" class="icon" id="addemail"><span class="glyphicon glyphicon-plus"></span>Add Email</a></li>
                        </ul>
                    @endcan
                </div><!-- /btn-group -->
            </div><!-- /input-group -->

            {{--other email addresses--}}
            @foreach($lead->emails as $email)
                <div class="input-group extra-email-group">
                    <input type="email" class="form-control extra-email" aria-label="email" value="{{ $email->email }}" >
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default disabled badge-btn">{{ $email->label }}</button>
                        <a class="btn btn-default" role="button" href="mailto:{{ $email->email }}"><span class="glyphicon glyphicon-envelope"></span></a>
                        <button type="button" data-id="{{ $email->id }}" class="btn btn-default delete-email" ><span class="glyphicon glyphicon-trash"></span></button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            @endforeach
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
        <div class="col-md-1">
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" value="{{ !empty($lead->state)? $lead->state: 'UT'  }}" >
            </div>
        </div>
    </div>
        <div class="row">
            @can('edit')
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
            @endcan
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
            @can('edit')
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
            @endcan
    </div>

        <div class="row">
            @can('edit')
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
            @endcan
        </div>


        <div class="row">

            <div class="col-md-6 col-lg-6">
                @can('edit')
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
                @endcan

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
                    <button type="button" class="btn btn-default" id="addImageModal">Add New Sketch</button>
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
            {{-- job progress --}}
            @can('read')
            <!-- Split button -->
            <div class="btn-group dropup" >
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" title="Labels" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Button</span>
                </button>
                <ul class="dropdown-menu lead-label-menu">
                    <?php
                       $lead_labels_ids = labelIds($lead->labels);
                    ?>
                    @foreach($lead_labels as $label)
                        <li class="label-list-item">
                            <div class="checkbox">
                                  <label><input type="checkbox" class="lead-label-menu-item" id="{{$label->id }}"
                                                data-order="{{ $label->display_order }}"
                                                value="{{ isLabelChecked($label->id, $lead_labels_ids) }}"
                                            {{ isLabelChecked($label->id, $lead_labels_ids) }} >{{ $label->name }}</label>
                            </div>
                        </li>
                    @endforeach
                    <li role="separator" class="divider"></li>
                    <li><a id="{{$lead->id}}" style="display: none" class="lead-label-menu-apply">Apply</a></li>
                    <li><a id="create-lead-label" class="create-lead-label">Create new</a></li>
                    <li><a id="edit-lead-label" class="edit-lead-label" href="/labels/edit">Manage labels</a></li>
                </ul>
            </div>
            @endcan
        </div>
    </form>
</div>
</div>
<!--     Jobs start here ************************************************************************************************************-->
@can('read')
<div class="container inner-container-top">
    @foreach($lead->jobs as $job)
        @include('partials.job')
    @endforeach
</div>
@endcan
    @include('partials.modals')
    @include('partials.confirmdlg')
    @include('partials.templates')
@stop
