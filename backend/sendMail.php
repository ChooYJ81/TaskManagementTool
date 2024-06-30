<?php
session_start();

// Generate OTP
$otp = rand(100000, 999999);

// Store OTP in session for later verification
$_SESSION['otp'] = $otp;

// Email subject and recipient
$subject = "Your SunCollab OTP Code";
$email = "shaorencheah@gmail.com";

// Boundary
$boundary = md5(uniqid(time()));

// Headers
$headers = "From: SunCollab <suncollab@outlook.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/related; boundary=\"{$boundary}\"\r\n";

// Image path
$imagePath = '../images/logoWhite.png';

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
        .otp {
            font-size: 48px;
            font-weight: bold;
            margin: 20px 0;
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
                    <img src=\"cid:logo\" alt=\"SunCollab Logo\">
                </td>
            </tr>
            <tr>
                <td class=\"content\">
                    <p>Hello,</p>
                    <p>Thank you for using SunCollab. Your OTP code is:</p>
                    <p class=\"otp\">{$otp}</p>
                    <p>Please enter this code to proceed with your account registration.</p>
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

--{$boundary}--";

// Send email
if (mail($email, $subject, $message, $headers)) {
    $success = true;
} else {
    $success = false;
}

// Send a JSON response indicating success or failure
$response = [
    'success' => $success
];

echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'Image file not found.']);
}
?>
