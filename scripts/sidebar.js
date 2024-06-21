document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const sidebarText = document.querySelectorAll(".sidebarText");
  const sidebarNavItem = document.querySelectorAll(".sidebarNavItems");
  const sidebarHr = document.querySelectorAll(".sidebarHr");
  const sidebarButton = document.querySelectorAll(".sidebarNavItemButton");
  const mainContent = document.querySelector(".main-content");
  const sidebarHr1 = document.querySelectorAll(".sidebarHr1");
  const sidebarHr2 = document.querySelector(".sidebarHr2");
  const sidebarTitle = document.querySelector(".sidebarTitle");
  const workspace = document.querySelector(".workspace");
  const workspaceList = document.querySelector(".workspaceList");

  function collapseSidebar() {
    sidebar.classList.add("collapsed");
    sidebarText.forEach((element) => {
      element.classList.add("d-none");
    });
    sidebarHr.forEach((element) => {
      element.classList.remove("d-none");
    });
    sidebarButton.forEach((element) => {
      element.classList.add("collapsed");
    });

    setTimeout(() => {
      sidebarNavItem.forEach((element) => {
        element.classList.add("border-bottom");
      });
    }, 200);
    sidebarHr1.forEach((element) => {
      element.classList.add("collapsed");
    });

    sidebarHr2.classList.add("collapsed");

    mainContent.classList.add("collapsed");

    sidebarTitle.classList.add("d-none");

    workspace.classList.remove("sidebarBorderLeft");
    workspaceList.classList.add("d-none");
    workspaceOpened = false;
    sidebar.setAttribute("data-state", "collapsed");
  }

  function openSidebar() {
    sidebar.classList.remove("collapsed");
    setTimeout(() => {
      sidebarText.forEach((element) => {
        element.classList.remove("d-none");
      });
      sidebarHr.forEach((element) => {
        element.classList.add("d-none");
      });
      sidebarButton.forEach((element) => {
        element.classList.remove("collapsed");
      });
      sidebarNavItem.forEach((element) => {
        element.classList.remove("border-bottom");
      });
      sidebarHr1.forEach((element) => {
        element.classList.remove("collapsed");
      });
      sidebarHr2.classList.remove("collapsed");
      sidebarTitle.classList.remove("d-none");
      workspace.classList.add("sidebarBorderLeft");
    }, 200);
    mainContent.classList.remove("collapsed");
    sidebar.setAttribute("data-state", "open");
  }

  // function toggleSidebar() {
  //     const state = sidebar.getAttribute("data-state");
  //     if (state === "open") {
  //         collapseSidebar();
  //     } else {
  //         openSidebar();
  //     }
  // }

  let sidebarOpened = false;
  let workspaceOpened = false;

  sidebar.addEventListener("mouseenter", function () {
    openSidebar();
    sidebarOpened = true;
  });
  sidebar.addEventListener("mouseleave", function () {
    collapseSidebar();
    sidebarOpened = false;
  });

  workspace.addEventListener("click", () => {
    if (!workspaceOpened) {
      workspaceList.classList.remove("d-none");
      workspaceOpened = true;
    } else {
      workspaceList.classList.add("d-none");
      workspaceOpened = false;
    }
  });
  getWorkspaceList();
  logout();


  async function logout() {
    document
        .getElementById("logoutButton")
        .addEventListener("click", async (e) => {
            e.preventDefault();

            const formDataObj = {
                action: "logout",
            };

            try {
                const response = await fetch("./backend/account.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(formDataObj),
                });

                if (!response.ok) {
                    throw new Error(
                        `HTTP error! status: ${response.status}`
                    );
                }

                const data = await response.json();
                alert(data.message);
                location.href = "./index.php";
            } catch (error) {
                console.error("Fetch error: " + error);
            }
        });
}

});

// Fetch workspace list from database
function getWorkspaceList() {
  var data = {
    action: "getWorkspaceList",
  };

  fetch("./backend/workspace.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json", // Set Content-Type to application/json
    },
    body: JSON.stringify(data), // Convert data object to JSON string
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      displayWorkspaceList(data);
    });
}

function displayWorkspaceList(data) {
  const workspaceList = document.querySelector(".workspaceList");
  var html = "";
  data.forEach((element) => {
    // Base64 encode the workspaceID (Vulnerable to URL manipulation)
    const encodedWorkspaceID = btoa(element.workspace.workspaceID);
    const href = `./workspace.php?workspace=${encodedWorkspaceID}`;

    html += `      
    <a class="workspaceItems" href="${href}">
        <div class="d-flex">
            <i class="bi bi-caret-right-fill me-2"></i>
            <div>
            <p class="mb-1">${element.workspace.workspaceName}<span class="members"><i class="bi bi-people-fill ms-2 me-1"></i>${element.members}</span></p>
            <p class="workspaceText">0 Assigned Pending Tasks</p>
            </div>
        </div>
    </a>`;
  });
  workspaceList.innerHTML = html;
}
