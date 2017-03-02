<!-- Stored in resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Bootstrap -->
    <title>SRP Leads - @yield('title')</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="/images/Logo16x16.png">
    <!-- Custom styles for this template -->
    {{--<link href="/css/offcanvas.css" rel="stylesheet">--}}
</head>
<body>
{!! csrf_field() !!}

      <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Sales Leads</a>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
              <li class="{{ isActive(['/','leads']) }}" id="main"><a href="/">Leads</a></li>
              <li class="{{ isActive(['jobs']) }}" id="main"><a href="/jobs">Jobs</a></li>
           <!-- <li><a href="#about">About</a></li> -->
            {{--<li><a href="#contact">Contact</a></li>--}}
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tools <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li>
                    @can('edit')
                    <a href="/create" id="createbt">Create New Lead</a>
                    @endcan
                </li>
                  @can('edit-user')
                  <li role="separator" class="divider"></li>
                  <li><a href="{{ url('/user/create') }}">Add New User</a></li>
                  <li><a href="{{ url('/reps') }}">Update Reps</a></li>
                  <li><a href="{{ url('/lists') }}">Update Lists</a></li>
                  <li><a href="{{ url('/labels/edit') }}">Manage Labels</a></li>
                  <li><a href="{{ url('/users') }}">List Users</a></li>
                  @endcan

                  @can('admin')
                  <li role="separator" class="divider"></li>
                  <li><a href="{{ url('/gapi') }}">Google Auth</a></li>
                  @endcan

                  <!--  add more actions
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                 -->
              </ul>
            </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      @can('edit-user')
                      <li role="separator" class="divider"></li>
                      <li><a href="{{ url('/report/upload') }}">Upload Job</a></li>
                      <li><a href="{{ url('/report/jobs') }}">Export Jobs</a></li>
                      <li><a href="{{ url('/report/leads') }}">Export Leads</a></li>
                      @if(isset($lead))
                          <li><a href="{{ url('/report/lead/'.$lead->id) }}">Export Lead</a></li>
                          @endif
                      @endcan
                  </ul>
              </li>

          </ul>

            @if(isPage(['/','leads']))
            <!-- search bar -->
            <form class="navbar-form navbar-left" id="searchbar" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchtx" placeholder="Enter text..." aria-label="search">
                    <div class="input-group-btn">
                        <button type="button" id="searchbt" class="btn btn-default" value="Name"><span class="glyphicon glyphicon-search"></span><small id="searchby">Name</small></button>
                        <!-- dropdown for search button -->
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="searchby">Name</a></li>
                            <li><a href="#" class="searchby">Tag</a></li>
                            <li><a href="#" class="searchby">Addr</a></li>
                            <li><a href="#" class="searchby">Job#</a></li>
                            <li><a href="#" class="searchby">Phone</a></li>
                            <li><a href="#" class="searchby">Email</a></li>
                        </ul>
                    </div>
                </div>
            </form>
            <!-- end search bar -->
            @endif

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!--/.nav-collapse    -->
      </div>
    </nav>

    <div class="alert-dlg">The note was deleted successfully</div>

    <!-- Begin page content -->
    {{--<div class="container">--}}

         @yield('content')
    {{--</div>--}}

    <footer class="footer">
      <div class="container">
        <p class="text-muted">Strong Rock Paves LLC.</p>
      </div>
    </footer>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script src='/libs/datepicker/js/bootstrap-datepicker.min.js'></script>
    <script src='/js/bootbox.min.js'></script>

    {{--<script src="/js/jspdf.js"></script>--}}
    {{--<script src="/js/home.js"></script>--}}
    <script src="/js/app.js?v=20170224"></script>

</body>
</html>