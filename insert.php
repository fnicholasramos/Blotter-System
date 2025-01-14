<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    
    if ($password != $confirm) {
        echo "<p class='match'>Password do not match.</p>";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // $host = "191.101.13.205"; 
    // $username = "u839485473_root"; 
    // $passwordd = "@Berrymcposa1"; 
    // $database = "u839485473_db_system";

    $connect = new mysqli('191.101.13.205', 'u839485473_root', '@Berrymcposa1', 'u839485473_db_system');
    if($connect->connect_error) {
        die('Connection failed: ' .$connect->connect_error);
    } else {
        $insert = $connect->prepare("insert into users (email, username, passwd, privilege) values(?,?,?,'user')");
        $insert->bind_param("sss",$email,$username,$hashedPassword);
        if ($insert->execute()) {
            echo "<p class='registered'>Registration Successful!</p>";
        } else {
            echo "Error in registration.";
        }
        $insert->close();
        $connect->close();
    }
}

?>
<!--

bind-parameter:
i - integer
d - double
s - string
b - blob 

-->
<style>
    .registered {
        color: green;
        margin-left: 65px;
        white-space: nowrap;
    }

    .match {
        color: red;
    }
    
</style>

