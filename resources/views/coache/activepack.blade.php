

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-12 ">
            <!--<button id="btn_add_package" name="btn_add_package" class="btn btn-secondary pull-right" >New Package</button>-->

            <div class="order btn-group btn-group-justified" role="group" aria-label="Order By">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" value='by_client'>Clients</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" value="by_package">Packages</button>
                </div>

            </div>
            <div class="detail">
                <!--Clients Order by Packages-->
                <div class="panel-body order_by_package"> 


                    <table class="table">
                        <thead>
                            <tr>
                                <!--<th style="width: 40px;"></th>-->
                                <th>Name </th>
                                <!--<th>Status </th>-->
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody id="clients-list" name="clients-list">
                            @foreach ($assignments as $assigned)
                            @foreach ($assigned->package()->get() as $package)
                            <tr id="package_{{$package->id}}">
                                <!--<td>+</td>-->
                                <td>{{$package->title}}</td>

                                <td><button class="btn btn-success viewmodules" value="{{$package->id}}" title="Show Modules"><i class="fa fa-arrow-circle-o-down" ></i> Show Modules</button></td>
                            </tr>

                            @foreach($package->selected_modules as $module)

                            @php
                            $clients = $collection->where('coache_id',$assigned->id)
                            ->where('package_id',$package->id)
                            ->where('module_id',$module->id);
                            @endphp

                            
                            @if($loop->index == 0)
                            <tr id="packmodule_{{$package->id}}" class="package_module"><td colspan="3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Selected Package Modules</h3>
                                        </div>
                                        <div class="panel-body">                    

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <!--<th style="width: 40px;"></th>-->
                                                        <th>Name </th>
                                                        <th>Description</th>
                                                        <th width="50">Action</th>                
                                                    </tr>
                                                </thead>
                                                <tbody id="ass-pack-list" name="ass-pack-list">                            
                                                    @endif

                            

                            <tr colspan="3" class="info">
                                <!--<td style="width: 40px;">--</td>-->
                                <td>{{$module->title}}</td>
                                <td>{{strip_tags($module->description)}}</td>
                                @if($clients->count() > 0)
                                <td><button class="btn btn-warning viewclients" value="{{$package->id}}-{{$module->id}}" title="Show Clients"><i class="fa fa-caret-square-o-down" ></i> Show Client</button></td>
                                @else
                                <td><button class="btn btn-warning viewclients disabled" value="{{$package->id}}-{{$module->id}}" title="Show Clients"><i class="fa fa-caret-square-o-down" ></i> Show Client</button></td>
                                @endif
                            </tr>

                            @foreach($clients as $client)

                            @if($loop->index == 0)
                            <tr id="packclient_{{$package->id}}-{{$module->id}}" class="package_module"><td colspan="3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Selected Module Clients</h3>
                                        </div>
                                        <div class="panel-body">                    

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <!--<th style="width: 40px;"></th>-->
                                                        <th>Name </th>
                                                        <th>Status</th>
                                                        <th width="50">Action</th>                
                                                    </tr>
                                                </thead>
                                                <tbody id="ass-pack-list" name="ass-pack-list">                            
                                                    @endif

                            <tr colspan="3" class="success" id="packclient_{{$package->id}}-{{$module->id}}">
                                <!--<td style="width: 40px;">-></td>-->
                                <td>{{$client->user->name}}</td>
                                <td>{{$client->getStatus()}}</td>
                                <td><a class="btn btn-info btn-detail preview_module" href="{{ url('assigned/'.$client->id) }}" title="Preview"><i class="fa fa-search" ></i> View Module</a></td>
                            </tr>

                                                   @if($loop->count+1 == $loop->last)
                                                </tbody>
                                            </table>
                                        </div>
                                </td>
                            </tr>
                            @endif  

                            @endforeach


                                                   @if($loop->count+1 == $loop->last)
                                                </tbody>
                                            </table>
                                        </div>
                                </td>
                            </tr>
                            @endif  

                            @endforeach

                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="order_by_client">
                    <table class="table" id="activeClientstbl">
                        <thead>
                            <tr>
                                <!--<th>ID</th>-->
                                <th>Name</th>
                                <!--<th>Status</th>-->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="client_active" name="client_active">
                            @foreach($collection->whereIn('coache_id',$assignments->pluck('id'))->unique('user_id') as $client)
                            @php
                            $pack_id = $package->id;
                            @endphp
                            <tr>
                                <td>{{$client->user->name}} </td>
                                <td><button class="btn btn-success view_assigned_packages" value="{{$client->user->id.'_'.$pack_id}}" title="Show Packages"><i class="fa fa-caret-square-o-down" ></i> Assigned Packages</button></td> <!--$package->id-->
                            </tr>

                            @foreach($client->getPackages(null,$collection) as $package)
                            @if($loop->index == 0)
                            <tr id="assignedpack_{{$client->user->id.'_'.$pack_id}}" class="active_package"><td colspan="2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Selected Client Packages</h3>
                                        </div>
                                        <div class="panel-body">                    

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <!--<th style="width: 40px;"></th>-->
                                                        <th>Name </th>
                                                        <th>Description</th>
                                                        <!--<th>Status</th>-->
                                                        <th width="50">Action</th>                
                                                    </tr>
                                                </thead>
                                                <tbody id="ass-pack-list" name="ass-pack-list">                            
                                                    @endif


                            <tr class="info">
                                <td>{{$package->title}} </td>
                                <td>{{strip_tags($package->description)}} </td>
                                <!--<td>&nbsp;</td>-->     
                                <td><button class="btn btn-success viewpackagemodules" value="{{$client->user->id.'_'.$package->id}}" title="Show Packages"><i class="fa fa-caret-square-o-down" ></i> Assigned Modules</button></td>
                            </tr>   
                            @foreach($package->selected_modules as $module)

                            @if($loop->index == 0)
                            <tr id="pack_modules_{{$client->user->id.'_'.$package->id}}" class="active_modules"><td colspan="4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Selected Client Package Modules</h3>
                                        </div>
                                        <div class="panel-body">                  

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <!--<th style="width: 40px;"></th>-->
                                                        <th>Name </th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th width="50">Action</th>                
                                                    </tr>
                                                </thead>
                                                <tbody>                            
                                                    @endif


                            <tr class="success">
                                <td>{{$module->title}} </td>
                                <td>{{strip_tags($module->description)}} </td>
                                @php
                                $activeModule=$collection->where('module_id',$module->id)->where('package_id',$package->id)->where('user_id',$client->user_id)->first();
                                $isActive=($activeModule == null)?false:true;
                                @endphp
                                <td>
                                    <form enctype='multipart/form-data' class="form-horizontal" role="form" method="POST"  id="statusform_{{$client->user_id}}" action="{{ url('assigned/update_status') }}">
                                        {{ csrf_field() }}
                                        <select class="form-control" name="status" id="module_status_{{$client->user_id}}">

                                            @foreach($client->getAllStatus() as $index=>$status) 
                                            @if($isActive) 
                                            @if($index == $activeModule->status)
                                            <option value="{{$index}}" selected="true">{{$status}}</option>
                                            @else 
                                            <option value="{{$index}}" >{{$status}}</option>   
                                            @endif
                                            @elseif($index == 2)
                                            <option value="{{$index}}" selected="true">{{$status}}</option>
                                            @else 
                                            <option value="{{$index}}" >{{$status}}</option>       
                                            @endif
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="assignment_id" value="{{($isActive) ? $activeModule->id : '0' }}" />
                                        <input type="hidden" name="package_id" value="{{$package->id }}" />
                                        <input type="hidden" name="module_id" value="{{$module->id }}" />
                                        <input type="hidden" name="user_id" value="{{$client->user_id }}" />
                                        
                                    </form>
                                </td>
                                <td>
                                    @if($isActive)
                                    <a class="btn btn-info btn-detail preview_module" href="{{ url('assigned/'.$activeModule->id) }}" title="Preview"><i class="fa fa-search" ></i> View Module</a></td>
                                @endif
                            </tr>   

                                                   @if($loop->count+1 == $loop->last)
                                                </tbody>
                                            </table>
                                        </div>
                                </td>
                            </tr>
                            @endif    
                            @endforeach

                                                   @if($loop->count+1 == $loop->last)
                                                </tbody>
                                            </table>
                                        </div>
                                </td>
                            </tr>
                            @endif                            
                            @endforeach

                            @endforeach
                        </tbody>
                    </table>

                </div>


            </div><!-- end of detail -->



        </div>
        <!--       incluides here-->
    </div>






