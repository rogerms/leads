{{--add delete confirmation modal form *************************************************************************  --}}
<div class="modal fade" id="delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="deleteConfirmationLabel">Delete</h4>
            </div>
            <div class="modal-body">
                <div>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
                <div id="message">Are you sure you want to delete this item?</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmOk" class="btn btn-primary">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- create new label modal dialog *************************************************************************  --}}
<div class="modal fade" id="new-label-dialog" tabindex="-1" role="dialog" aria-labelledby="new-label-dialog-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="new-label-dialog-label">New Label</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="label-name">Please enter a new label name</label>
                    <input type="text" class="form-control" id="label-name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmOk" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>