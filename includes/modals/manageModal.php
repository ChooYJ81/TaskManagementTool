<!-- Manage Task Modal -->
<div class="modal fade" id="manageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px">
    <div class="modal-content p-3">
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <p class="title-1 m-0">Manage Workspace</p>
        </div>
        <p class="text-1 mb-4">
          Manage your workspace
        </p>

        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="bi bi-card-text me-2"></i>Workspace Details
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
              <div class="accordion-body d-flex flex-column">
                <form id="editWorkspace">
                  <div class="mb-3">
                    <label class="input-label">Workspace Name</label>
                    <!-- name (placeholder) -->
                    <input type="text" class="inputs" placeholder="Enter workspace name" name="editWorkspaceName" id="editWorkspaceName" />
                  </div>
                  <div class="mb-3">
                    <label class="input-label">Workspace Description</label>
                    <!-- description -->
                    <textarea class="inputs" rows="4" placeholder="Enter workspace details." name="editWorkspaceDesc" id="editWorkspaceDesc"></textarea>
                  </div>
                  <div class="d-flex justify-content-center">
                    <button class="button-fill px-4" type="submit">Edit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="bi bi-send-plus me-2"></i>Invitations
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body d-flex flex-column">
                <div class="text-center">
                  <p class="workspace-code-title mb-1">Workspace Code</p>
                  <p class="workspace-code" id="modalWorkspaceCode">Disabled</p>
                  <div class="d-flex justify-content-center">
                    <button class="button-fill me-3" id="disableCodeBtn"><i class="bi bi-x me-3"></i>Disable Code</button>
                    <button class="button-fill ms-3" id="regenerateCodeBtn"><i class="bi bi-arrow-repeat me-3"></i>Regenerate Code</button>
                  </div>
                </div>
                <hr style="opacity: 1;">
                <div class="mb-3">
                  <label class="input-label">Invite via Email</label>
                  <input class="inputs" type="text" placeholder="Enter recipient email" />
                </div>
                <button class="button-fill mx-auto px-3">Send Invitation</button>

              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="bi bi-people me-2"></i>Members
                <!-- members number -->
                <span class="badge accordion-badge ms-2" id="memberNoBadge">0</span>
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <table class="table table-borderless member-table align-middle">
                  <thead>
                    <tr>
                      <th class="text-start">No.</th>
                      <th class="text-start">Name</th>
                      <th>Manage</th>
                    </tr>
                  </thead>
                  <tbody id="manageMemberList">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="./scripts/manageWorkspace.js"></script>