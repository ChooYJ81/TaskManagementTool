document.addEventListener("DOMContentLoaded", function () {
    editWorkspace();
    getMembers();
    disableCode();
    regenerateCode();

    async function editWorkspace() {
        document
            .getElementById("editWorkspace")
            .addEventListener("submit", async (e) => {
                e.preventDefault();

                // Initialize an object to hold form data
                const formDataObj = {
                    workspace: workspace,
                    action: "editWorkspace",
                };

                // Collect other form data
                const formData = new FormData(e.target);
                for (let [key, value] of formData.entries()) {
                    formDataObj[key] = value;
                }
                try {
                    const response = await fetch(
                        "./backend/manageWorkspace.php",
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(formDataObj),
                        }
                    );

                    if (!response.ok) {
                        throw new Error(
                            `HTTP error! status: ${response.status}`
                        );
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

    async function getMembers() {
        const data = {
            workspace: workspace,
            action: "getMembers",
        };

        try {
            const response = await fetch("./backend/manageWorkspace.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status : ${response.status}`);
            }

            const responseData = await response.json();
            displayMembers(responseData);
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    }

    function displayMembers(data) {
        const memberList = document.getElementById("manageMemberList");
        var memberNo = data.length;
        const memberNoBadge = document.getElementById("memberNoBadge");
        memberNoBadge.innerHTML = memberNo;
        var html = "";

        if (data.length > 0) {
            data.forEach((element, index) => {
                if (element.role === "Owner") {
                    html += `
                            <tr>
                              <td class="text-start">${index + 1}</td>
                              <td class="text-start">${element.username}</td>
                              <td><span class="badge accordion-member-badge">Host</span></td>
                            </tr>    
                    `;
                } else {
                    html += `
                    <tr>
                        <td class="text-start">${index + 1}</td>
                        <td class="text-start">${element.username}</td>
                        <td><button class="btn btn-danger deleteMemberBtn" style="padding: 0 5px;" account-id="${btoa(
                            element.accountID
                        )}"><i class="bi bi-x"></i></button></td>
                    </tr>    
            `;
                }
            });
        } else {
            html += `
            <tr>
                <td colspan="3" class="text-center">No members.</td>
            </tr>
        `;
        }

        memberList.innerHTML = html;
        deleteMember();
    }
});

async function deleteMember() {
    const deleteWorkspaceBtn = document.querySelectorAll(".deleteMemberBtn");
    deleteWorkspaceBtn.forEach((btn) => {
        btn.addEventListener("click", async () => {
            const accountID = atob(btn.getAttribute("account-id"));
            const confirmDeleteMember = confirm(
                "Are you sure you want to delete this member?"
            );

            if (confirmDeleteMember) {
                const data = {
                    workspace: workspace,
                    accountID: accountID,
                    action: "deleteMember",
                };

                try {
                    const response = await fetch(
                        "./backend/manageWorkspace.php",
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(data),
                        }
                    );

                    if (!response.ok) {
                        throw new Error(
                            `HTTP error! status : ${response.status}`
                        );
                    }

                    const responseData = await response.json();
                    alert(responseData.message);
                    location.reload();
                } catch (error) {
                    console.error("Fetch error: " + error.message);
                }
            }
        });
    });
}

async function disableCode() {
    document.getElementById("disableCodeBtn").addEventListener("click", async (e) => {
        e.preventDefault();
        const data = {
            workspace: workspace,
            action: "disableCode",
        };
    
        try {
            const response = await fetch("./backend/manageWorkspace.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });
    
            if (!response.ok) {
                throw new Error(`HTTP error! status : ${response.status}`);
            }
    
            const responseData = await response.json();
            alert(responseData.message);
            location.reload();
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    })
}

async function regenerateCode() {
    document.getElementById("regenerateCodeBtn").addEventListener("click", async (e) => {
        e.preventDefault();
        const data = {
            workspace: workspace,
            action: "regenerateCode",
        };
    
        try {
            const response = await fetch("./backend/manageWorkspace.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });
    
            if (!response.ok) {
                throw new Error(`HTTP error! status : ${response.status}`);
            }
    
            const responseData = await response.json();
            alert(responseData.message);
            location.reload();
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    })
}
