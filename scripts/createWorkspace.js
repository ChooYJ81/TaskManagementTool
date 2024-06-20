document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("createWorkspaceForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      console.log("submitted");
      var formData = new FormData(e.target); // This will get all the form data

      fetch("./backend/createWorkspace.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          alert(data.message);
          location.reload();
        });
    });
});
