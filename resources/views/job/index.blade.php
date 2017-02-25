       <!-- #7D1935
#4A96AD
#F5F3EE
#FFFFFF -->
@extends('layouts.master')

@section('title', 'All Jobs')

@section('content')
    <div class="container">
        @include('partials.feedback')
    </div>
    {{--<div>--}}
    {{--<div class="form-group ">--}}
    {{--<label for="searchtext">Search</label>--}}
    {{--<input type="search" class="form-control" id="searchtx" placeholder="Enter text to search">--}}
    {{--</div>--}}
    {{--<button type="button" id="searchbt" class="btn btn-default">Search</button>--}}
    {{--@can('edit')--}}
    {{--<button type="submit" class="btn btn-info" id="createbt">Create New Lead</button>--}}
    {{--@endcan--}}
    {{--</div>--}}

    <div class="fullscreen-container">
        <div class="row row-sidebar row-offcanvas row-offcanvas-right" style="min-height:100vh;">
            <div class="col-xs-10" style="overflow-x: auto; min-height: 90vh" >
                <p class="pull-right visible-xs">
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle bar</button>
                </p>
                <div id="table-holder">
                    <table  class="table table-striped table-hover table-bordered" id="jobstb">
                        <thead>
                        <tr>
                            <th style="min-width:100px">Progress</th>
                            <th style="min-width:80px">ID</th>
                            <th style="min-width:80px">Job#</th>
                            <th style="min-width:280px">Customer Name</th>
                            <th style="min-width:70px">Date Sold</th>
                            <th style="min-width:120px">City</th>
                            <th style="min-width:70px">Rep</th>
                            <th style="min-width:50px">S/F</th>
                            <th style="min-width:100px">Pavers</th>
                            <th style="min-width:70px">RB</th>
                            <th style="min-width:70px">Sand</th>
                            <th style="min-width:70px">Start Date</th>
                            <th style="min-width:70px">Skid</th>
                            <th style="min-width:70px">Crew</th>
                            <th style="min-width:400px">Notes</th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                    <div class="jobs-pagelinks"></div>
            </div>
            <div class="col-xs-2 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                                            {{--jobs progress--}}
                <a href="#" class="list-group-item list-header">Jobs Progress <span class="badge" id="labels_count_total"></span></a>
                @foreach($labels_count as $label)
                    <a  class="list-group-item thin-item">
                        <input class="jobtbfilter" type="checkbox" name="labels_count" value="{{ $label->name  }}" aria-label="labels">
                        {{ $label->name }}
                        <span class="badge">{{ $label->count }}</span>
                    </a>
                @endforeach

            </div>
        </div><!--/.sidebar-offcanvas-->

        </div>
    </div>
    {{--{!! $leads->render() !!}--}}
@endsection
<!-- #7D1935
#4A96AD
#F5F3EE
#FFFFFF -->
