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
                            <input type="text" class="form-control has-error" id="title" name="title" placeholder="Module title" value="{{$module->title}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" name="description" placeholder="description" value="{{$module->description}}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Introduction and Guidelines</label>
                        <div class="col-sm-9">
                            <progress></progress>
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
                                        <progress></progress>
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

@section('css')
    @parent

    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">

    <!-- include summernote css/js-->
    <link href="{{asset('css/summernote.css')}}">
    <!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
@endsection

@section('script')
@parent
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/modules.js')}}"></script>
<script src="{{asset('js/question.js')}}"></script>
<script src="{{asset('js/document.js')}}"></script>
{{--<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>--}}

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
<script src="{{asset('js/summernote.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('progress').hide();
    $('#content').summernote({
        height: 300,   //set editable area's height
        callbacks: {
            onImageUpload: function(file,editor, welEditable) {
                // upload image to server and create imgNode...
                console.log(file);
                sendFile(file, this, welEditable);
//                   console.log(imgNode);
//                    $(this).summernote('insertNode', imgNode);
            }
        }

    });
        $('#question').summernote({
            height: 300,   //set editable area's height
            callbacks: {
                onImageUpload: function(file,editor, welEditable) {
                    // upload image to server and create imgNode...
//                    console.log(editor);
                    sendFile(file,this, welEditable);
//                   console.log(imgNode);
//                    $(this).summernote('insertNode', imgNode);
                }
            }

        });

    });

    // send the file

    function sendFile(file, editor, welEditable) {
        data = new FormData();
//        console.log(editor);
        data.append("photo", file[0]);
//        console.log(data.photo);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('progress').show();
        $.ajax({
            data: data,
            type: 'POST',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
                return myXhr;
            },
            url:"{{url("coaches/upload")}}",
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
//                editor.insertImage(welEditable, url);
                imgNode = document.createElement('img');
                $(imgNode).attr("src",url);
                editorid=$(editor).attr('id');
                console.log($(editor).attr('id'));
                $("#"+editorid).summernote('insertNode', imgNode);
//                $summernote.summernote('insertNode', imgNode);
                $('progress').hide();

            }
        });
    }

    // update progress bar

    function progressHandlingFunction(e){
        if(e.lengthComputable){
            $('progress').attr({value:e.loaded, max:e.total});
            // reset progress on complete
            if (e.loaded == e.total) {
                $('progress').attr('value','0.0');
            }
        }
    }


</script>
@endsection
