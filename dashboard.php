<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Dashboard</title>
    <link rel="stylesheet" href="calendar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .pecture {
            display: flex;
            justify-content: center;
        }

        .pik {
            width: auto;
            height: 600px;
            border-radius: 5px;
            border: 1px solid #c3c3c3;
        }


        /* residents div */
        .total-residents {
            font-size: 36px;
            color: #fff;
            margin-top: 20px;
        }

        .total-residents p {
            font-size: 20px;
        }

        /* blotter div */
        .total-blotter {
            font-size: 36px;
            color: #fff;
            margin-top: 20px;
        }

        .total-blotter p {
            font-size: 20px;
        }

        /* scheduled div */
        .total-scheduled {
            font-size: 36px;
            color: #fff;
            margin-top: 20px;
        }

        .total-scheduled p {
            font-size: 20px;
        }

        /* pending div */
        .total-pending {
            font-size: 36px;
            color: #fff;
            margin-top: 20px;
        }

        .total-pending p {
            font-size: 20px;
        }

        .calendarTitle {
            display: flex;
            justify-content: center;
            width: 100%;
            height: auto;
            margin: 35px 0 35px 0;
            background-color: #8080ff;
            padding: 5px 0 5px 0;
            color: white;
            font-size: 24px;
            border-radius: 4px;
        }

        .container {
            display: flex;
            margin-top: 25px;
            margin-left: auto;
            margin-right: auto;
            flex-direction: column;
            width: max-content;
        }

        .horizontal {
            display: flex;
            width: 100%;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .rds {
            height: max-content;
            background-color: #4285f4;
            padding: 5px 25px 15px 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .bltr {
            height: max-content;
            background-color: #00b75b;
            padding: 5px 25px 15px 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .sched {
            height: max-content;
            background-color: #d7006b;
            padding: 5px 25px 15px 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .pend {
            height: max-content;
            background-color: #7171ff;
            padding: 5px 25px 15px 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .calendar {
            display: flex;
            flex-direction: column;
            margin-right: auto;
            margin-left: auto;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="horizontal">

            <div class="rds">
                <?php
                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "db_system";

                $conn = new mysqli($host, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

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
                $conn->close();
                ?>
            </div>

            <div class="bltr">
                <?php
                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "db_system";

                $conn = new mysqli($host, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

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
                $conn->close();
                ?>
            </div>

            <div class="sched">
                <?php
                // Database connection details
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

            <div class="pend">
                <?php
                // Database connection details
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
            Calendar of 2025
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
        </div>
    </div>

    <br>
    <script src="calendar.js" defer></script>
</body>

</html>