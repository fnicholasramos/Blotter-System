<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST['number'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $desc = $_POST['incident'];
    $action = $_POST['action'];

    $connect = new mysqli('191.101.13.205', 'u839485473_root', '@Berrymcposa1', 'u839485473_db_system');
    if ($connect->connect_error) {
        die('Connection failed: ' . $connect->connect_error);
    } else {
        $insert = $connect->prepare("INSERT INTO report (id, date, event_time, incident, action_taken) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("issss", $number, $date, $time, $desc, $action);
        $insert->execute();

        header("location: report.php");
        $insert->close();
        $connect->close();
    }
}
?>
