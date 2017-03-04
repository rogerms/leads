@extends('layouts.master')

@section('title', 'Update Selection Lists')

@section('content')
<div class="container">
    @include('partials.feedback')

<div class="row">
    <form class="form-inline" action="">
        <div class="row row-extra-bm-pad">
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

    </div>

    <div class="row row-extra-pad">

    {{--property_types--}}
    <div class="col-sm-4">
        <div class="row">
            <h4>Property Type</h4>
        </div>
        @foreach($property_types as $property_type)
            <div class="row update-row">
                <div class="form-group">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name" value="{{ $property_type->name }}">
                </div>
                <button type="button" id="{{ $property_type->id  }}" class="btn btn-default update-lists" data-type="property_types">Update</button>
            </div>
        @endforeach
        <div class="row reps-add">
            <div class="form-group">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control" id="name"  placeholder="type">
            </div>
            <button type="button" id="0" class="btn btn-info update-lists" data-type="property_types">Add</button>
        </div>
    </div>
        <div class="col-sm-4">
            <div class="row">
                <h4>Customer Type</h4>
            </div>
            @foreach($customer_types as $customer_type)
                <div class="row update-row">
                    <div class="form-group">
                        <label class="sr-only" for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $customer_type->name }}">
                    </div>
                    <button type="button" id="{{ $customer_type->id  }}" class="btn btn-default update-lists" data-type="customer_types">Update</button>
                </div>
            @endforeach
            <div class="row reps-add">
                <div class="form-group">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name"  placeholder="type">
                </div>
                <button type="button" id="0" class="btn btn-info update-lists" data-type="customer_types">Add</button>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="row">
                <h4>Job Type</h4>
            </div>
            @foreach($job_types as $job_type)
                <div class="row update-row">
                    <div class="form-group">
                        <label class="sr-only" for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $job_type->name }}">
                    </div>
                    <button type="button" id="{{ $job_type->id  }}" class="btn btn-default update-lists" data-type="job_types">Update</button>
                </div>
            @endforeach
            <div class="row reps-add">
                <div class="form-group">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name"  placeholder="type">
                </div>
                <button type="button" id="0" class="btn btn-info update-lists" data-type="job_types">Add</button>
            </div>
        </div>
        </div>
        <div class="col-sm-4">
            <div class="row">
                <h4>Job Features</h4>
            </div>
            @foreach($features as $feature)
                <div class="row update-row">
                    <div class="form-group">
                        <label class="sr-only" for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $feature->name }}">
                    </div>
                    <button type="button" id="{{ $feature->id  }}" class="btn btn-default update-lists" data-type="feature">Update</button>
                </div>
            @endforeach
            {{--<div class="row features-add">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="sr-only" for="name">Name</label>--}}
                    {{--<input type="text" class="form-control" id="name"  placeholder="feature">--}}
                {{--</div>--}}
                {{--<button type="button" id="0" class="btn btn-info update-lists" data-type="feature">Add</button>--}}
            {{--</div>--}}
        </div>

        {{--statuses--}}
        <div class="col-sm-6 row-extra-bm-pad">
            <div class="row">
                <h4>Status</h4>
            </div>
            <div class="row">
            <ul class="sortable">
            @foreach($statuses as $status)
                <li class="ui-state-default" id="status_{{$status->id}}"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                <div class="row update-row">
                    <div class="form-group">
                        <label class="sr-only" for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $status->name }}">
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label class="sr-only" for="order">Display Order</label>--}}
                        {{--<input type="text" class="form-control" id="order" value="{{ $status->display_order }}" placeholder="display order">--}}
                    {{--</div>--}}
                    <button type="button" id="{{ $status->id }}" class="btn btn-default update-lists" data-type="status">Update</button>
                </div>
                </li>
            @endforeach
            </ul>
            </div>
            <div class="row reps-add" style="padding-left: 16px;">
                <div class="form-group">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name"  placeholder="Alive">
                </div>
                {{--<div class="form-group">--}}
                    {{--<label class="sr-only" for="order">Display Order</label>--}}
                    {{--<input type="text" class="form-control" id="order" placeholder="display order">--}}
                {{--</div>--}}
                <button type="button" id="0" class="btn btn-info update-lists" data-type="status">Add</button>
            </div>
        </div>
</form>
</div>
</div>
@endsection
