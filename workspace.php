<?php include 'includes/validateUser.php'; ?>

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
  <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
</head>

<body id="workspaceBody">
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
              <p class="m-0 text-dark fw-medium" id="membersNo">0</p>
            </div>
            <!-- description -->
            <p class="text-2 mb-5" id="workspaceDescription">
            </p>
          </div>
          <button class="manage-button" data-bs-target="#manageModal" data-bs-toggle="modal" id="manageWorkspaceBtn">
            <i class="bi bi-gear me-2 fs-5"></i>Manage Workspace
          </button>
        </div>

        <!-- card -->
        <div class="row justify-content-around">

          <!-- To-do -->
          <div class="col-4 d-flex flex-column align-items-center pe-5">
            <div class="w-100 card mb-4">
              <div class="card-body d-flex justify-content-between align-items-center py-1">
                <div class="d-flex">
                  <p class="progress-title">To-dos</p>
                  <p class="progress-title-number ms-2 my-auto" id="toDoQty">
                    <!-- no. of to-dos task -->
                    0
                  </p>
                </div>
                <a href="#" class="createTask" create-type="To-Do" data-bs-target="#createModal" data-bs-toggle="modal">
                  <i class="bi bi-plus"></i>
                </a>
              </div>
            </div>
            <div class="w-100 container-draggable d-flex flex-column flex-grow-1" id="toDoColumn">
            </div>

            <!-- Looping tasks
            <div class="w-100 card mb-3">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="badge rounded-pill low-prio">Low Priority</span>
                  <a href="#" data-bs-target="#viewModal" data-bs-toggle="modal"
                    ><i class="bi bi-three-dots-vertical fs-5 me-2"></i
                  ></a>
                </div>
                <p class="task-title mb-2">Task Title</p>
                <p class="text-1 mb-3">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                  lobor eros ipsum vitae.
                </p>
              </div>
            </div> -->

          </div>

          <!-- In Progress -->
          <div class="col-4 d-flex flex-column align-items-center px-2">
            <div class="w-100 card mb-4">
              <div class="card-body d-flex justify-content-between align-items-center py-1">
                <div class="d-flex">
                  <p class="progress-title">In Progress</p>
                  <p class="progress-title-number ms-2 my-auto" id="inProgressQty">
                    <!-- no. of in progress task -->
                    0
                  </p>
                </div>
                <a href="#" class="createTask" create-type="In Progress" data-bs-target="#createModal" data-bs-toggle="modal">
                  <i class="bi bi-plus"></i>
                </a>
              </div>
            </div>
            <div class="w-100 container-draggable d-flex flex-column flex-grow-1" id="inProgressColumn">
            </div>
          </div>

          <!-- Completed -->
          <div class="col-4 d-flex flex-column align-items-center ps-5">
            <div class="w-100 card mb-4">
              <div class="card-body d-flex justify-content-between align-items-center py-1">
                <div class="d-flex">
                  <p class="progress-title">Completed</p>
                  <p class="progress-title-number ms-2 my-auto" id="completedQty">
                    <!-- no. of completed task -->
                    0
                  </p>
                </div>
                <a href="#" class="createTask" create-type="Completed" data-bs-target="#createModal" data-bs-toggle="modal">
                  <i class="bi bi-plus"></i>
                </a>
              </div>
            </div>
            <div class="w-100 container-draggable d-flex flex-column flex-grow-1" id="completedColumn">
            </div>

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
  <?php include 'includes/modals/manageModal.php'; ?>
  <?php include 'includes/modals/viewTask.php'; ?>
  <?php include 'includes/modals/editTask.php'; ?>

  <script src="scripts/workspace.js"></script>
</body>

</html>