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
                            <label for="title" class="sr-only">Label</label>
                            <input type="text" class="form-control" id="label" name="label" placeholder="Label">
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
                {{--<img src=""  alt="view sketch" id="img-holder" class="img-thumbnail">--}}
                <iframe id="img-holder" src="" style="width:870px; height:750px;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>



<!-- context menu -->
<div id="contextMenu" class="dropdown clearfix">
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
        <li><a tabindex="-1">Delete</a></li>
        <li><a tabindex="-1">Private/Public</a></li>
        <li><a tabindex="-1">Change Label</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1">Cancel</a></li>
    </ul>
</div>
<!-- /context menu -->

{{--add phone modal form *************************************************************************  --}}
<div id="add-phone-modal" class="modal fade">
    <form class="form-horizontal">
        <div class="form-group">
            <label for="number" class="col-sm-2 control-label">Phone</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="number" placeholder="phone#">
            </div>
        </div>
        <div class="form-group">
            <label for="label" class="col-sm-2 control-label">Label</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="label" placeholder="home">
            </div>
        </div>
    </form>
</div>