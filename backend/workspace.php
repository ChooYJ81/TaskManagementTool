<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $jsonData = file_get_contents('php://input');
  $data = json_decode($jsonData, true);

  require_once 'connection.php';

  session_start();

  $action = $data['action'];

  switch ($action) {
    case 'getWorkspaceList':
      // $workspaces = getWorkspaceList($pdo, $_SESSION['accountID']);
      $response = getWorkspaceList($pdo, $_SESSION['accountID']); // Hardcoded for testing
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
    case 'getTasks':
      $response = getTasks($pdo, $data['workspace']);
      break;
    case 'getCreatorAndAssigned':
      $response = [
        'creator' => getTaskCreator($pdo, $data['task']),
        'members' => getAssignedMembers($pdo, $data['task'])
      ];
      break;
    case 'updateTask':
      $response = updateTask($pdo, $data);
      break;
    case 'updateTaskType':
      $response = updateTaskType($pdo, $data);
      break;
    case 'deleteTask':
      $response = deleteTask($pdo, $data['taskID']);
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
function createTask($pdo, $data)
{
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

  if ($data['members'] != null) {
    foreach ($data['members'] as $member) {
      $query = "INSERT INTO Assigned (taskID, assignedMember) VALUES (:taskID, :assignedMember)";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':taskID', $taskID, PDO::PARAM_STR);
      $stmt->bindParam(':assignedMember', $member, PDO::PARAM_STR);
      $stmt->execute();
    }
  }

  $response = [
    'message' => 'Task created successfully',
  ];

  return $response;
}

function updateTask($pdo, $data)
{
  // Delete all assigned members first
  $query = "DELETE FROM Assigned WHERE taskID = :taskID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':taskID', $data['taskID'], PDO::PARAM_STR);
  $stmt->execute();

  // Update new task details
  $query = "UPDATE Task SET taskName = :taskName, taskDesc = :taskDesc, priority = :priority, due = :due WHERE taskID = :taskID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':taskName', $data['taskName'], PDO::PARAM_STR);
  $stmt->bindParam(':taskDesc', $data['taskDesc'], PDO::PARAM_STR);
  $stmt->bindParam(':priority', $data['priority'], PDO::PARAM_STR);
  $stmt->bindParam(':due', $data['due'], PDO::PARAM_STR);
  $stmt->bindParam(':taskID', $data['taskID'], PDO::PARAM_STR);
  $stmt->execute();

  // Assign new members
  foreach ($data['members'] as $member) {
    $query = "INSERT INTO Assigned (taskID, assignedMember) VALUES (:taskID, :assignedMember)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':taskID', $data['taskID'], PDO::PARAM_STR);
    $stmt->bindParam(':assignedMember', $member, PDO::PARAM_STR);
    $stmt->execute();
  }

  $response = [
    'message' => 'Task updated successfully',
  ];

  return $response;
}

function updateTaskType($pdo, $data)
{
  $query = "UPDATE Task SET type = :type WHERE taskID = :taskID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':type', $data['newType'], PDO::PARAM_STR);
  $stmt->bindParam(':taskID', $data['taskID'], PDO::PARAM_STR);
  $stmt->execute();

  $response = [
    'message' => 'Task type updated successfully from ' . $data['oldType'] . ' to ' . $data['newType'] . '.'
  ];

  return $response;
}

function deleteTask($pdo, $taskID)
{
  $query = "SELECT * FROM Assigned WHERE taskID = :taskID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':taskID', $taskID, PDO::PARAM_STR);
  $stmt->execute();
  $assigned = $stmt->fetchAll(PDO::FETCH_COLUMN);

  if ($assigned != null) {
    foreach ($assigned as $member) {
      $query = "DELETE FROM Assigned WHERE taskID = :taskID AND assignedMember = :assignedMember";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':taskID', $taskID, PDO::PARAM_STR);
      $stmt->bindParam(':assignedMember', $member, PDO::PARAM_STR);
      $stmt->execute();
    }
  }

  // Delete the task from the Task Table
  $query = "DELETE FROM Task WHERE taskID = :taskID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':taskID', $taskID, PDO::PARAM_STR);
  $stmt->execute();

  $response = [
    'message' => 'Task deleted successfully',
  ];

  return $response;
}

// Helper functions 
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
    $taskAssigned = getAssignedTasks($pdo, $workspace['workspaceID'], $accountID);

    $workspaces[] = [
      'workspace' => $workspace,
      'owner' => $owner,
      'members' => $membersCount,
      'taskAssigned' => $taskAssigned
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

function getAssignedTasks($pdo, $workspaceID, $accountID)
{
  $query = "SELECT COUNT(*) FROM Assigned a, Task t WHERE a.assignedMember = :accountID AND a.taskID = t.taskID AND t.workspaceID = :workspaceID AND t.type != 'Completed'";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $taskAssigned = $stmt->fetchColumn();
  return $taskAssigned;
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
function generateTaskID($pdo)
{
  // Select the highest taskID from the Task table
  $query = "SELECT taskID FROM Task ORDER BY taskID DESC LIMIT 1";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $lastTaskID = $stmt->fetchColumn();

  // Extract the numeric part of the taskID
  $number = substr($lastTaskID, 1);

  // Increment the number by 1
  $newNumber = intval($number) + 1;

  // Generate a new taskID
  $taskID = "T" . str_pad($newNumber, 4, "0", STR_PAD_LEFT);
  return $taskID;
}

// Get tasks for a workspace
function getTasks($pdo, $workspaceID)
{
  $types = ['To-Do', 'In Progress', 'Completed'];
  $result = [
    'To-Do' => [],
    'In Progress' => [],
    'Completed' => []
  ];
  foreach ($types as $type) {
    $taskQuantity = getTaskQuantity($pdo, $workspaceID, $type);
    $tasks = getTask($pdo, $workspaceID, $type);
    $result[$type] = [
      'quantity' => $taskQuantity,
      'tasks' => $tasks
    ];
  }
  return $result;
}

function getTaskQuantity($pdo, $workspaceID, $type)
{
  $query = "SELECT COUNT(*) FROM Task WHERE workspaceID = :workspaceID AND type = :type";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->bindParam(':type', $type, PDO::PARAM_STR);
  $stmt->execute();
  $count = $stmt->fetchColumn();
  return $count;
}

function getTask($pdo, $workspaceID, $type)
{

  $query = "SELECT t.*, a.taskID as assignedTaskID, a.assignedMember FROM Task t
            LEFT JOIN Assigned a ON t.taskID = a.taskID
            WHERE t.workspaceID = :workspaceID AND t.type = :type";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->bindParam(':type', $type, PDO::PARAM_STR);
  $stmt->execute();
  $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $tasks;
}

function getTaskCreator($pdo, $taskID)
{
  $query = "SELECT a.accountID, a.username FROM Account a, Task t WHERE t.taskID = :taskID AND t.creator = a.accountID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':taskID', $taskID, PDO::PARAM_STR);
  $stmt->execute();
  $creator = $stmt->fetch(PDO::FETCH_ASSOC);
  return $creator;
}

function getAssignedMembers($pdo, $taskID)
{
  $query = "SELECT ac.accountID, ac.username FROM Account ac, Assigned a WHERE a.taskID = :taskID AND a.assignedMember = ac.accountID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':taskID', $taskID, PDO::PARAM_STR);
  $stmt->execute();
  $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $members;
}
