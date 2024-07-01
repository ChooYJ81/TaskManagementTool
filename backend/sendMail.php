<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $jsonData = file_get_contents('php://input');
  $data = json_decode($jsonData, true);

  require_once 'connection.php';

  session_start();

  $action = $data['action'];

  switch ($action) {
    case 'sendOTP':
      $content = sendOTP($data['otp']);
      $email = $_SESSION['email'];
      break;
    case 'resendOTP':
      $otp = generateOTP(5,$pdo);
      $_SESSION['otp'] = $otp;  // Store the OTP in the session
      $content = sendOTP($otp);
      $email = $_SESSION['email'];
      break;
    case 'sendInvitation':
      $content = sendInvitation($pdo, $data['workspace']);
      $email = $data['email'];
      break;
    default:
      $response = [
        'message' => 'Invalid action',
      ];
  }

  $response = sendMail($content, $email);


  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}

// Generate unique OTP code
function generateOTP($length, $pdo)
{
  while (true) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $code = '';
    for ($i = 0; $i < $length; $i++) {
      $code .= $characters[rand(0, $charactersLength - 1)];
    }

    // Check if unique
    $query = "SELECT COUNT(*) FROM account WHERE OTP = :code AND email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':code', $code, PDO::PARAM_STR);
    $stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if ($count == 0) {
      break;
    }
  }

  // Update the OTP code in the database
  $query = "UPDATE account SET OTP = :code WHERE email = :email";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':code', $code, PDO::PARAM_STR);
  $stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
  $stmt->execute();
  
  return $code;
}


function sendOTP($otp)
{
  $html = "
    <p>Hello,</p>
    <p>Thank you for using SunCollab. Your OTP code is:</p>
    <p class=\"otp\">{$otp}</p>
    <p>Please enter this code to proceed with your account registration.</p>
  ";
  $content = [
    'subject' => "Your SunCollab OTP Code",
    'html' => $html
  ];
  return $content;
}

function sendInvitation($pdo, $workspaceID){
  $owner = getOwner($pdo, $workspaceID);
  $workspace = getWorkspace($pdo, $workspaceID);
  $name = $workspace['workspaceName'];
  $code = $workspace['workspaceCode'];
  
  $html = "
    <p>Hello,</p>
    <p><b>{$owner}</b> is inviting you to join their workspace.</p>
    <p class=\"ownerName\">{$name}</p>
     <p class=\"otp\">{$code}</p>
    <p>Please enter the workspace code above <br> at the sidebar after login to join.</p>
  ";
  $content = [
    'subject' => "SunCollab Workspace Invitation",
    'html' => $html
  ];
  return $content;
}

function getOwner($pdo,$workspaceID){
  $query = "SELECT owner FROM workspace WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $owner = $stmt->fetchColumn();
  
  $query = "SELECT username FROM account WHERE accountID = :owner";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':owner', $owner, PDO::PARAM_STR);
  $stmt->execute();
  $owner = $stmt->fetchColumn();

  return $owner;
}

function getWorkspace($pdo,$workspaceID){
  $query = "SELECT workspaceName, workspaceCode FROM workspace WHERE workspaceID = :workspaceID";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':workspaceID', $workspaceID, PDO::PARAM_STR);
  $stmt->execute();
  $workspaceDetails = $stmt->fetch(PDO::FETCH_ASSOC);

  return $workspaceDetails;
}

function sendMail($content, $email)
{
  // Subject
  $subject = $content['subject'];

  // Boundary
  $boundary = md5(uniqid(time()));

  // Headers
  $headers = "From: SunCollab <suncollab@outlook.com>\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/related; boundary=\"{$boundary}\"\r\n";

  // Image path
  $imagePath = '../images/logoWhite.png';

  // Body content
  $html = $content['html'];

  // Check if the image file exists
  if (file_exists($imagePath)) {
    // Read and encode the image
    $imageData = chunk_split(base64_encode(file_get_contents($imagePath)));

    // Message body
    $message = "
--{$boundary}
Content-Type: text/html; charset=UTF-8
Content-Transfer-Encoding: 7bit

<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #dddddd;
        }
        .header {
            background-color: #2a386e;
            color: white;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .header img {
            max-width: 250px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        .content {
            padding: 20px;
        }
        .ownerName{
          color:#2A386E;
          font-size: 18px;
          font-weight: bold;
        }
        .otp {
            font-size: 48px;
            font-weight: bold;
            margin: 5px 0;
            color: #3284ba;
        }
        .footer {
            margin-top: 20px;
            background-color: #2a386e;
            color: white;
            padding: 10px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div>
        <table class=\"container\" cellpadding=\"0\" cellspacing=\"0\">
            <tr>
                <td class=\"header\">
                    <h1>SunCollab</h1>
                    <p>Kanban Made Simple. Collaboration Made Brilliant.</p>
                </td>
            </tr>
            <tr>
                <td class=\"content\">";
    $message .= $html; // Append the HTML content
    $message .= "
                </td>
            </tr>
            <tr>
                <td class=\"footer\">
                    <p>&copy; " . date("Y") . " SunCollab. All rights reserved.</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

--{$boundary}
Content-Type: image/png
Content-Transfer-Encoding: base64
Content-ID: <logo>

{$imageData}

--{$boundary}--
    ";

    // Send email
    if (mail($email, $subject, $message, $headers)) {
      $status = true;
      $message = 'An OTP has been sent to your email for verification.';
    } else {
      $status = false;
      $message = 'Failed to send email.';
    }

    // Send a JSON response indicating success or failure
    $response = [
      'status' => $status,
      'message' => $message
    ];
  } else {
    $response = [
      'status' => false,
      'message' => 'Image file not found'
    ];
  }

  return $response;
}
