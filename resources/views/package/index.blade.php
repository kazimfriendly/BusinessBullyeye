

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-12 ">
            <a href="{{url('packages/add')}}"id="btn_add" name="btn_add" class="btn btn-default pull-right">New Package</a>



            <!--Clients Order by Packages-->
            <div class="panel-body"> 


                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Clients</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="package-list" name="package-list">
                        @foreach ($packages as $package)
                        <tr id="package_{{$package->id}}">
                            <td>{{$package->title}}</td>
                            <td>{{$package->price}}</td>
                            <td id="clients_{{$package->id}}">{{$package->linked_clients->unique('user_id')->count() }}</td>
                            <td>
                                @php
                                    $checked = ($package->status == 1)? 'checked':'';
                                @endphp
                                <form enctype='multipart/form-data' class="form-inline" role="form" method="POST" style="display: inline;"  id="statusPackage_{{$package->id}}" action="{{ url('packages/status/'.$package->id) }}">
                                    {{ csrf_field() }}
                                    <input type="checkbox" id="status_package_{{$package->id}}" name="status" {{$checked}} >Off Client Reply 
                                </form></td>
                            <td>
                                <div class="dropup">
                                    <button class="btn btn-danger btn-detail dropdown-toggle pull-left dropdownMenu1" value="{{$package->id}}"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="Add Client"><i class="fa fa-user" ></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li ><a class="add_client" data-value="{{$package->id}}" href="#">Add Existing Client</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a class="new_client" data-value="{{$package->id}}" href="#">Add New Client</a></li>
                                    </ul>
                                </div>&nbsp;
                                @can('assignCoach', $package)
                                <a href="{{url("/packages/assign_coach/".$package->id)}}" class="btn btn-success btn-detail assign_coach" value="{{$package->id}}" title="Assign Coach"><i class="fa fa-user-md" ></i></a>
                                @endcan
                                @can('edit', $package)
                                <button class="btn btn-secondary btn-detail edit_package" value="{{$package->id}}" title="Edit"><i class="fa fa-edit" ></i></button>
                                @elsecan('view', $package)
                                <button class="btn btn-secondary btn-detail view_package" value="{{$package->id}}" title="View"><i class="fa fa-video-camera" ></i></button>
                                @endcan
                                <button class="btn btn-warning linked_client" value="{{$package->id}}"  title="Linked Client"><i class="fa fa-group"></i></button>
                                <!--<button class="btn btn-success preview_package" value="{{$package->id}}" title="Preview"><i class="fa fa-search" ></i></button>-->
                                @can('edit', $package)
                                <form enctype='multipart/form-data' class="form-inline" role="form" method="POST" style="display: inline;"  id="copyPackage_{{$package->id}}" action="{{ url('packages/make_copy/'.$package->id) }}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary btn-delete copy_package" id="copy_package_{{$package->id}}" value="{{$package->id}}" title="Copy"><i class="fa fa-copy" ></i></button>
                                </form>
                                
                                <form enctype='multipart/form-data' class="form-inline" style="display:inline" role="form" method="POST"  id="deleteForm_{{$package->id}}" action="{{ url("packages/".$package->id) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger btn-delete delete-package " value="{{$package->id}}" id="delete_package_{{$package->id}}"  title="Delete">
                                        <i class="fa fa-remove" ></i></button>
                                    <input type="hidden" name="package_id" value="{{$package->id}}" />

                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>




        </div>
       
        @include('modals.add_client')
        @include('modals.linked_clients')
        
    </div>






</div>




@endsection

@section('heading')
Packages <!--<small>management</small>-->
@endsection

@section('title')
Packages
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
<script src="{{asset('js/package.js')}}"></script>

@endsection
