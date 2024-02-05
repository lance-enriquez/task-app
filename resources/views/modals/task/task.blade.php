<div id="task_modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div id="title-header" class="modal-title"></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="task_id">
                </div>
                <div class="form-group">
                    <label for="title">Title: <small style="{color:grey}">max of 100 characters.</small></label>
                    <input id="title" type="text" class="form-control modal-form-input" name="title" required>
                </div>
                <div class="form-group">
                    <label for="task_status">Status:</label>
                    <select id="task_status" class="form-control" name="task_status_id" required></select>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" class="form-control modal-form-input" name="content" placeholder="Type here...." required></textarea>
                </div>
                <div class="form-group form-check">
                    <label for="save_as_draft" class="form-check-label">
                        Save as draft
                    </label>
                    <input id="save_as_draft" class="form-check-input" type="checkbox" value="" name="is_draft">
                </div>
            </div>
            <div class="modal-footer">
                <button id="delete" type="button" class="btn btn-danger" hidden>Delete</button>
                <button id="submit" type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
