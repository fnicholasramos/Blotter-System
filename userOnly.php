<?php
session_start();
if (!isset($_SESSION['validate']) || $_SESSION['validate'] !== 'yes') {
    header('location: login.php'); 
    die();
}

?>

<?php include('database.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="calendar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofnPENhN6I5a1iVoY+1t4Ug7GPb1CrlNT" crossorigin="anonymous">
</head>
<style>
    .logo {
    height: auto;
    width: 55px;
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


    /* content */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .pecture {
            margin-left: 110px;
        }

    .pik {
            width: 91%;
            height: 600px;
            border-radius: 5px;
            border: 1px solid #c3c3c3;
        }

    .horizontal {
            display: flex;
            justify-content: center;
        }

    .total-pending p {
        font-size: 20px;
    }

    .dashboard-container:nth-child(1) {
            width: 250px;
            height: auto;
            margin: 50px 20px;
            background-color: #4285f4;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .dashboard-container:nth-child(2) {
            width: 250px;
            margin: 50px 20px;
            background-color: #00b75b;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .dashboard-container:nth-child(3) {
            width: 250px;
            margin: 50px 20px;
            background-color: #d7006b;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .dashboard-container:nth-child(4) {
            width: 250px;
            margin: 50px 20px;
            background-color: #7171ff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        /* residents div */
        .total-residents {
            font-size: 36px;
            color: #fff;
            margin-top: 20px;
        }

        .total-residents p{
            font-size: 20px;
        }
        /* blotter div */
        .total-blotter {
            font-size: 36px;
            color: #fff;
            margin-top: 20px;
        }

        .total-blotter p{
            font-size: 20px;
        }
        /* scheduled div */
        .total-scheduled {
            font-size: 36px;
            color: #fff;
            margin-top: 20px;
        }

        .total-scheduled p{
            font-size: 20px;
        }
        /* pending div */
        .total-pending {
            font-size: 36px;
            color: #fff;
            margin-top: 20px;
        }

        .total-pending p{
            font-size: 20px;
        }

        .calendarTitle {
            width: 84%;
            height: auto;
            margin: 50px 20px;
            background-color: #8080ff;
            padding: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 110px;
        }

        .calendarTitle h4 {
            color: white;
            display: flex;
            margin-top: 7px;
            justify-content: center;
        }

        .add {
        background-color: #135e96;
        font-size: 14px;
        border-color: #135e96;
        padding: 5px 5px;
        color: #fff;
        cursor: pointer;
        height: 40px;
        width: auto;
        border-radius: 8px;
        float: right;
        margin-top: 7px;
        margin-right: 10px;
        }

        .add:hover {
        background-color: #1879c0;
        }

        .out {
        background-color: #b30000;
        font-size: 14px;
        border-color: #b30000;
        padding: 5px 5px;
        color: #fff;
        cursor: pointer;
        height: 40px;
        width: auto;
        border-radius: 8px;
        float: right;
        margin-top: 7px;
        margin-right: 10px;
        }

        .out:hover {
        background-color: #ce0000;
        }

        .bot {
            margin-top: -65px;
            margin-bottom: 65px;
        }
        
    
</style>
<body>
    <h2 id="title">
        <img src="updated.png" alt="logo" class="logo">
        Barangay Sto.Rosario Kanluran Pateros    
    </h2>

    <div class="bot">
        <button class="out">
            <a class="dropdown-item" name="" href="logout.php"><i class="fa fa-sign-out"></i> Log out</a>
        </button>
        <button class="add" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-circle-plus"></i> Add Record
        </button>
    </div>
    

    
<div class="horizontal">
<!-- residents -->
<div class="dashboard-container">
    <?php
    // Database connection details
    // $host = "191.101.13.205";
    // $username = "u839485473_root";
    // $password = "@Berrymcposa1";
    // $database = "u839485473_db_system";

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "db_system";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get total count of residents
    $query = "SELECT COUNT(*) as totalResidents FROM tbl_resident";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalResidents = $row['totalResidents'];
        echo "<div class='total-residents'>
                <p>Total Residents</p>
                <i class='fas fa-user-group'></i> 
                $totalResidents
              </div>";

    } else {
        echo "0";
    }

    // Close connection
    $conn->close();
    ?>
</div>

<!-- blotter record -->
<div class="dashboard-container">
    <?php
    // Database connection details
    // $host = "191.101.13.205";
    // $username = "u839485473_root";
    // $password = "@Berrymcposa1";
    // $database = "u839485473_db_system";

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "db_system";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get total count of residents
    $query = "SELECT COUNT(*) as totalBlotter FROM blotter";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalResidents = $row['totalBlotter'];
        echo "<div class='total-blotter'>
                <p>Blotter Records</p>
                <i class='fa-solid fa-book'></i>
                $totalResidents
              </div>";

    } else {
        echo "0";
    }

    // Close connection
    $conn->close();
    ?>
</div>

<!-- scheduled report -->
<div class="dashboard-container">
    <?php
    // Database connection details
    // $host = "191.101.13.205";
    // $username = "u839485473_root";
    // $password = "@Berrymcposa1";
    // $database = "u839485473_db_system";

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "db_system";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get total count of residents
    $query = "SELECT COUNT(*) as totalScheduled FROM scheduled_report";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalResidents = $row['totalScheduled'];
        echo "<div class='total-scheduled'>
                <p>Scheduled Report</p>
                <i class='fa-solid fa-calendar-days'></i> 
                $totalResidents
              </div>";

    } else {
        echo "0";
    }

    // Close connection
    $conn->close();
    ?>
</div>

<!-- pending validation -->
<div class="dashboard-container">
    <?php
    // Database connection details
    // $host = "191.101.13.205";
    // $username = "u839485473_root";
    // $password = "@Berrymcposa1";
    // $database = "u839485473_db_system";

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "db_system";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get total count of residents
    $query = "SELECT COUNT(*) as totalPending FROM online_report";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalResidents = $row['totalPending'];
        echo "<div class='total-pending'>
                <p>Pending Reports</p>
                <i class='fa fa-file'></i>
                $totalResidents
              </div>";

    } else {
        echo "0";
    }

    // Close connection
    $conn->close();
    ?>
</div>

</div>

<div class="pecture">
    <img src="home.png" alt="" class="pik">
</div>

<div class="calendarTitle">
    <h4>Calendar of 2024</h4>
</div>

    <div class="calendar">
      <header>
        <h3></h3>
        <nav>
          <button id="prev"></button>
          <button id="next"></button>
        </nav>
      </header>
      <section>
        <ul class="days">
          <li>Sun</li>
          <li>Mon</li>
          <li>Tue</li>
          <li>Wed</li>
          <li>Thu</li>
          <li>Fri</li>
          <li>Sat</li>
        </ul>
        <ul class="dates"></ul>
      </section>
    </div><br>


<!-- modal for add records     -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="userReport.php" method="POST">

                    <div class="form-group">
                        <label>Complainant</label>
                        <input type="text" name="complainant" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control" maxlength="11" required>
                    </div>

                    <div class="form-group">
                        <label>Address of Complainant</label>
                        <input type="text" name="complainant_addr" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Complain</label>
                        <input type="text" name="complain" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Respondent</label>
                        <input type="text" name="respondent" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Address of Respondent</label>
                        <input type="text" name="respondent_addr" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control" placeholder="MM-DD-YY" required>
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

<script src="calendar.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
