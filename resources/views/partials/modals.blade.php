{{--add image modal form *************************************************************************  --}}
<div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addImageModalLabel">Image</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline">
                    <div class="row-extra-bm-pad">
                    <div class="form-group">
                        <input type="file" id="inputfile" name="photos[]" multiple  >
                    </div>
                    </div>
                    <div class="row row-extra-bm-pad">
                        <div class="form-group">
                            <label for="title" class="sr-only">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="uploadImage" class="btn btn-primary">Upload image</button>
            </div>
        </div>
    </div>
</div>


{{--show image modal form *************************************************************************  --}}
<div class="modal fade bs-example-modal-lg" id="showImageModal" tabindex="-1" role="dialog" aria-labelledby="showImageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="showImageModalLabel">Image</h4>
            </div>
            <div class="modal-body">
                <img src=""  alt="view sketch" id="img-holder" class="img-thumbnail">
            </div>
        </div>
    </div>
</div>



        <!-- context menu -->
<div id="contextMenu" class="dropdown clearfix">
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
        <li><a tabindex="-1">Delete</a></li>
        <li><a tabindex="-1">Select</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1">Cancel</a></li>
    </ul>
</div>
<!-- /context menu -->