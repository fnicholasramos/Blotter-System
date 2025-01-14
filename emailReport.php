<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

define('MAILHOST', "smtp.gmail.com");
define('USERNAME', "tuser2815@gmail.com");
define('PASSWORD', "bnpw olrt khpw deqg");
define('SEND_FROM', "no-reply@gmail.com");
define('SEND_FROM_NAME', "Blotter Report");
define('REPLY_TO', "no-reply@gmail.com");
define('REPLY_TO_NAME', "System");

// Replace these with your database credentials
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_system";

// Set the timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Create a database connection
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your email address for notification
$sqlNotificationEmail = "SELECT email FROM users WHERE privilege = 'administrator' LIMIT 1";
$resultNotificationEmail = $conn->query($sqlNotificationEmail);

// Check if there is a notification email in the database
if ($resultNotificationEmail->num_rows > 0) {
    $rowNotificationEmail = $resultNotificationEmail->fetch_assoc();
    $notificationEmail = $rowNotificationEmail['email'];
} else {
    // Default notification email if not found in the database
    $notificationEmail = "tuser2815@gmail.com";
}


// Get the current date
$currentDate = date('Y-m-d');

// Query to select scheduled reports for today
$sql = "SELECT classification, complainant, respondent, tim3 FROM scheduled_report WHERE schedule = '$currentDate'";
$result = $conn->query($sql);

// Check if there are any scheduled reports for today
if ($result->num_rows > 0) {
    // Loop through the results
    while ($row = $result->fetch_assoc()) {
        // Get the complainant and respondent values
        $classification = $row['classification'];
        $complainant = $row['complainant'];
        $respondent = $row['respondent'];
        $time = $row['tim3'];

        // Function to send an email
        sendEmail($notificationEmail, $classification, $complainant, $respondent, $time);
    }
}

// Close the database connection
$conn->close();

// Function to send an email
function sendEmail($to, $classification, $complainant, $respondent, $time) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = MAILHOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = USERNAME;
        $mail->Password   = PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Enable SMTP debugging
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        //Sender information
        $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
        $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);

        //Recipient
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Scheduled Report';

        $date = date('F j, Y');
        // Generate email body with complainant and respondent

        $mailBody = "
        <p>Dear Admin,</p><br>
        <p>This is to inform you that a scheduled blotter report is set to occur today. Please see the details below:</p><br>

        <p><strong>Classification:</strong> $classification</p>
        <p><strong>Complainant:</strong> $complainant</p>
        <p><strong>Respondent:</strong> $respondent</p>
        <p><strong>Date:</strong> $date</p>
        <p><strong>Time:</strong> $time</p><br>
        <p>Please ensure that you are prepared to review and take any necessary actions based on the information provided in the report.</p>
        <p>Thank you for your attention.</p>
        
        ";

        // Add the email body to the mail object
        $mail->Body = $mailBody;

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}


