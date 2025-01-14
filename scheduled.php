<?php
session_start();
if(!isset($_SESSION['validate']) || $_SESSION['validate'] !== 'yes') {
    header('location:login.php');
    exit();
}

if ($_SESSION['ROLE'] != 'administrator') {
    header('location: unauthorized.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Report</title>
    <?php include ('emailReport.php');?>
    <?php include ('database.php');?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofnPENhN6I5a1iVoY+1t4Ug7GPb1CrlNT" crossorigin="anonymous"> 
</head>
<style>
    /* header top bar css  */
    .logo {
    height: auto;
    width: 55px;
    margin-left: -10px;
    }

    .toggle-color {
    background-color: #424242;
    border-color: #424242;
    margin-left: -10px; 
    }

    .toggle-color:hover {
        background-color: #424242;
        border-color: #424242;
        color: red;
    }

    .home {
        color: white;
        text-decoration: none;
        font-size: 16px;
        margin-left: 300px;
        font-family: Arial, Helvetica, sans-serif;
        
    }

    .home:hover {
        color: #9dffff;
    }

    .residents {
        color: white;
        text-decoration: none;
        font-size: 16px;
        margin-left: 15px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .residents:hover {
        color: #9dffff;
    }

    .blotter {
        color: white;
        text-decoration: none;
        font-size: 16px;
        margin-left: 15px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .blotter:hover  {
        color: #9dffff;
    }

    .officials {
        color: white;
        text-decoration: none;
        font-size: 15px;
        margin-left: 15px;
    }

    .officials:hover {
        color: #9dffff;
    }

    /* style.css */
    #title {
        text-align: center;
        background-color: #424242;
        color: #fff;
        padding: 3px;
        letter-spacing: 2px;
        font-weight: 500;
    }


    /* schedule */
    .addSchedule {
        height: 30px;
        font-size: 14px;
        margin-left:10px ;
        border-radius: 8px;
        color: #fff;
        background-color: #135e96;
        border-color: #135e96;
    }

    .addSchedule:hover {
        background-color: #1571b5;
    }

    /* Add Schedule Button */
    .addSchedule {
        height: 30px;
        font-size: 14px;
        margin-left:10px ;
        border-radius: 8px;
        color: #fff;
        background-color: #135e96;
        border-color: #135e96;
    }

    .addSchedule:hover {
        background-color: #1571b5;
    }

    /* Number of notification */
    .notification-number {
        background-color: #ff4500;
        color: #fff;
        border-radius: 50%;
        padding: 4px 8px;
        font-size: 12px;
        margin-left: 2px;
    }

    #notificationList p {
        margin: 0; /* Remove default margin */
        position: relative;
        padding: 8px; /* Add padding for better appearance (optional) */
        border-top: 1px solid #dee2e6; /* Add Bootstrap-like border style */
    }

    #notificationList p:hover {
    /* border: 1.5px solid #4e4e4e; Add your desired border style here */
    background-color: #ebebeb;
    }

    .table th {
    background-color: #f2f2f2; /* Set your preferred background color */
    color: #333; /* Set your preferred text color */
    }

    .main {
        height: 400px;
        border: 1px solid #c3c4c7;
        overflow-y: auto;
        width: auto; /* You can adjust the percentage as needed */
        margin: 0 auto;
    }
    
    .borderColor {
        border-color: #cfcfcf;
    }


    /* mobile view */
    @media (max-width: 600px) {
        #title {

        }
    }
</style>
<body>

