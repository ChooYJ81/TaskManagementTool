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
</head>

<body>
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content collapsed">
      <!-- date -->
      <p class="date" id="today">Tuesday, 4 June 2024</p>
      <hr class="w-100" />
      <div class="row mb-4">
        <div class="col-7">


          <div class="card w-100 h-100">
            <div id="progressCarousel" class="carousel slide h-100">

              <div class="carousel-inner h-100">
                <p class="title-1 text-nowrap dashboard-progress-title">Progress Overview</p>
                <!-- Slide 1 -->
                <div class="carousel-item active">
                  <div class="card-body d-flex align-items-center" style="padding: 5% 5% 0 5%;">
                    <div class="p-4 pt-3">

                      <div class="progress-container ms-3">
                        <svg class="progress-ring1" width="12rem" height="12rem">
                          <circle class="progress-ring__circle1" stroke-width="14" fill="transparent" r="80" cx="6rem" cy="6rem"></circle>
                        </svg>
                        <svg class="progress-ring2" width="12rem" height="12rem">
                          <circle class="progress-ring__circle2" stroke-width="14" fill="transparent" r="80" cx="6rem" cy="6rem"></circle>
                        </svg>
                        <div class="progress-text">
                          <span style="color: #C7C7C7; font-size: 0.75rem;" class="text-nowrap fw-normal">Overall Progress</span>
                          <span class="progress-percent">0%</span>
                        </div>
                      </div>
                    </div>
                    <div class="row m-2">
                      <div class="col-12 pt-3">
                        <p class="fs-6 fw-bold mb-1">Workspace Name</p>
                        <p style="font-size: 0.875rem;">SWE 3033 Software Processes</p>
                      </div>
                      <div class="col-6">
                        <p class="fs-6 fw-bold mb-1">Tasks Completed</p>
                        <p style="font-size: 0.875rem;">21</p>
                      </div>
                      <div class="col-6">
                        <p class="fs-6 fw-bold mb-1">Tasks Remaining</p>
                        <p style="font-size: 0.875rem;">8</p>
                      </div>
                      <div class="col-12">
                        <p class="fs-6 fw-bold mb-1">Your Tasks</p>
                        <p style="font-size: 0.875rem;">2</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                  <div class="card-body d-flex align-items-center" style="padding: 5% 5% 0 5%;">
                    <div class="p-4 pt-3">

                      <div class="progress-container ms-3">
                        <svg class="progress-ring1" width="12rem" height="12rem">
                          <circle class="progress-ring__circle1" stroke-width="14" fill="transparent" r="80" cx="6rem" cy="6rem"></circle>
                        </svg>
                        <svg class="progress-ring2" width="12rem" height="12rem">
                          <circle class="progress-ring__circle2" stroke-width="14" fill="transparent" r="80" cx="6rem" cy="6rem"></circle>
                        </svg>
                        <div class="progress-text">
                          <span style="color: #C7C7C7; font-size: 0.75rem;" class="text-nowrap fw-normal">Overall Progress</span>
                          <span class="progress-percent">0%</span>
                        </div>
                      </div>
                    </div>
                    <div class="row m-2">
                      <div class="col-12 pt-3">
                        <p class="fs-6 fw-bold mb-1">Workspace Name</p>
                        <p style="font-size: 0.875rem;">SWE 3033 Software Processes</p>
                      </div>
                      <div class="col-6">
                        <p class="fs-6 fw-bold mb-1">Tasks Completed</p>
                        <p style="font-size: 0.875rem;">21</p>
                      </div>
                      <div class="col-6">
                        <p class="fs-6 fw-bold mb-1">Tasks Remaining</p>
                        <p style="font-size: 0.875rem;">8</p>
                      </div>
                      <div class="col-12">
                        <p class="fs-6 fw-bold mb-1">Your Tasks</p>
                        <p style="font-size: 0.875rem;">2</p>
                      </div>
                    </div>
                  </div>
                </div>
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
                <p style="font-size: 3rem;" class="fw-bold">8</p>
              </div>
              <div class="d-flex justify-content-around">
                <div class="d-flex flex-row">
                  <div class="dashboard-line low"></div>
                  <div class="d-flex flex-column text-center p-2">
                    <span class="badge rounded-pill low-prio">Low Priority</span>
                    <p style="font-size: 2rem;" class="mb-0 mt-2">3</p>
                  </div>
                </div>
                <div class="d-flex flex-row">
                  <div class="dashboard-line medium"></div>
                  <div class="d-flex flex-column text-center p-2">
                    <span class="badge rounded-pill med-prio">Medium Priority</span>
                    <p style="font-size: 2rem;" class="mb-0 mt-2">3</p>
                  </div>
                </div>
                <div class="d-flex flex-row">
                  <div class="dashboard-line high"></div>
                  <div class="d-flex flex-column text-center p-2">
                    <span class="badge rounded-pill high-prio">High Priority</span>
                    <p style="font-size: 2rem;" class="mb-0 mt-2">3</p>
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
            <th class="text-center">Priority</th>
            <th>Due Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Identify Stakeholders</td>
            <td style="color: #667085">Eugene</td>
            <td style="color: #667085">SP Assignment</td>
            <td class="text-center"><span class="badge rounded-pill high-prio">High</span></td>
            <td style="color: #667085">20 Jun 2024</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>

  <script src="./scripts/dashboard.js"></script>
</body>

</html>