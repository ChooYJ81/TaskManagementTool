// Read the parameter from the current page's URL
const queryParams = new URLSearchParams(window.location.search);
var workspace = queryParams.get("workspace");
workspace = atob(workspace);

document.addEventListener("DOMContentLoaded", function () {
  const date = document.getElementById("today");
  var today = dayjs().format("dddd, D MMMM YYYY");
  // console.log(today);
  date.innerHTML = today;

  getWorkspace();
  initializeCreateTask(); // Add event listener to get the task type
  initializeMultipleSelect(); // Add event listener to enable multi-select for the select element
  submitNewTask(); // Add event listener to create a task

  getTasks();
});

// Fetch data from database
async function getWorkspace() {
  const data = {
    workspace: workspace,
    action: "getWorkspace",
  };

  try {
    const response = await fetch("./backend/workspace.php", {
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
  } catch (error) {
    console.error("Fetch error: " + error.message);
  }
}

// Display the workspace details
function displayWorkspace(data) {
  const workspaceHistory = document.getElementById("workspaceHistory");
  var historyText =
    "Hosted by " +
    data.owner.username +
    " on " +
    dayjs(data.workspace.creationDate).format("dddd, D MMMM YYYY") +
    " at " +
    dayjs(data.workspace.creationDate).format("h:mm A");
  workspaceHistory.innerHTML = historyText;

  const workspaceTitle = document.getElementById("workspaceTitle");
  workspaceTitle.innerHTML = data.workspace.workspaceName;

  const workspaceDescription = document.getElementById("workspaceDescription");
  workspaceDescription.innerHTML = data.workspace.workspaceDesc;

  const membersNo = document.getElementById("membersNo");
  membersNo.innerHTML = data.members;

  // Input for create task form
  const taskWorkspaceID = document.getElementById("taskWorkspaceID");
  taskWorkspaceID.value = data.workspace.workspaceID;
}

function initializeCreateTask() {
  const createTaskLinks = document.querySelectorAll("a.createTask");
  const taskType = document.getElementById("taskType");

  createTaskLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const createType = this.getAttribute("create-type");
      // console.log(createType);
      taskType.value = createType;
    });
  });
}

function initializeMultipleSelect() {
  const dropdownDisplay = document.getElementById("dropdownDisplay");
  const dropdownOptions = document.getElementById("dropdownOptions");

  // Toggle dropdown visibility
  dropdownDisplay.addEventListener("click", function () {
    dropdownOptions.classList.toggle("show");
  });

  getWorkspaceMembers();

  // Handle assign members selection
  dropdownOptions.addEventListener("change", function (e) {
    if (e.target.type === "checkbox") {
      // Clear current selections
      dropdownDisplay.innerHTML = "";

      const selectedOptions = [
        ...dropdownOptions.querySelectorAll('input[type="checkbox"]:checked'),
      ];

      selectedOptions.forEach((option) => {
        const optionSpan = document.createElement("span");
        optionSpan.textContent = option.parentElement.textContent.trim();
        optionSpan.classList.add("selected-option");
        dropdownDisplay.appendChild(optionSpan);
      });

      // If no options are selected, show placeholder text
      if (selectedOptions.length === 0) {
        dropdownDisplay.textContent = "Select Members";
      }
    }
  });

  // Hide dropdown when clicking outside
  document.addEventListener("click", function (e) {
    if (
      !dropdownDisplay.contains(e.target) &&
      !dropdownOptions.contains(e.target)
    ) {
      dropdownOptions.classList.remove("show");
    }
  });
}

