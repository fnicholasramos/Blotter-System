<?php include ('database.php');?>
<?php

if (isset($_POST['insert_button'])) {
    $row_id = mysqli_real_escape_string($mysqli, $_POST['insert_button']);

    // Debugging: Output the received row_id
    echo "Received row_id: $row_id<br>";

    // Perform the insertion into the "blotter" table using $row_id
    $insert_query = "INSERT INTO `blotter` (classification, complainant, contact, complainant_addr, complain, respondent, respondent_addr, d4te, event_time) SELECT classification, complainant, contact, addr, complain, respondent, addrRespo, d4te, tim3 FROM `online_report` WHERE id = '$row_id'";

    // Debugging: Output the SQL query to check its correctness
    echo "Query: $insert_query<br>";

    $insert_result = mysqli_query($mysqli, $insert_query);

    if (!$insert_result) {
        // Debugging: Output the error message
        die("Insertion has failed. Error: " . mysqli_error($mysqli));
    } else {
        echo '<script>
                alert("Report confirmed.");
                window.location.href = "pendingTable.php";
              </script>';
    }
}

// Delete
if (isset($_POST['delete_button'])) {
    $id = $_POST['delete_button'];

    // Delete row from the database
    $query = "DELETE FROM online_report WHERE id = $id";
    mysqli_query($mysqli, $query);
    
    // Redirect back to the same page
    header("Location: pendingTable.php");
    exit();
}

// Fetch data from the database
$query = "SELECT * FROM online_report";
$result = mysqli_query($mysqli, $query);
?>

