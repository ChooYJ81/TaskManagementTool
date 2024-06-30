document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("sendMail").addEventListener("click", function () {
  fetch("./backend/sendMail.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    }
  })
    .then((response) => {
      console.log(response);
      return response.json();
    })
    .then((data) => {
      console.log(data);
      if (data.success) {
        alert("Receipt sent successfully");
      } else {
        alert("Error sending receipt");
      }
    });
  });
});
