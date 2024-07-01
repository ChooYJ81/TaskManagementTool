<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', './error.log');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    require_once 'connection.php';

    session_start();

    $action = $data['action'];

    switch ($action) {
        case 'register':
            $response = register($pdo, $data);
            break;
        case 'otpVerification':
            $response = otpVerification($pdo, $data);
            break;
        case 'signIn':
            $response = signIn($pdo, $data);
            break;
        case 'logout':
            $response = logout();
            break;
        default:
            $response = [
                'message' => 'Invalid action',
            ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function register($pdo, $data)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (checkEmail($pdo, $data['email'])) {
        $response = [
            'status' => 'error',
            'message' => 'Email already exists',
        ];
        return $response;
    } else {
        $otp = generateRandomOTP(5, $pdo);
        $accountID = getLatestUserID($pdo);
        $status = "Pending";
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO account (accountID, username, email, pwd, OTP, status) VALUES (:accountID, :username, :email, :password, :otp, :status)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
        $stmt->bindParam(':username', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':otp', $otp, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        $stmt->execute();

        $response = [
            'status' => 'success',
            'email' => $data['email'],
            'otp' => $otp,
            'message' => 'Your account has been created successfully. Please wait a moment for the OTP to be sent to your email.',
        ];

        return $response;
    }
}

function checkEmail($pdo, $email)
{
    $query = "SELECT COUNT(*) FROM account WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function addWorkspace($pdo)
{
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    } else {
        // $email = $_SESSION['email'];
    }

    $accountID = getAccountID($pdo, $email);

    $workspaceCode = generateWorkspaceCode(5, $pdo);
    $workspaceID = generateWorkspaceID($pdo);
    $workspaceName = "Your Personal Workspace";
    $workspaceDesc = "This is your personal workspace, start adding tasks now!";
    $type = "Personal";
    $currentDateTime = date('Y-m-d H:i:s');

    $query = "INSERT INTO workspace (workspaceID, workspaceName, workspaceDesc, type, creationDate, owner, workspaceCode) VALUES (:workspaceID, :workspaceName, :workspaceDesc, :type, :creationDate, :accountID, :workspaceCode)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->bindParam(':workspaceName', $workspaceName, PDO::PARAM_STR);
    $stmt->bindParam(':workspaceDesc', $workspaceDesc, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':creationDate', $currentDateTime, PDO::PARAM_STR);
    $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
    $stmt->bindParam(':workspaceCode', $workspaceCode, PDO::PARAM_STR);
    $stmt->execute();

    $role = "Owner";
    $query = "INSERT INTO member (workspaceID, accountID, role) VALUES (:workspaceID, :accountID, :role)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->execute();
}

function getAccountID($pdo, $email)
{
    $query = "SELECT accountID FROM account WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $accountID = $stmt->fetchColumn();
    return $accountID;
}

// Generate Workspace ID
function generateWorkspaceID($pdo)
{
    $query = "SELECT workspaceID FROM Workspace ORDER BY workspaceID DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $lastWorkspaceID = $stmt->fetchColumn();

    if ($lastWorkspaceID == null) {
        $lastWorkspaceID = "W0000";
    } else {
        $lastWorkspaceID = $lastWorkspaceID;
    }

    $number = substr($lastWorkspaceID, 1);
    $newNumber = intval($number) + 1;
    $workspaceID = "W" . str_pad($newNumber, 4, "0", STR_PAD_LEFT);

    return $workspaceID;
}

// Generate unique OTP code
function generateRandomOTP($length, $pdo)
{
    while (true) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }

        // Check if unique
        $query = "SELECT COUNT(*) FROM account WHERE OTP = :code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            break;
        }
    }
    return $code;
}

// Generate unique Workspace code
function generateWorkspaceCode($length, $pdo)
{
    while (true) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }

        // Check if unique
        $query = "SELECT COUNT(*) FROM Workspace WHERE workspaceCode = :code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            break;
        }
    }
    return $code;
}

function getLatestUserID($pdo)
{
    $query = "SELECT accountID FROM Account ORDER BY accountID DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $lastAccountID = $stmt->fetchColumn();

    if ($lastAccountID == null) {
        $lastAccountID = "A0000";
    } else {
        $lastAccountID = $lastAccountID;
    }

    $number = substr($lastAccountID, 1);
    $newNumber = intval($number) + 1;
    $accountID = "A" . str_pad($newNumber, 4, "0", STR_PAD_LEFT);

    return $accountID;
}

function otpVerification($pdo, $data)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ($data['otp'] == $_SESSION['otp']) {
        addWorkspace($pdo);
        $status = "Verified";
        $query = "UPDATE account SET status = :status WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);
        $stmt->execute();

        $query1 = "SELECT * FROM account WHERE email = :email";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);
        $stmt1->execute();
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);
        $_SESSION["accountID"] = $row["accountID"];
        $_SESSION["email"] = $row['email'];
        $_SESSION["name"] = $row["username"];
        $_SESSION["phoneNo"] = $row["phoneNo"];

        $message = "Your account has been verified!";
        $verificationStatus = "success";
    } else {
        $message = "OTP does not match";
        $verificationStatus = "error";
    }

    $response = [
        'status' => $verificationStatus,
        'message' => $message,
    ];

    return $response;
}

function signIn($pdo, $data)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $query = "SELECT * FROM account WHERE email=:email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $data['loginEmail'], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['otp'] = $row['OTP'];
        $_SESSION['email'] = $row['email'];
        $pwdMatch = password_verify($data['loginPassword'], $row['pwd']);
        if ($pwdMatch === true) {
            if ($row['status'] === "Verified") {
                $_SESSION["accountID"] = $row["accountID"];
                $_SESSION["email"] = $row['email'];
                $_SESSION["name"] = $row["username"];
                $_SESSION["phoneNo"] = $row["phoneNo"];
                $message = "Login Successful!";
                $status = "success";
                $errorType = "none";
            } else {
                $message = "Please verify before login";
                $status = "error";
                $errorType = "verification";
            }
        } else {
            $message = "Incorrect password!";
            $status = "error";
            $errorType = "password";
        }
    } else {
        $message = "Incorrect email!";
        $status = "error";
        $errorType = "email";
    }

    $response = [
        'status' => $status,
        'message' => $message,
        'errorType' => $errorType,
    ];

    return $response;
}

function logout()
{

    session_unset();

    session_destroy();

    $message = "Logout Successful!";

    $response = [
        'message' => $message,
    ];

    return $response;
}
