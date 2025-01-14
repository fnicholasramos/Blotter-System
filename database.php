<?php 
// $server = "191.101.13.205"; 
// $uname = "u839485473_root"; 
// $passwd = "@Berrymcposa1"; 
// $db = "u839485473_db_system";  

$server = "localhost";
$uname = "root";
$passwd = "";
$db = "db_system";

$mysqli = mysqli_connect($server,$uname,$passwd,$db);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

return $mysqli 
?>

