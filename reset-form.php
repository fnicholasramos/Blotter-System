<?php

if (isset($_SESSION['reset_submitted']) && $_SESSION['reset_submitted']) {
    header('Location: error.php');
    exit();
}
// Check if the form is submitted
if (isset($_POST['submit'])) {
    $newPassword = $_POST['pass'];
    $confirmPassword = $_POST['confirm_pass'];
    
    $_SESSION['reset_submitted'] = true;
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
</head>
<style>
    h2 {
    text-align:center;
    font-family: Arial, Helvetica, sans-serif;
    margin-left: 10px;
    margin-bottom: -5px;
    color: #4f4f4f;
    }   

    fieldset {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 1px;
        width: 350px;
        height: 230px;
        border: 1px solid #c3c4c7;
        margin: 20px auto; 
        text-align: center;
        position: relative;
    }

    label {
        display: block;
        margin-bottom: 5px;
        float: left;
        font-family: Arial, Helvetica, sans-serif;
        text-align: right;
        margin-right: 0.5em;
        display: block;
        overflow: hidden;
        padding-right: 50px; 
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px;
        border-style: solid;
        box-sizing: border-box;
        background-color: #ffffff;
        border-color: #bfc2ca;
        border-radius: 4px;
        font-size: 23px;
        float: left;
    }

    .submit {
        font-family: Arial, sans-serif;
        font-size: 15px;
        color: #ffffff;
        width: 100%;
        height: 40px;
        background-color: #135e96;
        border: 1px;
        border-style: solid;
        border-radius: 4px;
        cursor: pointer;
        margin: 0;
        padding: 0;
        float: center;
    }

    .submit:hover {
        background-color: #2980b9;
    }
</style>
<body>
    <h2>Choose a new password</h2>
    <fieldset>
        <form action="reset.php" method="POST">
            <label for="pass">New password</label> <br>
            <input type="password" id="pass" name="pass" required><br>
            

            <label for="pass">Re-type new password</label> <br>
            <input type="password" id="confirm_pass" name="confirm_pass" required><br><br>

            <button type="submit" name="submit" class="submit">Reset Password</button>
        </form>
    
    </fieldset>
</body>
</html>


