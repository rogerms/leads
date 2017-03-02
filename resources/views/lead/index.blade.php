@extends('layouts.master')

@section('title', 'All Leads')


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
              <table  class="table table-striped table-hover table-bordered" id="leadstb">
                  <thead>
                  <tr>
                      <th style="min-width:100px">Status</th>
                      <th style="min-width:280px">Customer Name</th>
                      <th style="min-width:120px">City</th>
                      <th style="min-width:250px">Address</th>
                      <th style="min-width:130px">Phone</th>
                      <th style="min-width:150px">Appointment</th>
                      <th style="min-width:70px">Rep</th>
                      <!--
                      <th style="min-width:50px">S/F</th>
                      <th style="min-width:100px">Pavers</th>
                      <th style="min-width:70px">RB</th>
                      <th style="min-width:70px">Sand</th>
                      <th style="min-width:70px">Date Sold</th>
                      <th style="min-width:70px">Start Date</th>
                      <th style="min-width:70px">Skid</th>
                      <th style="min-width:70px">Crew</th>
                      <th style="min-width:400px">Notes</th>
                      -->
                  </tr>
                  </thead>
                  <tbody>
                      @include('partials.leads', $leads)
                  </tbody>
              </table>
          </div>
          <div class="pagelinks"></div>
      </div>
      <div class="col-xs-2 sidebar-offcanvas" id="sidebar">
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
                  <span class="badge">0</span>
              </a>
              <a class="list-group-item thin-item">
                  <input class="tbfilter" type="checkbox" name="tomorrow" value="tomorrow" aria-label="tomorrow">
                  Tomorrow
                  <span class="badge">0</span>
              </a>
              <a class="list-group-item thin-item">
                  <input class="tbfilter" type="checkbox" name="week" value="week" aria-label="week">
                  Seven Days
                  <span class="badge">0</span>
              </a>

              {{--leads labels  --}}
              <a href="#" class="list-group-item list-header">Labels</a>
              @foreach($labels_count as $label)
                  <a  class="list-group-item thin-item">
                      <input class="tbfilter" type="checkbox" name="labels_count" value="{{ $label->name  }}" aria-label="labels">
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
