<div class="modal fade " id="documentModel" tabindex="-1" role="dialog" aria-labelledby="add_documentLabel" aria-hidden="true">
    <div class="modal-dialog big-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="add_documentLabel"> Documents</h4>
            </div>
            <div class="modal-body">
                @if ($message = Session::get('success'))
                <div class="success-notification" message="{{ $message }}">
                </div>

                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger upload-error">
                    <input type="hidden" value="{{session('module_id_doc')}}" id="upmodule_id">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div id="doc_tab" >	
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a  href="#list_doc" data-toggle="tab">List </a>
                        </li>
                        <li class="btn-secondary">
                            <a href="#add_doc" data-toggle="tab" class="btn-primary">Add New</a>
                        </li>

                    </ul>

                    <div class="tab-content ">
                        <div class="tab-pane active" id="list_doc">
                            <h3>List</h3>
                            <div class="panel-body"> 


                                <table class="table">
                                    <thead>
                                        <tr>
    <!--                                        <th>ID</th>-->
                                            <th>Description</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="doc-list" name="doc-list">

                                    </tbody>
                                </table>
                            </div>



                        </div>
                        <div class="tab-pane " id="add_doc">
                            <h3>New </h3>

                            <form action="{{ url('documents/upload') }}" enctype="multipart/form-data" method="POST">
                                {{ csrf_field() }}
                                <div class="row">

                                    <div class="form-group">
                                        <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="description" name="description" placeholder="description" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="file" class="col-sm-3 control-label">File</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="document" />
                                        </div>
                                    </div>
                                    <input type="hidden" id="doc_module_id" name="doc_module_id" value="0">
                                    <div class="col-sm-12 right">
                                        <button type="submit" class="btn btn-success">Upload</button>
                                    </div>
                                </div>
                            </form>   

                        </div>

                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>-->
                <!--<input type="hidden" id="module_id" name="module_id" value="0">-->
            </div>
        </div>
    </div>
</div>

@section('script')
@parent
<script src="{{asset('js/document.js')}}"></script>
@endsection