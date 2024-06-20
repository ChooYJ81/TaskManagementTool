<?php

include "../backend/connection.php";

if (isset($_POST['signin'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM account WHERE email=:email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $userPwd = $row["pwd"];
        $pwdMatch = password_verify($password, $userPwd);
        if ($pwdMatch === true){
            if ($row['status'] === "Verified"){
                session_start();
                $_SESSION["id"] = $row['accountID'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["name"] = $row["username"];
                $_SESSION["phoneNo"] = $row["phoneNo"];
                echo "<script>alert('Login Successful'); window.location.href='../dashboard.php';</script>";
            } else {
                echo "<script>alert('Your account is still pending.'); window.location.href='../index.php';</script>";
            }
        } else {
            echo "<script>alert('Password Incorrect.'); window.location.href='../index.php';</script>";
        }
    } else {
        echo "<script>alert('The email does not exists.'); window.location.href='../index.php';</script>";
    }
}

?>