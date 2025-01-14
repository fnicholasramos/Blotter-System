<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['complainant'];
    $addr1 = $_POST['complainant_addr'];
    $contact = $_POST['contact'];
    $classification = $_POST['type'];
    $complain = $_POST['complain'];
    $respondent = $_POST['respondent'];
    $addr2 = $_POST['respondent_addr'];
    $action = $_POST['action'];
    $status = $_POST['status'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // $connect = new mysqli('localhost', 'root', '', 'db_system');
    $connect = new mysqli('191.101.13.205', 'u839485473_root', '@Berrymcposa1', 'u839485473_db_system');

    if ($connect->connect_error) {
        die('Connection failed: ' . $connect->connect_error);
    } else {
        // Get the current maximum ID in the table
        $result = $connect->query("SELECT MAX(id) AS autoIncrement FROM blotter");
        $row = $result->fetch_assoc();
        $maxId = $row['autoIncrement'];

        // Set the next auto-increment value
        $connect->query("ALTER TABLE blotter AUTO_INCREMENT = " . ($maxId + 1));

        // Prepare and execute the insert statement
        $insert = $connect->prepare("INSERT INTO blotter (complainant, complainant_addr, contact, classification, complain, respondent, respondent_addr, act1on, st4tus, d4te, event_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssssssssss", $name, $addr1, $contact, $classification, $complain, $respondent, $addr2, $action, $status, $date, $time);
        $insert->execute();

        header('location:' . $_SERVER['HTTP_REFERER']);
        $insert->close();
        $connect->close();
    }

}
?>

<!-- No auto increment -->
<!-- $connect = new mysqli('localhost', 'root', '', 'db_system');
    if ($connect->connect_error) {
        die('Connection failed: ' . $connect->connect_error);
    } else {
        $insert = $connect->prepare("INSERT INTO blotter (complainant, complainant_addr, contact, classification, complain, respondent, respondent_addr, act1on, st4tus, d4te) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssssssss", $name, $addr1, $contact, $classification, $complain, $respondent, $addr2, $action, $status, $date);
        $insert->execute();
        
        header('location:index.php');
        $insert->close();
        $connect->close();
    } -->