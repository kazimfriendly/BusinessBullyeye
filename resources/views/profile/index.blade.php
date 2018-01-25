@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >


            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title " style="display: inline">{{$user->name}}</h3>
                    <small class=" pull-right "><b>Join at</b> :{{$user->created_at }} </small>
                </div>
                <div class="panel-body">
                    <div class="row">
                        @php
                        $url = Storage::disk('public')->url($user->avatar);
                        $path = public_path($url);
                        
                        @endphp
                        <div class="col-md-3 col-lg-3 " align="center"> 
                            <img width="150px" height="150px" alt="User Pic" src="{{asset('../storage/app/public/'.$user->avatar)}}" class=" img-responsive">
                               
                            
                        </div>

                        <div class=" col-md-9 col-lg-9 "> 
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>Full Name:</td>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>About</td>
                                        <td>{{$user->description}}</td>
                                    </tr>


                                </tbody>
                            </table>

                            <!--<a href="#" class="btn btn-primary">Active Packages</a>-->
                            <!--<a href="#" class="btn btn-primary">Active Clients</a>-->
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <!--<a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>-->
                    <span class="pull-right">
                        @if($user->id == \Auth::user()->id || Auth::user()->isAdmin())
                        <a href="{{url('profile/edit/'.$user->id)}}" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                        <!--<a href="{{url("user/destroy/".$user->id)}}" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>-->
                        @endif
                    </span>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>





    </div>
    <!-- includes here-->

</div>


@endsection

@section('heading')
User <small>Profile</small>
@endsection

@section('title')
Profile
@endsection

@section('css')
<style>
    .user-row {
        margin-bottom: 14px;
    }

    .user-row:last-child {
        margin-bottom: 0;
    }

    .dropdown-user {
        margin: 13px 0;
        padding: 5px;
        height: 100%;
    }

    .dropdown-user:hover {
        cursor: pointer;
    }

    .table-user-information > tbody > tr {
        border-top: 1px solid rgb(221, 221, 221);
    }

    .table-user-information > tbody > tr:first-child {
        border-top: 0;
    }


    .table-user-information > tbody > tr > td {
        border-top: 0;
    }
    .toppad
    {margin-top:20px;
    }
</style>
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">


@endsection
