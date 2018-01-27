@extends('layouts.app')

@section('content')
<div class="">
    <!--<div class="row">
        <div class="col-sm-11">
            <div class="panel-body module_desc">{{$module->description}}</div>
        </div>
    </div>-->

    <div class="col-sm-12">
        <h2 class="intro">Introduction and Guidelines</h2>
        <div class="panel panel-default module-desc">
            <div class="panel-body">
                {!! $module->content!!}

            </div>
        </div>
        <h3>Questions</h3>

        @foreach ($module->questions()->orderBy('sno')->get() as $question)        
        <div class="col-sm-12 questions">
            <div class="panel panel-white post panel-shadow">
                <div class="row table_question">
                    <div class="question-index">Q{{@$loop->index+1}}</div>
                    <!--<div class="pull-left image">
                        <img src="{{ url('/') }}/images/question.png" class="img-circle avatar" alt="q">
                    </div>-->
                    <div class="question-content">{!!($question->content)!!}</div>
                </div>
                <div class="row post-footer">
                    <div class="answer-index">&nbsp;</div>
                    <div class="answer-content">
                        <ul class="comments-list" id="comments-list_{{$question->id}}">

                            @if($assignment)

                            @foreach ( $question->getDiscussion($assignment->id) as $response )
                            @if(!($response->visibility == 1 && $assignment->coach->id == Auth::user()->id))

                            <li class="comment green" >
                                <a class="pull-left" href="#">
                                    <img class="avatar" src="{{asset('../storage/app/public/'.$response->getAvatar($response->user_id))}}" alt="avatar">
                                    <!--                                @if($response->user_id == session('client')->id)
                                                                    <img class="avatar" src="http://bootdey.com/img/Content/user_1.jpg" alt="avatar">
                                                                    @else
                                                                    <img class="avatar" src="http://bootdey.com/img/Content/user_3.jpg" alt="avatar">
                                                                    @endif-->
                                    <BR>
                                    @if($response->user_id == session('coach')->id)
                                    <span class="small bg-primary">Coach</span>
                                    @endif
                                </a>
                                <div class="comment-body">

                                    <div class="comment-heading">
                                        <h4 class="user">{{$response->getAName($response->user_id)}}</h4>

                                        <h5 class="time"> 

                                            {{$response->getTime($response->response_id)}}</h5>
                                    </div>
                                    <p>{!!$response->getContent($response->response_id)!!}</p>  
                                </div>

                            </li>

                            @endif
                            @endforeach
                            @endif 
                        </ul>
                    </div> <!--question-content-->
                </div>
                @if($assignment->status == 3 )
                <div class="row">
                    <div class="answer-index">&nbsp;</div>
                    <div class="response-content">
                        <div class="input-group">
                            <button class="btn btn-warning" id='rbtn_{{$question->id}}' value="{{$question->id}}">Show Reply Box</button>
                            <form class="form-horizontal" id="responseBox_{{$question->id}}" role="form" method="POST"  action="{{ url('assigned/'.$assignment->module_id.'/'.$module->id) }}">
                                {{ csrf_field() }}
                                <div class="res">Response:</div>
                                <textarea class="form-control input-lg" name="content" type="text"></textarea>                        
                                <input type="hidden" name="assignment_id" value="{{$assignment->id}}">
                                <input type="hidden" name="question_id" value="{{$question->id}}">
                                <input type="hidden" name="responseby" value="{{Auth::user()->id}}">                                
                                <span class="input-group-btn">
                                    <button type="button" id="save-response"  value="{{$question->id}}"class="btn btn-default  right" >SAVE</button>  
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>



        </div>

        @endforeach
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Coach Documents</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <!--<th>ID</th>-->
                                <!--<th>Description</th>-->
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="doc-list" name="doc-list">
                            @foreach ($module->documents()->where('uploaded_by',session('coach')->id)->get() as $document)  
                            <tr>
                                <!--<td>{{$document->description}}</td>-->
                                <td>
                                <?php
                                    $fileName = $document->filename;
                                    $substring = "_";
                                    if(strrpos($fileName,$substring) !== -1){ // Get the last instace of underscore
                                        $str = $document->filename;
                                        $index = strrpos($fileName,$substring);
                                        $fileName = substr($str,0,$index).substr($fileName,strrpos($fileName,"."));
                                    }
                                ?>
                                
                                {{$fileName}}</td>
                                <td>  <a href="{{url('/documents/'.$document->filename)}}" class="btn btn-success btn-dowonload doc_download" title="Download" download><i class="fa fa-download" ></i></a></td>
