// document.addEventListener("DOMContentLoaded", function () {
  
//   var createButton = document.getElementById("createWorkspaceButton");
//   createButton.addEventListener("click", function () {
//     // Select all input, select, and textarea elements within the form
//     var inputs = document.querySelectorAll(
//       "#createWorkspaceModal input, #createWorkspaceModal select, #createWorkspaceModal textarea"
//     );

//     var formData = {};

//     inputs.forEach(function (input) {
//       formData[input.id] = input.value;
//     });

//     console.log(formData);

//     fetch("./backend/createWorkspace.php", {
//       method: "POST",
//       body: formData,
//     })
//       .then((response) => response.json())
//       .then((data) => {
//         alert(data.message);
//       })
//       .catch((error) => {
//         console.error("Error:", error);
//       });
//   });
// });

document.getElementById('createWorkspaceForm').addEventListener('submit', function(e) {
  e.preventDefault();
  console.log('submitted')
  var formData = new FormData(e.target); // This will get all the form data

  fetch('./backend/createWorkspace.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    alert(data.message);
    location.reload();
  })
});
