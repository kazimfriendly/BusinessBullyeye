@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >
        
        <div class="col-xs-3">
            <!-- required for floating -->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs tabs-left">
                <li class="active"><a href="#edit" data-toggle="tab">Edit Profile</a></li>
                <li><a href="#cpwd" data-toggle="tab">Change Password</a></li>
                <li><a href="#dp" data-toggle="tab">Change Avatar</a></li>
                 <li><a href="{{url('profile/'.$user->id)}}">View Profile</a></li>
                
            </ul>
        </div>
        <div class="col-xs-9">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="edit">
                    @if ($message = Session::get('success'))
                            <div class="success-notification" message="{{ $message }}">
                            </div>

                            @endif
                    
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('profile/update/'.$user->id)}}">
                        {{ csrf_field() }}
                         {{ method_field('PUT') }}
                        <input type="hidden" name="type" value="detail"/>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">About you</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control" name="description"  >{{$user->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="tab-pane" id="cpwd">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('profile/update/'.$user->id)}}">
                        {{ csrf_field() }}
                         {{ method_field('PUT') }}
                        <input type="hidden" name="type" value="cpasword"/>
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

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                
                </div>
                <div class="tab-pane" id="dp">
                    <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('profile/update/'.$user->id)}}">
                        {{ csrf_field() }}
                          {{ method_field('PUT') }}
                        <input type="hidden" name="type" value="dp"/>
                        
                        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Upload Avatar</label>

                            <div class="col-md-6">
                                <input id="avatar" type="file" class="form-control" name="avatar" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                          <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                
            </div>
        </div>
        <div class="clearfix"></div>
        
        </div>
    </div>
    <!-- includes here-->

</div>


@endsection

@section('heading')
User <small>Profile Edit</small>
@endsection

@section('title')
Profile edit
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
$( document ).ready(function() {
    if ($('.success-notification').length){
        $.notify($( '.success-notification' ).attr( "message" ));
    }
    });
</script>

@endsection

@section('css')
<style>
    .tabs-left, .tabs-right {
  border-bottom: none;
  padding-top: 2px;
}
.tabs-left {
  border-right: 1px solid #ddd;
}
.tabs-right {
  border-left: 1px solid #ddd;
}
.tabs-left>li, .tabs-right>li {
  float: none;
  margin-bottom: 2px;
}
.tabs-left>li {
  margin-right: -1px;
}
.tabs-left>li>a {
  border-radius: 4px 0 0 4px;
  margin-right: 0;
  display:block;
}
.tabs-left>li.active>a,
.tabs-left>li.active>a:hover,
.tabs-left>li.active>a:focus {
  border-bottom-color: #ddd;
  border-right-color: transparent;
}
</style>
@endsection