<!--                        <button class="btn btn-danger doc_delete" value="' + doc.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'</td>
                                -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Client Documents</h3>
                </div>
                <div class="panel-body">                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <!--<th>ID</th>-->
                                <!--<th>Description</th>-->
                                <th>Name</th>
                                <th>Uploaded at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="doc-list" name="doc-list">
                            @foreach ($module->documents()->where('uploaded_by',session('client')->id)->get() as $document)  
                            <tr>
                                <!--<td>{{$document->description}}</td>-->
                                <td>
                                <?php
                                    $fileName = $document->filename;
                                    $substring = "_";
                                    if(strrpos($fileName,$substring) !== -1){ // Get the last instace of underscore
                                        $str = $document->filename;
                                        $index = strrpos($fileName,$substring);
                                        $fileName = substr($str,0,$index).substr($fileName,strrpos($fileName,"."));
                                    }
                                ?>
                                
                                {{$fileName}}</td>
                                <td>{{ date("D F j, Y, g:i a",  strtotime($document->uploaded_at))}}</td>
                                <td>  <a href="{{url('/documents/'.$document->filename)}}" class="btn btn-success btn-dowonload doc_download" title="Download" download><i class="fa fa-download" ></i></a></td>
<!--                        <button class="btn btn-danger doc_delete" value="' + doc.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'</td>
                                -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12"> 
            @if($assignment->status == 3)

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Upload New Documents</h3>
                </div>
                <div class="panel-body">                                        
                    <form action="{{ url('documents/upload') }}" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="form-group doc_name">
                                <label for="inputDetail" class="col-sm-3 control-label">Name of document <span class="req">(REQUIRED)</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Name of Document" value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="file" class="col-sm-3 control-label">File</label>
                                <div class="col-sm-9">
                                    <input type="file" name="document" />
                                </div>
                            </div>
                            <input type="hidden" id="doc_module_id" name="doc_module_id" value="{{$module->id}}">
                            <div class="col-sm-12 right">
                                <button type="submit" class="btn btn-success">Upload</button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
            @endif

            <!--<div align="right">
                @can('sendcoachAlert', $assignment)
                <form enctype='multipart/form-data' class="form-inline" role="form" method="POST" style="display: inline;"  id="send_to_client_{{$assignment->id}}" action="{{ url('assigned/sendtoclient/'.$assignment->id) }}">
                    {{ csrf_field() }}

                    <button type="button" class="btn btn-warning" id="sendtocoach" value="{{$assignment->id}}" title="Copy"><i class="fa fa-envelope" > SAVE & SUBMIT TO COACH</i></button>
                </form>
                @endcan
                <form en1ctype='multipart/form-data' class="form-inline" role="form" method="POST" style="display: inline;"  id="saveandcontinue" action="{{ url('assigned/savecontinue/'.$assignment->id) }}">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-primary btn-delete copy_module" id="savecontinue" value="{{$assignment->id}}" title="Copy"><i class="fa fa-save" > SAVE AND CONTINUE</i></button>
                </form>
            </div>-->

            <div align="right">
                <form enctype='multipart/form-data' class="form-inline" role="form" method="POST" style="display: inline;"  id="saveandcontinue" action="{{ url('assigned/savecontinue/'.$assignment->id) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="assignment_id" value="{{$assignment->id}}"/>
                    <button type="button" class="btn btn-primary" id="savecontinue" value="{{$assignment->id}}" title=""><i class="fa fa-arrow-circle-right" > SUBMIT TO  
                            @can('sendcoachAlert', $assignment) CLIENT @endcan
                @can('sendclientAlert', $assignment)COACH @endcan & CONTINUE </i></button>
                </form>
                @can('sendcoachAlert', $assignment)
                <form enctype='multipart/form-data' class="form-inline" role="form" method="POST" style="display: inline;"  id="send_to_client_{{$assignment->id}}" action="{{ url('assigned/sendtoclient/'.$assignment->id) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="assignment_id" value="{{$assignment->id}}"/>
                    <button type="button" class="btn btn-warning" id="sendtoclient" value="{{$assignment->id}}" title=""><i class="fa fa-envelope" > SUBMIT TO CLIENT & EXIT</i></button>
                </form>
                @endcan
                @can('sendclientAlert', $assignment)
                <form enctype='multipart/form-data' class="form-inline" role="form" method="POST" style="display: inline;"  id="send_to_client_{{$assignment->id}}" action="{{ url('assigned/sendtocoach/'.$assignment->id) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="assignment_id" value="{{$assignment->id}}"/>
                    <button type="button" class="btn btn-warning" id="sendtocoach" value="{{$assignment->id}}" title=""><i class="fa fa-envelope" > SUBMIT TO COACH & EXIT</i></button>
                </form>
                @endcan


            </div>

        </div>

    </div>

