<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog big-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel"> Module</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmModules" name="frmModules" class="form-horizontal" novalidate="">
                            <div class="form-group error">
                                <label for="inputName" class="col-sm-3 control-label">Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control has-error" id="title" name="title" placeholder="Module title" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="description" name="description" placeholder="description" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputDetail" class="col-sm-3 control-label">Introduction and Guidelines</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="content" name="content" ></textarea>
                                </div>
                            </div>

                        </form>
                        
                        <div class="frmModule-footer"></div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                        <input type="hidden" id="module_id" name="module_id" value="0">
                    </div>
                </div>
            </div>
        </div>

@section('script')
     @parent
    <script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
tinymce.init({
    selector: 'textarea',
    height: 300,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code',
        'textcolor'
    ],
    toolbar: 'undo redo | insert | styleselect | fontsizeselect | bold italic | forecolor | backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ',
    content_css: '//www.tinymce.com/css/codepen.min.css'
});
    </script>
    @endsection