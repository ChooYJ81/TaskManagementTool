document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const sidebarText = document.querySelectorAll(".sidebarText");
    const sidebarNavItem = document.querySelectorAll(".sidebarNavItems");
    const sidebarHr = document.querySelectorAll(".sidebarHr");
    const sidebarButton = document.querySelectorAll(".sidebarNavItemButton");
    const mainContent = document.querySelector(".main-content");
    const sidebarHr1 = document.querySelectorAll(".sidebarHr1");
    const sidebarHr2 = document.querySelector(".sidebarHr2");
    const toggleElement = document.querySelectorAll(".toggleSidebar");

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
        }, 200);
        mainContent.classList.remove("collapsed");
        sidebar.setAttribute("data-state", "open");
    }

    function toggleSidebar() {
        const state = sidebar.getAttribute("data-state");
        if (state === "open") {
            collapseSidebar();
        } else {
            openSidebar();
        }
    }

    toggleElement.forEach((element) => {
        element.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior
            toggleSidebar();
        });
    });
});
