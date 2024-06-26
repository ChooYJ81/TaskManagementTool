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
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
  <link href="css/style.css" rel="stylesheet" />
</head>

<body>
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content collapsed">
      <!-- date -->
      <p class="date" id="today"></p>
      <hr class="w-100" />
      <div class="row mb-4">
        <div class="col-7">


          <div class="card w-100 h-100">
            <div id="progressCarousel" class="carousel slide h-100">

              <div class="carousel-inner h-100">
                <p class="title-1 text-nowrap dashboard-progress-title">Progress Overview</p>
                <!-- Add more slides as needed -->
                <button class="btn p-0 progressArrowBtn left" id="prevProgress" data-bs-target="#progressCarousel" data-bs-slide="prev">
                  <i class="bi bi-chevron-compact-left fs-2 my-auto"></i>
                </button>
                <button class="btn p-0 progressArrowBtn right" id="nextProgress" data-bs-target="#progressCarousel" data-bs-slide="next">
                  <i class="bi bi-chevron-compact-right fs-2 my-auto"></i>
                </button>


              </div>
            </div>
          </div>


        </div>


        <div class="col-5">
          <div class="card w-100 h-100">
            <div class="card-body px-4">
              <p class="title-1 mb-2">Task Breakdown</p>
              <div class="text-center">
                <p style="font-size: 0.875rem;" class="mb-0 mt-4">Remaining Tasks</p>
                <p style="font-size: 3rem;" class="fw-bold" id="breakdownRemaining">0</p>
              </div>
              <div class="d-flex justify-content-around">
                <div class="d-flex flex-row">
                  <div class="dashboard-line low"></div>
                  <div class="d-flex flex-column text-center p-2">
                    <span class="badge rounded-pill low-prio">Low Priority</span>
                    <p style="font-size: 2rem;" class="mb-0 mt-2" id="breakdownLowPrio">0</p>
                  </div>
                </div>
                <div class="d-flex flex-row">
                  <div class="dashboard-line medium"></div>
                  <div class="d-flex flex-column text-center p-2">
                    <span class="badge rounded-pill med-prio">Medium Priority</span>
                    <p style="font-size: 2rem;" class="mb-0 mt-2" id="breakdownMedPrio">0</p>
                  </div>
                </div>
                <div class="d-flex flex-row">
                  <div class="dashboard-line high"></div>
                  <div class="d-flex flex-column text-center p-2">
                    <span class="badge rounded-pill high-prio">High Priority</span>
                    <p style="font-size: 2rem;" class="mb-0 mt-2" id="breakdownHighPrio">0</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p style="font-size: 1.25rem;" class="fw-bold">Task Overview</p>
      <table class="table table-hover dashboard-table">
        <thead>
          <tr>
            <th>Task</th>
            <th>Person in Charge</th>
            <th>Project</th>
            <th>Status</th>
            <th class="text-center">Priority</th>
            <th>Due Date</th>
          </tr>
        </thead>
        <tbody id="tasks">
        </tbody>
      </table>
      <nav>
        <ul class="pagination justify-content-center" id="pagination">
          <li class="page-item"><a class="page-link" href="#">Prev</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
      </nav>
    </div>
  </div>
  <script src="./scripts/dashboard.js"></script>

</body>

</html>