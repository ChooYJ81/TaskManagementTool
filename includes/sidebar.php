<!-- collapsed -->
<div class="sidebar collapsed" data-state="collapsed">
  <nav class="nav flex-column justify-content-between h-100">
    <div class="d-flex flex-column">
      <a class="sidebarLogo toggleSidebar" href="#">
        <img src="./images/logo.png" />
      </a>
      <hr class="sidebarHr1 collapsed" />
      <a class="sidebarNavItems toggleSidebar border-bottom" href="dashboard.html">
        <i class="bi bi-speedometer2"></i>
        <span class="sidebarText d-none">Dashboard</span>
      </a>
      <a class="sidebarNavItems toggleSidebar border-bottom" href="tracker.html">
        <i class="bi bi-pencil-square"></i>
        <span class="sidebarText d-none">Personal Tracker</span>
      </a>
      <a class="sidebarNavItems toggleSidebar active border-bottom" href="#">
        <i class="bi bi-diagram-3"></i>
        <span class="sidebarText d-none">Workspaces</span>
      </a>
    </div>
    <div class="d-flex flex-column">
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