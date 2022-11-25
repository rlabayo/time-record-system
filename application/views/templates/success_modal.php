<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="container bg-success py-1">
        <div class="row justify-content-center">
          <i class="bi bi-check-circle text-center text-white" style="font-size: 90px;"></i>
        </div>
      </div>
      <div class="container justify-content-center pt-2 pb-3 text-center">
          <h3 id="successModalLabel"></h3>
          <p class="text-muted" id="successMessage"></p>
          <button type="button" class="btn btn-primary" onclick="refresh_page()">Close</button>
      </div>
    </div>
  </div>
</div>