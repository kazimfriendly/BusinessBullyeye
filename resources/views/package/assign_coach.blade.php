@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-11 ">
            <br>
            <form id="frmCoachAssign" name="frmClient" class="form-horizontal" method="POST" action="{{url("/packages/assign_coach")}}">
                 {{ csrf_field() }}
                    <div class="form-group">
                       
                            <label class="col-sm-1 control-label">Package</label>
                             <div class="col-xs-11">
                            <input type="text" class="form-control has-error" value="{{$package->title}}" disabled="true" id="package_name"/>
                            <input type="hidden"  value="{{$package->id}}" id="package_id" name="package_id"/>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div class="col-xs-5">
                            <label>Available Coaches</label>
                            <select name="AllCoaches[]" class="multiselect form-control" size="8" multiple="multiple" data-right="#multiselect_to_1" data-right-all="#right_All_1" data-right-selected="#right_Selected_1" data-left-all="#left_All_1" data-left-selected="#left_Selected_1">
                                @foreach ($coaches as $coach)
                                <option value="{{ $coach->id }}">{{ $coach->name }} [ {{ $coach->email}} ]</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-2">
                            <br>
                            <button type="button" id="right_All_1" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                            <button type="button" id="right_Selected_1" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                            <button type="button" id="left_Selected_1" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                            <button type="button" id="left_All_1" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                        </div>
                        <label>Assigned Coach(es)</label>
                        <div class="col-xs-5">
                            <select name="assignedCoaches[]" id="multiselect_to_1" class="form-control" size="8" multiple="multiple">
                                  @foreach ($assignedCoaches as $coach)
                                <option value="{{ $coach->id }}">{{ $coach->name }} [ {{ $coach->email}} ]</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="frmModule-footer"></div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary" id="btn-save-client" value="add">Save changes</button>
                   
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
@parent
<script type="text/javascript" src="{{ asset('js/multiselect.min.js') }}"></script>
<script type="text/javascript">
jQuery(document).ready(function ($) {
    $('.multiselect').multiselect();
});
</script>
<script>
    /*  $(document).ready(function () {
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
     //        var $btn = $(this);
     //    $btn.button('loading');
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
     }); */
</script>
@endsection

@section('css')
@parent



@endsection

@section('heading')
Assign Package
@endsection

@section('title')
Assign Coach on Package
@endsection

@section('breadcrumbs')
Assign Coach
@endsection