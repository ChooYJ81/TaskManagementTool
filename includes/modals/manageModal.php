<div class="modal fade" id="manageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px">
    <div class="modal-content p-3">
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <p class="title-1 m-0">Manage Workspace</p>
        </div>

        <div>
        <?php
          $taskWorkspaceID = base64_decode($_GET['workspace']);
          print($taskWorkspaceID);
        ?>
        </div>

        <div id="manageModalSet">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  Workspace Details
                </button>
              </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#manageModalSet">
              <div class="card-body">
                1
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Invitations
                </button>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#manageModalSet">
              <div class="card-body">
                2
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingThree">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Members
                </button>
              </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#manageModalSet">
              <div class="card-body">
                3
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>