</div>
</div>
</div>
@endsection

@section('heading')
{{$module->title}} 
@endsection

@section('title')
{{$module->title}}Modules
@endsection

@section('breadcrumbs')
<!--<i class="fa fa-file"></i>-->
{{$module->title}}Modules
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/module.js')}}"></script>
<script>
$(document).on('click', '#sendtoclient', function (e) {
    console.log("clicked");
    var delbtn = $(this);
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    
     $('[id^=responseBox_]').each(function () {
                    if ($(this).find("textarea").val()) {
                        $('#savecontinue').button('loading');
                        var thisform = $(this);
//                        setTimeout(function () {
//                            $btn.button('reset');
//                        }, 10000);



//    console.log(formData);
                        $.ajax({
                            type: "POST",
                            url: thisform.attr('action'),
                            data: thisform.serialize(),
                            dataType: 'json',
                            success: function (data) {

                            },
                            error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
//            $('#addClientModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message

                                $.notify({
                                    message: "Error :" + $(xhr.responseText).find('.exception_message').html(),
                                    type: 'danger'
                                });
                            }
                        });
                    }
                });
//    bootbox.confirm({
//        title: "Send to Client?",
//        message: "Are you sure to send changes to client?",
//        buttons: {
//            cancel: {
//                label: '<i class="fa fa-times"></i> Cancel'
//            },
//            confirm: {
//                label: '<i class="fa fa-check"></i> Confirm'
//            }
//        },
//        callback: function (result) {
//            if (result) {
//                console.log(result);
//                console.log(delbtn.val());
//
//                delbtn.parents('form').submit();
//
//            }
//        }
//    });
//    return result; //you can just return c because it will be true or false
    delbtn.parents('form').submit();
});

$(document).on('click', '#sendtocoach', function (e) {
    console.log("clicked");
    var delbtn = $(this);
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    
     $('[id^=responseBox_]').each(function () {
                    if ($(this).find("textarea").val()) {
                        $('#savecontinue').button('loading');
                        var thisform = $(this);
//                        setTimeout(function () {
//                            $btn.button('reset');
//                        }, 10000);



//    console.log(formData);
                        $.ajax({
                            type: "POST",
                            url: thisform.attr('action'),
                            data: thisform.serialize(),
                            dataType: 'json',
                            success: function (data) {

                            },
                            error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
//            $('#addClientModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message

                                $.notify({
                                    message: "Error :" + $(xhr.responseText).find('.exception_message').html(),
                                    type: 'danger'
                                });
                            }
                        });
                    }
                });
//    bootbox.confirm({
//        title: " Confirm Submit to Coach",
//        message: "Are you sure to send changes to coach?",
//        buttons: {
//            cancel: {
//                label: '<i class="fa fa-times"></i> Cancel'
//            },
//            confirm: {
//                label: '<i class="fa fa-check"></i> Confirm'
//            }
//        },
//        callback: function (result) {
//            if (result) {
//                console.log(result);
//                console.log(delbtn.val());
//
//                delbtn.parents('form').submit();
//
//            }
//        }
//    });
//    return result; //you can just return c because it will be true or false

    delbtn.parents('form').submit();
});

$(document).on('click', '#savecontinue', function (e) {
    console.log("clicked");
    var delbtn = $(this);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
//    bootbox.confirm({
//        title: "Continue to next module?",
//        message: "Are you sure to save changes?",
//        buttons: {
//            cancel: {
//                label: '<i class="fa fa-times"></i> Cancel'
//            },
//            confirm: {
//                label: '<i class="fa fa-check"></i> Confirm'
//            }
//        },
//        callback: function (result) {
//            if (result) {
//                console.log(result);
//                console.log(delbtn.val());

                $('[id^=responseBox_]').each(function () {
                    if ($(this).find("textarea").val()) {
                        $('#savecontinue').button('loading');
                        var thisform = $(this);
//                        setTimeout(function () {
//                            $btn.button('reset');
//                        }, 10000);



//    console.log(formData);
                        $.ajax({
                            type: "POST",
                            url: thisform.attr('action'),
                            data: thisform.serialize(),
                            dataType: 'json',
                            success: function (data) {

                            },
                            error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
//            $('#addClientModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message

                                $.notify({
                                    message: "Error :" + $(xhr.responseText).find('.exception_message').html(),
                                    type: 'danger'
                                });
                            }
                        });
                    }
                });
                delbtn.parents('form').submit();

//            }
//        }
//    });
//    return result; //you can just return c because it will be true or false
});

