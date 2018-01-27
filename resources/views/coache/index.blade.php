@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-12 ">
            <button id="btn_add_coach" name="btn_add_coach" class="btn btn-secondary pull-right" >New Coach</button>
            @if ($message = Session::get('success'))
            <div class="success-notification" message="{{ $message }}">
            </div>

            @endif

            <!--Clients Order by Packages-->
            <div class="panel-body"> 

                <table class="table">
                    <thead>
                        <tr>
                            <!--<th style="width: 100px;"></th>-->
                            <th>Name </th>
                            <!--<th> </th>
                            <th> </th>-->
                        </tr>
                    </thead>
                    <tbody id="coach-list" name="coach-list">
                        @foreach ($coaches as $coach)
                        <tr id="coache_{{$coach->id}}" class="coaches_coach">
                            <!--<td>C</td>-->
                            <td><strong>[{{($coach->status==2)?'Coach':'Admin'}}]</strong> {{$coach->email}}</td>
                            <td><button class="btn btn-success viewpackages" value="{{$coach->id}}" title="Show Modules"><i class="fa fa-caret-square-o-down" ></i> Show Packages</button>

                                <form enctype='multipart/form-data' class="form-inline" role="form" method="POST"  id="deleteForm_{{$coach->id}}" action="{{ url("coaches/".$coach->id) }} " style="display: inline;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-danger btn-delete delete-coach " value="{{$coach->email}}" id="delete_coach_{{$coach->id}}"  title="Delete">
                                        <i class="fa fa-remove" ></i></button>
                                    <!--<input type="hidden" name="coache_id" value="{{$coach->id}}" />-->

                                </form>

                            </td>
                            <!--<td></td>-->
                        </tr>
                        @php
                        $pack =$collection->where('role_id', \App\role::coache())->where('user_id',$coach->id)->unique("package_id")->pluck("package_id");
                        $packages= \App\package::whereIn("id",$pack)->get();
                        @endphp

                        @foreach ($packages as $package)
                        @if($loop->index == 0)
                        <tr id="packmodule_{{$coach->id}}" class="coach_packages"><td colspan="3">                 
                                <table class="table">
                                    <tbody id="clients-list" name="clients-list">                            
                                        @endif
                                        <tr class="coaches_pkg">
                                            <!--<td></td>-->
                                            <td>&nbsp;&nbsp;&nbsp; <strong>[Package]</strong> &nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;{{$package->title}}
                                                <div class="pull-right">  
                                                    @php
                                                    $checked = ($collection->where('role_id', \App\role::coache())->where('user_id',$coach->id)->where("package_id",$package->id)->first()->status == 5)? 'checked':'';
                                                    @endphp
                                                    <form enctype='multipart/form-data' class="form-inline" role="form" method="POST" style="display: inline;"  id="statusPackage_{{$package->id}}" action="{{ url('coaches/status') }}">
                                                        {{ csrf_field() }}
                                                        <input type="checkbox" id="status_package_{{$package->id}}" name="status" {{$checked}} > Disable
                                                        <input type="hidden" id="coach_id" name="coach_id" value="{{$coach->id}}">
                                                        <input type="hidden" id="package_id" name="package_id" value="{{$package->id}}">
                                                        
                                                         
                                                    </form>
                                                </div>

                                            </td>  
                                        </tr>
                                        @foreach ($package->selected_modules as $module)
                                        <tr class="coaches_pkg_module">
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>[Module]</strong> &nbsp;&nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;{{$module->title}}</td>  
                                        </tr>
                                        @endforeach


                                        @if($loop->count+1 == $loop->last)
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!--       incluides here-->
        @include('modals.add_coach')
    </div>

</div>

@endsection

@section('heading')
Coaches <!--<small>management</small>-->
@endsection

@section('title')
Coaches
@endsection

@section('script')
@parent
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/coaches.js')}}"></script>
<script>
$(document).ready(function () {
    console.log("ready!");
    $('[id^=packmodule_]').hide();
});
$(document).on('click', '.viewpackages', function (e) {
    var package_id = $(this).val();
    $('[id^=packmodule_' + package_id + ']').toggle();
});
$(document).on('click', '[id^=delete_coach_]', function () {
    delbtn = $(this);
    bootbox.confirm({
        title: "Delete Coach?",
        message: "Are you sure to delete <b>" + delbtn.val() + "</b> ?  it will delete all related packages and discussions",
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
                console.log(result);
                console.log(delbtn.val());

                delbtn.parents('form').submit();

            }
        }
    });
//    return result; //you can just return c because it will be true or false
});

$(document).on('click', '[id^=status_package_]', function (e) {
    delbtn = $(this);
    if (this.checked) {
        bootbox.confirm({
            title: "Disable Package?",
            message: "Are you sure to disable package?  It will no more accessable from client and coach.",
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
                    console.log(result);
                    console.log(delbtn.val());

                    delbtn.parents('form').submit();

                } else {
                    delbtn.prop('checked', false);
                }
            }
        });
//    return result; //you can just return c because it will be true or false+
    }
    else
    {
     delbtn.parents('form').submit();
    }
});
</script>
@endsection