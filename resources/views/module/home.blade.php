

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <button id="btn_add" name="btn_add" class="btn btn-default pull-right">Add New Module</button>
            <div class="panel-body"> 
       <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <!--<th>Details</th>-->
            <th>Actions</th>
          </tr>
         </thead>
         <tbody id="modules-list" name="modules-list">
           @foreach ($modules as $module)
            <tr id="module{{$module->id}}">
             <td>{{$module->id}}</td>
             <td>{{$module->title}}</td>
             <!--<td>{{$module->description}}</td>-->
              <td>
              <button class="btn btn-warning btn-detail open_modal" value="{{$module->id}}">Edit</button>
              <button class="btn btn-danger btn-delete delete-module" value="{{$module->id}}">Delete</button>
              </td>
            </tr>
            @endforeach
        </tbody>
        </table>
       </div>
       </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Product</h4>
            </div>
            <div class="modal-body">
            <form id="frmModules" name="frmModules" class="form-horizontal" novalidate="">
                <div class="form-group error">
                 <label for="inputName" class="col-sm-3 control-label">Title</label>
                   <div class="col-sm-9">
                    <input type="text" class="form-control has-error" id="title" name="title" placeholder="Module title" value="">
                   </div>
                   </div>
                 <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="description" name="description" placeholder="description" value="">
                    </div>
                </div>
                
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Content</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="content" name="content" placeholder="content" value="">
                    </div>
                </div>
                
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
            <input type="hidden" id="module_id" name="module_id" value="0">
            </div>
        </div>
      </div>
  </div>
</div>
   
       
@endsection

@section('heading')
Modules <!--<small>management</small>-->
@endsection

@section('title')
Modules
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/module-script.js')}}"></script>
@endsection
