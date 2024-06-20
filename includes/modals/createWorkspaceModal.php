<div class="modal fade" id="createWorkspaceModal" tabindex="-1" aria-labelledby="createWorkspaceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:33rem">
    <div class="modal-content">
      <div class="modal-body d-flex flex-column align-items-center my-3">
        <h4 class="fw-semibold">Create a New Workspace</h4>
        <p class="fw-light text-muted mb-4" style="font-size:0.75rem">Describe the workspace you are hosting</p>

        <!-- Create workspace form section -->
        <form class="w-100 px-5 d-flex flex-column" id="createWorkspaceForm">
          <div class="mb-4">
            <label for="workspaceName" class="form-label">Workspace Name</label>
            <input type="text" class="form-control" id="workspaceName" name="workspaceName" placeholder="Enter workspace name" required />
          </div>

          <div class="mb-4">
            <label for="workspaceType" class="form-label">Workspace Type</label>
            <select class="form-select" aria-label="Small select example" id="workspaceType" name="workspaceType" required>
              <option value="" selected disabled>Select workspace type</option>
              <option value="Personal">Personal</option>
              <option value="Collaboration">Collaboration</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="workspaceDesc" class="form-label">Workspace Description</label>
            <textarea class="form-control" id="workspaceDesc" name="workspaceDesc" maxlength="100" rows="5" placeholder="Enter workspace description" required></textarea>
          </div>

          <!-- The two pagination circle -->
          <div class="d-flex justify-content-center mt-3 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="var(--blue)" class="bi bi-circle-fill me-2" viewBox="0 0 16 16">
              <circle cx="8" cy="8" r="8" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#CECECE" class="bi bi-circle" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            </svg>
          </div>

          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary mt-4 px-5" style="background-color:var(--blue)" id="createWorkspaceButton">Create</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>

<script src="./scripts/createWorkspace.js"></script>