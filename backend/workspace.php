<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $jsonData = file_get_contents('php://input');
  $data = json_decode($jsonData, true);

  require_once 'connection.php';

  // session_start();

  $action = $data['action'];

  switch ($action) {
    case 'getWorkspaceList':
      // $workspaces = getWorkspaceList($pdo, $_SESSION['accountID']);
      $response = getWorkspaceList($pdo, 'A0001'); // Hardcoded for testing
      break;
    case 'getWorkspace':
      $response = getWorkspace($pdo, $data['workspace']);
      break;
    case 'getWorkspaceMembers':
      $response = getWorkspaceMembers($pdo, $data['workspace']);
      break;
    case 'createTask':
      $response = createTask($pdo, $data);
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

// Main functions
function getWorkspaceList($pdo, $accountID)
{
  $query = "SELECT * FROM Member WHERE accountID = :accountID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
  $stmt->execute();
  $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $workspaces = [];
  foreach ($members as $member) {
    $workspace = getWorkspaceDetail($pdo, $member['workspaceID']);
    $owner = getWorkspaceOwner($pdo, $workspace['owner']);
    $membersCount = getMembersQuantity($pdo, $workspace['workspaceID']);

    $workspaces[] = [
      'workspace' => $workspace,
      'owner' => $owner,
      'members' => $membersCount,
    ];
  }
  return $workspaces;
}

function getWorkspace($pdo, $workspaceID)
{
  $workspace = getWorkspaceDetail($pdo, $workspaceID);
  $owner = getWorkspaceOwner($pdo, $workspace['owner']);
  $members = getMembersQuantity($pdo, $workspaceID);

  $workspace = [
    'workspace' => $workspace,
    'owner' => $owner,
    'members' => $members,
  ];

  return $workspace;
}

function createTask($pdo, $data){
  $taskID = generateTaskID($pdo);
  $date = date('Y-m-d H:i:s');
  
  $query = "INSERT INTO Task (taskID, workspaceID, creator, taskName, taskDesc, type, priority, creationDate, due) VALUES (:taskID, :workspaceID, :creator, :taskName, :taskDesc, :type, :priority, :creationDate, :due)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':taskID', $taskID, PDO::PARAM_STR);
  $stmt->bindParam(':workspaceID', $data['workspaceID'], PDO::PARAM_STR);
  $accountID = 'A0001'; // Hardcoded for testing
  $stmt->bindParam(':creator', $accountID, PDO::PARAM_STR);
  $stmt->bindParam(':taskName', $data['taskName'], PDO::PARAM_STR);
  $stmt->bindParam(':taskDesc', $data['taskDesc'], PDO::PARAM_STR);
  $stmt->bindParam(':type', $data['type'], PDO::PARAM_STR);
  $stmt->bindParam(':priority', $data['priority'], PDO::PARAM_STR);
  $stmt->bindParam(':creationDate', $date, PDO::PARAM_STR);
  $stmt->bindParam(':due', $data['due'], PDO::PARAM_STR);
  $stmt->execute();

  foreach ($data['members'] as $member) {
    $query = "INSERT INTO Assigned (taskID, assignedMember) VALUES (:taskID, :assignedMember)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':taskID', $taskID, PDO::PARAM_STR);
    $stmt->bindParam(':assignedMember', $member, PDO::PARAM_STR);
    $stmt->execute();
  }

  $response = [
    'message' => 'Task created successfully',
  ];

  return $response;
}

// Helper functions 
function getWorkspaceDetail($pdo, $workspaceID)
{
  $query = "SELECT * FROM Workspace WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $workspace = $stmt->fetch(PDO::FETCH_ASSOC);
  return $workspace;
}

function getWorkspaceOwner($pdo, $accountID)
{
  $query = "SELECT * FROM Account WHERE accountID = :accountID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
  $stmt->execute();
  $owner = $stmt->fetch(PDO::FETCH_ASSOC);
  return $owner;
}

function getMembersQuantity($pdo, $workspaceID)
{
  $query = "SELECT COUNT(*) FROM Member WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $membersCount = $stmt->fetchColumn(); // Fetches the count directly
  return $membersCount;
}

// Get list of workspace members
function getWorkspaceMembers($pdo, $workspaceID)
{
  $query = "SELECT a.accountID, a.username FROM Account a, Member m WHERE m.workspaceID = :workspaceID AND m.accountID = a.accountID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $members;
}

// Generate a unique task ID
function generateTaskID($pdo){
  $query = "SELECT COUNT(*) FROM Task";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $count = $stmt->fetchColumn();
  $taskID = "T" . str_pad($count + 1, 4, "0", STR_PAD_LEFT);
  return $taskID;
}

