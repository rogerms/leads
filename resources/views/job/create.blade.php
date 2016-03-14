@extends('layouts.master')

@section('title', 'Job Details')

@section('content')
<form>
    <div class="panel-group">
    <div class="row row-extra-pad">
        <h2>New Job</h2>
    </div>
    <div class="row">
    <div class="form-group col-lg-2 col-md-2">
        <label for="jobtype">Job Type </label>
        <select class="form-control" id="jobtype">
         @foreach($job_types as $type)
            <option>{{$type->name}}</option>
          @endforeach
        </select>
    </div>
    <div class="form-group col-lg-2 col-md-2">
        <label for="customertype">Customer Type </label>
        <select class="form-control" id="customertype">
         @foreach($customer_types as $type)
            <option>{{$type->customer_type}}</option>
          @endforeach
        </select>
    </div>
    <div class="form-group col-lg-3 col-md-3">
        <label for="contractor">Contractor</label>
        <input type="text" class="form-control" id="contractor" value="" name="contractor" placeholder="Contractor">
    </div> 
    <div class="form-group col-lg-2 col-md-2">
        <label for="propertytype">Property Type </label>
        <select class="form-control" id="propertytype">
         @foreach($property_types as $type)
            <option>{{$type->property_type}}</option>
          @endforeach
        </select>
    </div>
    <div class="form-group col-lg-3 col-md-3">
        <label for="datesold">Date Sold</label>
        <input type="date" class="form-control" id="datesold" value="">
    </div>
    </div>

    <div class="row">
    <div class="form-group col-lg-2 col-md-2">
        <label for="size">Size</label>
        <input type="text" class="form-control" id="size" value="" placeholder="Size">
    </div>
    <div class="form-group col-lg-2 col-md-2">
        <label for="sqftprice">SQ. FT. Price</label>
        <input type="text" class="form-control" id="sqftprice" value="" placeholder="SQ. FT. Price">
    </div>
    <div class="form-group col-lg-3 col-md-3">
        <label for="proposalamount">Proposal Amount</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" class="form-control"  id="proposalamount" value="" aria-label="Amount">
        </div>
    </div>

    <div class="form-group col-lg-3 col-md-3">
        <label for="invoicedamount">Amount Invoiced</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" class="form-control"  id="invoicedamount" value="" aria-label="Amount">
        </div>
    </div>
    </div>
    <?php $count = 0; ?>
    <div class="row"> 
    @foreach($features as $feat) 
        @if($count % 6 == 0)
            </div><div class="row">
        @endif
        @if( $count++ ) @endif
        <div class="form-group col-lg-2 col-md-2">
            <label class="checkbox-inline">
                <input type="checkbox" name="featurescb"  value="{{ $feat->id }}"  > {{ $feat->name }}
            </label>
        </div>
    @endforeach
    </div> <!-- / FEATURES -->
    <div id="jobstyles">
        <div class="row stylegroup" data-styleid="0">
            <div class="row inner-row" >
                <div class="form-group col-lg-2 col-md-2">
                    <label for="paverstyle">Paver Style</label>
                    <input type="text" class="form-control" name="paverstyle" id="paverstyle" value="" placeholder="Paver Style">
                </div>
                <div class="form-group col-lg-3 col-md-3">
                    <label for="manufacturer">Paver Manufacturer</label>
                    <input type="text" class="form-control" name="manufacturer" id="manufacturer" value="" placeholder="Paver Manufacturer">
                </div>
                <div class="form-group col-lg-3 col-md-3">
                    <label for="pavercolor">Paver Color</label>
                    <input type="text" class="form-control" name="pavercolor"  id="pavercolor" value="" placeholder="Paver Color">
                </div>
                <div class="form-group col-lg-3 col-md-3">
                    <label for="paversize">Paver Size</label>
                    <input type="text" class="form-control" name="paversize"  id="paversize" value="" placeholder="Paver Size">
                </div>
            </div> {{-- / row--}}
            <div class="row inner-row">
                <div class="form-group col-lg-2 col-md-2">
                    <label for="sqft">SQ/FT</label>
                    <input type="text" class="form-control" name="sqft"  id="sqft" value="" placeholder="0">
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <label for="weight">Weight</label>
                    <input type="text" class="form-control" name="weight"  id="weight" value="" placeholder="0">
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price"  id="price" value="" placeholder="0.00">
                </div>
                <div class="form-group col-lg-1 col-md-1">
                    <label for="palets">Palets</label>
                    <input type="text" class="form-control" name="palets"  id="palets" value="" placeholder="0">
                </div>
                <div class="form-group col-lg-2 col-md-2 center-box">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="tumbled" name="tumbled">Tumbled
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-extra-pad">
        <button type="button" class="btn btn-primary btn-xs" id="anotherstyle">Another Style</button>
    </div>

    <div class="row">
        <div class="form-group col-lg-3 col-md-3">
            <label for="portland">Number of Portlands</label>
            <input type="text" class="form-control" name="portland" id="portland" placeholder="0">
        </div>
        <div class="form-group col-lg-3 col-md-3">
            <label for="crew">Crew</label>
            <input type="text" class="form-control" name="crew"  id="crew"  placeholder="Name">
        </div>
        <div class="form-group col-lg-2 col-md-2 center-box">
            <label class="checkbox-inline">
                <input type="checkbox" id="downpayment" name="downpayment">Down payment
            </label>
        </div>
        <div class="form-group col-lg-3 col-md-3">
            <label for="orderedby">Ordered by</label>
            <input type="text" class="form-control" name="orderedby"  id="orderedby" placeholder="Name">
        </div>
        <div class="form-group col-lg-3 col-md-3">
            <label for="handledby">Delivery Handled by</label>
            <input type="text" class="form-control" name="handledby"  id="handledby" placeholder="Name">
        </div>
        <div class="form-group col-lg-2 col-md-2">
            <label for="delivered">Delivery Date</label>
            <input type="date" class="form-control" name="delivered"  id="delivered"  placeholder="mm/dd/yyyy">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <label for="placementnote">Notes for placement pavers</label>
            <textarea class="form-control" id="placementnote" ></textarea>
        </div>
    </div>

    <!-- add removals -->
    <div class="row">
        <div class="form-group col-lg-12 col-md-12 note-form">
            <label>Removals </label>
            <div class="list-group" id="removals" name="removals">
                <input type="text" class="form-control inline-control"
                       name="removal"  data-removalid="0"
                       value="" placeholder="removal...">
                <button type="button" class="btn btn-primary " id="addremoval">Add </button>
            </div>
        </div>
    </div>
    {{-- /add removals --}}

    <div class="row">
        <div class="form-group col-lg-2 col-md-2">
        <label class="checkbox-inline">
            <input type="checkbox"  id="paversordered" value="paversOrdered">Pavers Ordered
        </label>
        </div>
        <div class="form-group col-lg-2 col-md-2">
        <label class="checkbox-inline">
            <input type="checkbox"   id="prelien" value="prelien">Pre-Lien
        </label>
        </div>
        <div class="form-group col-lg-2 col-md-2">
        <label class="checkbox-inline">
            <input type="checkbox" id="bluestakes" value="bluestakes">Bluestakes
        </label>
        </div>
    </div>

    <div class="row row-extra-bm-pad">
        <div class="form-group col-lg-6 col-md-6">
            <label for="paversize">Note</label>
            <textarea class="form-control" id="note" ></textarea>
        </div>
    </div><!-- /.row -->


    <div class="row row-extra-pad">
        <input type="hidden" name="leadid" id="leadid" value="{{ $lead_id }}" />
        <button type="button" class="btn btn-primary" id="createjob">Create</button>
    </div>
    </form>
    </div>
@stop