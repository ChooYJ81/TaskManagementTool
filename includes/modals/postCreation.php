<div class="modal fade" id="postCreationModal" tabindex="-1" aria-labelledby="postCreationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:33rem">
    <div class="modal-content">
      <div class="modal-body d-flex flex-column align-items-center my-3">
        <h4 class="fw-semibold" style="color:#2A386E">Workplace Created Successfully!</h4>
        <p class="fw-light text-muted mb-4" style="font-size:0.75rem">You can invite people to your workspace via the generated code</p>

        <!-- Create workspace form section -->
        <img src="./images/workspaceCode.png" class="mb-4" style="width: 12rem" />

        <h5 style="color:#2A386E">Workspace Code:</h5>
        <h3 class="fw-semibold mb-4" id="postWorkspaceCode" style="color:#3284BA">A1B2C3D4</h3>

        <p class="fw-light text-muted mb-4 text-center" style="font-size:0.75rem">To manage or send invitations via email, navigate to <br> Workspace > Manage Workspae</p>


        <!-- The two pagination circle -->
        <div class="d-flex justify-content-center mt-3 mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#CECECE" class="bi bi-circle me-2" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="var(--blue)" class="bi bi-circle-fill" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="8" />
          </svg>
        </div>

        <div class="d-flex justify-content-center">
          <a class="btn btn-primary mt-4 px-5" style="background-color:var(--blue)" id="viewWorkspaceBtn">View Workspace</a>
        </div>

        </form>
      </div>
    </div>
  </div>
</div>