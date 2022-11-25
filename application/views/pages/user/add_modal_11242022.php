
<!-- Modal -->
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modal_title" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_modal_title">Add Modal</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-add-user">
            <div class="row mb-3">
                <div class="form-group form-group-user-name">
                    <label for="user_name">Username</label>
                    <!-- <input type="hidden" id="temp_user_name" /> -->
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User name">
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" minlength="10">
                    <!-- <a class="text-decoration-none" style="cursor:pointer" onclick='generate_password()' >Generate password</a> -->
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Please confirm password" minlength="10">
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group">
                    <label for="user_type">User Type</label>
                    <select class="form-select" id="user_type" name="user_type" aria-label="Default select">
                      <option value="1">Admin</option>
                      <option value="2">Super Admin</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel_insert_user">Cancel</button>
        <button type="submit" class="btn btn-primary" id="submit_user">Save changes</button>
      </div>
    </div>
  </div>
</div>