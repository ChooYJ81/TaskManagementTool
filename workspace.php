<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <title>Workspace</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link href="css/style.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
</head>

<body>
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content collapsed">
      <?php if (isset($_GET['workspace'])) { ?>
        <!-- date -->
        <p class="date" id="today"></p>
        <hr class="w-100" />
        <!-- hosted -->
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-1" id="workspaceHistory">

            </p>
            <div class="d-flex align-items-center title-1">
              <!-- title -->
              <p class="m-0" id="workspaceTitle"></p>
              <i class="bi bi-dot mx-1 fs-2" style="color: #f0f0f0"></i>
              <i class="bi bi-people-fill me-2"></i>
              <p class="m-0 text-dark fw-medium" id="membersNo"></p>
            </div>
            <!-- description -->
            <p class="text-2 mb-5" id="workspaceDescription">
            </p>
          </div>
          <button class="manage-button" data-bs-target="#manageModal" data-bs-toggle="modal">
            <i class="bi bi-gear me-2 fs-5"></i>Manage Workspace
          </button>
        </div>

        <!-- card -->
        <div class="row justify-content-around">

          <!-- To-do -->
          <div class="col-4 text-center">
            <div class="card mb-4">
              <div class="card-body d-flex justify-content-between align-items-center py-1">
                <div class="d-flex">
                  <p class="progress-title">To-dos</p>
                  <p class="progress-title-number ms-2 my-auto">
                    <!-- no. of to-dos task -->
                    10
                  </p>
                </div>
                <a href="#" class="createTask" create-type="To-Do" data-bs-target="#createModal" data-bs-toggle="modal">
                  <i class="bi bi-plus"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- In Progress -->
          <div class="col-4 text-center">
            <div class="card mb-4">
              <div class="card-body d-flex justify-content-between align-items-center py-1">
                <div class="d-flex">
                  <p class="progress-title">In Progress</p>
                  <p class="progress-title-number ms-2 my-auto">
                    <!-- no. of in progress task -->
                    10
                  </p>
                </div>
                <a href="#" class="createTask" create-type="In Progress" data-bs-target="#createModal" data-bs-toggle="modal">
                  <i class="bi bi-plus"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Completed -->
          <div class="col-4 text-center">
            <div class="card mb-4">
              <div class="card-body d-flex justify-content-between align-items-center py-1">
                <div class="d-flex">
                  <p class="progress-title">Completed</p>
                  <p class="progress-title-number ms-2 my-auto">
                    <!-- no. of completed task -->
                    0
                  </p>
                </div>
                <a href="#" class="createTask" create-type="Completed" data-bs-target="#createModal" data-bs-toggle="modal">
                  <i class="bi bi-plus"></i>
                </a>
              </div>
            </div>
            <!-- if no task -->
            <p style="font-size: 0.875rem; color: #878787">No task.</p>
          </div>
        </div>
      <?php } else { ?>
        <div class="d-flex justify-content-center align-items-center h-100">
          <p class="text-1">Select a workspace to view its content.</p>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- modals -->
  <?php include 'includes/modals/addTask.php'; ?>

  <script src="./scripts/sidebar.js"></script>
  <script src="scripts/workspace.js"></script>
</body>

</html>