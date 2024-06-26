<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Welcome</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link href="css/style.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column overflow-hidden">
    <?php include "./includes/modals/otpModal.php"; ?>
    <div class="position-absolute top-0" style="left: -5px">
        <img src="./images/wave.png" style="height: 100vh;"/>
    </div>
    <div class="position-absolute top-0" style="right: -5px">
        <img src="./images/wave.png" style="height: 100vh; transform: rotate(180deg);">
    </div>
    <div class="align-items-center d-flex my-auto flex-column">
        <img src="./images/logo3.png" height="80px;" class="mb-4"/>
        <div class="login-container" id="login-container">
            <div class="sign-up">
                <form class="login-form" id="signupForm">
                    <p class="title-1 fw-normal">Sign Up</p>
                    <div class="mb-3">
                        <label class="input-label">Name</label>
                        <input class="inputs" type="text" placeholder="Enter your name" required id="name" name="name" />
                    </div>
                    <div class="mb-3">
                        <label class="input-label">Email</label>
                        <input class="inputs" type="email" placeholder="Enter your email" required id="email" name="email" />
                    </div>
                    <div class="mb-2">
                        <label class="input-label">Password</label>
                        <input class="inputs" type="password" placeholder="Enter your password" required id="password" name="password" />
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" required />
                        <label class="form-check-label" style="font-size: 0.625rem">I accept the <a href="#">Terms of Service</a> and
                            acknowledge the
                            <a href="#">Privacy Policy</a>.</label>
                    </div>
                    <button class="button-fill mx-auto mt-3 px-3 py-2" type="submit" style="width: fit-content;">
                        Sign Up
                    </button>
                </form>
            </div>
            <div class="sign-in">
                <form class="login-form" id="signinForm">
                    <p class="title-1 fw-normal mb-1">Sign In</p>
                    <p style="font-size: 0.75rem">Welcome back to SunCollab!</p>
                    <div class="mb-3">
                        <label class="input-label">Email</label>
                        <input class="inputs" type="email" placeholder="Enter your email" required id="loginEmail" name="loginEmail" />
                    </div>
                    <div class="mb-1">
                        <label class="input-label">Password</label>
                        <input class="inputs" type="password" placeholder="Enter your password" required id="loginPassword" name="loginPassword" />
                    </div>
                    <p class="m-0" style="font-size: 0.625rem">
                        Forgot your password? <a href="#">Reset it here</a>
                    </p>
                    <button class="button-fill mx-auto mt-3 px-3 py-2" type="submit" style="width: fit-content;" id="signin" name="signin">
                        Sign In
                    </button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-left">
                        <p class="title-1" style="color: white;">Welcome Back!</p>
                        <p style="font-size: 0.875rem" class="mb-4">
                            Access your dashboard and stay on top of your tasks.
                        </p>
                        <button id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-right">
                        <p class="title-1" style="color: white;">Hello Friend!</p>
                        <p style="font-size: 0.75rem" class="mb-4">
                            Welcome to SunCollab!<br />
                            Super easy visual management tool for teams.<br />
                            Don’t have an account? Sign up now!
                        </p>
                        <button id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute w-100 text-center" style="bottom: 5px;">
        <p style="font-size: 0.75rem; color: #B3B3B3;" class="text-nowrap m-0">Copyright © 2024 SunCollab. All rights reserved.</p>
    </div>
    <script type="text/javascript">
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const main = document.getElementById('login-container');

        signUpButton.addEventListener('click', () => {
            main.classList.add("right-panel-active");
        })
        signInButton.addEventListener('click', () => {
            main.classList.remove("right-panel-active");
        })
    </script>
</body>

</html>