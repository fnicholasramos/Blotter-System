<?php
// $host = 'localhost';
// $username = 'root';
// $password = '';
// $database = 'db_system'; 

$host = "191.101.13.205"; 
$username = "u839485473_root"; 
$password = "@Berrymcposa1"; 
$database = "u839485473_db_system";  
// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the POST request
$complainant = $_POST['full_name'];
$contact = $_POST['contact_number'];
$address = $_POST['address'];
$complain = $_POST['complain'];
$respondent = $_POST['respondent'];
$respoAddress = $_POST['respondentAddr'];
$date = $_POST['date'];
$time = $_POST['time'];

// Use prepared statement to prevent SQL injection
$sql = "INSERT INTO online_report (complainant, contact, addr, complain, respondent, addrRespo, d4te, tim3)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssssss', $complainant, $contact, $address, $complain, $respondent, $respoAddress, $date, $time);

if ($stmt->execute()) {
    // Display success message using JavaScript alert
    echo '<script>
            alert("Your report has been sent.");
            window.location.href = "onlineReportForm.php";
          </script>';
} else {
    echo "Error: " . $stmt->error;
}



// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
