<style>
    .notification-number {
        background-color: #ff4500;
        color: #fff;
        border-radius: 50%;
        padding: 4px 8px;
        font-size: 12px;
        margin-left: 2px;
    }
</style>

<?php
include 'database.php';

$query = "SELECT * FROM `scheduled_report`";

$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query has failed." . mysqli_error($error));
} else {
    // Create an associative array to store the count of schedules for each date
    $scheduleCount = array();

    while ($row = mysqli_fetch_assoc($result)) {
        // Check if the schedule date matches the current date
        $scheduleDate = $row['schedule'];

        // Update the schedule count for the current date
        if (isset($scheduleCount[$scheduleDate])) {
            $scheduleCount[$scheduleDate]++;
        } else {
            $scheduleCount[$scheduleDate] = 1;
        }
    }

    // Encode the schedule counts as JSON for JavaScript use
    $scheduleCountJson = json_encode($scheduleCount);

    // Pass the current date and schedule counts to JavaScript
    echo '<script>';
    echo 'var currentDateString = "' . date('Y-m-d') . '";';
    echo 'var scheduleCount = ' . $scheduleCountJson . ';';

    // Include the HTML structure for the notification list
    echo 'var notificationModal = \'<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">\' +';
    echo '\'<div class="modal-dialog">\' +';
    echo '\'<div class="modal-content">\' +';
    echo '\'<div class="modal-header">\' +';
    echo '\'<h5 class="modal-title" id="notificationModalLabel">Notifications</h5>\' +';
    echo '\'<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\' +';
    echo '\'</div>\' +';
    echo '\'<div class="modal-body" id="notificationList">\' +';
    echo '\'<!-- Notifications will be added here -->\' +';
    echo '\'</div>\' +';
    echo '\'</div>\' +';
    echo '\'</div>\' +';
    echo '\'</div>\';';

    echo 'document.write(notificationModal);'; // Add the modal structure to the document

    foreach ($scheduleCount as $date => $count) {
        if ($date === date('Y-m-d')) {
           
        }
    }

    echo '</script>';

    // Include the notifications_script.php file (with shared logic)
    include 'notifications_script.php';
}
?>
