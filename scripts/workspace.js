// Read the parameter from the current page's URL
const queryParams = new URLSearchParams(window.location.search);
var workspace = queryParams.get("workspace");
workspace = atob(workspace);
var sessionAccountID = null;

document.addEventListener("DOMContentLoaded", function () {
  fetch("./backend/getSessionData.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.accountID) {
        sessionAccountID = data.accountID;
      } else {
        console.error("Error fetching session data:", data.error);
      }
    })
    .catch((error) => console.error("Error:", error));

  const date = document.getElementById("today");
  var today = dayjs().format("dddd, D MMMM YYYY");
  // console.log(today);
  date.innerHTML = today;

  getWorkspace();
  initializeCreateTask(); // Add event listener to get the task type
  initializeMultipleSelect("createDropdownDisplay", "createDropdownOptions"); // Add event listener to enable multi-select for the select element
  submitNewTask(); // Add event listener to create a task

  getTasks(); // Fetch tasks from database

  viewTask(); // Initialize the task modal
  editTask(); // Initialize the edit task modal
  updateTask(); // Add event listener to update a task
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
  // console.log(data);
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

  const workspaceCode = document.getElementById("modalWorkspaceCode");
  if (data.workspace.workspaceCode === null) {
    workspaceCode.classList.add("text-secondary");
    workspaceCode.innerHTML = "Disabled";
  } else {
    workspaceCode.innerHTML = data.workspace.workspaceCode;
  }
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

