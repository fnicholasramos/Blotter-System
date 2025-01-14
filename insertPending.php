<?php
session_start();
if(!isset($_SESSION['validate']) || $_SESSION['validate'] !== 'yes') {
    header('location:login.php');
    exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classification = $_POST['classification'];
    $complainant = $_POST['complainant'];
    $contact = $_POST['contact'];
    $address1 = $_POST['complainant_addr'];
    $complain = $_POST['complain'];
    $respondent = $_POST['respondent'];
    $address2 = $_POST['respondent_addr'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // $server = "191.101.13.205"; 
    // $uname = "u839485473_root"; 
    // $passwd = "@Berrymcposa1"; 
    // $db = "u839485473_db_system";  

    $connect = new mysqli('191.101.13.205', 'u839485473_root', '@Berrymcposa1', 'u839485473_db_system');
    if ($connect->connect_error) {
        die('Connection failed: ' . $connect->connect_error);
    } else {
        $result = $connect->query("SELECT MAX(id) AS autoIncrement FROM online_report");
        $row = $result->fetch_assoc();
        $maxId = $row['autoIncrement'];

        // Set the next auto-increment value
        $connect->query("ALTER TABLE online_report AUTO_INCREMENT = " . ($maxId + 1));
        
        $insert = $connect->prepare("INSERT INTO online_report (classification, complainant, contact, addr, complain, respondent, addrRespo, d4te, tim3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssssssss", $classification, $complainant, $contact, $address1, $complain, $respondent, $address2, $date, $time);
        $insert->execute();
        
        header('location:pendingTable.php');
        $insert->close();
        $connect->close();
    }
}
?>
