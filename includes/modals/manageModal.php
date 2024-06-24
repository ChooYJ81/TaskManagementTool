<!-- Manage Task Modal -->
<div class="modal fade" id="manageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px">
    <div class="modal-content p-3">
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <p class="title-1 m-0">Manage Workspace</p>
        </div>
        <p class="text-1 mb-4">
          Lorem ipsum dolor sit amet, consectetur adipiscing
          elit.
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
                <div class="mb-3">
                  <label class="input-label">Workspace Name</label>
                  <!-- name (placeholder) -->
                  <input type="text" class="inputs" placeholder="SWE3033 Software Process" />
                </div>
                <div class="mb-3">
                  <label class="input-label">Workspace Description</label>
                  <!-- description -->
                  <textarea class="inputs" rows="4" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lobortis eros ipsum vitae."></textarea>
                </div>
                <button class="button-fill mx-auto px-4">Edit</button>
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
                  <p class="workspace-code">W8SDJ</p>
                  <div class="d-flex justify-content-center">
                    <button class="button-fill me-3"><i class="bi bi-x me-3"></i>Disable Code</button>
                    <button class="button-fill ms-3"><i class="bi bi-arrow-repeat me-3"></i>Regenerate Code</button>
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
                <span class="badge accordion-badge ms-2">10</span>
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <table class="table table-borderless member-table align-middle">
                  <thead>
                    <tr>
                      <th class="text-start">No.</th>
                      <th>Name</th>
                      <th>Date Joined</th>
                      <th>Manage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td class="text-start">Kenneth</td>
                      <td>5/6/2024</td>
                      <td><span class="badge accordion-member-badge">Host</span></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td class="text-start">John Marcus</td>
                      <td>5/6/2024</td>
                      <td><button class="btn btn-danger" disabled style="padding: 0 5px;"><i class="bi bi-x"></i></button></td>
                    </tr>
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