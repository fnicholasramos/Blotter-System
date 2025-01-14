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
<?php include 'notification-count.php'; ?>
<?php include('database.php'); ?>


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
        font-size: 15px;
        height: 30px;
        margin-top: 7px;
        padding-top: 3px;
    }

    .table th {
    background-color: #f2f2f2; /* Set your preferred background color */
    color: #333; /* Set your preferred text color */
    }

    .borderColor {
        border-color: #cfcfcf;
    }
</style>

<h2>
    <span>
    <form action="print_report.php" method="GET">
    <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>">
    <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <!-- Add the hidden input for 'id' -->
    <input type="hidden" name="id" id="selectedId" value="">
    <button type="button" class="addOfficials" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus"></i> Add new</button>
    <button type="button" class="btn btn-success printR" onclick="printSelectedRow()">Print <i class="fa-solid fa-print"></i></button>
</form>
    </span>
</h2>

<div class="serge">
    <form action="" method="GET">
        <input type="text" id="search" name="search" value="<?php if (isset($_GET['search'])) {echo $_GET['search'];} ?>">
        <label for="search" id="labelSearch">Search: </label>
    </form>
</div>

<fieldset class="main">
    <form action="print_report.php" method="GET">
        <table class="table table-hover table-bordered table-width borderColor">
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
                    $query = " WHERE CONCAT(id, date, incident, action_taken) LIKE '%$search%'";
                } else {
                    $query = ""; // No WHERE clause if there's no search
                }

                $query = "SELECT * FROM `report` $query"; // Append the WHERE clause if needed

                $result = mysqli_query($mysqli, $query);

                if (!$result) {
                    die("Query has failed." . mysqli_error($error));
                } else {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td class="grp"><?php echo $row['id']; ?></td>
                                <td class="grp" width="50px"><?php echo $row['date']; ?></td>
                                <td class="grp" width="8%"><?php echo $row['event_time']; ?></td>
                                <td class="grp" style="font-size: 13px"><?php echo $row['incident']; ?></td>
                                <td class="grp"><?php echo $row['action_taken']; ?></td>
                                <td class="opt">
                                    <div class="dropdown">
                                        <button label="Action" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                            <li><a class="dropdown-item" name="update" href="updateReport.php?id=<?php echo $row['id']; ?>">Edit</a></li>
                                            <!-- <li><a class="dropdown-item" name="delete" href="deleteReport.php?id=<?php echo $row['id']; ?>">Delete</a></li> -->
                                            <li>
                                                <input type="hidden" name="selected_id" value="<?php echo $row['id']; ?>">
                                                <!-- <button type="submit" class="dropdown-item" formtarget="_blank">Print</button> -->
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        echo "<tr> <td colspan='6' style='color:red;'>No record found.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </form>
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
                    <div class="form-group">
                        <label>Case #</label>
                        <input type="number" name="number" class="form-control" required required min="0">
                    </div>

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

<script>
    function printSelectedRow() {
        // Get the selected row's id
        var selectedId = document.querySelector('input[name="selected_id"]').value;
        
        // Set the 'id' value in the hidden input
        document.getElementById('selectedId').value = selectedId;

        // Submit the form to print_report.php
        document.forms[0].submit();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>