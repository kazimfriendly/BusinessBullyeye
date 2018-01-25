@extends('layouts.app')
@section('content')
<div class="">
    <div class="row">
        <div class="col-md-11 ">

            <form id="frmPackage" name="frmPackage" class="form-horizontal" method="POST" >
                <div class="modal-body">

                    <div class="form-group error">
                        <label for="inputName" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <div class="well well-sm">{{$package->title}}</div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <div class="well well-lg">{!!str_replace('../', '../../', $package->description)!!}</div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Price</label>
                        <div class="col-sm-9">
                            <div class="well well-sm">{{$package->price}}</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Payment Currency </label>
                        <div class="col-sm-9">
                            <div class="well well-sm">{{$package->currency}}</div>             

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Payment Frequency </label>
                        <div class="col-sm-9">
                            <div class="well well-sm">{{$package->paymnent_frequency}}</div>
                           
                        </div>
                    </div>

                    <!--<div class="form-group">
                        <label for="input-payment_frequency" class="col-sm-3 control-label">Module Release Schedule </label>
                        <div class="col-sm-9">
                         <div class="well well-sm">{{$package->release_schedule}}</div>
                           
                        </div>
                    </div>--> 

                    <div class="form-group error">
                        <label for="facebook_group" class="col-sm-3 control-label"><i class="fa fa-facebook-square"></i>Facebook Group</label>
                        <div class="col-sm-9">
                        <div class="well well-sm">{{$package->facebook_group}}</div>   
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-available_modules" class="col-sm-3 control-label"> Modules </label>
                        <div class="col-sm-9">
                             <ol class="available-modules list-unstyled list-group droptrue " id="available-modules">
                                        @foreach ($package->selected_modules as $module)
                                        <li value="{{ $module->id }}" id="{{ $module->id}}" style="cursor:move" ><i class="fa fa-fw fa-folder"></i>{{ $module->title }}</li>
                                        @endforeach

                                    </ol>
                           
                            <!--<div id="serialize_output2">testing</div>-->

                            <!-- end multi select -->
                        </div>
                    </div>


                   
                </div>
                <div class="modal-footer ">
               
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('css')
@parent
<style>
    .selected {
        background:yellow !important;
    }
    .hidden {
        display:none !important;
    }
    .ui-sortable-placeholder {
        background:greenyellow !important;
    }
</style>
@endsection

@section('script')
@parent

@endsection

@section('heading')
Package <small>view</small>
@endsection

@section('title')
Packages
@endsection

@section('breadcrumbs')
Package
@endsection