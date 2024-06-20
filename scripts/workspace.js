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
  document.getElementById("createTaskForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    // Initialize an object to hold form data
    const formDataObj = {
      action: "createTask",
      members: [],
    };

    // Collect checked members
    document.querySelectorAll('input[name="members[]"]:checked').forEach((checkbox) => {
      formDataObj.members.push(checkbox.value);
    });

    // Collect other form data
    const formData = new FormData(e.target);
    for (let [key, value] of formData.entries()) {
      if (key !== "members[]") { // Skip members[] as it's already handled
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
