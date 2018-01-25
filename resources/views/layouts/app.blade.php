<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Business BullsEye ') }} - @yield('title')</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
            ]) !!};
        </script>
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="{{ asset('css/plugins/morris.css') }}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link href="{{ asset('css/custom.css?v='.time()) }}" rel="stylesheet">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        @yield('css')

    </head>
    <body>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/home') }}"><img src="{{ url('/') }}/images/logo.png" /></a>
                        <!--{{ config('app.name', 'Laravel') }}-->
                </div>

                
                @if (!Auth::guest())                                
                    <div class="welcome_user">Welcome <strong>{{ Auth::user()->name }},</strong></div>
                @endif
                
                <?php
                $request = request();
                $uri = $request->path();
                $uri_part = explode('/',$uri);
                ?>


                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <!--<li><a href="{{ route('register') }}">Register</a></li>-->
                    @else
                    <li class="dropdown {{ ($uri_part[0] == 'profile') ? 'active' : '' }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li class="{{ ($uri_part[0] == 'profile' && $uri_part[1] != 'edit') ? 'active' : '' }}"><a href="{{url('profile/'.Auth::user()->id)}}"> <i class="fa fa-fw fa-file"></i> Profile</a></li>
                            <li class="{{ ($uri_part[0] == 'profile' && $uri_part[1] == 'edit') ? 'active' : '' }}"><a href="{{url('profile/edit/'.Auth::user()->id)}}"> <i class="fa fa-fw fa-shield"></i> Settings</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                    <i class="fa fa-fw fa-power-off"></i>    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endif

                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">                    
                        @if (!Auth::guest())
                        @if(Auth::user()->isCoach() )
                        <li class="{{ ($uri == 'home') ? 'active' : '' }}">
                            <a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        @endif
                        @if (Auth::user())
                        @if (Auth::user()->isAdmin())
                        <li class="{{ ($uri == 'modules' || $uri_part[0] == 'modules') ? 'active' : '' }}">
                            <a href="{{ url('/modules') }}"><i class="fa fa-fw fa-bar-chart-o"></i> Modules</a>
                        </li>
                        <li class="{{ ($uri == 'packages' || $uri_part[0] == 'packages') ? 'active' : '' }}">
                            <a href="{{ url('/packages') }}"><i class="fa fa-fw fa-table"></i> Packages</a>
                        </li>
                        <li class="{{ ($uri == 'clients') ? 'active' : '' }}">
                            <a href="{{ url('/clients') }}"><i class="fa fa-fw fa-users"></i> Clients</a>
                        </li>
                        <li class="{{ ($uri == 'coaches') ? 'active' : '' }}">
                            <a href="{{ url('/coaches') }}"><i class="fa fa-fw fa-user-md"></i> Coaches</a>
                        </li>
                        <!--                        <li role="separator" class="divider">
                        
                                                </li>-->
                        
                        <li class="dropdown {{ ($uri == 'register') ? 'active' : '' }}">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" ><!-- data-toggle="collapse" data-target="#demo" --><i class="fa fa-fw fa-power-off"></i> Administration <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul class="dropdown-menu"> <!--id="demo" class="collapse"-->
                                <li>
                                    <a href="{{ url('/register') }}">Add Admin User</a>
                                </li>                                
                            </ul>
                        </li>
                         <li class="dropdown {{ ($uri == 'active_packages' || $uri == 'clients/active_packages' || $uri == 'coaches/active_packages' || $uri_part[0] == 'assigned') ? 'active' : '' }}">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" ><!-- data-toggle="collapse" data-target="#demo" --><i class="fa fa-fw fa-database"></i> Active Packages <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul class="dropdown-menu"> <!--id="demo" class="collapse"-->
                                <li>
                                    <a href="{{ url('/clients/active_packages') }}"><i class="fa fa-fw fa-users"></i> Client</a>
                                </li>  
                                <li>
                                    <a href="{{ url('/coaches/active_packages') }}"><i class="fa fa-fw fa-headphones"></i> Coaches</a>
                                </li> 
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->isClient() && !Auth::user()->isAdmin() )
                        <li class="{{ ($uri == 'clients/active_packages' || substr($uri,0,8) == 'assigned') ? 'active' : '' }}">
                            <a href="{{ url('/clients/active_packages') }}"><i class="fa fa-fw fa-database"></i> Active Packages</a>
                        </li>
                        @endif
                        @if(Auth::user()->isCoach() )
                        <li class="{{ ($uri == 'modules' || $uri_part[0] == 'modules') ? 'active' : '' }}">
                            <a href="{{ url('/modules') }}"><i class="fa fa-fw fa-bar-chart-o"></i> Modules</a>
                        </li>
                        <li class="{{ ($uri == 'packages' || $uri_part[0] == 'packages') ? 'active' : '' }}">
                            <a href="{{ url('/packages') }}"><i class="fa fa-fw fa-table"></i> Packages</a>
                        </li>
                         <li class="{{ ($uri == 'clients') ? 'active' : '' }}">
                            <a href="{{ url('/clients') }}"><i class="fa fa-fw fa-users"></i> Clients</a>
                        </li>
                        <li class="{{ ($uri == 'coaches/active_packages' || substr($uri,0,8) == 'assigned') ? 'active' : '' }}">
                            <a href="{{ url('/coaches/active_packages') }}"><i class="fa fa-fw fa-database"></i> Active Packages</a>
                        </li>
                        @endif
                        <!--
                        <li class="active">
                            <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                        </li>-->
                        <!--                    <li>
                                                <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> Amin</a>
                                            </li>-->
                        
                      @endif
                     @endif
                    </ul>

                </div>
                <!-- /.navbar-collapse -->
            </nav>

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                            @if (!Auth::guest())                                

                            <h1 class="page-header">
                                @yield('heading')
                            </h1>

                            
                            {{-- <ol class="breadcrumb">
                                <li>
                                    <i class="fa fa-dashboard"></i>  <a href="{{ url('/home') }}">Dashboard</a>
                                </li>
                                <li class="active">
                                    <i class="fa fa-file"></i> @yield('breadcrumbs')
                                </li>
                            </ol> --}}
                            
                            @endif
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12"> 

                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="{{asset('js/jquery.js')}}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <!-- Scripts -->
        <script src="{{asset('js/bootstrap-notify.min.js')}}"></script>
        <script src="{{asset('js/config.js')}}"></script>
        <script src="{{asset('js/bootbox.min.js')}}"></script>

        @yield('script')
    </body>
</html>
