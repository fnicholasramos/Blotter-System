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
<?php include('header.php'); ?>
<?php include('database.php'); ?>

<style>
    .main {
        height: 400px;
        width: 100%;
        border: 1px solid  #c3c4c7;
        overflow-y: auto;
    }

    .table-width {
        width: 100%;
    }

</style>

<div class="box">
    <form action="" method="GET">
    <input type="text" id="search" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>">
    <label for="search">Search:</label>
    </form>
    <button type="button" class="add" data-bs-toggle="modal" data-bs-target="#exampleModal">Add new</button>
    <form action="export.php" method="POST">
        <button type="submit" class="export" name="export"><i class="fa-solid fa-file-export"></i>Export</button>
    </form>
    <a href="print.php" target="_blank" class="btn btn-success pull-right print"><i class="fa-solid fa-print"></i> Print</a> <br>
</div>

<fieldset class="main">
    <table class="table table-hover table-bordered table-width">
        <thead>
            <tr>
                <th>#</th>
                <th>Classification</th>
                <th>Complainant</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Complain</th>
                <th>Respondent</th>
                <th>Address</th>
                <th>Action</th>
                <th>Status</th>
                <th>Datetime</th>
                <th width="20px">Edit</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $query = "SELECT * FROM `blotter`";

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($mysqli, $_GET['search']);
                $query .= " WHERE CONCAT(id, classification, complainant, complainant_addr, contact, complain, respondent, respondent_addr, act1on, st4tus, d4te) LIKE '%$search%'";
            }

            $result = mysqli_query($mysqli, $query);

            if (!$result) {
                die("Query has failed." . mysqli_error($error));
            } else {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['classification']; ?></td>
                            <td height="50px"><?php echo $row['complainant']; ?></td>
                            <td width="200px" style="font-size: 14px;"><?php echo $row['complainant_addr']; ?></td>
                            <td width="100px"><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['complain']; ?></td>
                            <td><?php echo $row['respondent']; ?></td>
                            <td width="200px" style="font-size: 14px;"><?php echo $row['respondent_addr']; ?></td>
                            <td><?php echo $row['act1on']; ?></td> 
                            <td><?php echo $row['st4tus']; ?></td> 
                            <td style="font-size: 14px;"><?php echo $row['d4te']; ?></td> 
                            <td>
                                <div class="dropdown">
                                    <button label="Action" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class='fas fa-edit'></i>
                                     <!-- <i class="fas fa-trash"></i> para sa delete icon -->
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                        <li><a class="dropdown-item" name="update" href="update.php?id=<?php echo $row['id']; ?>">Edit</a></li>
                                        <!-- <li><a class="dropdown-item" name="delete" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a></li> -->
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
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
                <form action="insertRecord.php" method="POST">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="complainant" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Address of Complainant</label>
                        <input type="text" name="complainant_addr" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control" required>
                    </div>

                    <!-- old feature -->
                    <div class="form-group">
                        <label>Classification</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>

                    <!-- new feature (dropdown) -->
                    <!-- <div>
                        <label>Classification</label>
                        <input type="hidden" name="type" required>
                        <select name="type" class="form-select typeSelect" >
                            <option selected disabled>Select classification:</option>
                            <option value="Disturbances">Disturbances</option>
                            <option value="Property Damage">Property Damage</option>
                            <option value="Environmental Incident">Environmental incident</option>
                            <option value="Robbery">Robbery</option>
                            <option value="Domestic Violence">Domestic Violence</option>
                            <option value="Assault">Assault (sexual or physical)</option>
                            <option value="Assault with a deadly weapon">Assault with a deadly weapon</option>
                        </select>
                    </div>  -->

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
                        <label>Action</label>
                        <input type="text" name="action" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" name="status" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control" required>
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

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>


// LOGIN validation (old)

<?php
require('database.php');
$error = '';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['user'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE username='$username' AND passwd='$password'";
    $res = mysqli_query($mysqli, $query);
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['ROLE'] = $row['privilege'];
        $_SESSION['validate'] = 'yes';

        if ($row['privilege'] == 'administrator') {
            header('location: index.php');
            die();
        } elseif ($row['privilege'] == 'user') {
            header('location: userOnly.php');
            die();
        } else {
            header('location: unauthorized.php');
            die();
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>


// report.php
<?php include('header.php'); ?>
<?php include('database.php'); ?>

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

<style>
    .main {
        height: 400px;
        border: 1px solid  #c3c4c7;
        overflow-y: auto;
    }

    .addOfficials {
        height: 30px;
        font-size: 14px;
        margin-left:10px ;
        border-radius: 8px;
        color: #fff;
        background-color: #135e96;
        border-color: #135e96;
    }

    .addOfficials:hover {
        background-color: #1571b5;
    }

    .serge {
        float: right;
        margin-top: -40px;
    }

    #labelSearch {
        float: left;
        margin-right: 5px;
    }

    #search {
        
    }

    .grp {
        height: 200px;
        white-space: pre-line; 
    }

    .printR {
        font-size: 14px;
        height: 30px;
        margin-top: 7px;
        padding-top: 3px;
    }
</style>

<h2>
    <span>
        
        <form action="print_report.php" method="GET">
            <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>">
            <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="button" class="addOfficials" data-bs-toggle="modal" data-bs-target="#exampleModal">Add new</button>
            <button type="submit" class="btn btn-success printR" formtarget="_blank">
                <i class="fa-solid fa-print"></i> Print
            </button>
        </form>
    </span>
</h2>


<div class="serge">
    <form action="" method="GET">
        <input type="text" id="search" name="search" 
        value="<?php if (isset($_GET['search'])) {echo $_GET['search'];} ?>">
        <label for="search" id="labelSearch">Search:  </label>
    </form> 
</div>

    


<fieldset class="main">
    <table class="table table-hover table-bordered table-width"> 
        <thead>
            <tr>
                <th width="7%">Case #</th>
                <th width="10%">Date</th>
                <th width="8%">Time</th>
                <th height="20%">Case Description</th>
                <th width="11%">Action Taken</th>
                <th width="5">Edit</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($mysqli, $_GET['search']);
                $query = " WHERE CONCAT(id, incident, action_taken) LIKE '%$search%'";
            } else {
                $query = ""; // No WHERE clause if there's no search
            }
            
            // $query = "SELECT * FROM `report` $query"; 

            $report = mysqli_query($mysqli, "SELECT * FROM `report` $query");

            $blotter = mysqli_query($mysqli, "SELECT * FROM `blotter` $query");
            
            // $result = mysqli_query($mysqli, $query);

            if (!$report || !$blotter) {
                die("Query has failed." . mysqli_error($error));
            } else {
                $row_report = ($report && mysqli_num_rows($report) > 0) ? mysqli_fetch_assoc($report) : array();
                $row_blotter = ($blotter && mysqli_num_rows($blotter) > 0) ? mysqli_fetch_assoc($blotter) : array();

        if ($report || $blotter) {
            ?>
            <tr>
        <td class="grp"><?php echo isset($row_blotter['id']) ? $row_blotter['id'] : ''; ?></td>
        <td class="grp" width="50px"><?php echo isset($row_blotter['d4te']) ? $row_blotter['d4te'] : ''; ?></td>
        <td class="grp" width="8%"><?php echo isset($row_blotter['event_time']) ? $row_blotter['event_time'] : ''; ?></td>
        <td class="grp" style="font-size: 13px"><?php echo isset($row_report['incident']) ? $row_report['incident'] : ''; ?></td>
        <td class="grp"><?php echo isset($row_blotter['act1on']) ? $row_blotter['act1on'] : ''; ?></td>
        <td class="opt">
            <div class="dropdown">
                <button label="Action" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class='fas fa-edit'></i>
                <!-- <i class="fas fa-trash"></i> -->
                </button>
                <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                    <li><a class="dropdown-item" name="update" href="updateReport.php?id=<?php echo isset($row_report['id']) ? $row_report['id'] : ''; ?>">Edit</a></li>
                    <li><a class="dropdown-item" name="delete" href="deleteReport.php?id=<?php echo isset($row_report['id']) ? $row_report['id'] : ''; ?>">Delete</a></li>
                </ul>
        </td>
            </div>
        </td>
    </tr>
    <?php
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
                <form action="insertReport.php" method="POST">
                    <!-- <div class="form-group">
                        <label>Case #</label>
                        <input type="text" name="name" class="form-control" required>
                    </div> -->

                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Time</label>
                        <input type="text" name="time" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Case Description</label>
                        <textarea name="incident" class="form-control" rows="7"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Action Taken</label>
                        <input type="hidden" name="action" class="form-control" required>
                        <select name="action" class="form-select typeSelect" >
                            <option selected disabled>Select action:</option>
                            <option value="Referred to KT">Referred to KT</option>
                            <option value="Issued of CFA">Issued of CFA</option>
                            <option value="Immediately Settled">Immediately Settled</option>
                        </select>
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