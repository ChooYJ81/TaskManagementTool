<div class="modal fade" id="manageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px">
    <div class="modal-content p-3">
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <p class="title-1 m-0">Manage Workspace</p>
        </div>

        <!--
        <div>
        <?php
          $taskWorkspaceID = base64_decode($_GET['workspace']);
          print($taskWorkspaceID);
        ?>
        </div>
        -->

        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit
        </p>

        <div id="manageModalSet">
          <div class="card">
            <div class="card-header collapsible-card-header-blue" id="headingOne" role=button data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              <h5 class="mb-0">
                Workspace Details
              </h5>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#manageModalSet">
              <div class="card-body">
                <form id="workspaceDetails">
                  <div class="col-12 mb-3">
                    <label class="form-label">Workspace Name</label>
                    <input class="form-control" type="text" name="workspaceName" placeholder="Name" required />
                  </div>

                  <div class="col mb-3">
                    <label class="form-label">Workspace Description</label>
                    <textarea class="form-control" rows="5" placeholder="Description" name="taskDesc" required></textarea>
                  </div>

                  <div class="w-100 text-center">
                    <button type="submit" class="btn btn-primary mt-4 px-5 b-0" style="background-color:var(--blue)" id=" ">Edit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header collapsible-card-header-blue" id="headingTwo" role=button data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h5 class="mb-0">
                Invitations
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#manageModalSet">
              <div class="card-body">
                <div class="text-center">
                  Workspace Code
                </div>
                <div class="text-center">
                  XXXXX
                </div>
                <div class="w-100 text-center">
                  <button type="submit" class="btn btn-primary mt-4 px-5 b-0" style="background-color:var(--blue)" id=" ">Disable Code</button>
                </div>

                <form>
                  <div class="col-12 mb-3">
                    <label class="form-label">Invite via Email</label>
                    <input class="form-control" type="text" name="email" placeholder="Enter recipient email" required />
                  </div>
                  <div class="w-100 text-center">
                    <button type="submit" class="btn btn-primary mt-4 px-5 b-0" style="background-color:var(--blue)" id=" ">Send Invitation</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header collapsible-card-header-blue" id="headingThree" role=button data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <h5 class="mb-0">
                Members
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