document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll(".otpInputs input");
  const button = document.querySelector(".otpModal button");

  inputs.forEach((input) => {
    let lastInputStatus = 0;
    input.onkeyup = (e) => {
      const currentElement = e.target;
      const nextElement = input.nextElementSibling;
      const prevElement = input.previousElementSibling;

      if (prevElement && e.keyCode === 8) {
        if (lastInputStatus === 1) {
          prevElement.value = "";
          prevElement.focus();
        }
        button.setAttribute("disable", true);
        lastInputStatus = 1;
      } else {
        const reg = /^[a-zA-Z0-9]+$/;
        if (!reg.test(currentElement.value)) {
          currentElement.value = currentElement.value.replace(/\D/g, "");
        } else if (currentElement.value) {
          if (nextElement) {
            nextElement.focus();
          } else {
            button.removeAttribute("disabled");
            lastInputStatus = 0;
          }
        }
      }
    };
  });

  register();
  verifyOTP();
  signIn();

  async function register() {
    document
      .getElementById("signupForm")
      .addEventListener("submit", async (e) => {
        e.preventDefault();

        const formDataObj = {
          action: "register",
        };

        const formData = new FormData(e.target);
        for (let [key, value] of formData.entries()) {
          formDataObj[key] = value;
        }

        try {
          const response = await fetch("./backend/account.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(formDataObj),
          });

          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }

          const data = await response.json();

          alert(data.message);
          if (data.status === "success") {
            sendOTP("sendOTP");
          }
        } catch (error) {
          console.error("Fetch error: " + error);
          console.log(formDataObj);
        }
      });
  }

  var resendOtp = document.getElementById("resendOtp");

  resendOtp.addEventListener("click", function () {
    sendOTP("resendOTP");
  });

  async function sendOTP(action) {
    var sessionData = await getSessionData();
    const formDataObj = {
      action: action,
      email: sessionData.email,
      otp: sessionData.otp,
    };

    try {
      const response = await fetch("./backend/sendMail.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formDataObj),
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      alert(data.message);

      if (data.status) {
        $("#otpModal").modal("show");
      }
    } catch (error) {
      console.error("Fetch error: " + error);
    }
  }

  async function verifyOTP() {
    document.getElementById("otpForm").addEventListener("submit", async (e) => {
      e.preventDefault();

      const otp = combineOTP();

      const formDataObj = {
        action: "otpVerification",
        otp: otp,
      };

      const formData = new FormData(e.target);
      for (let [key, value] of formData.entries()) {
        formDataObj[key] = value;
      }

      try {
        const response = await fetch("./backend/account.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(formDataObj),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        alert(data.message);
        if (data.status === "success") {
          $("#otpModal").modal("hide");
          $("#verifiedModal").modal("show");
        }
      } catch (error) {
        console.error("Fetch error: " + error);
      }
    });
  }

  function combineOTP() {
    const otpInputs = document.querySelectorAll(".otpInputs input");
    let combinedOTP = "";
    otpInputs.forEach((input) => {
      combinedOTP += input.value;
    });
    return combinedOTP;
  }

  async function signIn() {
    document
      .getElementById("signinForm")
      .addEventListener("submit", async (e) => {
        e.preventDefault();

        const formDataObj = {
          action: "signIn",
        };

        const formData = new FormData(e.target);
        for (let [key, value] of formData.entries()) {
          formDataObj[key] = value;
        }

        try {
          const response = await fetch("./backend/account.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(formDataObj),
          });

          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }

          const data = await response.json();
          alert(data.message);
          if (data.status === "error") {
            if (data.errorType === "verification") {
              $("#otpModal").modal("show");
            }
          } else {
            location.href = "./dashboard.php";
          }
        } catch (error) {
          console.error("Fetch error: " + error);
        }
      });
  }

  async function getSessionData() {
    const sessionResponse = await fetch("./backend/getSessionData.php");
    const sessionData = await sessionResponse.json();
    if (sessionData.email && sessionData.otp) {
      return sessionData;
    } else {
      console.error("Error fetching session data:", sessionData.error);
    }
  }
});
