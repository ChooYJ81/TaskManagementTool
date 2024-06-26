// Read the parameter from the current page's URL
const queryParams = new URLSearchParams(window.location.search);
var workspace = queryParams.get("workspace");
workspace = atob(workspace);


document.addEventListener("DOMContentLoaded", function () {

    //Fetch data from database
    async function getMembers() {
        const data = {
            workspace: workspace,
            action: "getMembers",
        };

        try {
            const response = await fetch("./backend/dashboard.php", {
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
            displayMembers(responseData);
            console.log(responseData);
        } catch (error) {
            console.error("Fetch error: " + error.message);
        }
    }

});