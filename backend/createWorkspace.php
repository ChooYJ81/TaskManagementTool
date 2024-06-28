<?php
require_once './connection.php';

// session_start();
// $accountID = $_SESSION['user']['accountID'];

$accountID = 'A0001'; // Dummy accountID

$name = $_POST['workspaceName'];
$type = $_POST['workspaceType'];
$desc = $_POST['workspaceDesc'];

try {
  $flag = true;
  $status = "";
  $message = "";
  // Generate workspaceID
  $workspaceID = generateWorkspaceID($pdo);

  $currentDateTime = date('Y-m-d H:i:s');

  // Generate unique workspace code
  $code = generateCode(5, $pdo);


  // Insert workspace details
  $query = "INSERT INTO Workspace (workspaceID, workspaceName, workspaceDesc, type, creationDate, owner, workspaceCode) VALUES (:workspaceID, :workspaceName, :workspaceDesc, :type, :creationDate, :owner, :workspaceCode)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->bindParam(':workspaceName', $name, PDO::PARAM_STR);
  $stmt->bindParam(':workspaceDesc', $desc, PDO::PARAM_STR);
  $stmt->bindParam(':type', $type, PDO::PARAM_STR);
  $stmt->bindParam(':creationDate', $currentDateTime, PDO::PARAM_STR);
  $stmt->bindParam(':owner', $accountID, PDO::PARAM_STR);
  $stmt->bindParam(':workspaceCode', $code, PDO::PARAM_STR);
  $stmt->execute();

  if ($stmt->rowCount() == 0) {
    $flag = false;
  } else {
    // Insert member details
    $query = "INSERT INTO Member (workspaceID, accountID, role) VALUES (:workspaceID, :accountID, 'Owner')";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
      $flag = false;
    }
  }

  if($flag){
    $status = "success";
    $message = 'Workspace created successfully';
  } else {
    $status = "fail";
    $message = 'Error processing the request';
  }

} catch (Exception $e) {
  $message = 'Error processing the request: ' . $e->getMessage();
}

$response = [
  'message' => $message,
  'code' => $code,
  'status' => $status,
  'workspaceID' => $workspaceID
];

header('Content-Type: application/json');
echo json_encode($response);
exit;

// Generate Workspace ID
function generateWorkspaceID($pdo)
{
  $query = "SELECT COUNT(*) FROM Workspace";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $count = $stmt->fetchColumn();
  $workspaceID = "W" . str_pad($count + 1, 4, "0", STR_PAD_LEFT);
  return $workspaceID;
}

// Generate unique Workspace code
function generateCode($length, $pdo)
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
