
<!-- Modal -->
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modal_title" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_modal_title">Add Modal</h5>
        <button type="button" class="close border-0 bg-white" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-add-user">
            <div class="row mb-3">
                <div class="form-group form-group-user-name">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User name">
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary" onclick="view_password('password')" id="password_btn" type="button"><i class="bi bi-eye-fill"></i></button>
                    </div>
                      <input type="password" class="form-control" id="password" name="password" class="form-control" placeholder="Enter password" minlength="10" >
                </div>
                <a class="text-decoration-none cursor-pointer w-auto" onclick="generate_password('password')">Generate Password</a>
            </div>
            <div class="row mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary" onclick="view_password('confirm_password')" id="confirm_password_btn" type="button"><i class="bi bi-eye-fill"></i></button>
                    </div>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" class="form-control" placeholder="Please confirm password" minlength="10" >
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group">
                    <label for="user_type">User Type</label>
                    <select class="form-select" id="user_type" name="user_type" aria-label="Default select">
                      <option value="2">Admin</option>
                      <option value="1">Super Admin</option>
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