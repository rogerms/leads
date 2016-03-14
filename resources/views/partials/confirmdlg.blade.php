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
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmOk" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>