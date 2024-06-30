<?php
session_start();
header('Content-Type: application/json');
if(isset($_SESSION['accountID'])) {
    echo json_encode(array("accountID" => $_SESSION['accountID']));
} else if(isset($_SESSION['email']) && isset($_SESSION['otp'])) {
    echo json_encode(array("email" => $_SESSION['email'], "otp" => $_SESSION['otp']));
} else {
    echo json_encode(array("error" => "Session variable not set."));
}
?>