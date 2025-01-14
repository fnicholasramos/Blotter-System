<?php
session_start();
if (!isset($_SESSION['validate']) || $_SESSION['validate'] !== 'yes') {
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
    border: 1px solid #c3c4c7;
    overflow-y: auto;
    width: 115%; /* You can adjust the percentage as needed */
    margin: 0 auto;
    margin-left: -7.5%;
    }
    
    .table-width {
    width: 100%;
    }

    .pagination {
    margin-top: 20px;
    text-align: center;
    float: right;
    margin-right: -9%;
    }

    .pagination-link {
    display: inline-block;
    padding: 3px 7px;
    background-color: #f1f1f1;
    color:black;
    border: 1px solid #c3c4c7;
    text-decoration: none;
    margin-right: 15px;
    }

    .next-page {
    background-color: #f1f1f1;
    color: black;
    border: 1px solid #c3c4c7;
    }

    .add {
    background-color: #135e96;
    font-size: 14px;
    border-color: #135e96;
    color: #fff;
    cursor: pointer;
    height: 30px;
    width: auto;
    border-radius: 8px;
    float: right;
    margin-right: 80%;
    }

    .add:hover {
    background-color: #1879c0;
    }

    #notificationList p {
    margin: 0; /* Remove default margin */
    position: relative;
    padding: 8px; /* Add padding for better appearance (optional) */
    border-top: 1px solid #dee2e6; /* Add Bootstrap-like border style */
    }

    #notificationList p:hover {
    background-color: #ebebeb;
    }

    .table th {
    background-color: #f2f2f2; /* Set your preferred background color */
    color: #333; /* Set your preferred text color */
    }

    .searchForm {
    float:right;
    margin-top: -30px;
    margin-right: -35px;
    margin-bottom: 10px;
    }

    .h4Head {
    margin-left: -55px;
    margin-bottom: -10px;
    }

    .borderColor {
    border-color: #cfcfcf;
    }
</style>

<span><button type="button" class="add" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus"></i> Add Record</button></span>
<h4 class="h4Head">
    Blotter Records
</h4>

<form action="" method="GET" class="searchForm">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" class="s3arch"
    value="<?php if (isset($_GET['search'])) {echo $_GET['search'];} ?>">
</form>
     
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


<fieldset class="main">
    <table class="table table-hover table-bordered table-width borderColor">
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
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
                <th>Status</th>
                <th width="20px">Edit</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $recordsPerPage = 10;

            // Determine the current page
            if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                $currentPage = $_GET['page'];
            } else {
                $currentPage = 1;
            }

            // Calculate the offset for the SQL query
            $offset = ($currentPage - 1) * $recordsPerPage;

            // Modify your existing query to include LIMIT and OFFSET
            $query = "SELECT * FROM `blotter`";

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($mysqli, $_GET['search']);
                
                $query .= " WHERE 
                    CONCAT(id, classification, complainant, complainant_addr, contact, complain, respondent, respondent_addr, act1on, st4tus, d4te, event_time) LIKE '%$search%' OR 
                    date_format(d4te, '%m/%d/%Y') = '$search' OR 
                    date_format(d4te, '%M %d, %Y') = '$search' OR 
                    id = '$search'";
                }
            $query .= " LIMIT $recordsPerPage OFFSET $offset";
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
                            <td style="font-size: 14px;"><?php echo $row['complain']; ?></td>
                            <td><?php echo $row['respondent']; ?></td>
                            <td width="200px" style="font-size: 14px;"><?php echo $row['respondent_addr']; ?></td>
                            <td style="font-size: 14px;"><?php echo $row['d4te']; ?></td>
                            <td><?php echo $row['event_time']; ?></td>
                            <td><?php echo $row['act1on']; ?></td>
                            <td><?php echo $row['st4tus']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button label="Action" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class='fas fa-edit'></i>
                                        <!-- <i class="fas fa-trash"></i> para sa delete icon -->
                                    </button>
                                    <ul class="dropdown-menu " aria-labelledby="actionDropdown">
                                        <li><a class="dropdown-item" name="update" href="update.php?id=<?php echo $row['id']; ?>">Edit</a></li>
                                        <li><a class="dropdown-item" name="delete" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo "<tr> <td colspan='13' style='color:red;'>No record found.</td></tr>";
                }
            }
            ?>
        </tbody>

    </table>
</fieldset>

<div class="pagination">
    <?php
    if ($currentPage > 1) {
        echo '<a class="pagination-link" href="?page=' . ($currentPage - 1) . '">Previous</a>';
    }
    if (mysqli_num_rows($result) == $recordsPerPage) {
        echo '<a class="pagination-link next-page" href="?page=' . ($currentPage + 1) . '">Next</a>';
    }
    ?>
</div>

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
                        <input type="text" name="contact" class="form-control" maxlength="11" required>
                    </div>
                    <div class="form-group">
                        <label>Classification</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Complain</label>
                        <textarea id="complain" name="complain" rows="4" style="width: 100%; border: 1px solid #ccc; border-radius: 4px;" required></textarea>
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
                        <input type="hidden" name="action" class="form-control" required>
                        <select name="action" class="form-select typeSelect" >
                            <option selected disabled>Select action:</option>
                            <option value="Referred to KT">Referred to KT</option>
                            <option value="Issued of CFA">Issued of CFA</option>
                            <option value="Immediately Settled">Immediately Settled</option>
                            <option value="Scheduled">Scheduled</option>
                        </select>
                    </div>
                    <div>
                        <label>Status</label>
                        <input type="hidden" name="status" required>
                        <select name="status" class="form-select typeSelect" >
                            <option selected disabled>Select status:</option>
                            <option value="Active">Active</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control" placeholder="Month-Date-Year" required>
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
