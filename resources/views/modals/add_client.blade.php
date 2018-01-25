<div class="modal fade " id="newClientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog big-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="clientModalLabel"> New Client </h4>
            </div>
            <form id="frmClient" name="frmClient" class="form-horizontal" >
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
                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required>

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



                    <div class="frmModule-footer"></div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary" id="btn-save-client" value="add">Save changes</button>
                    <input type="hidden" id="package_id" name="client_id" value="0">
                </div>
            </form>
        </div>
    </div>
</div>

<!--Existing Client form-->

<div class="modal fade " id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog big-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="clientModalLabel"> Existing  Client </h4>
            </div>
            <form id="frmAddClient" name="frmAddClient" class="form-horizontal" >
                <div class="modal-body">



                    <div class="form-group{{ $errors->has('emails') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Addresses In Comma separated format</label>

                        <div class="col-md-6">
                            <input id="emails" type="text" class="form-control" name="emails" value="{{ old('email') }}" required>


                        </div>
                    </div>




                    <div class="frmModule-footer"></div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary" id="btn-save-addclient" value="add">Save changes</button>
                    <input type="hidden" id="package_id" name="package_id" value="0">
                </div>
            </form>

        </div>
    </div>
</div>

@section('script')
@parent
<script>
    $(document).ready(function () {
        $('#frmClient').bootstrapValidator({
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
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();
            $('#frmClient').data('bootstrapValidator').resetForm();
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
                package_id: $('#package_id').val()
            };
            console.log(formData);
            $.ajax({
                type: "POST",
                url: app.base_url + "/clients",
                data: formData,
                dataType: 'json',
                success: function (data) {
//                    $btn.button('reset');
                    $.notify("Client have been added successfully.");
                    console.log(data);
                    $('#clients_' + $('#package_id').val()).html(data.totalclients);
                    $('#frmClient').trigger("reset");
                    $('#newClientModal').modal('hide');
                },
                error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
$('#frmClient').trigger("reset");
                    $('#newClientModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message
                    $.notify("Error :" + $(xhr.responseText).find('.exception_message').html());
                }
            });
        });


        $('#frmAddClient').bootstrapValidator({
            message: 'This value is not valid',
            trigger: 'keyup',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                emails: {
                    validators: {
                        notEmpty: {
                            message: 'The email addresses is required'
                        },
                        regexp: {
                            regexp: /^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},?){1,6}$/,
                            message: 'The input is not valid (email comma seperated with no space)'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();
            $('#frmAddClient').data('bootstrapValidator').resetForm();
//            var $btn = $("#btn-save-addclient");
//            $btn.button('loading');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                    
//                    $btn.button('reset');
                    if(data.clients == " ")
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
                    $('#frmAddClient').trigger("reset");
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message

                    $.notify({
                        message: "Error :" + $(xhr.responseText).find('.exception_message').html(),
                        type: 'danger'
                    });
                }
            });
        });
    });
    
    $('#btn-save-addclient, #btn-save-client').click(function () {
     var $btn = $(this);
            $btn.button('loading');
    setTimeout(function () {
        $btn.button('reset');
    }, 10000);
});
</script>
@endsection

@section('css')
@parent



@endsection