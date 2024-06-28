<?php
require_once './connection.php';

session_start();
$accountID = $_SESSION['accountID'];
$code = $_POST['workspaceCode'];

try {
  if(validateWorkspaceCode($pdo, $code) && $code != ""){
    $workspaceID = getWorkspaceID($pdo, $code);

    if(validateMember($pdo, $workspaceID, $accountID)){
      $message = [
        'status' => 'fail',
        'message' => 'You are already a member of this workspace'
      ];
      header('Content-Type: application/json');
      echo json_encode($message);
      exit;
    }

    $query = "INSERT INTO Member (workspaceID, accountID, role) VALUES (:workspaceID, :accountID, 'Member')";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
    $stmt->execute();

    $message = [
      'status' => 'success',
      'message' => 'Workspace joined successfully',
      'workspaceID' => $workspaceID
    ];
  } else {
    $message = [
      'status' => 'fail',
      'message' => 'Invalid workspace code'
    ];
  }

  
} catch (Exception $e) {
  $message = 'Error processing the request: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($message);
exit;

// Validate Workspace Code
function validateWorkspaceCode($pdo, $code){
  $query = "SELECT COUNT(*) FROM Workspace WHERE workspaceCode = :code";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':code', $code, PDO::PARAM_STR);
  $stmt->execute();
  $count = $stmt->fetchColumn();
  return $count > 0;
}

// Get Workspace ID
function getWorkspaceID($pdo, $code){
  $query = "SELECT workspaceID FROM Workspace WHERE workspaceCode = :code";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':code', $code, PDO::PARAM_STR);
  $stmt->execute();
  $workspaceID = $stmt->fetchColumn();
  return $workspaceID;
}

// Validate Member
function validateMember($pdo, $workspaceID, $accountID){
  $query = "SELECT COUNT(*) FROM Member WHERE workspaceID = :workspaceID AND accountID = :accountID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
  $stmt->execute();
  $count = $stmt->fetchColumn();
  return $count > 0;
}
