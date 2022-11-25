<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="container bg-danger">
        <div class="row justify-content-center">
          <i class="bi bi-x-circle text-center text-white" style="font-size: 90px;"></i>
        </div>
      </div>
      <div class="container justify-content-center pt-2 pb-3 text-center">
          <input type="hidden" id="user_id" />
          <h3 id="confirmationModalLabel"></h3>
          <p class="text-muted" id="confirmationMessage"></p>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="delete_confirmed">Delete</button>
      </div>
    </div>
  </div>
</div>