$(document).on('click', '#save-response', function (e) {
    var quid = $(this).val();
    var $btn = $(this);
    $btn.button('loading');
    setTimeout(function () {
        $btn.button('reset');
    }, 10000);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();


//    console.log(formData);
    $.ajax({
        type: "POST",
        url: $("#responseBox_" + quid).attr('action'),
        data: $("#responseBox_" + quid).serialize(),
        dataType: 'json',
        success: function (data) {

            $.notify("Your response has been added successfully.");
            console.log(data);
            var newrec = '<li class="comment green" >'
                    + ' <a class="pull-left" href="#">'
                    + '<img class="avatar" src="{{asset("../storage/app/public/")}}/' + data.user.avatar + '" alt="avatar">'
                    + ' <BR>'
                    + '@if(\Auth::user()->id == session("coach")->id)'
                    + '<span class="small bg-primary">Coach</span>'
                    + '@endif'
                    + '</a>'
                    + '<div class="comment-body">'
                    + '<div class="comment-heading">'
                    + '<h4 class="user">' + data.user.name + '</h4>'
                    + '<h5 class="time"> ' + data.response.created_at + '</h5>'
                    + '</div>'
                    + '<p>' + data.response.content + '</p>  '
                    + '</div>'
                    + '</li>';

            $('#comments-list_' + quid).append(newrec);
            $("#responseBox_" + quid).trigger("reset");
            $("#responseBox_" + quid).toggle();

        },
        error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
//            $('#addClientModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message

            $.notify({
                message: "Error :" + $(xhr.responseText).find('.exception_message').html(),
                type: 'danger'
            });
        }
    });
});


</script>
@endsection

@section('css')
<style>
    .panel-shadow {
        box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
    }
    .panel-white {
        border: 1px solid #dddddd;
    }
    .panel-white  .panel-heading {
        color: #333;
        background-color: #fff;
        border-color: #ddd;
    }
    .panel-white  .panel-footer {
        background-color: #fff;
        border-color: #ddd;
    }

    .post .post-heading {
        /*height: 95px;*/
        padding: 20px 15px;
    }
    .post .post-heading .avatar {
        width: 60px;
        height: 60px;
        display: block;
        margin-right: 15px;
    }
    .post .post-heading .meta .title {
        margin-bottom: 0;
    }
    .post .post-heading .meta .title a {
        color: black;
    }
    .post .post-heading .meta .title a:hover {
        color: #aaaaaa;
    }
    .post .post-heading .meta .time {
        margin-top: 8px;
        color: #999;
    }
    .post .post-image .image {
        width: 100%;
        height: auto;
    }
    .post .post-description {
        padding: 15px;
    }
    .post .post-description p {
        font-size: 14px;
    }
    .post .post-description .stats {
        margin-top: 20px;
    }
    .post .post-description .stats .stat-item {
        display: inline-block;
        margin-right: 15px;
    }
    .post .post-description .stats .stat-item .icon {
        margin-right: 8px;
    }
    .post .post-footer {
        border-top: 2px solid #b8b8b8;
        /*padding: 15px;*/
    }
    .post .post-footer .input-group-addon a {
        color: #454545;
    }
    .post .post-footer .comments-list {
        padding: 0;
        margin-top: 20px;
        list-style-type: none;
    }
    .post .post-footer .comments-list .comment {
        display: block;
        width: 100%;
        margin: 20px 0;
    }
    .post .post-footer .comments-list .comment .avatar {
        width: 35px;
        height: 35px;
    }
    .post .post-footer .comments-list .comment .comment-heading {
        display: block;
        width: 100%;
    }
    .post .post-footer .comments-list .comment .comment-heading .user {
        font-size: 14px;
        font-weight: bold;
        display: inline;
        margin-top: 0;
        margin-right: 10px;
    }
    .post .post-footer .comments-list .comment .comment-heading .time {
        font-size: 12px;
        color: #aaa;
        margin-top: 0;
        display: inline;
    }
    .post .post-footer .comments-list .comment .comment-body {
        margin-left: 50px;
    }
    .post .post-footer .comments-list .comment > .comments-list {
        margin-left: 50px;
    }

    .post-footer .input-group {
        width: 100%;
    }
    .post-footer .input-group textarea {
        width: 100% !important;
        margin-bottom: 10px;
        resize: none;
    }
</style>
@endsection
