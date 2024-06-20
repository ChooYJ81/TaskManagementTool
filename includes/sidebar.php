
  <!-- collapsed -->
  <div class="sidebar collapsed toggleSidebar" data-state="collapsed" id="sidebar">
    <nav class="nav flex-column h-100">
      <div class="d-flex flex-column">
        <a class="sidebarLogo d-flex" href="#">
          <img src="./images/logo.png" />
          <p class="sidebarTitle my-0 d-none">SunCollab</p>
        </a>
        <hr class="sidebarHr1 collapsed" />
        <a class="sidebarNavItems border-bottom" href="dashboard.php">
          <i class="bi bi-speedometer2"></i>
          <span class="sidebarText d-none">Dashboard</span>
        </a>
        <a class="sidebarNavItems border-bottom" href="tracker.php">
          <i class="bi bi-pencil-square"></i>
          <span class="sidebarText d-none">Personal Tracker</span>
        </a>
        <a class="sidebarNavItems active border-bottom workspace" href="#">
          <i class="bi bi-diagram-3"></i>
          <span class="sidebarText d-none">Workspaces<i class="bi bi-caret-down-fill ms-2"></i></span>
        </a>
      </div>
      <div class="workspaceList d-none sidebarBorderLeft">
        <!-- workspace list repeat start -->
        <a class="workspaceItems" href="#">
          <div class="d-flex">
            <i class="bi bi-caret-right-fill me-2"></i>
            <div>
              <p class="mb-1">SWE3033 Software Processes<span class="members"><i class="bi bi-people-fill ms-2 me-1"></i>10</span></p>
              <p class="workspaceText">8 Assigned Pending Tasks</p>
            </div>
          </div>
        </a>
        <!-- repeat end -->
        <!-- below for test -->
        <a class="workspaceItems" href="#">
          <div class="d-flex">
            <i class="bi bi-caret-right-fill me-2"></i>
            <div>
              <p class="mb-1">SWE3033 Software Processes<span class="members"><i class="bi bi-people-fill ms-2 me-1"></i>10</span></p>
              <p class="workspaceText">8 Assigned Pending Tasks</p>
            </div>
          </div>
        </a>
        <a class="workspaceItems" href="#">
          <div class="d-flex">
            <i class="bi bi-caret-right-fill me-2"></i>
            <div>
              <p class="mb-1">SWE3033 Software Processes<span class="members"><i class="bi bi-people-fill ms-2 me-1"></i>10</span></p>
              <p class="workspaceText">8 Assigned Pending Tasks</p>
            </div>
          </div>
        </a>
        <a class="workspaceItems" href="#">
          <div class="d-flex">
            <i class="bi bi-caret-right-fill me-2"></i>
            <div>
              <p class="mb-1">SWE3033 Software Processes<span class="members"><i class="bi bi-people-fill ms-2 me-1"></i>10</span></p>
              <p class="workspaceText">8 Assigned Pending Tasks</p>
            </div>
          </div>
        </a>
        <a class="workspaceItems" href="#">
          <div class="d-flex">
            <i class="bi bi-caret-right-fill me-2"></i>
            <div>
              <p class="mb-1">SWE3033 Software Processes<span class="members"><i class="bi bi-people-fill ms-2 me-1"></i>10</span></p>
              <p class="workspaceText">8 Assigned Pending Tasks</p>
            </div>
          </div>
        </a>
        <!-- test end -->
      </div>

      <div class="d-flex flex-column mt-auto">
        <hr class="sidebarHr2 collapsed" />
        <button class="sidebarNavItemButton collapsed">
          <i class="bi bi-arrow-bar-right"></i>
          <span class="sidebarText d-none">Join Workspace</span>
        </button>
        <hr class="m-0 sidebarHr" />
        <button type="button" class="sidebarNavItemButton collapsed" data-bs-toggle="modal" data-bs-target="#createWorkspaceModal">
          <i class="bi bi-plus-circle"></i>
          <span class="sidebarText d-none">Create Workspace</span>
        </button>
        <hr class="sidebarHr1 collapsed" />
        <a class="sidebarNavItems1 align-items-center d-flex" href="#">
          <i class="bi bi-person-circle pe-1"></i>
          <span class="sidebarText d-none">User Name</span>
          <i class="bi bi-caret-down-fill ps-1" style="font-size: 0.8rem"></i>
        </a>
      </div>
    </nav>
  </div>
  <script src="./scripts/sidebar.js"></script>

  <!-- Modals -->
  <?php include 'includes/modals/createWorkspaceModal.php'; ?>