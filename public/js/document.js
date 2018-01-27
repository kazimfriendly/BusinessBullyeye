var docUrl = app.base_url + "/documents";
var lastmodal=0;
//display modal form for module editing
$(document).on('click', '.open_doc', function () {
    var module_id = $(this).val();
    lastmodal = module_id;
    $.get(docUrl + '/list/' + module_id, function (documents) {
        //success data
        console.log(documents);
        $('#doc-list').html("");
        $.each(documents, function (i, doc) {
            console.log(doc.filename);

            //Remove the _ and id from filename.
            var fileName = doc.filename;
            substring = "_";
            if(fileName.indexOf(substring) !== -1){ // Get the last instace of underscore
                var str = doc.filename;
                var index = str.lastIndexOf("_");
                fileName = str.substr(0,index) + str.substr(fileName.indexOf("."));
            }


            $('#doc-list').append(
                    '<tr id="doc_' + doc.id + '">'
                    //+ '  <td>' + doc.description + '</td>'
                    + '  <td>' + fileName + '</td>'
                    + '  <td>'
                    + '     <a href="' + app.base_url + '/documents/' + doc.filename + '" class="btn btn-success btn-dowonload doc_download" title="Download" download><i class="fa fa-download" ></i></a>'
                    + '     <button class="btn btn-danger doc_delete" value="' + doc.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                    + '  </td>'
                    + '</tr>'
                    );
        });
//        $('#doc-list').html(data);
//        $('#doc-list').append(data);

    })

    $('#doc_module_id').val(module_id);
    $('#documentModel').modal('show');
});

$(document).on('click', '.doc_delete', function () {
    var doc_id = $(this).val();
    bootbox.confirm({
        title: "Delete document?",
        message: "Do you want to delete this document? This cannot be undone.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Yes'
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
                    url: docUrl + '/' + doc_id,
                    success: function (data) {
                        console.log(data);
                        $("#doc_" + doc_id).remove();
                        $.notify("Document deleted successfully.");
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        }
    });

});

$( document ).ready(function() {
    if ($('.success-notification').length){
        $.notify($( '.success-notification' ).attr( "message" ));
    }
    if ($('.upload-error').length){
       
    var module_id = $('#upmodule_id').val();
    $.get(docUrl + '/list/' + module_id, function (documents) {
        //success data
        //console.log(documents);
        $('#doc-list').html("");
        $.each(documents, function (i, doc) {
            console.log(doc.filename);

            //Remove the _ and id from filename.
            var fileName = doc.filename;
            substring = "_";
            if(fileName.indexOf(substring) !== -1){ // Get the last instace of underscore
                var str = doc.filename;
                var index = str.lastIndexOf("_");
                fileName = str.substr(0,index) + str.substr(fileName.indexOf("."));
            }

            $('#doc-list').append(
                    '<tr id="doc_' + doc.id + '">'
                    //+ '  <td>' + doc.description + '</td>'
                    + '  <td>' + fileName + '</td>'
                    + '  <td>'
                    + '     <a href="' + app.base_url + '/documents/' + doc.filename + '" class="btn btn-success btn-dowonload doc_download" title="Download" download><i class="fa fa-download" ></i></a>'
                    + '     <button class="btn btn-danger doc_delete" value="' + doc.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                    + '  </td>'
                    + '</tr>'
                    );
        });
//        $('#doc-list').html(data);
//        $('#doc-list').append(data);
    $('#doc_module_id').val(module_id);
     $('#documentModel').modal('show');
      $('.nav-tabs a[href="#add_doc"]').tab('show');
    

});
}
});