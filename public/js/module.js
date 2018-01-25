var url = app.base_url + "/modules";

function addModuleHtml(type, data)
{
    var module;
    switch (type) {
        case 'live':
            module = '<tr id="module' + data.id + '">'
                    + '<td>' + data.title + '</td>'
                    + '<td>'
                    + ' <a href="' + app.base_url + '/modules/' + data.id + '" class="btn btn-default" value="' + data.id + '" title="Edit"><i class="fa fa-edit" ></i></a>'
                    + '<form enctype="multipart/form-data" class="form-inline" style="display:inline" role="form" method="POST"  id="copyModule_' + data.id + '" action="' + app.base_url + '/modules/make_copy/' + data.id + '">'
                    + '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">'
                    + '  <button class="btn btn-primary btn-detail copy_module" value="' + data.id + '" id="copy_module_' + data.id + '" title="Copy"><i class="fa fa-copy" ></i></button>'
                    + '</form>&nbsp;'
                    //+ '  <button class="btn btn-warning btn-detail preview_module" value="' + data.id + '+" title="Preview"><i class="fa fa-search" ></i></button>'
                    + '  <button class="btn btn-danger btn-delete delete-module" value="' + data.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                    + '</td>'
                    + '</tr>';
            break;
        case 'draft':
        default:

            module = '<tr id="module' + data.id + '">'
                    + '<td>' + data.title + '</td>'
                    + '<td>'
                    + ' <a href="' + app.base_url + '/modules/' + data.id + '" class="btn btn-default" value="' + data.id + '" title="Edit"><i class="fa fa-edit" ></i></a>'
                    + ' <button class="btn btn-success make_live " value="' + data.id + '" title="Make Live"><i class="fa fa-plus-square-o" ></i></button>'
                    + ' <button class="btn btn-danger btn-delete delete-module" value="' + data.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                    + '</td>'
                    + '</tr>';

            break;


    }

    return module;

}

function getModuleType(id) {
    var $wrapper = $('#live-modules-list'),
            $target = $('#module' + id);
    if ($.contains($wrapper[0], $target[0])) {
        return('live');
    } else
    {
        return('draft');
    }
}



//display modal form for module editing
$(document).on('click', '.open_modal2e', function () {
    var module_id = $(this).val();

    $.get(url + '/' + module_id, function (data) {
        //success data
        console.log(data);
        $('#module_id').val(data.id);
        $('#title').val(data.title);
        $('#description').val(data.description);
       $('#content').val(data.content);
//         tinymce.get('content').setContent(data.content);
        $('#btn-save').val("update");
        $('.frmModule-footer').html('').append('<div class="panel panel-success"> <div class="panel-heading">More with module</div>'
                + ' <div class="panel-body">  <button class="btn btn-primary btn-detail left open_doc" value="' + module_id + '" title="Documents"><i class="fa fa-file-text-o" ></i> Documents</button>'
                + ' <button class="btn btn-warning open_ques" value="' + module_id + '"  title="Questions"><i class="fa fa-question-circle"></i> Questions</button></div></div>');

        $('#myModal').modal('show');
    });
});
//display modal form for creating new module
$('#btn_add11').click(function () {
    $('#btn-save').val("add");
    $('#frmModules').trigger("reset");
    $('.frmModule-footer').html("");
    $('#myModal').modal('show');

});
//delete module and remove it from list
$(document).on('click', '.delete-module', function () {
    var module_id = $(this).val();

    bootbox.confirm({
        title: "Delete Module?",
        message: "Do you want to delete module? This cannot be undone.",
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "DELETE",
                    url: url + '/' + module_id,
                    success: function (data) {
                        console.log(data);
                        $("#module" + module_id).remove();
                        $.notify("Module has been deleted successfully.");

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }

        }
    });

});
//});
//create new module / update existing module
$("#btn-save").click(function (e) {
    // alert($('meta[name="_token"]').attr('content'));
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    var formData = {
        title: $('#title').val(),
        description: $('#description').val(),
        content:  $('#content').val(), //tinymce.get('content').getContent() //$('textarea#content').val()
    };
    //used to determine the http verb to use [add=POST], [update=PUT]
    var state = $('#btn-save').val();
    var type = "POST"; //for creating new resource
    var module_id = $('#module_id').val();
    ;
    var my_url = url;
    if (state == "update") {
        type = "PUT"; //for updating existing resource
        my_url += '/' + module_id;
    }
    console.log(formData);
    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function (data) {
            console.log(data);

            var module_type = getModuleType(data.id);
            if (state == "add") { //if user added a new record
                $('#modules-list').append(addModuleHtml(module_type, data));
                $.notify("Module has been added successfully.");
            } else { //if user updated an existing record
                $("#module" + module_id).replaceWith(addModuleHtml(module_type, data));
                $.notify("Module has been updated successfully.");
            }
            $('#frmModules').trigger("reset");
            $('#myModal').modal('hide');
            $('.nav-tabs a[href="#' + module_type + '"]').tab('show');
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});

$(document).on('click', '.make_live', function () {
    var module_id = $(this).val();
    bootbox.confirm({
        title: "Make Live?",
        message: "Warning! Once you make this module live, any client who buy any packages containg this module in the future will buy this version. <br/><br/>Clients who have purchased this moduel previously will continue to see the module as it was when they bought it. Do you want to continue?",
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "PUT",
                    url: url + '/make_live/' + module_id,
                    success: function (data) {
                        console.log(data);
                        $("#module" + module_id).remove();
                        $('#live-modules-list').append(addModuleHtml('live', data));
                        $('.nav-tabs a[href="#live"]').tab('show');
                        $.notify("Module is live now.");

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        }
    });
});

$(document).on('click', '[id^=rbtn_]',function (e) {
    $responsebx = $(this).val();
    $("#responseBox_"+$responsebx).toggle();
    
});

$( document ).ready(function() {
    $("[id^=responseBox_]").hide();
});