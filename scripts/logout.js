document.addEventListener("DOMContentLoaded", function(){
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

})