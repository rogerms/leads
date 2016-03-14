@extends('layouts.master')

@section('title', 'Details')

@section('content')
<div class="panel-group">
    <form>
        {!! csrf_field() !!}
        <div class="row row-extra-pad">
            <h2>Lead Info</h2>
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
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" value="{{$lead->phone}}" placeholder="Phone #">
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
                <input type="text" class="form-control" id="street" value="{{$lead->street}}" placeholder="Address">
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
        <div class="col-md-3">
            <div class="form-group">
                <label for="appointment">Appointment Date</label>
                <input type="date" class="form-control" id="appointment" value="{{  toInputDate($lead->appointment) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="apptime">Time</label>
                <input type="time" class="form-control" id="apptime" value="{{  toInputTime($lead->appointment) }}">
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group note-form">
                    <label>Notes</label>
                    <div class="list-group" id="notes" name="notes">
                        @foreach($lead->notes as $note)
                             <a href="#" class="list-group-item active">
                                 <button type="button" class="delete-note" data-noteid="{{ $note->id }}"><span aria-hidden="true">&times;</span></button>
                                <h4 class="list-group-item-heading">{{ $note->note }}</h4>
                                <p class="list-group-item-text">Created on: {{ toFormatted($note->created_at) }}</p>
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
            <button type="button" class="btn btn-primary" id="addjobbt">Add a Job</button>
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
<div class="panel-group">
    <form id="{{$job->id}}">
        <div class="row row-extra-pad">
            <h2>Job: {{$job->id}}</h2>
        </div>
        <div class="row">
        <div class="form-grrup col-md-2">
            <label for="jobtype">Job Type </label>
            <select class="form-control" id="jobtype">
             @foreach($job_types as $type)
                <option {{ isSelected($type->name, $job->job_type) }}>{{$type->name}}</option>
              @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="customertype">Customer Type </label>
            <select class="form-control" id="customertype">
             @foreach($customer_types as $type)
                <option {{ isSelected($type->customer_type, $job->customer_type) }}>{{$type->customer_type}}</option>
              @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="contractor">Contractor</label>
            <input type="text" class="form-control" id="contractor" value="{{$job->contractor}}" placeholder="Contractor">
        </div> 
        <div class="form-group col-md-2">
            <label for="propertytype">Property Type </label>
            <select class="form-control" id="propertytype">
             @foreach($property_types as $type)
                <option {{ isSelected($type->property_type, $job->property_type) }}>{{$type->property_type}}</option>
              @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="datesold">Date Sold</label>
            <input type="date" class="form-control" id="datesold" value="{{  toInputDate($job->date_sold) }}">
        </div>
        </div>

        @can('read-job')
        <div class="row">
        <div class="form-group col-md-2">
            <label for="size">Size</label>
            <input type="text" class="form-control" id="size" value="{{$job->size}}" placeholder="Size">
        </div>
        <div class="form-group col-md-2">
            <label for="sqftprice">SQ. FT. Price</label>
            <input type="text" class="form-control" id="sqftprice" value="{{$job->sqft_price}}" placeholder="SQ. FT. Price">
        </div>
        <div class="form-group col-md-3">
            <label for="proposalamount">Proposal Amount</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="text" class="form-control"  id="proposalamount" value="{{$job->proposal_amount}}" aria-label="Amount">
            </div>
        </div>

        <div class="form-group col-md-3">
            <label for="invoicedamount">Amount Invoiced</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="text" class="form-control"  id="invoicedamount" value="{{$job->invoiced_amount}}" aria-label="Amount">
            </div>
        </div>
        </div>
        @endcan

        <?php $count = 0; ?>

        <div class="row"> 
        @foreach($job->features as $feat) 
            @if($count % 6 == 0)
                </div><div class="row">
            @endif
            @if( $count++ ) @endif
            <div class="form-group col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="feats" value="{{ $feat->id }}"  {{ isChecked($feat->pivot->active) }} > {{ $feat->name }}
                </label>
            </div>
        @endforeach
        </div> <!-- END FEATURES 2-->
        <div id="stylesgroups">
            @foreach($job->stylegroups as $stylegroup)
                @foreach($stylegroup->styles as $style)
                    <div id="jobstyles">
                    <div class="row stylegroup" data-styleid = "{{ $style->id }}">
                    <div class="row inner-row" >
                    <div class="form-group col-md-2">
                        <label for="paverstyle">Paver Style</label>
                        <input type="text" class="form-control" name="paverstyle" id="paverstyle" value="{{ $style->style }}" placeholder="Paver Style">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="manufacturer">Paver Manufacturer</label>
                        <input type="text" class="form-control" name="manufacturer" id="manufacturer" value="{{ $style->manufacturer }}" placeholder="Paver Manufacturer">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pavercolor">Paver Color</label>
                        <input type="text" class="form-control" name="pavercolor"  id="pavercolor" value="{{ $style->color }}" placeholder="Paver Color">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="paversize">Paver Size</label>
                        <input type="text" class="form-control" name="paversize"  id="paversize" value="{{ $style->size }}" placeholder="Paver Size">
                    </div>
                    </div>  <!-- /row -->
            @can('read-job')
                    <div class="row inner-row">
                        <div class="form-group col-md-2">
                            <label for="sqft">SQ/FT</label>
                            <input type="text" class="form-control" name="sqft"  id="sqft" value="{{ $style->sqft }}" placeholder="0">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control" name="weight"  id="weight" value="{{ $style->weight }}" placeholder="0">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" name="price"  id="price" value="{{ $style->price }}" placeholder="0.00">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="palets">Palets</label>
                            <input type="text" class="form-control" name="palets"  id="palets" value="{{ $style->palets }}" placeholder="0">
                        </div>
                        <div class="form-group col-md-2 center-box">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="tumbled" name="tumbled" {{ isChecked($style->tumbled) }}>Tumbled
                            </label>
                        </div>
                    </div>
                </div>
            @endcan
            </div>
            @can('edit-job')
            <div class="row row-extra-pad">
                <button type="button" class="btn btn-primary btn-xs anotherstyle" id="anotherstyle">Another Style</button>
            </div>
            @endcan
                    @endforeach <!-- / styles -->
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="portland">Number of Portlands</label>
                            <input type="text" class="form-control" name="portland" id="portland" value="{{ $stylegroup->portlands }}" placeholder="0">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="orderedby">Ordered by</label>
                            <input type="text" class="form-control" name="orderedby"  id="orderedby" value="{{ $stylegroup->pavers_orderedby }}" placeholder="Name">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="handledby">Delivery Handled by</label>
                            <input type="text" class="form-control" name="handledby"  id="handledby" value="{{ $stylegroup->pavers_handledby }}" placeholder="Name">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="delivered">Delivery Date</label>
                            <input type="date" class="form-control" name="delivered"  id="delivered" value="{{ toInputDate($stylegroup->delivery_at) }}" placeholder="mm/dd/yyyy">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="placementnote">Notes for placement pavers</label>
                            <textarea class="form-control" id="placementnote" >{{ $stylegroup->delivery_note }}</textarea>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="delivered">Manufacturer</label>
                            <input type="text" class="form-control" name="manu"  id="manu" value="{{ $stylegroup->manufacturer }}" placeholder="name">
                        </div>
                    </div>
                {{-- todo: add style group button--}}
            @endforeach  <!-- / stylegroups -->
        </div>


        <div class="row">
            <div class="form-group col-md-3">
                <label for="crew">Crew</label>
                <input type="text" class="form-control" name="crew"  id="crew" value="{{ $job->crew }}" placeholder="Name">
            </div>
            <div class="form-group col-md-2 center-box">
                <label class="checkbox-inline">
                    <input type="checkbox" id="downpayment" name="downpayment" {{ isChecked($job->downpayment_done) }}>Down payment
                </label>
            </div>

        </div> <!--  -->

        <div class="row">
            <div class="form-group col-md-12 note-form">
                <label>Removals </label>
                <div class="list-group" id="removals" name="removals">
                    @foreach($job->removals as $removal)
                            <input type="text" class="form-control inline-control" name="removal"  data-removalid="{{ $removal->id  }}"
                                   value="{{ $removal->name }}" placeholder="removal..."
                            >
                    @endforeach
                    @can('edit-job')<button type="button" class="btn btn-primary " id="addremoval">Add </button>@endcan
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
             <div class="row">
                <div class="form-group">
                <label>Todo list</label>
                </div>
             </div>
            <div class="row">
                <div class="form-group col-md-4">
                <label class="checkbox-inline">
                    <input type="checkbox" id="paversordered" {{ isChecked($job->pavers_ordered) }} value="paversOrdered">Pavers Ordered
                </label>
                </div>
                <div class="form-group col-md-4">
                <label class="checkbox-inline">
                    <input type="checkbox" id="prelien"  {{ isChecked($job->prelien) }} value="prelien">Pre-Lien
                </label>
                </div>
                <div class="form-group col-md-4">
                <label class="checkbox-inline">
                    <input type="checkbox" id="bluestakes" {{ isChecked($job->bluestakes) }}  value="bluestakes">Bluestakes
                </label>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 note-form">
                    <label>Notes</label>
                    <div class="list-group" id="notes" name="notes">
                        @foreach($job->notes as $note)
                             <a href="#" class="list-group-item active">
                                 <button type="button" class="delete-note" data-noteid="{{ $note->id }}"><span aria-hidden="true">&times;</span></button>
                                <h4 class="list-group-item-heading">{{ $note->note }}</h4>
                                <p class="list-group-item-text">Created on: {{ toFormatted($note->created_at) }}</p>
                              </a>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="row row-extra-bm-pad">
                <div class="col-md-12">
                    @can('edit-job')
                <div class="input-group">
                  <span class="input-group-addon" id="jobnotelb">+</span>
                  <input type="text" id="jobnote" class="form-control jobnote" data-job-id="{{ $job->id }}"  placeholder="Add a note" aria-describedby="jobnotelb">
                </div>
                    @endcan
               </div>
            </div><!-- /.row -->
        </div>

        </div>

        <div class="row row-extra-pad">
            <input type="hidden" id="jobid" value="{{$job->id}}" />
            @can('edit-job')
            <button type="button" class="btn btn-primary updatejob" name="updatejob">Save</button>
            @endcan
        </div>

    </form>
    <div id="pdfviewer"></div>
</div>
    @endforeach
@endcan
    @include('partials.modals')
    @include('partials.confirmdlg')
@stop