function initializeMultipleSelect(
  dropdownDisplayID,
  dropdownOptionsID,
  preSelectedMembers = []
) {
  const dropdownDisplay = document.getElementById(dropdownDisplayID);
  const dropdownOptions = document.getElementById(dropdownOptionsID);

  // Toggle dropdown visibility
  dropdownDisplay.addEventListener("click", function () {
    dropdownOptions.classList.toggle("show");
  });

  // Pre-select members and update display
  const updateSelectedDisplay = () => {
    dropdownDisplay.innerHTML = ""; // Clear current selections
    const selectedOptions = [
      ...dropdownOptions.querySelectorAll('input[type="checkbox"]:checked'),
    ];

    if (selectedOptions.length === 0) {
      // If no options are selected, show placeholder text
      dropdownDisplay.textContent = "Select members"; // Placeholder text
    } else {
      selectedOptions.forEach((option) => {
        // Create and append the span for the selected option
        const optionSpan = document.createElement("span");
        optionSpan.textContent = option.parentElement.textContent.trim();
        optionSpan.classList.add("selected-option");
        dropdownDisplay.appendChild(optionSpan);
      });
    }
  };

  getWorkspaceMembers(
    dropdownOptionsID,
    preSelectedMembers,
    updateSelectedDisplay
  );

  // Handle assign members selection
  dropdownOptions.addEventListener("change", function (e) {
    if (e.target.type === "checkbox") {
      updateSelectedDisplay();
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

async function getWorkspaceMembers(
  dropdownOptionsID,
  preSelectedMembers,
  callback
) {
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
    displayWorkspaceMembers(
      responseData,
      dropdownOptionsID,
      preSelectedMembers,
      callback
    );
  } catch (error) {
    console.error("Fetch error: " + error.message);
  }
}

function displayWorkspaceMembers(
  data,
  dropdownOptionsID,
  preSelectedMembers,
  callback
) {
  const dropdownOptions = document.getElementById(`${dropdownOptionsID}`);
  var html = "";
  data.forEach((element) => {
    html += `
      <label class="dropdown-option">
        <input type="checkbox" name="members[]" value="${element.accountID}"
    `;
    if (preSelectedMembers.includes(element.accountID)) {
      html += ` checked`;
    }

    html += `
    >
        <span>${element.username}</span>
      </label>
    `;
  });
  dropdownOptions.innerHTML = html;
  if (callback) {
    callback();
  }
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
    displayTasks(responseData, initializeDraggable);
  } catch (error) {
    console.error("Fetch error: " + error.message);
  }
}

function displayTasks(data, callback) {
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
      taskColumn.insertAdjacentHTML("beforeend", html);
    } else {
      let html = "";

      // Display each task
      for (const task of data[key].tasks) {
        var assignedMember = "";

        if (displayedTasks.has(task.taskID)) {
          // If this task has already been displayed, but the previous one was not assigned to the user
          if (task.assignedMember == sessionAccountID) {
            assignedMember = `<p class="text-1 mt-5" style="color:#3284BA">You are assigned to this task.</p>`;
          }
          var taskCard = document.getElementById(task.taskID);
          var childDiv = taskCard.querySelector(".card-body");
          childDiv.insertAdjacentHTML("beforeend", assignedMember);
          continue; // Skip this task if it has already been displayed
        }

        // If the task comes first and assigned to the user
        if (task.assignedMember == sessionAccountID) {
          // Hardcoded for now
          assignedMember = `<p class="text-1 mt-5" style="color:#3284BA">You are assigned to this task.</p>`;
        }

        displayedTasks.add(task.taskID); // Mark this task as displayed

        if (task.priority == "Low Priority") {
          priority = `<span class="badge rounded-pill low-prio">Low Priority</span>`;
        } else if (task.priority == "Medium Priority") {
          priority = `<span class="badge rounded-pill med-prio">Medium Priority</span>`;
        } else if (task.priority == "High Priority") {
          priority = `<span class="badge rounded-pill high-prio">High Priority</span>`;
        }

        const taskJsonString = JSON.stringify(task);
        const escapedTaskJsonString = taskJsonString.replace(/"/g, "&quot;");

        html = `
        <div class="w-100 card mb-3 draggable" draggable="true" id="${task.taskID}" task-type="${key}">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              ${priority}
              <a href="#" data-bs-target="#viewTaskModal" data-bs-toggle="modal" data-bs-task="${escapedTaskJsonString}" class="text-decoration-none"
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
        taskColumn.insertAdjacentHTML("beforeend", html);
      }
    }
  }
  if (callback) {
    callback();
  }
}

function viewTask() {
  const viewTaskModal = document.getElementById("viewTaskModal");
  const taskTitle = document.getElementById("viewTaskTitle");
  const taskDesc = document.getElementById("viewTaskDesc");
  const creatorTextEl = document.getElementById("creatorText");
  const membersAssignedEl = document.getElementById("membersAssigned");
  const editTaskModalBtn = document.getElementById("editTaskModalBtn");

  if (viewTaskModal) {
    viewTaskModal.addEventListener("show.bs.modal", async (event) => {
      const button = event.relatedTarget;
      const taskJson = button.getAttribute("data-bs-task");
      const task = JSON.parse(taskJson.replace(/&quot;/g, '"'));

      try {
        var viewTask = await getCreatorAndAssigned(task.taskID); // Contains creator and members assigned
        var creatorText = `Created by ${viewTask.creator.username} on ${dayjs(
          task.creationDate
        ).format("dddd, D MMMM YYYY")} at ${dayjs(task.creationDate).format(
          "h:mm A"
        )}`;

        var membersAssigned = "";
        if (viewTask.members.length > 0) {
          viewTask.members.forEach((member) => {
            membersAssigned += `<span class="members-badge">${member.username}</span>`;
          });
        } else {
          membersAssigned = `<p class="text-1">No members assigned</p>`;
        }
      } catch (error) {
        console.error("Error fetching task details:", error);
      }

      // console.log(viewTask);

      var priorityClass = "";
      var priorityText = "";

      if (task.priority == "Low Priority") {
        priorityClass = "low-prio";
        priorityText = "Low Priority";
      } else if (task.priority == "Medium Priority") {
        priorityClass = "med-prio";
        priorityText = "Medium Priority";
      } else if (task.priority == "High Priority") {
        priorityClass = "high-prio";
        priorityText = "High Priority";
      }

      taskTitle.textContent = task.taskName;
      taskDesc.textContent = task.taskDesc;
      creatorTextEl.textContent = creatorText;
      membersAssignedEl.innerHTML = membersAssigned;
      editTaskModalBtn.setAttribute("data-bs-task", taskJson);

      const prioritySpan = document.createElement("span");
      prioritySpan.textContent = priorityText;
      prioritySpan.classList.add(
        "badge",
        "rounded-pill",
        "mx-2",
        priorityClass
      );
      taskTitle.appendChild(prioritySpan);

      console.log(task);
    });
  }
}

async function getCreatorAndAssigned(taskID) {
  const data = {
    workspace: workspace,
    task: taskID,
    action: "getCreatorAndAssigned",
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
    return responseData;
  } catch (error) {
    console.error("Fetch error: " + error.message);
  }
}

function editTask() {
  const editTaskModal = document.getElementById("editTaskModal");
  const editTaskForm = document.getElementById("editTaskForm");
  const deleteTaskBtn = document.getElementById("deleteTaskBtn");

  if (editTaskModal) {
    editTaskModal.addEventListener("show.bs.modal", async (event) => {
      const button = event.relatedTarget;
      const taskJson = button.getAttribute("data-bs-task");
      const task = JSON.parse(taskJson.replace(/&quot;/g, '"'));

      const taskID = task.taskID;
      const taskName = task.taskName;
      const taskDesc = task.taskDesc;
      const taskPriority = task.priority;
      const taskType = task.type;
      const taskDue = task.due;
      const workspaceID = task.workspaceID;

      // Get members assigned to the task
      try {
        const response = await getCreatorAndAssigned(taskID);
        var members = [];
        for (const member of response.members) {
          members.push(member.accountID);
        }
        initializeMultipleSelect(
          "editDropdownDisplay",
          "editDropdownOptions",
          members
        );

        // Set the form values
        editTaskForm.taskID.value = taskID;
        editTaskForm.taskName.value = taskName;
        editTaskForm.taskDesc.value = taskDesc;
        editTaskForm.priority.value = taskPriority;
        editTaskForm.type.value = taskType;
        editTaskForm.due.value = taskDue;
        editTaskForm.workspaceID.value = workspaceID;

        // Add event listener to delete task
        deleteTaskBtn.setAttribute("task-id", taskID);

        deleteTaskBtn.addEventListener("click", async () => {
          const taskID = deleteTaskBtn.getAttribute("task-id"); // Get the task-id attribute
          console.log(taskID);
          const confirmDelete = confirm(
            "Are you sure you want to delete this task?"
          );
          if (confirmDelete) {
            const data = {
              taskID: taskID,
              action: "deleteTask",
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
              alert(responseData.message);
              location.reload();
            } catch (error) {
              console.error("Fetch error: " + error.message);
            }
          }
        });
      } catch (error) {
        console.error("Failed to initialize multiple select:", error);
        // Handle the error appropriately
      }
    });
  }
}

function updateTask() {
  document
    .getElementById("editTaskForm")
    .addEventListener("submit", async (e) => {
      e.preventDefault();

      // Initialize an object to hold form data
      const formDataObj = {
        action: "updateTask",
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
        console.log(formDataObj);
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

// Draggable functions
function initializeDraggable() {
  const draggables = document.querySelectorAll(".draggable");
  const containers = document.querySelectorAll(".container-draggable");

  draggables.forEach((draggable) => {
    draggable.addEventListener("dragstart", () => {
      draggable.classList.add("dragging");
    });

    draggable.addEventListener("dragend", () => {
      draggable.classList.remove("dragging");
      // New: Update task type based on the column it was dropped into
      updateTaskType(draggable);
    });
  });

  containers.forEach((container) => {
    container.addEventListener("dragover", (e) => {
      e.preventDefault();
      const afterElement = getDragAfterElement(container, e.clientY);
      const draggable = document.querySelector(".dragging");
      if (afterElement == null) {
        container.appendChild(draggable);
      } else {
        container.insertBefore(draggable, afterElement);
      }
    });
  });
}

function getDragAfterElement(container, y) {
  const draggableElements = [
    ...container.querySelectorAll(".draggable:not(.dragging)"),
  ];

  return draggableElements.reduce(
    (closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;
      if (offset < 0 && offset > closest.offset) {
        return { offset: offset, element: child };
      } else {
        return closest;
      }
    },
    { offset: Number.NEGATIVE_INFINITY }
  ).element;
}

// New function to update task type based on the column it was dropped into
function updateTaskType(draggable) {
  const parentColumnID = draggable.parentElement.id;

  let newType;
  switch (parentColumnID) {
    case "completedColumn":
      newType = "Completed";
      break;
    case "inProgressColumn":
      newType = "In Progress";
      break;
    case "toDoColumn":
      newType = "To-Do";
      break;
    default:
      console.log("Unknown column");
      return; // Unknown column, no action taken
  }

  let taskID = draggable.id;

  const data = {
    taskID: taskID,
    oldType: draggable.getAttribute("task-type"),
    newType: newType,
    action: "updateTaskType",
  };

  fetch("./backend/workspace.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      // Handle the response data
      window.alert(data.message);
      location.reload();
    })
    .catch((error) => {
      console.error("Fetch error: " + error);
    });
}
