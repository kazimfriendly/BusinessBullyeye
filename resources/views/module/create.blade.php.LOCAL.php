@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 ">
        @php
            if ($state == 'add')
              {
              $module = new \App\module();
              $disabled = "disabled";
              }
              else{
              $disabled ="";
              }
        @endphp
        <div class="panel panel-primary">
            <div class="panel-heading">
                Content
            </div>
            <form id="frmModules" name="frmModules" class="form-horizontal" novalidate="">
                <div class="panel-body">

                    <div class="form-group error">
                        <label for="inputName" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="title" name="title" placeholder="Module title" value="{{$module->title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" name="description" placeholder="description" value="{{$module->description}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Introduction and Guidelines</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="content" name="content" >{{$module->content}}</textarea>
                        </div>
                    </div>


                    <div class="frmModule-footer"></div>
                </div>
                <div class="panel-footer ">

                    <span class="pull-right">
                        <button type="submit" class="btn btn-primary " id="btn-save" value="{{$state}}">Save changes</button>
                        <input type="hidden" id="module_id" name="module_id" value="{{$module->id}}">
                    </span>
                    <div class="clearfix"></div>
                </div>
            </form>

        </div>
        <!-- questions-->

        <div class="panel panel-yellow">
            <div class="panel-heading">
                Questions
            </div>
            <div class="panel-body">
                <div class="panel panel-default ">
                    <!--<div class="panel-heading">
                        List
                    </div>-->
                    <div class="panel-body"> 
                        <!--<button id="btn_add_question" name="btn_add_question" class="btn btn-warning pull-right">New Question</button>-->
                        <table class="table" id="questiontbl">
                            <thead>
                                <tr>
                                    <!--<th>ID</th>-->
                                    <th class="s_no">S.No</th> <!--S.No-->
                                    <th>Questions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="que-list" name="que-list">
                               

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default  ">
                    <div class="panel-heading">
                        New
                    </div>
                    <form action="{{ url('questions/') }}" enctype="multipart/form-data" method="POST" id="frmQuestion" name="frmQuestion">
                        <div class="panel-body"> 

                            {{ csrf_field() }}
                            <div class="row">

                                <div class="form-group">
                                    <label for="inputDetail" class="col-sm-3 control-label">Question</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="question" name="question" ></textarea>
                                    </div>
                                </div>


                                <input type="hidden" id="que_module_id" name="que_module_id" value="0">
                                <input type="hidden" id="que_id" name="que_id" value="0">

                            </div>


                        </div>
                        <div class="panel-footer">
                            <span class="pull-right">
                                <button type="button" class="btn btn-warning {{$disabled}}" id="btn-save-question" value="add">Save changes</button>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </form>  
                </div>

            </div>



        </div>

        <!--documents-->
        <div class="panel panel-green">
            <div class="panel-heading">
                Documents
            </div>
            <div class="panel-body">
                <div class="panel panel-default ">
                    <!--<div class="panel-heading">
                        List
                    </div>-->
                    <div class="panel-body"> 


                        <table class="table">
                            <thead>
                                <tr>
<!--                                        <th>ID</th>-->
                                    <!--<th>Description</th>-->
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="doc-list" name="doc-list">

                            </tbody>
                        </table>
                        <input type="hidden" id="user_id" name="user_id" value="{{\Auth::user()->id}}"/>
                    </div>

                </div>    


                <div class="panel panel-default">
                    <div class="panel-heading">
                        New
                    </div>



                    <form action="{{ url('documents/upload') }}" enctype="multipart/form-data" method="POST">
                        <div class="panel-body">  
                            @if ($message = Session::get('success'))
                            <div class="success-notification" message="{{ $message }}">
                            </div>

                            @endif

                            @if (count($errors) > 0)
                            <div class="alert alert-danger upload-error">
                                <input type="hidden" value="{{session('module_id_doc')}}" id="upmodule_id">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="form-group">
                                    <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="description" value="" required >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="file" class="col-sm-3 control-label">File</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="document" required />
                                    </div>
                                </div>
                                <input type="hidden" id="doc_module_id" name="doc_module_id" value="0">

                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="pull-right">
                                <button type="submit" id="uploaddocument" class="btn btn-success {{$disabled}}">Upload</button>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </form>   

                </div>






            </div>
        </div>

    </div>
</div>


@endsection

@section('heading')
Modules <small>New</small>
@endsection

@section('title')
Modules
@endsection

@section('script')
@parent
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/modules.js')}}"></script>
<script src="{{asset('js/question.js')}}"></script>
<script src="{{asset('js/document.js')}}"></script>
<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#content',
    height: 300,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code',
        'textcolor'
    ],
    toolbar: 'undo redo | insert | styleselect | fontsizeselect | bold italic | forecolor | backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | media | image ',
  //  content_css: '//www.tinymce.com/css/codepen.min.css'
  // enable title field in the Image dialog
  image_title: true, 
  // enable automatic uploads of images represented by blob or data URIs
  automatic_uploads: true,
  // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
  images_upload_url: 'http://localhost:82/laravel5.3/bulleye/cocpanel/public/postAcceptor.php',
  // here we add custom filepicker only to Image dialog
  file_picker_types: 'image | media | files', 
  images_upload_base_path: '../',
  // and here's our custom image picker
  file_picker_callback: function(cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'files/*');
    
    // Note: In modern browsers input[type="file"] is functional without 
    // even adding it to the DOM, but that might not be the case in some older
    // or quirky browsers like IE, so you might want to add it to the DOM
    // just in case, and visually hide it. And do not forget do remove it
    // once you do not need it anymore.

    input.onchange = function() {
      var file = this.files[0];
      
      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function () {
        // Note: Now we need to register the blob in TinyMCEs image blob
        // registry. In the next release this part hopefully won't be
        // necessary, as we are looking to handle it internally.
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var blobInfo = blobCache.create(id, file, reader.result);
        blobCache.add(blobInfo);

        // call the callback and populate the Title field with the file name
        cb(blobInfo.blobUri(), { title: file.name });
      };
    };
    
    input.click();
  }
});

tinymce.init({
    selector: '#question',
    height: 100,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code',
        'textcolor'
    ],
    toolbar: 'undo redo | insert | styleselect | fontsizeselect | bold italic | forecolor | backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ',
   // content_css: '//www.tinymce.com/css/codepen.min.css'
   // enable title field in the Image dialog
  image_title: true, 
  // enable automatic uploads of images represented by blob or data URIs
  automatic_uploads: true,
  // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
  images_upload_url: 'http://localhost:82/laravel5.3/bulleye/cocpanel/public/postAcceptor.php',
  // here we add custom filepicker only to Image dialog
  file_picker_types: 'image | media | files', 
  images_upload_base_path: '../',
  // and here's our custom image picker
  file_picker_callback: function(cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'files/*');
    
    // Note: In modern browsers input[type="file"] is functional without 
    // even adding it to the DOM, but that might not be the case in some older
    // or quirky browsers like IE, so you might want to add it to the DOM
    // just in case, and visually hide it. And do not forget do remove it
    // once you do not need it anymore.

    input.onchange = function() {
      var file = this.files[0];
      
      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function () {
        // Note: Now we need to register the blob in TinyMCEs image blob
        // registry. In the next release this part hopefully won't be
        // necessary, as we are looking to handle it internally.
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var blobInfo = blobCache.create(id, file, reader.result);
        blobCache.add(blobInfo);

        // call the callback and populate the Title field with the file name
        cb(blobInfo.blobUri(), { title: file.name });
      };
    };
    
    input.click();
  }
});
</script>
@endsection
