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
<?php include('notification-count.php'); ?>
<?php include('database.php'); ?>


<div class="box">
    <form action="" method="GET">
    <input type="text" id="search" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>">
    <label for="search">Search:</label>
    </form>
</div>

<style>
    .main {
        height: 400px;
        border: 1px solid  #c3c4c7;
        overflow-y: auto;
    }

    .table-width {
        width: 100%;
    }

    .addResident {
        height: 30px;
        font-size: 14px;
        margin-left:10px ;
        border-radius: 8px;
        color: #fff;
        background-color: #135e96;
        border-color: #135e96;
    }

    .addResident:hover {
        background-color: #1571b5;
    }

    .borderColor {
        border-color: #cfcfcf;
    }

</style>
    <h4>
        Barangay Residents
        <span><button type="button" class="addResident" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus"></i> Add new</button></span>
    </h4>

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
    
<fieldset class="main">
    <table class="table table-hover table-bordered table-width borderColor">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Address</th>
            <th width="10">Purok</th>
            <th>Birthday</th>
            <th>Age</th>
            <th>Civil Status</th>
            <th>Nationality</th>
            <th width="5">Edit</th>
        </tr>
    </thead>

        <tbody>
            <?php
            $query = "SELECT * FROM `tbl_resident`";

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($mysqli, $_GET['search']);
                
                $query .= " WHERE 
                    CONCAT(resident_id, name, contact, address, purok, birthday, age, civilStatus, nationality) LIKE '%$search%' OR 
                    date_format(birthday, '%m/%d/%Y') = '$search' OR 
                    date_format(birthday, '%M %d, %Y') = '$search' OR 
                    resident_id = '$search'";
                }


            $result = mysqli_query($mysqli, $query);

            if (!$result) {
                die("Query has failed." . mysqli_error($error));
            } else {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['resident_id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td width="15%" style="font-size:14px;"><?php echo $row['address']; ?></td>
                            <td width="10%"><?php echo $row['purok']; ?></td>
                            <td width="5px"><?php echo $row['birthday']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td width="10%"><?php echo $row['civilStatus']; ?></td>
                            <td width="5%"><?php echo $row['nationality']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button label="Action" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class='fas fa-edit'></i> 
                                    <!-- <i class="fas fa-trash"></i> -->
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                        <li><a class="dropdown-item" name="update" href="updateResident.php?id=<?php echo $row['resident_id']; ?>">Edit</a></li>
                                        <li><a class="dropdown-item" name="delete" href="deleteResident.php?id=<?php echo $row['resident_id']; ?>">Delete</a></li>
                                    </ul>
                            </td>
                                </div>
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

</fieldset>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="insertResident.php" method="POST">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control"  maxlength="11" required>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Purok</label>
                        <input type="text" name="purok" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="text" name="birthday" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" name="age" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Civil Status</label>
                        <select name="civil" class="form-select typeSelect" required>
                            <option selected disabled>Select --</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Divorced">Divorced</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nationality</label>
                        <input type="text" name="nationality" class="form-control" required>
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
</html