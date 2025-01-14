<?php
session_start();
include 'database.php';

if(isset($_POST["submit"])) {
    // Validate and sanitize input
    $newPassword = mysqli_real_escape_string($mysqli, $_POST["pass"]);
    $confirmPassword = mysqli_real_escape_string($mysqli, $_POST["confirm_pass"]);

    if ($newPassword != $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    
    if ($email) {

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE users SET passwd = ? WHERE email = ?";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);
        
        if (mysqli_stmt_execute($stmt)) {
            header('location:index.php?update=Password has been reset.');
        } else {
            die("Query has failed." . mysqli_error($mysqli));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "The reset link has expired. Please request a new password reset.";
    }
}
?>