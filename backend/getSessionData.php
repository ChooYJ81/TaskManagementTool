<?php
session_start();
header('Content-Type: application/json');
if(isset($_SESSION['accountID'])) {
    echo json_encode(array("accountID" => $_SESSION['accountID']));
} else {
    echo json_encode(array("error" => "Session variable not set."));
}
?>