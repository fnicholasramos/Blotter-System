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
    $respondent = $_POST['respondent'];
    $schedule = $_POST['schedule'];
    $time = $_POST['time'];

    $connect = new mysqli('191.101.13.205', 'u839485473_root', '@Berrymcposa1', 'u839485473_db_system');
    if ($connect->connect_error) {
        die('Connection failed: ' . $connect->connect_error);
    } else {
        $result = $connect->query("SELECT MAX(id) AS autoIncrement FROM scheduled_report");
        $row = $result->fetch_assoc();
        $maxId = $row['autoIncrement'];

        // Set the next auto-increment value
        $connect->query("ALTER TABLE scheduled_report AUTO_INCREMENT = " . ($maxId + 1));
        
        $insert = $connect->prepare("INSERT INTO scheduled_report (classification, complainant, complainant_number, respondent, schedule, tim3) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssss", $classification, $complainant, $contact, $respondent, $schedule, $time);
        $insert->execute();
        
        header('location:scheduled.php');
        $insert->close();
        $connect->close();
    }
}
?>