<h2 id="title">
        <img src="duck.png" alt="logo" class="logo">
        BSRKP
    <span>

        <button class="btn home" onclick="window.location.href='home.php'">
            <i class="fa fa-home" aria-hidden="true"></i> Home
        </button>
        <button class="btn officials" onclick="window.location.href='admin-privilege.php'">
            <i class="fas fa-user-alt"></i> Users
        </button>
        <button class="btn residents" onclick="window.location.href='residents.php'">
            <i class="fas fa-address-card"></i> Residents
        </button>
        <button class="btn blotter" onclick="window.location.href='#'" id="certificatesDropdown" data-bs-toggle="dropdown" >
            <i class="fa-solid fa-book"></i> Blotter
        </button>
        <ul class="dropdown-menu" aria-labelledby="certificatesDropdown">
            <li><a class="dropdown-item" href="index.php">Blotter Record</a></li> 
            <li><a class="dropdown-item" href="report.php">Summary Report</a></li> 
            <li><a class="dropdown-item" href="scheduled.php">Scheduled Report</a></li> 
            <li><a class="dropdown-item" href="pendingTable.php">Pending Validation</a></li>  
        </ul>

        <button class="btn blotter" id="notificationBell" data-bs-toggle="modal" data-bs-target="#notificationModal">
            <i class="fa-solid fa-bell"></i>  Notification
        </button>


        
        <button label="Action" class="btn btn-secondary dropdown-toggle toggle-color" data-bs-toggle="dropdown">
        <i class="fa fa-power-off" aria-hidden="true"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
            <li><a class="dropdown-item" name="" href="logout.php"><i class="fa fa-sign-out"></i>Log out</a></li>
        </ul>
    </span>
        
    </h2>

<div class="container">
    <h4>
        Scheduled Report
        <span><button type="button" class="addSchedule" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus"></i> Add Schedule</button></span>
    </h4>

    <!-- Notif modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="notificationList">
                <!-- Notifications will be added here -->
            </div>
        </div>
    </div>
</div>


<!-- content -->
<fieldset class="main">
    <table class="table table-hover table-bordered table-width borderColor">
        <thead>
            <tr>
                <th width='15px'>#</th>
                <th>Classification</th>
                <th>Complainant</th>
                <th width="188px">Complainant's Contact</th>
                <th>Respondent</th>
                <th>Schedule</th>
                <th>Time</th>
                <th width="5">Edit</th>
            </tr>
        </thead>

        <tbody>
        <?php
        include 'database.php';
        $query = "SELECT * FROM `scheduled_report`";

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($mysqli, $_GET['search']);
            $query .= " WHERE CONCAT(resident_id, name, contact, address, purok, birthday, age, civilStatus, nationality) LIKE '%$search%'";
        }

        $result = mysqli_query($mysqli, $query);

        if (!$result) {
            die("Query has failed." . mysqli_error($error));
        } else {
            // Create an associative array to store the count of schedules for each date
            $scheduleCount = array();

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['classification']; ?></td>
                        <td><?php echo $row['complainant']; ?></td>
                        <td><?php echo $row['complainant_number']; ?></td>
                        <td><?php echo $row['respondent']; ?></td>
                        <td width="10%"><?php echo $row['schedule']; ?></td>
                        <td><?php echo $row['tim3']; ?></td>
                        <td>
                            <div class="dropdown">
                                <button label="Action" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class='fas fa-edit'></i> 
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                    <li><a class="dropdown-item" name="update" href="updateSchedule.php?id=<?php echo $row['id']; ?>">Edit</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php

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

                foreach ($scheduleCount as $date => $count) {
                    if ($date === date('Y-m-d')) {
                        // echo 'notificationBell.innerHTML += \'<span class="notification-number">\' + scheduleCount["' . $date . '"] + \'</span>\';';
                    }
                }
                echo '</script>';
            } else {
                echo "<tr> <td colspan='5' style='color:red;'>No record found.</td></tr>";
            }
        }
        ?>



        </tbody>
    </table>
</fieldset>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="insertSchedule.php" method="POST">

                    <div class="form-group">
                        <label>Classification</label>
                        <input type="text" name="classification" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Complainant</label>
                        <input type="text" name="complainant" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control" maxlength="11" required>
                    </div>
                    <div class="form-group">
                        <label>Respondent</label>
                        <input type="text" name="respondent" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Schedule</label>
                        <input type="date" name="schedule" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Time</label>
                        <input type="text" name="time" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 <!-- from header.php -->

<?php
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
?>

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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>


<!-- <script>
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

            // Check if the schedule is in the future
            if (scheduleDate >= currentDateString) {
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
</script> -->