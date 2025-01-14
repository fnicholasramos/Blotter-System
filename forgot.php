<?php require("script.php"); ?>
<?php 
	if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $_SESSION['email'] = $email;
		$response = sendMail($_POST['email']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="forgot.css">
</head>
<body>
    <form method="POST" action="">
    <fieldset>
        <h2 id="forgot">Forgot your password?</h2>
        <p>Please enter your email for your account.</p> <br>
            <label for="email">Enter your email</label>
            <input type="email" name="email" id="email" required> <br>
            <button type="submit" name="submit">Reset</button>
            <p><a href="login.php" id="back-to-login"> ← Back to login</a></p>

            <?php 
			if(@$response == "success"){
				?>
					<p class="success">
                        Message sent, please check your inbox. 
                    </p>
				<?php
			}else{
				?>
					<p class="error"><?php echo @$response; ?></p>		
				<?php
			}
		?>
    </fieldset>
    </form>
</body>
</html>