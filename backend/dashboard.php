<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    require_once 'connection.php';

    session_start();

    $action = $data['action'];

    switch ($action) {
        case 'getWorkspace':
            // $workspaces = getWorkspaceList($pdo, $_SESSION['accountID']);
            $response = getWorkspace($pdo, $_SESSION['accountID']); // Hardcoded for testing
            break;
        case 'getTaskDetails':
            $response = getTaskDetails($pdo, $data['workspaceID'], $data['pageNo']);
            break;
        case 'getTaskBreakdown':
            $response = getTaskBreakdown($pdo, $data['workspaceID']);
            break;
        case 'getProgressPercentage':
            $response = getProgressPercentage($pdo, $data['workspaceID']);
            break;
        case 'getTotalPage':
            $response = getTotalTaskPages($pdo, $data['workspaceID'], 7);
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

function getWorkspace($pdo, $accountID)
{
    $query = "SELECT * FROM member WHERE accountID = :accountID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $workspaces = [];
    foreach ($members as $member) {
        $workspace = getWorkspaceDetail($pdo, $member['workspaceID']);
        $tasks = getTasksQuantity($pdo, $workspace['workspaceID'], $accountID);

        $workspaces[] = [
            'workspace' => $workspace,
            'tasks' => $tasks,
        ];
    }
    return $workspaces;
}

function getWorkspaceDetail($pdo, $workspaceID)
{
    $query = "SELECT * FROM workspace WHERE workspaceID = :workspaceID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->execute();
    $workspace = $stmt->fetch(PDO::FETCH_ASSOC);
    return $workspace;
}

function getTasksQuantity($pdo, $workspaceID, $accountID)
{
    $types = ['Remaining', 'Completed', 'yourTask'];

    foreach ($types as $type) {
        if ($type === 'Remaining') {
            $taskQuantity = getRemainingTaskQuantity($pdo, $workspaceID);
        }
        if ($type === 'Completed') {
            $taskQuantity = getCompletedTask($pdo, $workspaceID, $type);
        }
        if ($type === 'yourTask') {
            $taskQuantity = getYourTask($pdo, $workspaceID, $accountID);
        }
        $result[$type] = $taskQuantity;
    }
    return $result;
}

function getTaskBreakdown($pdo, $workspaceID)
{
    $priority = ['Low Priority', 'Medium Priority', 'High Priority'];
    $remainingTask = getRemainingTaskQuantity($pdo, $workspaceID);
    $result = [
        'remainingTask' => $remainingTask,
        'Low Priority' => '',
        'Medium Priority' => '',
        'High Priority' => '',
    ];

    foreach ($priority as $p) {
        $taskQuantity = getTaskPriorityQuantity($pdo, $workspaceID, $p);
        $result[$p] = $taskQuantity;
    }

    return $result;
}

function getTaskPriorityQuantity($pdo, $workspaceID, $priority)
{
    $query = "SELECT COUNT(*) FROM task WHERE workspaceID = :workspaceID AND priority = :priority";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->bindParam(':priority', $priority, PDO::PARAM_STR);
    $stmt->execute();
    $task = $stmt->fetchColumn();
    return $task;
}

function getRemainingTaskQuantity($pdo, $workspaceID)
{
    $types = ['To-Do', 'In Progress'];
    $query = "SELECT COUNT(*) FROM task WHERE workspaceID = :workspaceID AND type IN (:type1, :type2)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->bindParam(':type1', $types[0], PDO::PARAM_STR);
    $stmt->bindParam(':type2', $types[1], PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count;
}

function getCompletedTask($pdo, $workspaceID, $type)
{
    $query = "SELECT COUNT(*) FROM task WHERE workspaceID = :workspaceID AND type = :type";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count;
}

function getYourTask($pdo, $workspaceID, $accountID)
{
    $query = "SELECT COUNT(*) FROM task t, assigned a WHERE workspaceID = :workspaceID AND t.taskID = a.taskID AND a.assignedMember = :accountID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count;
}

function getTaskDetails($pdo, $workspaceID, $pageNo)
{
    $max_record = 7;
    $offset = ($pageNo - 1) * $max_record;

    $query = "SELECT *, t.type as 'taskType'
FROM Task t
INNER JOIN Assigned a ON t.taskID = a.taskID
INNER JOIN Member m ON t.workspaceID = m.workspaceID AND t.creator = m.accountID
INNER JOIN Account b ON a.assignedMember = b.accountID
INNER JOIN Workspace w ON t.workspaceID = w.workspaceID
WHERE t.workspaceID = :workspaceID
LIMIT $offset, $max_record";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $tasks;
}

function getProgressPercentage($pdo, $workspaceID)
{
    $remainingTask = getRemainingTaskQuantity($pdo, $workspaceID);
    $query = "SELECT COUNT(*) FROM task WHERE workspaceID = :workspaceID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if ($count == 0) {
        return 0;
    } else {
        $percentage = ceil(($count - $remainingTask) / $count * 100);
        return $percentage;
    }
}

function getTotalTaskPages($pdo, $workspaceID, $record)
{
    $query = "SELECT COUNT(*)
FROM Task t
INNER JOIN Assigned a ON t.taskID = a.taskID
INNER JOIN Member m ON t.workspaceID = m.workspaceID AND t.creator = m.accountID
INNER JOIN Account b ON a.assignedMember = b.accountID
INNER JOIN Workspace w ON t.workspaceID = w.workspaceID
WHERE t.workspaceID = :workspaceID;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return (ceil($count / $record));
}
