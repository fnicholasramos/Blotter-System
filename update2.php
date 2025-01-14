<?php include('database.php'); ?>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofnPENhN6I5a1iVoY+1t4Ug7GPb1CrlNT" crossorigin="anonymous">
<style>
    /*header top bar*/
    .logo {
        height: 45px;
        width: auto;
        margin-left: -10px;
    }

    .toggle-color {
        background-color: #424242;
        border-color: #424242;
        margin-left: -20px; 
    }



    .two {
        margin-left: 50%;
    }

    .toggle-color:hover {
        background-color: #424242;
        border-color: #424242;
    }

    .home {
        margin-left: 10px;
        
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

    .button {
        background-color: #00b33c;
        border-color: #00b33c;
        float: right;
    }

    .button:hover {
        background-color: #00cc44;
        border-color: #00cc44;
    }

    .formUpdate {
        margin: 20px auto; 
        width: 90%;
        padding: 15px; /* Adjusted padding */
        border: 1px solid #c3c4c7;
        border-radius: 8px;
    }
    
    .cancel {
        float: right;
        margin-left: 5px;
    }
    
    @media (max-width: 600px) {

        .toggle-color {
        background-color: #424242;
        border-color: #424242;
        margin-left: -20px; 
    }

        .notif {
        margin-top: 2px;
        margin-left: -10px
    }

        .two {
        margin-left: 150px;
    }

    .logo {
        height: 45px;
        width: auto;
        margin-left: 10px;
    }

    .toggle-color {
        margin-left: -10px; /* Adjusted margin for the toggle-color button */
    }



    .cancelUpdate {
        float: right;
        margin-left: 5px; /* Adjusted margin for the cancelUpdate button */
    }
    } 
</style>


<?php
    $row = null; 
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    
    
        $query = "SELECT * FROM `scheduled_report` WHERE `id` = '$id'";
        $result = mysqli_query($mysqli, $query);

        if (!$result) {
            die("Query has failed." . mysqli_error($error));
        } else {
            $row = mysqli_fetch_assoc($result);
        
    }
}
?>

<?php
    if(isset($_POST["update"])) {

        $schedule = $_POST['schedule'];
        $time = $_POST['time'];

        $query = "UPDATE `scheduled_report` SET 
            `schedule` = '$schedule', 
            `tim3` = '$time' 
          WHERE `id` = '$id'";
        ob_start();
        $result = mysqli_query($mysqli, $query);
        if (!$result) {
            die("Query has failed." . mysqli_error($error));
        } else {
            header('location:schedule.php?update=Record has been updated.');
        ob_end_flush();
        
    }
    
    }
?>

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

<h2 id="title">
        <img src="duck.png" alt="logo" class="logo">
        BSRKP
    <span class="two">
        <button class="btn blotter notif" id="notificationBell" data-bs-toggle="modal" data-bs-target="#notificationModal">
            <i class="fa-solid fa-bell"></i>
        </button>

        <button label="Action" class="btn btn-secondary toggle-color" data-bs-toggle="dropdown">
            <i class="fa fa-bars"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
            <li><a class="dropdown-item" href="scheduled.php"><i class="far fa-calendar-alt"></i> Scheduled Report</a></li> 
            <li><a class="dropdown-item" href="pendingTable.php"><i class="fa fa-spinner"></i> Pending Validation</a></li>
            <li><a class="dropdown-item" name="" href="logout.php"><i class="fa fa-sign-out"></i>Log out</a></li>
        </ul>
    </span>
        
</h2>

<fieldset class="formUpdate">
<form  action="updateSchedule.php?id=<?php echo $id; ?>" method="POST">
    <p style="color: red;">Follow the date format: (Date-Month-Year)</p>
    <div class="form-group">
        <label>Schedule</label>
        <input type="date" name="schedule" class="form-control" value="<?php echo $row['schedule'] ?? '';?>">
    </div> 
    <div class="form-group">
        <label>Time</label>
        <input type="text" name="time" class="form-control" value="<?php echo $row['tim3'] ?? '';?>">
    </div> 
    <br>
        <button type="button" class="btn btn-secondary cancelUpdate" data-bs-dismiss="modal" onclick="window.location.href='schedule.php'">Cancel</button>
        <button type="submit" class="btn btn-primary button" name="update">Save</button> 
    </form>
</form>
</fieldset>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
