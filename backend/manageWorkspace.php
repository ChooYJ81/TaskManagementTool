<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $jsonData = file_get_contents('php://input');
  $data = json_decode($jsonData, true);

  require_once 'connection.php';

  session_start();

  $action = $data['action'];

  switch ($action) {
    case 'editWorkspace':
      $response = editWorkspace($pdo, $data);
      break;
    case 'getMembers':
      $response = getMembers($pdo, $data['workspace']);
      break;
    case 'deleteMember':
      $response = deleteMember($pdo, $data['accountID'], $data['workspace']);
      break;
    case 'disableCode':
      $response = disableCode($pdo, $data['workspace']);
      break;
    case 'regenerateCode':
      $response = regenerateCode($pdo, $data['workspace']);
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


function editWorkspace($pdo, $data)
{
  $query = "UPDATE workspace SET workspaceName = :workspaceName, workspaceDesc = :workspaceDesc WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $data['workspace'], PDO::PARAM_STR);
  $stmt->bindParam(':workspaceName', $data['editWorkspaceName'], PDO::PARAM_STR);
  $stmt->bindParam(':workspaceDesc', $data['editWorkspaceDesc'], PDO::PARAM_STR);
  $stmt->execute();

  $response = [
    'message' => 'Workspace details updated.',
  ];

  return $response;
}

function getMembers($pdo, $workspaceID)
{
  $query = "SELECT * FROM member m, account a WHERE m.accountID = a.accountID AND workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $members;
}

function deleteMember($pdo, $accountID, $workspaceID)
{
  // Delete all assigned tasks
  $query = "DELETE FROM assigned WHERE assignedMember = :accountID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
  $stmt->execute();
  error_log(print_r($workspaceID, true));
  // Delete member
  $query = "DELETE FROM member WHERE accountID = :accountID AND workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();

  $response = [
    'message' => 'Member deleted successfully',
  ];

  return $response;
}

function disableCode($pdo, $workspaceID){
  $query = "UPDATE workspace SET workspaceCode = null WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();

  $response = [
    'message' => 'Workspace code disabled!',
  ];

  return $response;
}

function regenerateCode($pdo, $workspaceID){
  $workspaceCode = generateCode(5, $pdo);
  $query = "UPDATE workspace SET workspaceCode = :workspaceCode WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->bindParam(':workspaceCode', $workspaceCode, PDO::PARAM_STR);
  $stmt->execute();

  $response = [
    'message' => 'Workspace code regenerate successful.',
  ];

  return $response;
}

// Generate unique Workspace code
function generateCode($length,$pdo) {
  while(true) {
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