</div>





@endsection

@section('heading')
&nbsp;<!--Coach <small>management</small>-->
@endsection

@section('title')
Coach
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--<script src="{{asset('js/client.js')}}"></script>-->
<script>
    $(document).ready(function () {
        console.log("ready!");
        $('[id^=packmodule_]').hide();
        $('[id^=packclient_]').hide();


        $('[id^=assignedpack_]').hide();
        $('[id^=pack_modules_]').hide();

        $('.detail div').hide();
        $('.order_by_client').show();
        $('.btn-group .btn:first').addClass("btn-primary");
    });
    $(document).on('click', '.viewmodules', function (e) {
        var package_id = $(this).val();
        $('[id^=packmodule_' + package_id + ']').toggle();
        $('[id^=packmodule_' + package_id + '] div').toggle();
        console.log(package_id);
    });
    $(document).on('click', '.viewclients', function (e) {
        var package_id = $(this).val();
        $('[id^=packclient_' + package_id + ']').toggle();
    });

    $(document).on('click', '.view_assigned_packages', function (e) {
        var user_packageid = $(this).val();
        $('[id^=assignedpack_' + user_packageid + ']').toggle();
        $('[id^=assignedpack_' + user_packageid + '] div').toggle();
    });

    $(document).on('click', '.viewpackagemodules', function (e) {
        var user_packageid = $(this).val();
        $('[id^=pack_modules_' + user_packageid + ']').toggle();

    });
    
    
    $('.btn-group .btn').on('click', function () { // On the click event for each button
        $('.btn-group .btn').removeClass('btn-primary');
        $(this) // get the button being clicked
                .addClass('btn-primary'); // add the `btn-primary` class
//    .siblings('.btn-primary') // get all sibling buttons which may already be selected
//    .removeClass('btn-primary'); // remove the selected class
//        alert($(this).val());

        $('[id^=packmodule_]').hide();
        $('[id^=packclient_]').hide();

        $('[id^=assignedpack_]').hide();
        $('[id^=pack_modules_]').hide();

        $('.detail div').hide();
        $('.order_' + $(this).val()).show();
    });

    $('[id^=module_status]').change(function () {
//        alert("Handler for .change() called.");
        //$('[id^=statusform').submit();
//        $(this).parents('form').submit();
        $selecbox=$(this);
        bootbox.confirm({
        title: "Change Status?",
        message: "Are you sure the changes will be seen on client side.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if (result) {

                $selecbox.parents('form').submit();
            }
        }
    });
        
    });
</script>
@endsection
