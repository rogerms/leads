@extends('layouts.master')

@section('title', 'All Leads')


@section('content')
    @include('partials.feedback')

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

  <div class="row row-sidebar row-offcanvas row-offcanvas-right">
      <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
              <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div id="table-holder">
              <table  class="table table-striped table-hover table-bordered" id="leadstb">
                  <thead>
                  <tr>
                      <th>Customer Name</th>
                      <th>Phone</th>
                      <th>Street</th>
                      <th>City</th>
                      <th>Appointment</th>
                      <th>Sales Rep</th>
                      <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                      @include('partials.leads', $leads)
                  </tbody>
              </table>
          </div>
      </div>
      <div class="col-xs-6 col-sm-3 sidebar-offcanvas" style="" id="sidebar">
          <div class="list-group">
              <a href="#" id="statusa" class="list-group-item list-header">Status</a>
              @foreach($status_count as $sta)
              <a class="list-group-item thin-item">
                  <input class="tbfilter" type="checkbox" name="status_count" value="{{ $sta->name }}" aria-label="status">
                  {{ $sta->name }}
                  <span class="badge">{{ $sta->count }}</span>
              </a>
              @endforeach

              <a href="#" class="list-group-item list-header">Sales Rep</a>
              @foreach($reps_count as $rep)
                  <a  class="list-group-item thin-item">
                      <input class="tbfilter" type="checkbox" name="reps_count" value="{{ $rep->name  }}" aria-label="reps">
                      {{ $rep->name }}
                      <span class="badge">{{ $rep->count }}</span>
                  </a>
              @endforeach

              <a  class="list-group-item list-header">Appointment</a>
              <a class="list-group-item thin-item">
                  <input class="tbfilter" type="checkbox" name="today" value="today" aria-label="today">
                  Today
                  <span class="badge">{{ $appts->today }}</span>
              </a>
              <a class="list-group-item thin-item">
                  <input class="tbfilter" type="checkbox" name="tomorrow" value="tomorrow" aria-label="tomorrow">
                  Tomorrow
                  <span class="badge">{{ $appts->tomorrow }}</span>
              </a>
              <a class="list-group-item thin-item">
                  <input class="tbfilter" type="checkbox" name="week" value="week" aria-label="week">
                  Seven Days
                  <span class="badge">{{ $appts->week }}</span>
              </a>

          </div>
      </div><!--/.sidebar-offcanvas-->

  </div>
{!! $leads->render() !!}
@endsection
<!-- #7D1935
#4A96AD
#F5F3EE
#FFFFFF -->