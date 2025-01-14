<?php 
session_start();
include ('database.php');

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
define('SEND_FROM_NAME', "no-reply");
define('REPLY_TO', "no-reply@gmail.com");
define('REPLY_TO_NAME', "User");

function isEmailInDatabase($email) {
    $mysqli = new mysqli("localhost", "root", "", "db_system");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $email = $mysqli->real_escape_string($email);

    $query = "SELECT COUNT(*) as count FROM users WHERE email = '$email'";
    $result = $mysqli->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $result->close();
        $mysqli->close();
        return $count > 0;
    } else {
        $mysqli->close();
        return false;
    }
}

//for token
function generateResetToken($email) {
    $token = bin2hex(random_bytes(32)); // Generate a random token
    $expirationTime = time() + 120; // Set expiration time to 2 minutes from now

    // $server = "191.101.13.205"; 
    // $uname = "u839485473_root"; 
    // $passwd = "@Berrymcposa1"; 
    // $db = "u839485473_db_system";  

    $mysqli = new mysqli("191.101.13.205", "u839485473_root", "@Berrymcposa1", "u839485473_db_system");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $email = $mysqli->real_escape_string($email);
    $token = $mysqli->real_escape_string($token);

    // Check if a row with the same email already exists
    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = $mysqli->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        // Update the existing row
        $updateQuery = "UPDATE users SET token = '$token', token_expires_at = '$expirationTime' WHERE email = '$email'";
        $updateResult = $mysqli->query($updateQuery);

        if (!$updateResult) {
            die("Error updating reset token: " . $mysqli->error);
        }
    } else {
        // Insert a new row
        $insertQuery = "INSERT INTO users (email, token, token_expires_at) VALUES ('$email', '$token', '$expirationTime')";
        $insertResult = $mysqli->query($insertQuery);

        if (!$insertResult) {
            die("Error inserting reset token: " . $mysqli->error);
        }
    }

    $mysqli->close();

    return $token;
}


function sendMail($email) {
    if (!isEmailInDatabase($email)) {
        return "<p class='not-found'>Email address is invalid.</p>";
    }

    $token = generateResetToken($email);

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = MAILHOST;
    $mail->Username = USERNAME;
    $mail->Password = PASSWORD;                   

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;                                      

    $mail->setFrom(SEND_FROM, "no-reply@gmail.com");
    $mail->addAddress($email);
    $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);

    $mail->Subject = "Reset your password";
	$mail->isHTML(true);
    $mail->Body = "We received a request to reset your password. Please click <a href='http://localhost/main/reset-form.php?token=$token'>here.</a>";

    if (!$mail->send()) {
        return "Email not sent. Please try again";
    } else {
        return "success";
    }
}
?>

        <!-- old code -->