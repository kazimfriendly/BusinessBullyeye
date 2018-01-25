/* 
 *Deal with all packages related operations.
 */
var pUrl = app.base_url + "/packages";
//display package form
$(document).on('click', '#btn_add_package', function () {
//     $.get(url + '/live' , function (data) {

    $('#frmPackage').trigger("reset");
    $('#addPackageModal').modal('show');
    $('#btn-save-package').val("add");
    $('.available-modules li').show();
    $('.selected-modules').html("");
//    });
    $('#addPackageModal').on('shown', function () {
        $("#selected-modules, #available-modules").css('minHeight', $("#available-modules").height() + "px");
    })


});
$(document).on('click', '#btn-save-package111', function (e) {
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
    e.preventDefault();
    var formData = {
        title: $('#title').val(),
        description:$('#description').val(),// tinymce.get('description').getContent(),
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
});
$(document).on('click', '.edit_package', function (e) {
    var package_id = $(this).val();
    window.location = app.base_url + "/packages/" + package_id;
    /* $('.available-modules li').show();
     $.get(pUrl + '/' + package_id, function (data) {
     //success data
     console.log(data);
     $('#package_id').val(data.id);
     $('#title').val(data.title);
     tinymce.get('description').setContent((data.description == null)?"<p></p>":data.description);
     $('#price').val(data.price);
     $('#currency').val(data.currency);
     $('input[value="' + data.release_schedule + '"]').prop("checked", true);
     $('input[value="' + data.paymnent_frequency + '"]').prop("checked", true);
     $('#facebook_group').val(data.facebook_group);
     $('.selected-modules').html("");
     //group.sortable("refresh");
     var modulez=0;
     $.each(data.selected_modules, function (index, module) {
     //            alert(index + ": " + value);
     modulez+=module.id+',';
     $('.selected-modules').append('<li value="' + module.id + '" id="' + module.id + '" style="cursor:move" ><i class="fa fa-fw fa-folder"></i>' + module.title + '</li>');
     $('.available-modules #' + module.id).hide();
     });
     $('#modules').val(modulez);
     $('#btn-save-package').val("update");
     //         $('#frmPackage').trigger("reset");
     $('#addPackageModal').modal('show');
     });*/
});
$(document).on('click', '.view_package', function (e) {
    var package_id = $(this).val();
    window.location = app.base_url + "/packages/view/" + package_id;
    });
$(document).on('click', '.new_client', function (e) {
    var package_id = $(this).data('value');
    $('#package_id').val(package_id);
    $('#name').val('');
    $('#email').val('');
    $('#password').val('');
    $('#newClientModal').modal('show');
});
$(document).on('click', '#btn-save-client1', function (e) {

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
    var formData = {
        name: $('#name').val(),
        password: $('#password').val(),
        email: $('#email').val(),
        package_id: $('#package_id').val()
    };
    console.log(formData);
    $.ajax({
        type: "POST",
        url: app.base_url + "/clients",
        data: formData,
        dataType: 'json',
        success: function (data) {
            $.notify("Client have been added successfully.");
            console.log(data);
            $('#clients_' + $('#package_id').val()).html(data.totalclients);
            $('#frmClient').trigger("reset");
            $('#newClientModal').modal('hide');
        },
        error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
            $('#newClientModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message
            $.notify("Error :" + $(xhr.responseText).find('.exception_message').html());
        }
    });
});
$(document).on('click', '.add_client', function (e) {
    var package_id = $(this).data('value');
    $('#package_id').val(package_id);
    $('#emails').val('');
    $('#addClientModal').modal('show');

});
$(document).on('click', '#btn-save-addclient1', function (e) {

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
    var formData = {
        emails: $('#emails').val(),
        package_id: $('#package_id').val()
    };
    console.log(formData);
    $.ajax({
        type: "POST",
        url: app.base_url + "/clients/addExisting",
        data: formData,
        dataType: 'json',
        success: function (data) {
            $.notify(data.clients + " Clients have been added successfully.");
            console.log(data);
            $('#clients_' + $('#package_id').val()).html(data.totalclients);
            $('#frmAddClient').trigger("reset");
            $('#addClientModal').modal('hide');
        },
        error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
            $('#addClientModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message

            $.notify({
                message: "Error :" + $(xhr.responseText).find('.exception_message').html(),
                type: 'danger'
            });
        }
    });
});
$(document).on('click', '.linked_client', function (e) {
    $('#linked_clients_list').html("");
    var package_id = $(this).val();
    $('#package_id').val(package_id);
    $.get(pUrl + '/linked_clients/' + package_id, function (data) {
        console.log(data);
        $.each(data.clients, function (index, client) {
            //console.log(index + ": " + client.name + '<br/>');
            $('#linked_clients_list').append('<tr><td>' + client.name + ' </td><td>' + client.email + ' </td>'
                    + '<td> <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST"  id="deleteForm_' + client.id + '" action="' + app.base_url + '/clients/' + client.id + '">'
                    + '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">'
                    + '<input type="hidden" name="_method" value="DELETE">'
                    + ' <button type="button" class="btn btn-danger btn-delete delete-client " value="' + client.id + '" id="delete_client_' + client.id + '"  title = "Delete" >'
                    + '<i class="fa fa-remove" > </i></button >'
                    + '<input type="hidden" name = "coache_id" value = "' + data.coach.id + '" / >'
                    + '<input type="hidden" name = "package_id" value = "' + package_id + '" / >'
                    + '</form></td></tr>'
                    );
        });
    });
    $('#linkedClient').modal('show');
});

$(document).on('click', '[id^=delete_client_]', function (e) {
    console.log("clicked");
    var delbtn = $(this);
    bootbox.confirm({
        title: "Delete Client?",
        message: "Are you sure to delete this client?  it will be deleted from all your subscribed packages",
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

$(document).on('click', '[id^=delete_package_]', function (e) {
    delbtn = $(this);
    bootbox.confirm({
        title: "Delete Package?",
        message: "Are you sure to delete this package? It will be completely deleted.",
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
            title: "Change Client Reply on Package?",
            message: "Are you sure to make changes in client reply on package?  It will completely disable the client coach communication.",
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
});

$(document).on('click', '.assign_coach22', function (e) {
    var package_id = $(this).data('value');
    $('#package_id').val(package_id);
    console.log('coach-assignment');
    $('#assigncoachmodal').modal('show');

});