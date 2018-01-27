

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-12">
            <!--<button id="btn_add_package" name="btn_add_package" class="btn btn-secondary pull-right" >New Package</button>-->



            <!--Clients Order by Packages-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Packages</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <!--<th style="width: 40px;"></th>-->
                                <th>Name </th>
                                <th>Description</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody id="clients-list" name="clients-list">
                            @foreach ($assignments as $assigned)
                            @foreach ($assigned->package()->get() as $package)
                            <tr id="package_{{$package->id}}">
                                <!--<td>+</td>-->
                                <td>{{$package->title}}</td>
                                <td>{{strip_tags($package->description)}}</td>
                                <td><button class="btn btn-success viewmodules" value="{{$package->id}}" title="Show Modules"><i class="fa fa-caret-square-o-down" ></i> Show Modules</button></td>
                            </tr>

                           @foreach($package->selected_modules as $module)
                            @if($loop->index == 0)
                            <tr id="packmodule_{{$package->id}}" class="active_modules"><td colspan="3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Modules</h3>
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
                                                <tbody id="clients-list" name="clients-list">                            
                                                    @endif

                                                    <tr colspan="3" class="active_modules">
                                                        <!--<td style="width: 40px;">--</td>-->
                                                        <td>{{$module->title}}</td>
                                                        <td>{{strip_tags($module->description)}}</td>
                                                        @php
                                                        $assigned = $collection->where('user_id',Auth::user()->id)
                                                        ->where('package_id',$package->id)
                                                        ->where('role_id',\App\role::client())
                                                        ->where('module_id',$module->id);
                                                        @endphp
                                                        
                                                        
                                                        @if($assigned->count()>0)
                                                        <td class="success">{{$assigned->first()->getStatus()}}</td>
                                                        <td><a class="btn btn-warning btn-detail preview_module" href="{{ url('assigned/'.$assigned->first()->id) }}" title="Preview"><i class="fa fa-search" ></i> View Module</a></td>
                                                        @else
                                                        <td class="danger">Pending</td>
                                                        <td><a class="btn btn-warning btn-detail preview_module disabled" href="#" title="Preview"><i class="fa fa-search" ></i> View Module</a></td>
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

                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <!--       incluides here-->
    </div>
</div>
@endsection

@section('heading')
&nbsp;<!--Client <small>management</small>-->
@endsection

@section('title')
Client
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--<script src="{{asset('js/client.js')}}"></script>-->
<script>
    $(document).ready(function () {
        console.log("ready!");
        $('[id^=packmodule_]').hide();
    });
    $(document).on('click', '.viewmodules', function (e) {
        var package_id = $(this).val();
        $('[id^=packmodule_'+package_id+']').toggle();
    });
</script>
@endsection
