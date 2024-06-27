<?php session_start(); ?>
<!-- collapsed -->
<div class="sidebar collapsed toggleSidebar" data-state="collapsed" id="sidebar">
  <nav class="nav flex-column h-100" style="flex-wrap:nowrap;">
    <div class="d-flex flex-column">
      <a class="sidebarLogo d-flex" href="#">
        <img src="./images/logo.png" />
        <p class="sidebarTitle my-0 d-none">SunCollab</p>
      </a>
      <hr class="sidebarHr1 collapsed" />
      <a class="sidebarNavItems border-bottom" href="dashboard.php" id="dashboard">
        <i class="bi bi-speedometer2"></i>
        <span class="sidebarText d-none">Dashboard</span>
      </a>
      <a class="sidebarNavItems border-bottom" href="tracker.php" id="tracker">
        <i class="bi bi-pencil-square"></i>
        <span class="sidebarText d-none">Personal Tracker</span>
      </a>
      <a class="sidebarNavItems border-bottom workspace" href="#" id="workspace">
        <i class="bi bi-diagram-3"></i>
        <span class="sidebarText d-none">Workspaces
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" id="workspace-arrow" viewBox="0 0 16 16">
            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
          </svg></span>
      </a>
    </div>
    <div class="workspaceList d-none sidebarBorderLeft flex-grow-1">
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
    </div>

    <div class="d-flex flex-column mt-auto">
      <hr class="sidebarHr2 collapsed" />
      <button type="button" class="sidebarNavItemButton collapsed" data-bs-toggle="modal" data-bs-target="#joinWorkspaceModal">
        <i class="bi bi-arrow-bar-right"></i>
        <span class="sidebarText d-none">Join Workspace</span>
      </button>
      <hr class="m-0 sidebarHr" />
      <button type="button" class="sidebarNavItemButton collapsed" data-bs-toggle="modal" data-bs-target="#createWorkspaceModal">
        <i class="bi bi-plus-circle"></i>
        <span class="sidebarText d-none">Create Workspace</span>
      </button>
      <hr class="sidebarHr1 collapsed" />
      <div class="dropup">
        <a class="sidebarNavItems1 align-items-center d-flex" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-person-circle pe-1"></i>
          <span class="sidebarText d-none"><?= $_SESSION['name']; ?></span>
          <i class="bi bi-caret-down-fill ps-1" style="font-size: 0.8rem"></i>
        </a>
        <ul class="dropdown-menu ms-4" style="padding: 0;">
          <li><button class="dropdown-item py-2" type="submit" id="logoutButton"><i class="bi bi-box-arrow-left me-2"></i>Logout</button></li>
        </ul>
      </div>
    </div>
  </nav>
</div>
<script src="./scripts/sidebar.js"></script>

<!-- Modals -->
<?php include 'includes/modals/createWorkspaceModal.php'; ?>
<?php include 'includes/modals/joinWorkspace.php'; ?>