<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $jsonData = file_get_contents('php://input');
  $data = json_decode($jsonData, true);

  require_once 'connection.php';

  session_start();

  $action = $data['action'];

  switch ($action) {
    case 'getWorkspace':
      $workspace = getWorkspace($pdo, $data['workspace']);
      break;
    default:
      $response = [
        'message' => 'Invalid action',
      ];
      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
  }
}

// Main functions
function getWorkspace($pdo, $workspaceID){
  $workspace = getWorkspaceDetail($pdo, $workspaceID);
  $owner = getWorkspaceOwner($pdo, $workspace['owner']);
  $members = getMembersQuantity($pdo, $workspaceID);

  $response = [
    'workspace' => $workspace,
    'owner' => $owner,
    'members' => $members,
  ];

  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Helper functions 
function getWorkspaceDetail($pdo, $workspaceID){
  $query = "SELECT * FROM Workspace WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $workspace = $stmt->fetch(PDO::FETCH_ASSOC);
  return $workspace;
}

function getWorkspaceOwner($pdo, $accountID){
  $query = "SELECT * FROM Account WHERE accountID = :accountID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
  $stmt->execute();
  $owner = $stmt->fetch(PDO::FETCH_ASSOC);
  return $owner;
}

function getMembersQuantity($pdo, $workspaceID){
  $query = "SELECT COUNT(*) FROM Member WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $membersCount = $stmt->fetchColumn(); // Fetches the count directly
  return $membersCount;
}
