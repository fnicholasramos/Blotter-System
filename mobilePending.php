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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pending Report</title>
    <?php include ('database.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofnPENhN6I5a1iVoY+1t4Ug7GPb1CrlNT" crossorigin="anonymous"> 
    <style>
        .table th {
            background-color: #f2f2f2; /* Set your preferred background color */
            color: #333; /* Set your preferred text color */
        }

        /* header */
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

      button insert-button {
        background-color: #4caf50;
        color: white;
        padding: 5px 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 15px;
        transition: background-color 0.3s;
    }

    button insert-button:hover {
        background-color: #45a049;
    }

    .insert-button {
        background-color: #4CAF50;
        color: white;
        padding: 5px 7px;
        font-size: medium;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .insert-button:hover {
        background-color: #45a049;
    }

    .delete-button {
        background-color: #cc0000;
        color: white;
        padding: 5px 7px;
        font-size: medium;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .delete-button:hover {
        background-color: #e80000;
    }

    .pending {
        background-color: #135e96;
        font-size: 14px;
        border-color: #135e96;
        color: #fff;
        cursor: pointer;
        height: 30px;
        width: auto;
        border-radius: 8px;
        float: center;
        margin-left: 10px;
    }

    h4 {
        margin-left: 35px;
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

    #title {
        text-align: center;
        background-color: #424242;
        color: #fff;
        padding: 3px;
        letter-spacing: 2px;
        font-weight: 500;
    }

    @media (max-width: 600px) {
        .main {
        height: 600px;
        border: 1px solid #c3c4c7;
        overflow-y: auto;
        width: auto; /* You can adjust the percentage as needed */
        margin: 0 auto;
    }
        .logo {
        height: 45px;
        width: auto;
        margin-left: 10px;
    }

        .toggle-color {
        background-color: #424242;
        border-color: #424242;
        margin-left: -20px; 
    }

        .notif {
        margin-top: 2px;
        margin-left: -20px
    }

        .two {
        margin-left: 150px;
    }
    
        .pending {
            margin-left: 73px ;
    }

        h4 {
            margin-left: 5px;
        }
    }
    </style>
</head>
<body>

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

        <!-- notification modal -->
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

<!-- add button      -->

<h4>
    Pending Validation
    <span><button type="button" class="pending" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus"></i> Add Draft</button></span>
</h4>

<fieldset class="main">
<form action="finalized.php" method="POST">
    <table class="table table-hover table-bordered table-width borderColor">
        <thead>
            <tr>
                <th>#</th>
                <th>Complainant</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Complain</th>
                <th>Respondent</th>
                <th>Respondent Address</th>
                <th>Date</th>
                <th>Time</th>
                <th width="6%">Option</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM `online_report`";

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($mysqli, $_GET['search']);
            $query .= " WHERE CONCAT(resident_id, name, contact, address, purok, birthday, age, civilStatus, nationality) LIKE '%$search%'";
        }

        $result = mysqli_query($mysqli, $query);

        if (!$result) {
            die("Query has failed." . mysqli_error($mysqli));
        } else {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['complainant']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['addr']; ?></td>
                        <td><?php echo $row['complain']; ?></td>
                        <td><?php echo $row['respondent']; ?></td>
                        <td><?php echo $row['addrRespo']; ?></td>
                        <td><?php echo $row['d4te']; ?></td>
                        <td><?php echo $row['tim3']; ?></td>
                        <td>
                            <span>
                                <button type="submit" class="insert-button" name="insert_button" value="<?php echo $row['id']; ?>"><i class="fa-solid fa-check"></i></button>
                                <button type="submit" class="delete-button" name="delete_button" value="<?php echo $row['id']; ?>"><i class="fas fa-trash"></i></button>
                            </span> 
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr> <td colspan='10' style='color:red;'>No record found.</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>
</form>
</fieldset>
 <!-- header container -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="insertPending.php" method="POST">

                    <div class="form-group">
                        <label>Complainant</label>
                        <input type="text" name="complainant" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control" required>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>


