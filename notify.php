<script>
// Get the current date in the "YYYY-MM-DD" format
var currentDateString = serverCurrentDate;

// Notification bell icon
var notificationBell = document.getElementById('notificationBell');

// Notifications list container
var notificationList = document.getElementById('notificationList');

// Check if the schedule dates match the current date
var scheduleCount = <?php echo json_encode($scheduleCount); ?>;

// Check if there are schedules for the current date
if (scheduleCount[currentDateString]) {
    var count = scheduleCount[currentDateString];

    // Display the notification number
    // notificationBell.innerHTML += '<span class="notification-number">' + count + '</span>';

    // Add a click event listener to hide the notification number when clicked
    notificationBell.addEventListener('click', function () {
        // Hide the notification number by setting its style to display: none
        var notificationNumber = notificationBell.querySelector('.notification-number');
        notificationNumber.style.display = 'none';
    });

    // Loop through each row in the PHP result
    <?php
    mysqli_data_seek($result, 0); // Reset the result set pointer to the beginning
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        // Use the complainant data from the current PHP row
        var complainantData = '<?php echo isset($row['complainant']) ? htmlspecialchars($row['complainant']) : '' ?>';
        var scheduleDate = '<?php echo $row['schedule']; ?>';

        // Check if the schedule date matches the current date
        if (scheduleDate === currentDateString) {
            var notificationText = 'Blotter Alert: Hearing scheduled for <strong>' + complainantData + '</strong>'

            var notificationItem = document.createElement('p');

            // Add a click event listener to each notification item
            notificationItem.addEventListener('click', function () {
                // Replace 'your-page-url' with the actual URL you want to navigate to
                window.location.href = 'scheduled.php';
            });

            notificationItem.innerHTML = notificationText;
            notificationList.appendChild(notificationItem);
        }
    <?php
    }
    ?>
}

</script>