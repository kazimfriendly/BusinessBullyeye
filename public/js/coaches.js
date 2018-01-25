var coUrl = app.base_url + "/coaches";
//display package form
$(document).on('click', '#btn_add_coach', function () {
//     $.get(url + '/live' , function (data) {

    $('#frmCoach').trigger("reset");
    $('#newCoachModal').modal('show');

});

$("#btn-save-coachww11").click(function (e) {
    // alert($('meta[name="_token"]').attr('content'));
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
        status: $('#status').val()
    };

    console.log(formData);
    $.ajax({
        type: "POST",
        url: app.base_url + "/coaches",
        data: formData,
        dataType: 'json',
        success: function (data) {
            $.notify("Coach have been added successfully.");
            console.log(data);
            if(data[1]== 0){
            $('#coach-list').append('<tr id="coache_'+data[0].id+'" class="coaches_coach">'
                          +'<td><strong>[Coach]</strong> '+data[0].email+'</td>'
                           +' <td><button class="btn btn-success viewpackages" value="'+data[0].id+'" title="Show Modules"><i class="fa fa-caret-square-o-down" ></i> Show Packages</button>'
                            +' <form enctype="multipart/form-data" class="form-inline" role="form" method="POST"  id="deleteForm_'+data[0].id+'" action="'+coUrl+'/'+data[0].id+') }} " style="display: inline;">'
                                     +'<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">'
                                     + '<input type="hidden" name="_method" value="DELETE">'
                                      +'     <button type="button" class="btn btn-danger btn-delete delete-coach " value="'+data[0].email+'" id="delete_coach_'+data[0].id+'"  title="Delete">'
                                      +'       <i class="fa fa-remove" ></i></button>'
                                      +'      </form>'
                            +'</td>'
                            +'</tr>');
            $('#frmCoach').trigger("reset");
        } 
        else
        {
            $.notify("Coach already there.");
        }
            $('#newCoachModal').modal('hide');
            

        },
        error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
            $('#newCoachModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message
            $.notify("Error :" + $(xhr.responseText).find('.exception_message').html());
        }
    });


});