async function getWorkspaceMembers() {
  const data = {
    workspace: workspace,
    action: "getWorkspaceMembers",
  };

  try {
    const response = await fetch("./backend/workspace.php", {
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
    displayWorkspaceMembers(responseData);
  } catch (error) {
    console.error("Fetch error: " + error.message);
  }
}

function displayWorkspaceMembers(data) {
  const dropdownOptions = document.getElementById("dropdownOptions");
  var html = "";
  data.forEach((element) => {
    html += `
      <label class="dropdown-option">
        <input type="checkbox" name="members[]" value="${element.accountID}">
        <span>${element.username}</span>
      </label>
    `;
  });
  dropdownOptions.innerHTML = html;
}

async function submitNewTask() {
  document
    .getElementById("createTaskForm")
    .addEventListener("submit", async (e) => {
      e.preventDefault();

      // Initialize an object to hold form data
      const formDataObj = {
        action: "createTask",
        members: [],
      };

      // Collect checked members
      document
        .querySelectorAll('input[name="members[]"]:checked')
        .forEach((checkbox) => {
          formDataObj.members.push(checkbox.value);
        });

      // Collect other form data
      const formData = new FormData(e.target);
      for (let [key, value] of formData.entries()) {
        if (key !== "members[]") {
          // Skip members[] as it's already handled
          formDataObj[key] = value;
        }
      }

      try {
        const response = await fetch("./backend/workspace.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(formDataObj),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        // Handle the response data
        alert(data.message);
        location.reload();
      } catch (error) {
        console.error("Fetch error: " + error);
      }
    });
}

async function getTasks() {
  const data = {
    workspace: workspace,
    action: "getTasks",
  };

  try {
    const response = await fetch("./backend/workspace.php", {
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
    console.log(responseData);
    displayTasks(responseData);
  } catch (error) {
    console.error("Fetch error: " + error.message);
  }
}

function displayTasks(data) {
  for (const key in data) {
    let className = "";

    if (key == "To-Do") {
      className = "toDo";
    } else if (key == "In Progress") {
      className = "inProgress";
    } else if (key == "Completed") {
      className = "completed";
    }

    // Display task quantity
    quantity = data[key].quantity;

    var taskQuantity = document.getElementById(`${className}Qty`);
    taskQuantity.innerHTML = quantity;

    var displayedTasks = new Set(); // Initialize a Set to track displayed tasks

    // Modify task by column
    var taskColumn = document.getElementById(`${className}Column`);
    if (quantity == 0) {
      let html = `<p class="noTasks">No tasks available.</p>`;
      taskColumn.insertAdjacentHTML('beforeend', html);
    } else {
      let html = "";

      // Display each task
      for (const task of data[key].tasks) {
        var assignedMember = "";
        
        if (displayedTasks.has(task.taskID)) {
          // If this task has already been displayed, but the previous one was not assigned to the user
          if(task.assignedMember == 'A0001'){ // Hardcoded for now
            assignedMember = `<p class="text-1 mt-5" style="color:#3284BA">You are assigned to this task.</p>`;
          }
          var taskCard = document.getElementById(task.taskID);
          var childDiv = taskCard.querySelector('.card-body');
          childDiv.insertAdjacentHTML('beforeend', assignedMember);
          continue; // Skip this task if it has already been displayed
        }

        // If the task comes first and assigned to the user
        if(task.assignedMember == 'A0001'){ // Hardcoded for now
          assignedMember = `<p class="text-1 mt-5" style="color:#3284BA">You are assigned to this task.</p>`;
        }

        displayedTasks.add(task.taskID); // Mark this task as displayed

        if(task.priority == "Low Priority"){
          priority = `<span class="badge rounded-pill low-prio">Low Priority</span>`;
        }else if(task.priority == "Medium Priority"){
          priority = `<span class="badge rounded-pill med-prio">Medium Priority</span>`;
        }else if(task.priority == "High Priority"){
          priority = `<span class="badge rounded-pill high-prio">High Priority</span>`;
        }

        html = `
        <div class="w-100 card mb-3" id="${task.taskID}">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              ${priority}
              <a href="#" data-bs-target="#viewModal" data-bs-toggle="modal"
                ><i class="bi bi-three-dots-vertical fs-5 me-2"></i
              ></a>
            </div>
            <p class="task-title mb-2">${task.taskName}</p>
            <p class="text-1 mb-3">
              ${task.taskDesc}
            </p>
            ${assignedMember}
          </div>
        </div>
        `;
        taskColumn.insertAdjacentHTML('beforeend', html);
      }
    }
  }
}
