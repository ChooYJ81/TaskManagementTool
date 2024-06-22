document.addEventListener("DOMContentLoaded", function () {
    const progressCircle = document.querySelector(".progress-ring__circle2");

    // Example: Set progress to 70%
    function setProgress(percent) {
        const offset = 503 - (percent / 100) * 503;
        progressCircle.style.strokeDashoffset = offset;
        document.querySelector(".progress-percent").textContent = `${percent}%`;
        progressCircle.classList.add("progress");
    }

    // Call setProgress with desired percentage (0-100)
    // setProgress(85); // Example: 70% progress

    var myCarousel = document.getElementById("progressCarousel");
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: false, // Disables automatic cycling
        wrap: false, // Prevents looping
    });

    const date = document.getElementById("today");
    var today = dayjs().format("dddd, D MMMM YYYY");
    date.innerHTML = today;

    getWorkspace();

    // Event listener for slid.bs.carousel event
    myCarousel.addEventListener("slid.bs.carousel", function () {
        const activeItem = document.querySelector(".carousel-item.active");
        if (activeItem) {
            const workspaceID = atob(activeItem.getAttribute("id"));
            getTaskDetails(workspaceID);
            getTaskBreakdown(workspaceID);
        }
    });

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
                getTaskDetails(workspaceID);
                getTaskBreakdown(workspaceID);
            }
            // console.log(responseData);
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    }

    async function getTaskDetails(workspaceID) {
        const data = {
            workspaceID: workspaceID,
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
        if(data && Array.isArray(data) && data.length > 0){
            data.forEach(task => {
                if(task.priority === 'Low Priority'){
                    var priorityClass = 'low-prio';
                    var priority = "Low";
                }
                if(task.priority === 'Medium Priority'){
                    var priorityClass = 'med-prio';
                    var priority = "Medium";
                }
                if(task.priority === 'High Priority'){
                    var priorityClass = 'high-prio';
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

    function displayTaskBreakdown(data){

        document.getElementById("breakdownRemaining").innerHTML = data.remainingTask;
        document.getElementById("breakdownLowPrio").innerHTML = data["Low Priority"];
        document.getElementById("breakdownMedPrio").innerHTML = data["Medium Priority"];
        document.getElementById("breakdownHighPrio").innerHTML = data["High Priority"];

    }
});
