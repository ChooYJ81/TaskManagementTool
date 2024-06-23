document.addEventListener("DOMContentLoaded", function () {

    var myCarousel = document.getElementById("progressCarousel");
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: false, // Disables automatic cycling
        wrap: false, // Prevents looping
    });

    const date = document.getElementById("today");
    var today = dayjs().format("dddd, D MMMM YYYY");
    date.innerHTML = today;

    getWorkspace();

    let currentPage = 1;
    // Event listener for slid.bs.carousel event
    myCarousel.addEventListener("slid.bs.carousel", function () {
        const activeItem = document.querySelector(".carousel-item.active");
        if (activeItem) {
            const workspaceID = atob(activeItem.getAttribute("id"));
    
            getTaskDetails(workspaceID, currentPage);
            getTaskBreakdown(workspaceID);
            getProgressPercentage(workspaceID);
            getTotalPage(workspaceID);
        }
    });

    function pageOnClick(){
        const pageLink = document.querySelectorAll(".page-link");
        pageLink.forEach(page => {
            page.addEventListener("click", function (e){
                e.preventDefault();
                var pageClicked = e.target.id.split("-")[1];
                currentPage = pageClicked;
                // console.log(currentPage);
                const activeItem = document.querySelector(".carousel-item.active");
                const workspaceID = atob(activeItem.getAttribute("id"));

                getTaskDetails(workspaceID, currentPage);
                // displayPagination(data);
                // getTotalPage(workspaceID);
                pageLink.forEach(page => {
                    page.classList.remove("active");
                })
                e.target.classList.add("active");
            })
        })
    }

    //Fetch data from database
    async function getWorkspace() {
        const data = {
            action: "getWorkspace",
        };

        try {
            const response = await fetch("./backend/dashboard.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseData = await response.json();
            displayWorkspace(responseData);
            // Call getTaskDetails for initially active item after displaying workspace
            const initialActiveItem = document.querySelector(
                ".carousel-item.active"
            );
            if (initialActiveItem) {
                const workspaceID = atob(initialActiveItem.getAttribute("id"));
    
                getTaskDetails(workspaceID, currentPage);
                getTaskBreakdown(workspaceID);
                getProgressPercentage(workspaceID);
                getTotalPage(workspaceID);
            }
            // console.log(responseData);
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    }

    async function getTaskDetails(workspaceID, currentPage) {
        const data = {
            workspaceID: workspaceID,
            pageNo: currentPage,
            action: "getTaskDetails",
        };

        try {
            const response = await fetch("./backend/dashboard.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseData = await response.json();
            // console.log(responseData)
            displayTasks(responseData);
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    }

    async function getTaskBreakdown(workspaceID) {
        const data = {
            workspaceID: workspaceID,
            action: "getTaskBreakdown",
        };

        try {
            const response = await fetch("./backend/dashboard.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseData = await response.json();
            // console.log(responseData);
            displayTaskBreakdown(responseData);
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    }

    async function getProgressPercentage(workspaceID) {
        const data = {
            workspaceID: workspaceID,
            action: "getProgressPercentage",
        };

        try {
            const response = await fetch("./backend/dashboard.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseData = await response.json();
            // console.log(responseData);
            displayProgressPercentage(responseData, workspaceID);
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    }

    async function getTotalPage(workspaceID) {
        const data = {
            workspaceID: workspaceID,
            action: "getTotalPage",
        };

        try {
            const response = await fetch("./backend/dashboard.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseData = await response.json();
            // console.log(responseData);
            displayPagination(responseData);
            pageOnClick();
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    }

    function displayWorkspace(data) {
        const carouselInner = document.querySelector(".carousel-inner");
        var html = "";
        data.forEach((element, index) => {
            const isActive = index === 0 ? "active" : "";
            html += `
                <div class="carousel-item ${isActive}" id="${btoa(
                element.workspace.workspaceID
            )}">
                  <div class="card-body d-flex align-items-center" style="padding: 5% 5% 0 5%;">
                    <div class="p-4 pt-3">

                      <div class="progress-container ms-3">
                        <svg class="progress-ring1" width="12rem" height="12rem">
                          <circle class="progress-ring__circle1" stroke-width="14" fill="transparent" r="80" cx="6rem" cy="6rem"></circle>
                        </svg>
                        <svg class="progress-ring2" width="12rem" height="12rem">
                          <circle class="progress-ring__circle2" stroke-width="14" fill="transparent" r="80" cx="6rem" cy="6rem" id="progress-${btoa(
                              element.workspace.workspaceID
                          )}"></circle>
                        </svg>
                        <div class="progress-text">
                          <span style="color: #C7C7C7; font-size: 0.75rem;" class="text-nowrap fw-normal">Overall Progress</span>
                          <span class="progress-percent" id="percent-${btoa(
                              element.workspace.workspaceID
                          )}">0%</span>
                        </div>
                      </div>
                    </div>
                    <div class="row m-2">
                      <div class="col-12 pt-3">
                        <p class="fs-6 fw-bold mb-1">Workspace Name</p>
                        <p style="font-size: 0.875rem;" id="workspaceTitle">${
                            element.workspace.workspaceName
                        }</p>
                      </div>
                      <div class="col-6">
                        <p class="fs-6 fw-bold mb-1">Tasks Completed</p>
                        <p style="font-size: 0.875rem;" id="taskCompleted">${
                            element.tasks.Completed
                        }</p>
                      </div>
                      <div class="col-6">
                        <p class="fs-6 fw-bold mb-1">Tasks Remaining</p>
                        <p style="font-size: 0.875rem;" id="taskRemaining">${
                            element.tasks.Remaining
                        }</p>
                      </div>
                      <div class="col-12">
                        <p class="fs-6 fw-bold mb-1">Your Tasks</p>
                        <p style="font-size: 0.875rem;" id="yourTask">${
                            element.tasks.yourTask
                        }</p>
                      </div>
                    </div>
                  </div>
                </div>
            `;
        });
        carouselInner.innerHTML += html;
    }

    function displayTasks(data) {
        const tasks = document.getElementById("tasks");
        var html = "";
        if (data && Array.isArray(data) && data.length > 0) {
            data.forEach((task) => {
                if (task.priority === "Low Priority") {
                    var priorityClass = "low-prio";
                    var priority = "Low";
                }
                if (task.priority === "Medium Priority") {
                    var priorityClass = "med-prio";
                    var priority = "Medium";
                }
                if (task.priority === "High Priority") {
                    var priorityClass = "high-prio";
                    var priority = "High";
                }
                html += `
                <tr>
                    <td>${task.taskName}</td>
                    <td style="color: #667085">${task.username}</td>
                    <td style="color: #667085">${task.workspaceName}</td>
                    <td style="color: #667085">${task.taskType}</td>
                    <td class="text-center"><span class="badge rounded-pill ${priorityClass}">${priority}</span></td>
                    <td style="color: #667085">${task.due}</td>
                </tr>
                `;
            });
        } else {
            html += `
            <tr>
                <td colspan="6" class="text-center">No Tasks</td>
            </tr>
            `;
        }

        tasks.innerHTML = html;
    }

    function displayTaskBreakdown(data) {
        document.getElementById("breakdownRemaining").innerHTML =
            data.remainingTask;
        document.getElementById("breakdownLowPrio").innerHTML =
            data["Low Priority"];
        document.getElementById("breakdownMedPrio").innerHTML =
            data["Medium Priority"];
        document.getElementById("breakdownHighPrio").innerHTML =
            data["High Priority"];
    }

    function displayProgressPercentage(percentage, workspaceID) {
        const offset = 503 - (percentage / 100) * 503;
        const progressCircle = document.getElementById(
            `progress-${btoa(workspaceID)}`
        );
        // console.log(progressCircle);
        progressCircle.style.strokeDashoffset = offset;
        document.getElementById(
            `percent-${btoa(workspaceID)}`
        ).textContent = `${percentage}%`;
        progressCircle.classList.add("progress");
    }

    function displayPagination(total_page) {
        const pagination = document.getElementById("pagination");
        var html = "";

        for (i = 0; i < total_page; i++) {
            // console.log(i);
            // console.log(currentPage);
            if (i + 1 === currentPage) {
                html += `
                <li class="page-item"><a class="page-link active" href="#" id="page-${
                    i + 1
                }">${i + 1}</a></li>
            `;
            }else {
                html += `
                    <li class="page-item"><a class="page-link" href="#" id="page-${
                        i + 1
                    }">${i + 1}</a></li>
                `;
            }
        }
        pagination.innerHTML = html;
    }
});
