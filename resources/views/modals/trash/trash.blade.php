<div id="trash_modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    Select an action
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input type="hidden" name="task_id">
                </div>
                <div class="form-check">
                    <input id="delete" type="radio" value="delete" name="action" autocomplete="false" checked>
                    <label for="delete" class="form-check-label">
                        - Delete
                    </label>
                </div>
                <div class="form-check">
                    <input id="restore" type="radio" value="restore" name="action" autocomplete="false">
                    <label for="restore" class="form-check-label">
                        - Restore
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button id="submit" type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
