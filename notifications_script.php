<?php
// notifications_script.php

$scheduleCountJson = json_encode($scheduleCount);

// Set the time zone to 'Asia/Manila'
date_default_timezone_set('Asia/Manila');

// Pass the server's current date and schedule counts to JavaScript
echo '<script>';
echo 'var serverCurrentDate = "' . date('Y-m-d') . '";';
echo 'var scheduleCount = ' . $scheduleCountJson . ';';

foreach ($scheduleCount as $date => $count) {
    if ($date === date('Y-m-d')) {
        echo 'notificationBell.innerHTML += \'<span class="notification-number">\' + scheduleCount["' . $date . '"] + \'</span>\';';
    }
}

echo '</script>';

include 'notify.php';
?>

