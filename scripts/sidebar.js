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
        if (!workspaceOpened){
            workspaceList.classList.remove("d-none");
            workspaceOpened = true;
        } else {
            workspaceList.classList.add("d-none");
            workspaceOpened = false;
        }
    })
});
