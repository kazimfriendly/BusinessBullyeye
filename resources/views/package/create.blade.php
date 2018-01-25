@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-12 ">
            @php
            if ($state == 'add')
            {
            $package = new \App\package();
            
            }
            @endphp
            <form id="frmPackage" name="frmPackage" class="form-horizontal" method="POST" >
                <div class="modal-body">

                    <div class="form-group error">
                        <label for="inputName" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="title" name="title" placeholder="Package title" value="{{$package->title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <progress></progress>
                            <textarea class="form-control" id="description" name="description" >{!!$package->description!!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Price</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control has-error" id="price" name="price" placeholder="0.00" value="{{$package->price}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Payment Currency </label>
                        <div class="col-sm-9">
                            <select class="form-control has-error input-medium bfh-currencies" id="currency" name="currency" placeholder="select" value="{{$package->currency}}"></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Payment Frequency </label>
                        <div class="col-sm-9">
                            @foreach ($epackage->getPaymentsFrequencies() as $pfre)
                            <div class="radio-inline">
                                <input type="radio" name="paymnent_frequency" value="{{$pfre}}">{{$pfre }}
                            </div>
                            @endforeach
                        </div>
                    </div>

<!--                    <div class="form-group">
                        <label for="input-payment_frequency" class="col-sm-3 control-label">Module Release Schedule </label>
                        <div class="col-sm-9">
                            @foreach ($epackage->getReleaseSchedule() as $rsch)
                            <div class="radio">
                                &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="release_schedule" value="{{$rsch}}">{{$rsch}}
                            </div>
                            @endforeach
                        </div>
                    </div>-->

                    <div class="form-group error">
                        <label for="facebook_group" class="col-sm-3 control-label"><i class="fa fa-facebook-square"></i>Facebook Group</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="facebook_group" name="facebook_group" placeholder="" value="{{$package->facebook_group}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-available_modules" class="col-sm-3 control-label">Select Modules </label>
                        <div class="col-sm-9">
                            Drag and drop to select modules. <input type="text" class="invisible" id="modules" name="modules" >
                            <!--start multi select--> 
                            <div class="row">
                                <div class="col-xs-5 panel panel-default">
                                    <label class="">Available Modules</label>
                                    <ol class="available-modules list-unstyled list-group droptrue " id="available-modules">
                                        @foreach ($live_modules as $module)
                                        <li value="{{ $module->id }}" id="{{ $module->id}}" style="cursor:move" ><i class="fa fa-fw fa-folder"></i>{{ $module->title }}</li>
                                        @endforeach

                                    </ol>


                                </div>

                                <div class="col-xs-1">
                                    <br>
                                    <br>
                                    <!--<button type="button" id="right_All_1" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>-->
                                    <!--<button type="button" id="right_Selected_1" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>-->
                                    <!--<button type="button" id="left_Selected_1" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>-->
                                    <!--<button type="button" id="left_All_1" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>-->
                                </div>

                                <div class="col-xs-5 panel panel-default">
                                    <label>Selected Modules</label>
                                    <ol class="selected-modules list-unstyled list-group droptrue" id="selected-modules" style="cursor:move"  data-unique="unique">

                                    </ol>
                                </div>
                            </div>

                            <!--<div id="serialize_output2">testing</div>-->

                            <!-- end multi select -->
                        </div>
                    </div>


                    <div class="frmModule-footer"></div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary" id="btn-save-package" value="{{$state}}">Save changes</button>
                    <input type="hidden" id="package_id" name="package_id" value="{{$package->id}}">
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
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">

<!-- include summernote css/js-->
<link href="{{asset('css/summernote.css')}}">
<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
@endsection

@section('script')
@parent

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>

<script src="../js/bootstrap-formhelpers.js"></script>
<script src="../js/bootstrap-formhelpers-currencies.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>

$(document).ready(function () {
    var state="{{$state}}";
    if(state == "update")
    {
         $('#currency').val("{{$package->currency}}");
        $('input[value="{{$package->release_schedule}}"]').prop("checked", true);
        $('input[value="{{$package->paymnent_frequency}}"]').prop("checked", true);
        $('.selected-modules').html("");
        //group.sortable("refresh");
        var modulez=0;
        var selectedmodules={!!$package->selected_modules!!};
        $.each(selectedmodules, function (index, module) {
//            alert(index + ": " + value);
            modulez+=module.id+',';
            $('.selected-modules').append('<li value="' + module.id + '" id="' + module.id + '" style="cursor:move" ><i class="fa fa-fw fa-folder"></i>' + module.title + '</li>');
            $('.available-modules #' + module.id).hide();
        });
        $('#modules').val(modulez);
    }
    $("#selected-modules").css('minHeight', "200px");

    $('.droptrue').on('click', 'li', function () {
        $(this).toggleClass('selected');
    });

    $("ol.droptrue").sortable({
        connectWith: 'ol.droptrue',
        opacity: 0.6,
        revert: false,
        helper: function (e, item) {
            console.log('parent-helper');
            console.log(item);
            if (!item.hasClass('selected'))
                item.addClass('selected');
            var elements = $('.selected').not('.ui-sortable-placeholder').clone();
            var helper = $('<ul/>');
            item.siblings('.selected').addClass('hidden');
            return helper.append(elements);
        },
        start: function (e, ui) {
            var elements = ui.item.siblings('.selected.hidden').not('.ui-sortable-placeholder');
            ui.item.data('items', elements);
        },
        receive: function (e, ui) {
            ui.item.before(ui.item.data('items'));
            console.log(ui.item.parent());
            console.log(ui.item);
            console.log($(this).attr('id'));
            if ($(this).attr('id') == "available-modules") {
                bootbox.confirm({
                    title: " Confirm Module Removal",
                    message: "Are you sure, all the associations of these modules will be deleted for all the clients of this package?",
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
                            //ajax delete module;

                        } else {
//                            $("selected-modules").append(ui.item);
                            ui.item.appendTo($("#selected-modules"));
                            updatemodules();
                            validatemodules();
                        }
                    }
                });
            }
        },
        stop: function (e, ui) {
            ui.item.siblings('.selected').removeClass('hidden');
            $('.selected').removeClass('selected');
            // alert('done');
            // console.log($(this).attr('id'));
            validatemodules();
        },
        update: updatemodules
    });

    $("#selected-modules, #available-modules").disableSelection();
    function validatemodules() {
        var mval = $('#modules').val();
        var isEmpty = $("#modules").val() == '';
        $('#modules').bootstrapValidator('validateField', 'modules', !isEmpty);
        $('#modules').val(mval).trigger('keyup');
    }
    function updatemodules() {
        if ($("#available-modules").height() < 200)
            $("#available-modules").css('minHeight', "200px");

        var arr = [];
        $("#selected-modules li").each(function () {
            arr.push($(this).attr('id'));
        });
        $('#modules').val(arr.join(','));
    }


    $('#frmPackage').bootstrapValidator({
        message: 'This value is not valid',
        trigger: 'keyup',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: 'Title is required'
                    },
                    stringLength: {
                        min: 6,
                        message: 'The title must have at least 6 characters'
                    }
                    //regexp: {
                    //    regexp: /^[a-zA-Z ]+$/,
                    //    message: 'Name cannot have numbers or symbols'
                    //}
                }
            },
            modules: {
                validators: {
//                    callback: {
//                        message: 'Modules is required',
//                        callback: function (value, validator, $field) {
//                            var count = 0;
//                            $('.selected-modules li').each(function (index) {
//                                count++;
//                            });
//                            return count>0;
//                        }
//                    }
                    notEmpty: {
                        message: 'Modules is required'
                    },
                }
            },
        }
    }).on('success.form.bv', function (e) {
        // Prevent form submission
        e.preventDefault();
        $('#frmPackage').data('bootstrapValidator').resetForm();
        var selected_modules = {};
        $('.selected-modules li').each(function (index) {
            selected_modules[index] = $(this).attr('value');
            console.log(index + ": " + $(this).text() + " value =" + $(this).attr('value'));
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
//    e.preventDefault();
        var formData = {
            title: $('#title').val(),
            description: $('#description').val(),//  tinymce.get('description').getContent(),
            price: $('#price').val(),
            currency: $('#currency').val(),
            paymnent_frequency: $('input[name=paymnent_frequency]:checked').val(),
            release_schedule: $('input[name=release_schedule]:checked').val(),
            facebook_group: $('#facebook_group').val(),
            selected_modules: selected_modules
        };
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save-package').val();
        var type = "POST"; //for creating new resource
        var package_id = $('#package_id').val();
        var my_url = app.base_url + "/packages";
        if (state == "update") {
            type = "PUT"; //for updating existing resource
            my_url += '/' + package_id;
        }

        console.log(formData);
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (package) {
                console.log(package);

                if (state == "add") { //if user added a new record
//                    $('#package-list').append(packagerow);
                    $.notify("Package has been added successfully.");
                } else { //if user updated an existing record
//                    $("#package_" + package_id).replaceWith(packagerow);
                    $.notify("Package has been updated successfully.");
                }
//                $('#frmPackage').trigger("reset");
//                $('#addPackageModal').modal('hide');
                window.location = app.base_url + "/packages";
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

//       
    });
});

</script>

<!--<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script>
$('.sortable').sortable({
  update: function(){
     console.log('sortable updated'); 
  }
});
</script>-->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
<script src="{{asset('js/summernote.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('progress').hide();
        $('#description').summernote({
            height: 300,           //set editable area's height
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


    });

    // send the file

    function sendFile(file, editor, welEditable) {
        data = new FormData();
        $('progress').show();
//        console.log(editor);
        data.append("photo", file[0]);
//        console.log(data.photo);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
            success: function(url,editor,welEditable) {
//                editor.insertImage(welEditable, url);
                imgNode = document.createElement('img');
                $(imgNode).attr("src",url);
                console.log(imgNode);
                $('#description').summernote('insertNode', imgNode);
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

@section('heading')
Package <small>New</small>
@endsection

@section('title')
Packages
@endsection

@section('breadcrumbs')
New Package
@endsection