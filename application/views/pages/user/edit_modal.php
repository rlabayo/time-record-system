
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
        <form id="form-edit-user">
            <input type="hidden" id="user_id" name="user_id">
            <input type="hidden" id="user_name_exists" />
            <div class="row mb-3">
                <div class="form-group form-group-edit-user-name">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" class="form-control" id="edit_user_name" name="edit_user_name" placeholder="Enter username">
                </div>
                <!-- <label for="user_name" class="form-label">Username</label>
                <div class="input-group mb-3 form-group-edit-user-name">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary" type="button"><i class="bi bi-person"></i></button>
                    </div>
                    <input type="text" class="form-control" id="edit_user_name" name="edit_user_name" placeholder="Enter username">
                </div> -->
            </div>
            <div class="row mb-3">
                <!-- <div class="form-group form-group-current-password">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password">
                </div> -->
                <label for="current_password" class="form-label">Current Password</label>
                <div class="input-group form-group-current-password">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary" onclick="view_password('current_password')" id="current_password_btn" type="button"><i class="bi bi-eye-fill"></i></button>
                    </div>
                      <input type="password" class="form-control" id="current_password" name="current_password" class="form-control" placeholder="Enter current password" minlength="10" >
                </div>
            </div>
            <div class="row mb-3">
                <!-- <div class="form-group">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password">
                </div> -->
                <label for="new_password" class="form-label">New Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary" onclick="view_password('new_password')" id="new_password_btn" type="button"><i class="bi bi-eye-fill"></i></button>
                    </div>
                      <input type="password" class="form-control" id="new_password" name="new_password" class="form-control" placeholder="Enter new password" minlength="10" >
                </div>
                <a class="text-decoration-none cursor-pointer w-auto" onclick="generate_password('new_password')">Generate Password</a>
            </div>
            <div class="row mb-3">
                <!-- <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="edit_confirm_password" name="edit_confirm_password" placeholder="Enter confirm password">
                </div> -->
                <label for="edit_confirm_password" class="form-label">Confirm Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary" onclick="view_password('edit_confirm_password')" id="edit_confirm_password_btn" type="button"><i class="bi bi-eye-fill"></i></button>
                    </div>
                      <input type="password" class="form-control" id="edit_confirm_password" name="edit_confirm_password" class="form-control" placeholder="Confirm password" minlength="10" >
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group">
                    <label for="edit_user_type" class="form-label">User Type</label>
                    <select class="form-select" id="edit_user_type" aria-label="Default select">
                      <option></option>
                      <option value="2">Admin</option>
                      <option value="1">Super Admin</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit_user">Save changes</button>
      </div>
    </div>
  </div>
</div>