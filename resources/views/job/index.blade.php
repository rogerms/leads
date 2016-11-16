@extends('layouts.master')

@section('title', 'All Leads')


@section('content')
    <div class="container">
    <div class="row row-sidebar row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <table  class="table table-striped table-hover table-bordered" id="jobstb">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Job#</th>
                    <th>Customer Name</th>
                    <th>Date Sold</th>
                    <th>City</th>
                    {{--<th>Appointment</th>--}}
                    <th>Sales Rep</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="jobs-pagelinks"></div>
        </div>

    </div>
    </div>
@endsection
            <!-- #7D1935
#4A96AD
#F5F3EE
#FFFFFF -->
