<?php
require('database.php');
$error = '';
session_start();

// Define the maximum number of incorrect login attempts
$maxAttempts = 3;
// Define the delay in seconds after reaching the maximum attempts
$delaySeconds = 30;

if (isset($_SESSION['loginAttempts']) && $_SESSION['loginAttempts'] >= $maxAttempts) {
    // Check if the delay period has passed
    if (isset($_SESSION['lastFailedAttemptTime'])) {
        $timeElapsed = time() - $_SESSION['lastFailedAttemptTime'];
        $remainingDelay = max(0, $delaySeconds - $timeElapsed);

        if ($remainingDelay > 0) {
            $error = 'Too many incorrect login attempts. Please try again after ' . $remainingDelay . ' seconds.';
        } else {
            // Reset login attempts and update the last failed attempt time
            $_SESSION['loginAttempts'] = 0;
            $_SESSION['lastFailedAttemptTime'] = null;
        }
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['user'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username=?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    $count = mysqli_num_rows($res);

    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);

        if (password_verify($password, $row['passwd'])) {
            // Successful login
            $_SESSION['ROLE'] = $row['privilege'];
            $_SESSION['validate'] = 'yes';
        
            // Reset login attempts and update the last failed attempt time
            $_SESSION['loginAttempts'] = 0;
            $_SESSION['lastFailedAttemptTime'] = null;
        
            if ($row['privilege'] == 'administrator') {
                header('location: home.php');
                die();
            } elseif ($row['privilege'] == 'user') {
                header('location: userOnly.php');
                die();
            } else {
                header('location: unauthorized.php');
                die();
            }
        } else {
            $error = 'Invalid username or password.';
            // Increment the login attempts
            $_SESSION['loginAttempts'] = isset($_SESSION['loginAttempts']) ? ($_SESSION['loginAttempts'] + 1) : 1;
            // Update the last failed attempt time
            $_SESSION['lastFailedAttemptTime'] = time();
        }
    } else {
        $error = 'Invalid username or password.';
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="loginStyle.css">
</head>

<body>
    <div class="logo">
        <img src="updated.png" alt="logo">
    </div>
    
    <form method="POST" id="loginForm"> <!-- Add the ID "loginForm" here -->
        <fieldset>
            <label for="user">Username</label>
            <input type="text" id="usernameInput" name="user" required>

            <label for="pass">Password</label>
            <input type="password" id="passwordInput" name="password" required>

            <input type="submit" class="submit" value="Log In" name="login" id="loginButton"> <!-- Add the ID "loginButton" here -->
            <br><br><br><br>
            <a href="create.php">Don't have an account?</a> <br>
            <a href="forgot.php">Forgot password?</a> <br><br>
            <div id="errorMsg">
                <?php echo $error; ?>
            </div>
            <input type="hidden" id="remainingDelay" value="<?php echo $remainingDelay; ?>">
        </fieldset>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
        var countdownContainer = $('#errorMsg');
        var loginForm = $('#loginForm');
        var usernameInput = $('#usernameInput');
        var passwordInput = $('#passwordInput');
        var loginButton = $('#loginButton');
        var remainingDelayInput = $('#remainingDelay');

        var remainingDelay = remainingDelayInput.val();

        if (remainingDelay > 0) {
            updateCountdown();
            disableInputs();
        }

        function updateCountdown() {
            $.ajax({
                url: 'delaySeconds.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    remainingDelay = response.remainingDelay;

                    if (remainingDelay > 0) {
                        countdownContainer.html('Too many attempts. Try again in ' + remainingDelay + ' seconds');
                        disableInputs();
                        setTimeout(updateCountdown, 1000);
                    } else {
                        countdownContainer.html('');
                        enableInputs();
                    }
                }
            });
        }

        function disableInputs() {
            usernameInput.prop('disabled', true);
            passwordInput.prop('disabled', true);
            loginButton.prop('disabled', true);
        }

        function enableInputs() {
            usernameInput.prop('disabled', false);
            passwordInput.prop('disabled', false);
            loginButton.prop('disabled', false);
        }

        loginForm.submit(function (event) {
            if (remainingDelay > 0) {
                updateCountdown();
                disableInputs();
                event.preventDefault();
            }
        });
    });

    </script>
</body>

</html>

