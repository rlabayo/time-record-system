
<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal_title" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit_modal_title">Edit Modal</h5>
        <button type="button" class="close border-0 bg-white" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-edit-employee">
            <input type="hidden" id="emp_id" name="emp_id">
            <div class="row mb-3">
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="edit_first_name" name="edit_first_name" placeholder="Enter first name">
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="edit_last_name" name="edit_last_name" placeholder="Enter last name">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_employee">Save changes</button>
      </div>
    </div>
  </div>
</div>