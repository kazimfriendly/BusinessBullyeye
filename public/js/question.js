var qUrl = app.base_url + "/questions";
//display list of questions
$(document).on('click', '.open_ques', function () {
    var module_id = $(this).val();
    $.get(qUrl + '/list/' + module_id, function (questions) {
        //success data
        console.log(questions);
        $('#que-list').html("");
        if (questions) {
            $.each(questions, function (i, que) {

                $('#que-list').append(
                    '<tr id="que_' + que.id + '">'
                    + '  <td class="s_no">' + que.sno + '</td>'
                    + '  <td class="ques_content">' + que.content + '</td>'
                    //$($.parseHTML(que.content)).text().substring(0, 120)
                    + '  <td class="ques_actions">'
                    + '     <button class="btn btn-success que_edit" value="' + que.id + '" title="Edit"><i class="fa fa-edit" ></i></button>'
                    + '     <button class="btn btn-danger que_delete" value="' + que.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                    + '  </td>'
                    + '</tr>'
                );
            });
        } else {
            $('#que-list').append(
                '<tr >'
                + '  <td colspan="3">No question found.</td>'
                + '  </td>'
                + '</tr>'
            );
        }
//        $('#doc-list').html(data);
//        $('#doc-list').append(data);

    });
    $('#btn_add_question').val(module_id);
    $('#questionsModel').modal('show');

});

//display question form
$('#btn_add_question').click(function () {
    var module_id = $(this).val();
    $('#frmQuestion').trigger("reset");
    $('#addQuestionsModel').modal('show');
    $('#que_module_id').val(module_id);
    $('#que_id').val(0);
    console.log(module_id);
});

//create new question / update existing question
$("#btn-save-question").click(function (e) {
    // alert($('meta[name="_token"]').attr('content'));
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            contentType: "application/x-www-form-urlencoded"
        }
    });
    e.preventDefault();
    // var formData = {
    //     sno: $('#questiontbl tr').length,
    //     module_id: $('#que_module_id').val(),
    //     content: $('#question').val() //$('textarea#content').val()
    // };
    //used to determine the http verb to use [add=POST], [update=PUT]
    var state = ($('#que_id').val() == 0) ? 'add' : 'update';
    var type = "POST"; //for creating new resource
    var question_id = $('#que_id').val();

    var my_url = qUrl;
    if (state == "update") {
        type = "PUT"; //for updating existing resource
        my_url += '/' + question_id;
        var formData = {
            sno: $('#que_'+question_id+' .s_no').html(),
            module_id: $('#que_module_id').val(),
            content: $('#question').val() //$('textarea#content').val()
        };
    }
    else {
        var formData = {
            sno: $('#questiontbl tr').length,
            module_id: $('#que_module_id').val(),
            content: $('#question').val() //$('textarea#content').val()
        };
    }

    //console.log(formData);
    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function (que) {
            console.log(que);
            var question = '<tr id="que_' + que.id + '">'
                + '  <td class="s_no">' + que.sno + '</td>'
                + '  <td class="ques_content">' + que.content + '</td>'
                + '  <td class="ques_actions">'
                + '     <button class="btn btn-success que_edit" value="' + que.id + '" title="Edit"><i class="fa fa-edit" ></i></button>'
                + '     <button class="btn btn-danger que_delete" value="' + que.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                + '  </td>'
                + '</tr>'

            if (state == "add") { //if user added a new record
                $('#que-list').append(question);
                $.notify("Question has been added successfully.");
            } else { //if user updated an existing record
                $("#que_" + question_id).replaceWith(question);
                $.notify("Question has been updated successfully.");
            }
            $('#que_id').val(0);
            $('#frmQuestion').trigger("reset");
            $('#addQuestionsModel').modal('hide');

        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});

$(document).on('click', '.que_edit', function () {
    var que_id = $(this).val();

    $.get(qUrl + '/' + que_id, function (data) {
        //success data
        console.log(data);
        $('#que_module_id').val(data.module_id);
        $('#que_id').val(data.id);
        $('#question').val(data.content);
        // content: $('#question').val()
        // tinymce.get('question').setContent(data.content);
        $('#question').summernote('code', data.content);
        $('#btn-save-question').val("update");
        $('#addQuestionsModel').modal('show');
    });

});

//delete questions and remove it from list
$(document).on('click', '.que_delete', function () {
    var que_id = $(this).val();

    bootbox.confirm({
        title: "Delete Questions?",
        message: "Do you want to delete questions? This cannot be undone.",
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
                    url: qUrl + '/' + que_id,
                    success: function (data) {
                        console.log(data);
                        $("#que_" + que_id).remove();
                        $.notify("Questions have been deleted successfully.");
                        $('#frmQuestion').trigger("reset");
                        $('#que_id').val(0);

                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }

        }
    });

});

$("#que-list").sortable({
    stop: function (event, ui) {
        var data = [];
        $(this).find('tr').each(function (i) {
            var trid = $(this).attr('id').split('_');
//            console.log(trid.split('_'));
            $(this).find('td:first').text(i + 1);
            data.push({"q_id": trid[1], "sno": i + 1});

        });
        console.log(data);
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //contentType: 'application/json',
            //processData: false
        });
//    e.preventDefault();
        $.ajax({
            type: "PUT",
            url: qUrl + "/sort",
            data: JSON.stringify(data),
            dataType: 'json',
            success: function (data) {
                console.log('SORTED');
                //console.log(data);
            }
        });
    }
});