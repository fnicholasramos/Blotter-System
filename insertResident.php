<?php
session_start();
if(!isset($_SESSION['validate']) || $_SESSION['validate'] !== 'yes') {
    header('location:login.php');
    exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $purok = $_POST['purok'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $civilStatus= $_POST['civil'];
    $nationality = $_POST['nationality'];

    $connect = new mysqli('191.101.13.205', 'u839485473_root', '@Berrymcposa1', 'u839485473_db_system');
    if ($connect->connect_error) {
        die('Connection failed: ' . $connect->connect_error);
    } else {
        $result = $connect->query("SELECT MAX(resident_id) AS autoIncrement FROM tbl_resident");
        $row = $result->fetch_assoc();
        $maxId = $row['autoIncrement'];

        // Set the next auto-increment value
        $connect->query("ALTER TABLE tbl_resident AUTO_INCREMENT = " . ($maxId + 1));
        
        $insert = $connect->prepare("INSERT INTO tbl_resident (name, contact, address, purok, birthday, age, civilStatus, nationality) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssssss", $name, $contact, $address, $purok, $birthday, $age, $civilStatus, $nationality);
        $insert->execute();
        
        header('location:residents.php');
        $insert->close();
        $connect->close();
    }
}
?>
