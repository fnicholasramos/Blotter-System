<?php
include('database.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM `users` WHERE `uid` = '$id'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die("Query has failed." . mysqli_error($mysqli));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['role']) && !empty($_POST['role'])) {
    $role = $_POST['role'];
    $user = $_POST['username'];

    // Check the current number of administrators
    $adminCountQuery = "SELECT COUNT(*) AS adminCount FROM `users` WHERE `privilege` = 'administrator'";
    $adminCountResult = mysqli_query($mysqli, $adminCountQuery);

    if (!$adminCountResult) {
        die("Query to count administrators failed." . mysqli_error($mysqli));
    }

    $adminCountRow = mysqli_fetch_assoc($adminCountResult);
    $adminCount = $adminCountRow['adminCount'];

    // If there's only one administrator and you're trying to update their role to "user," prevent the update
    if ($adminCount <= 1 && $role === 'user') {
        // Set error message in a session variable
        session_start();
        $_SESSION['error_message'] = "At least one administrator must exist.";
        header('location:admin-privilege.php');
        exit();
    }

    // Perform the update operation
    $query = "UPDATE `users` SET `privilege` = '$role' WHERE username = '$user'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die("Query has failed." . mysqli_error($error));
    } else {
        header('location:admin-privilege.php?update=User has been updated.');
        exit();
    }
} else {
    // Pass error message in the URL to index.php
    header('location:admin-privilege.php?error=Please select a valid role.');
    exit();
}
?>
