// Read the parameter from the current page's URL
// const queryParams = new URLSearchParams(window.location.search);
// const workspace = queryParams.get('workspace');

// Dummy URL for testing
const url = "http://localhost/TaskManagementTool/workspace.php?workspace=W0001";
const workspace = "W0001";

document.addEventListener("DOMContentLoaded", function () {
  const date = document.getElementById("today");
  var today = dayjs().format("dddd, D MMMM YYYY");
  // console.log(today);
  date.innerHTML = today;

  getWorkspace();
});

// Fetch data from database
function getWorkspace() {
  var data = {
    workspace: workspace,
    action: "getWorkspace",
  };

  fetch("./backend/workspace.php", {
    method: "POST",
    headers: {
      'Content-Type': 'application/json', // Set Content-Type to application/json
    },
    body: JSON.stringify(data) // Convert data object to JSON string
  })
  .then((response) => response.json())
  .then((data) => {
    console.log(data);
    displayWorkspace(data);
  });
}

function displayWorkspace(data) {
  const workspaceHistory = document.getElementById("workspaceHistory");
  var historyText = "Hosted by " + data.owner.username + " on " + dayjs(data.workspace.creationDate).format("dddd, D MMMM YYYY")+" at "+dayjs(data.workspace.creationDate).format("h:mm A");
  workspaceHistory.innerHTML = historyText;

  const workspaceTitle = document.getElementById("workspaceTitle");
  workspaceTitle.innerHTML = data.workspace.workspaceName;

  const workspaceDescription = document.getElementById("workspaceDescription");
  workspaceDescription.innerHTML = data.workspace.workspaceDesc;

  const membersNo = document.getElementById("membersNo");
  membersNo.innerHTML = data.members;
}

