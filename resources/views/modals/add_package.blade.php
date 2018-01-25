<!-- Styles -->
<link href="{{ asset('css/bootstrap-formhelpers.min.css') }}" rel="stylesheet">
<div class="modal fade " id="addPackageModal" tabindex="-1" role="dialog" aria-labelledby="addPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog big-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="addPackageModalLabel"> Package</h4>
            </div>
            <form id="frmPackage" name="frmPackage" class="form-horizontal" method="POST" >
                <div class="modal-body">

                    <div class="form-group error">
                        <label for="inputName" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="title" name="title" placeholder="Package title" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" ></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Price</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control has-error" id="price" name="price" placeholder="0.00" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Payment Currency </label>
                        <div class="col-sm-9">
                            <select class="form-control has-error input-medium bfh-currencies" id="currency" name="currency" placeholder="select"></select>
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

                    <div class="form-group">
                        <label for="input-payment_frequency" class="col-sm-3 control-label">Module Release Schedule </label>
                        <div class="col-sm-9">
                            @foreach ($epackage->getReleaseSchedule() as $rsch)
                            <div class="radio">
                                &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="release_schedule" value="{{$rsch}}">{{$rsch}}
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group error">
                        <label for="facebook_group" class="col-sm-3 control-label"><i class="fa fa-facebook-square"></i>Facebook Group</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="facebook_group" name="facebook_group" placeholder="" value="">
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
                    <button type="submit" class="btn btn-primary" id="btn-save-package" value="add">Save changes</button>
                    <input type="hidden" id="package_id" name="package_id" value="0">
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
<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: 'textarea',
    height: 300,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code',
        'textcolor'
    ],
    toolbar: 'undo redo | insert | styleselect | fontsizeselect | bold italic | forecolor | backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ',
    content_css: '//www.tinymce.com/css/codepen.min.css'
});
</script>
<script src="js/bootstrap-formhelpers.js"></script>
<script src="js/bootstrap-formhelpers-currencies.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>

$(document).ready(function () {
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
    function validatemodules(){
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
            description: tinymce.get('description').getContent(),
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
        var my_url = pUrl;
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
                var packagerow = '<tr id="package_' + package.id + '">'
                        + '<td>' + package.title + '</td>'
                        + '<td>' + package.price + '</td >'
                        + '<td id="clients_' + package.id + '"> 0 </td>'
                        + ' <td>'
                        + ' <div class="dropup">'
                        + ' <button class="btn btn-danger btn-detail dropdown-toggle pull-left dropdownMenu1" value="' + package.id + '"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="Add Client"><i class="fa fa-user" ></i>'
                        + ' <span class="caret"></span>'
                        + ' </button>'
                        + '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">'
                        + '    <li ><a class="add_client" data-value="' + package.id + '" href="#">Add Existing Client</a></li>'
                        + '    <li role="separator" class="divider"></li>'
                        + '    <li><a class="new_client" data-value="' + package.id + '" href="#">Add New Client</a></li>'
                        + '</ul>'
                        + '</div>&nbsp;'
                        + ' <button class="btn btn-secondary btn-detail edit_package" value="' + package.id + '" title="Edit"><i class="fa fa-edit" ></i></button>'
                        + ' <button class="btn btn-warning linked_client" value="' + package.id + '"  title="Linked Client"><i class="fa fa-group"></i></button>'
                        + ' <form enctype="multipart/form-data" class="form-inline" role="form" method="POST" style="display: inline;"  id="copyPackage_' + package.id + '" action="' + app.base_url + '/packages/make_copy/' + package.id + '">'
                        + '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">'
                        + ' <button class="btn btn-primary btn-delete copy_package" id="copy_package_' + package.id + '" value="' + package.id + '" title="Copy"><i class="fa fa-copy" ></i></button>'
                        + '</form>&nbsp;'
                        + '<form enctype="multipart/form-data" class="form-inline" style="display:inline" role="form" method="POST"  id="deleteForm_' + package.id + '" action="' + app.base_url + '/packages/' + package.id + '">'
                        + '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">'
                        + '<input type="hidden" name="_method" value="DELETE">'
                        + '<button type="button" class="btn btn-danger btn-delete delete-package " value="' + package.id + '" id="delete_package_' + package.id + '"  title="Delete">'
                        + '<i class="fa fa-remove" ></i></button>'
                        + '<input type="hidden" name="package_id" value="' + package.id + '" />'
                        + '</form>'

                        //+ ' <button class="btn btn-success preview_package" value="' + package.id + '" title="Preview"><i class="fa fa-search" ></i></button>'
                        //+ ' <button class="btn btn-primary btn-delete copy_package" value="' + package.id + '" title="Copy"><i class="fa fa-copy" ></i></button>'
                        + '</td>'
                        + '</tr>'

                if (state == "add") { //if user added a new record
                    $('#package-list').append(packagerow);
                    $.notify("Package has been added successfully.");
                } else { //if user updated an existing record
                    $("#package_" + package_id).replaceWith(packagerow);
                    $.notify("Package has been updated successfully.");
                }
                $('#frmPackage').trigger("reset");
                $('#addPackageModal').modal('hide');
                window.location.reload();
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
@endsection