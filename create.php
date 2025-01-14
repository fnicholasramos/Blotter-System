<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <link rel="stylesheet" href="createStyle.css">
</head>
<body>
    <form action="" method="POST" onsubmit="return validateForm()">
    <fieldset>
        <h2>Create an account</h2>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required oninput="validatePassword()">

        <label for="confirm">Confirm password</label>
        <input type="password" id="confirm" name="confirm" required oninput="updateConfirmPasswordPlaceholder()">

        <input type="submit" class="signUp" name="sign-up">
        <p><a href="login.php" id="back-to-login"> ← Back to login</a></p>

        <?php include 'insert.php';?>
    </fieldset>
    </form>

    <script>
        function updateConfirmPasswordPlaceholder() {
            var password = document.getElementById('password').value;
            var confirm = document.getElementById('confirm');
            
            if (password !== confirm.value) {
                confirm.setCustomValidity("Passwords do not match.");
            } else {
                confirm.setCustomValidity('');
            }

            // Additionally, you can display a message to guide the user
            if (confirm.validationMessage === "Passwords do not match.") {
                document.getElementById('confirm').setCustomValidity("Passwords should match.");
            } else {
                document.getElementById('confirm').setCustomValidity('');
            }
        }

        function validatePassword() {
            var password = document.getElementById('password').value;

            // Add your password validation logic here
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+=])[A-Za-z\d@$!%*?&+=]{8,}$/;
            
            if (!regex.test(password)) {
                document.getElementById('password').setCustomValidity("Password should be 8 characters with at least one special character (*[@#$%^&+=]), one numeric, one small case, and one upper case letter.");
            } else {
                document.getElementById('password').setCustomValidity('');
            }
        }

        function validateForm() {
            // Additional form-level validation can be added here
            // Return false to prevent form submission if validation fails
            return true;
        }
    </script>
</body>
</html>
