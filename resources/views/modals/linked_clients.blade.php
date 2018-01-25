<div class="modal fade " id="linkedClient" tabindex="-1" role="dialog" aria-labelledby="linkedClientLabel" aria-hidden="true">
    <div class="modal-dialog big-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="linkedClientLabel"> Linked Clients </h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="linked_clients_list" name="linked_clients_list">
                                    
                                </tbody>
                            </table>
            </div>
            <div class="modal-footer ">

            </div>
        </div>
    </div>
</div>

@section('script')
@parent

</script>
@endsection