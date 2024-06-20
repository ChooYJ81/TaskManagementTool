<?php
include "../backend/connection.php";

$password = password_hash("12345", PASSWORD_DEFAULT);
$query = "INSERT INTO account (accountID, username, phoneNo, email, pwd, OTP, status) VALUES ('A0001', 'John Smith', null, 'test@mail.com', :password, '123AB', 'Verified')";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':password', $password);
$stmt->execute();
echo "<script>alert('email = test@mail.com, pwd = 12345');</script>";
?>