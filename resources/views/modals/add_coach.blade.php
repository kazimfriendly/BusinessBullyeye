
<div class="modal fade " id="newCoachModal" tabindex="-1" role="dialog" aria-labelledby="coachModalLabel" aria-hidden="true">
    <div class="modal-dialog big-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="coachModalLabel"> New Coach </h4>
            </div>
            <form id="frmCoach" name="frmCoach" class="form-horizontal" novalidate="">
                <div class="modal-body">

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <input type="hidden" id="status" name="status" value="2">


                    <div class="frmModule-footer"></div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary" id="btn-save-coach" value="add">Save changes</button>

                </div>
            </form>
        </div>
    </div>
</div>
@section('script')
@parent
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>

<script>
$(document).ready(function () {
    $('#frmCoach').bootstrapValidator({
        message: 'This value is not valid',
        trigger: 'keyup',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'Name cannot have numbers or symbols'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    regexp: {
                        regexp: /^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},?){1,6}$/,
                        message: 'Enter valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    },
                    stringLength: {
                        min: 6,
                        message: 'The password must have at least 6 characters'
                    }
                }
            }
        }
    }).on('error.form.bv', function(e) {
         $('#btn-save-coach').button('reset');
            console.log('error.form.bv');
            // You can get the form instance and then access API
            var $form = $(e.target);
            console.log($form.data('bootstrapValidator').getInvalidFields());
            // If you want to prevent the default handler (bootstrapValidator._onError(e))
             e.preventDefault();
        }).on('success.form.bv', function (e) {
        // Prevent form submission
        e.preventDefault();
        $('#frmCoach').data('bootstrapValidator').resetForm();
//            var $btn = $("#btn-save-client");
//            $btn.button('loading');
//    setTimeout(function () {
//        $btn.button('reset');
//    }, 10000);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
//    e.preventDefault();
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
                if (data[1] == 0) {
                    $('#coach-list').append('<tr id="coache_' + data[0].id + '" class="coaches_coach">'
                            + '<td><strong>[Coach]</strong> ' + data[0].email + '</td>'
                            + ' <td><button class="btn btn-success viewpackages" value="' + data[0].id + '" title="Show Modules"><i class="fa fa-caret-square-o-down" ></i> Show Packages</button>'
                            + ' <form enctype="multipart/form-data" class="form-inline" role="form" method="POST"  id="deleteForm_' + data[0].id + '" action="' + coUrl + '/' + data[0].id + ') }} " style="display: inline;">'
                            + '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">'
                            + '<input type="hidden" name="_method" value="DELETE">'
                            + '     <button type="button" class="btn btn-danger btn-delete delete-coach " value="' + data[0].email + '" id="delete_coach_' + data[0].id + '"  title="Delete">'
                            + '       <i class="fa fa-remove" ></i></button>'
                            + '      </form>'
                            + '</td>'
                            + '</tr>');
                    $('#frmCoach').trigger("reset");
                } else
                {
                    $.notify("Coach already there.");
                }
                $('#newCoachModal').modal('hide');
                $('#btn-save-coach').button('reset');

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
});

$('#btn-save-coach').click(function () {
    var $btn = $(this);
    $btn.button('loading');
    setTimeout(function () {
        $btn.button('reset');
    }, 20000);
});
</script>
@endsection
