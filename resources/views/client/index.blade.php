

@extends('layouts.app')

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-12 ">
            <!--<button id="btn_add_package" name="btn_add_package" class="btn btn-secondary pull-right" >New Package</button>-->
            @if ($message = Session::get('success'))
            <div class="success-notification" message="{{ $message }}">
            </div>

            @endif

            <!--Clients Order by Packages-->
            <div class="panel-body"> 


                <table class="table">
                    <thead>
                        <tr>
                            <!--<th style="width: 14px;"></th>-->
                            <th>Name </th>
                            <!--<th> </th>
                            <th> </th>-->
                        </tr>
                    </thead>
                    <tbody id="clients-list" name="clients-list">
                        @foreach ($coaches as $coache)
                        <tr id="coache_{{$coache->id}}" class="coaches_list">
                            <!--<td>+</td>-->
                            <td><strong>[{{ ($coache->getUserStatus($users)==2)?'Coach':'Admin'}}]</strong> {{$coache->getEmail($users)}}</td>
                            <td><button class="btn btn-success viewclients" value="{{$coache->id}}" title="Show Clients"><i class="fa fa-caret-square-o-down" ></i> Show Clients</button></td>
                        </tr>
                        @foreach ($coache->getClients($users,$collection) as $client)
                        @if($loop->index == 0)
                        <tr id="coach_{{$coache->id}}" class="coach_clients">
                            <td colspan="3">                 
                                <table class="table">
                                    <tbody id="clients-list" name="clients-list">                            
                                        @endif
                                        <tr class="coach_client">
                                            <!--<td>-</td>-->
                                            <td>{{$client->email}}</td> 
                                            <td>
                                                <form enctype='multipart/form-data' class="form-horizontal" role="form" method="POST"  id="deleteForm_{{$client->id}}" action="{{ url("clients/".$client->id) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="button" class="btn btn-danger btn-delete delete-client " value="{{$client->id}}" id="delete_client_{{$client->id}}"  title="Delete">
                                                        <i class="fa fa-remove" ></i></button>
                                                    <input type="hidden" name="coache_id" value="{{$coache->id}}" />

                                                </form>

                                            </td>
                                        </tr>

                                        @if($loop->count+1 == $loop->last)
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endif                        
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!--       incluides here-->
    </div>

</div>

@endsection

@section('heading')
Clients <!--<small>management</small>-->
@endsection

@section('title')
Clients
@endsection

@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--<script src="{{asset('js/client.js')}}"></script>-->
<script>
    $(document).ready(function () {
        console.log("ready!");
        $('[id^=coach_]').hide();
    });
    $(document).on('click', '.viewclients', function (e) {
        var coach_id = $(this).val();
        $('[id^=coach_' + coach_id + ']').toggle();
    });
    $(document).ready(function () {
        if ($('.success-notification').length) {
            $.notify($('.success-notification').attr("message"));
        }

    });
    $('[id^=delete_client_]').click(function () {
        delbtn = $(this);
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
</script>
@endsection
