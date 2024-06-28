<div class="modal fade" id="joinWorkspaceModal" tabindex="-1" aria-labelledby="joinWorkspaceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:33rem">
    <div class="modal-content">
      <div class="modal-body d-flex flex-column align-items-center my-3">
        <h4 class="fw-semibold" style="color:#2A386E">Join Workspace</h4>
        <p class="fw-light text-muted mb-4" style="font-size:0.75rem">Enter the workspace code provided by the owner to join</p>
        <img src="./images/joinWorkspace.png" class="mb-4" style="width: 12rem" />
        <form class="w-100 px-5 d-flex  justify-content-center align-items-center" id="joinWorkspaceForm">
          <input type="text" class="form-control me-3" id="workspaceCode" name="workspaceCode" placeholder="Enter workspace code" required autocomplete="off" />
          <button type="submit" class="btn btn-primary  px-1 w-50" style="background-color:var(--blue)" id="joinWorkspaceButton"><i class="bi bi-arrow-right me-2"></i> Join</button>
        </form>
      </div>
    </div>
  </div>
</div>
