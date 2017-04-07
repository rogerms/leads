{{--add image modal form *************************************************************************  --}}
<div class="modal fade" id="add-image-modal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel">
    <form class="form-horizontal">
        <div class="form-group">
            <label for="inputfile" class="col-sm-2 control-label">File</label>
            <div class="col-sm-8">
                <input type="file" id="inputfile" name="photos[]" multiple >
            </div>
        </div>
        <div class="form-group">
            <label for="label" class="col-sm-2 control-label">Label</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="label" value="" placeholder="proposal">
            </div>
        </div>
        <div class="form-group">
            <label for="visibility" class="col-sm-2 control-label">Visibility</label>
            <div class="col-sm-8">
                <select class="form-control col-sm-6" id="visibility">
                    <option value="0">Private</option>
                    <option value="1" selected>Protected</option>
                    <option value="2">Public</option>
                </select>
            </div>
        </div>
    </form>
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
@can('edit-job')
<div id="contextMenu" class="dropdown clearfix">
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
        <li><a tabindex="-1">Delete</a></li>
        <li><a tabindex="-1">Change Label</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1">Private</a></li>
        <li><a tabindex="-1">Protected</a></li>
        <li><a tabindex="-1">Public</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1">Cancel</a></li>
    </ul>
</div>
@endcan
<!-- /context menu -->

{{--add phone modal form *************************************************************************  --}}
<div id="add-phone-modal" class="modal fade">
    <form class="form-horizontal">
        <div class="form-group">
            <label for="number" class="col-sm-2 control-label item1-label">Phone</label>
            <div class="col-sm-8">
                <input type="text" class="form-control item1-input" id="number">
            </div>
        </div>
        <div class="form-group">
            <label for="label" class="col-sm-2 control-label item2-label">Label</label>
            <div class="col-sm-8">
                <input type="text" class="form-control item2-input" id="label" placeholder="home">
            </div>
        </div>
    </form>
</div>

{{--email customer modal form *************************************************************************  --}}
<div id="email-customer-modal" class="modal fade">
    <form class="form-horizontal">
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">To</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="email" value="=email=">
            </div>
        </div>
        <div class="form-group">
            <label for="subject" class="col-sm-2 control-label">Subject</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="subject" placeholder="Job Proposal">
            </div>
        </div>
        <div class="form-group">
            <label for="message" class="col-sm-2 control-label">Message</label>
            <div class="col-sm-8">
                <textarea id="message" class="form-control" rows="3" placeholder="Message..."></textarea>
            </div>
        </div>
    </form>
</div>