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
        width: 450px;
        padding:25px;
        border: 1px solid #c3c4c7;
        border-radius: 8px;
    }
    
    .cancel {
        float: right;
        margin-left: 5px;
    }
</style>


<?php
    $row = null; 
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    
    
        $query = "SELECT * FROM `blotter` WHERE `id` = '$id'";
        $result = mysqli_query($mysqli, $query);

        if (!$result) {
            die("Query has failed." . mysqli_error($error));
        } else {
            $row = mysqli_fetch_assoc($result);
        
    }
}
?>

<?php
    if(isset($_POST["updateRecord"])) {

        // $name = $_POST['complainant'];
        // $addr1 = $_POST['complainant_addr'];
        // $contact = $_POST['contact'];
        // $classification = $_POST['type'];
        // $complain = $_POST['complain'];
        // $respondent = $_POST['respondent'];
        // $addr2 = $_POST['respondent_addr'];
        $action = $_POST['action'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        $query = "UPDATE `blotter` SET 
            `act1on` = '$action', 
            `st4tus` = '$status',
            `d4te` = '$date', 
            `event_time` = '$time' 
          WHERE `id` = '$id'";

        $result = mysqli_query($mysqli, $query);
        if (!$result) {
            die("Query has failed." . mysqli_error($error));
        } else {
            header('location:index.php?update=Record has been updated.');
        
    }
    
    }

?>



<fieldset class="formUpdate">
<form  action="update.php?id=<?php echo $id; ?>" method="POST">
    <!-- <div class="form-group">
        <label>Name</label>
        <input type="text" name="complainant" class="form-control" value="<?php echo $row['complainant'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Address of Complainant</label>
        <input type="text" name="complainant_addr" class="form-control" value="<?php echo $row['complainant_addr'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control" value="<?php echo $row['contact'] ?? '';?>">
    </div> -->

    <!-- old feature -->
    <!-- <div class="form-group">
        <label>Classification</label>
        <input type="text" name="type" class="form-control" value="<?php echo $row['classification'] ?? '';?>">
    </div> -->

    <!-- new feature (dropdown) -->
    <!-- <div>
        <label>Classification</label>
        <input type="hidden" name="type" >
        <select name="type" class="form-select typeSelect" value="<?php echo $row['classification'] ?? '';?>">
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

    <!-- <div class="form-group">
        <label>Complain</label>
        <input type="text" name="complain" class="form-control" value="<?php echo $row['complain'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Respondent</label>
        <input type="text" name="respondent" class="form-control" value="<?php echo $row['respondent'] ?? '';?>">
    </div> 
    <div class="form-group">
        <label>Address of Respondent</label>
        <input type="text" name="respondent_addr" class="form-control" value="<?php echo $row['respondent_addr'] ?? '';?>">
    </div>  -->
    <div class="form-group">
        <label>Action</label>
        <input type="hidden" name="action" class="form-control" value="<?php echo $row['act1on'] ?? '';?>">
        <select name="action" class="form-select typeSelect">
            <option selected disabled>Select action:</option>
            <option value="Referred to KT">Referred to KT</option>
            <option value="Issued of CFA">Issued of CFA</option>
            <option value="Immediately Settled">Immediately Settled</option>
            <option value="Scheduled">Scheduled</option>
        </select>
    </div> 
    
    <!-- old status update -->
    <!-- <div class="form-group">
        <label>Status</label>
        <input type="text" name="status" class="form-control" value="<?php echo $row['st4tus'] ?? '';?>">
    </div>  -->

    <div>
        <label>Status</label>
        <input type="hidden" name="status" required value="<?php echo $row['st4tus'] ?? '';?>">
        <select name="status" class="form-select typeSelect">
            <option selected disabled>Select classification:</option>
            <option value="Active">Active</option>
            <option value="Settled">Settled</option>
        </select>
    </div>

    <div class="form-group">
        <label>Date</label>
        <input type="text" name="date" class="form-control" value="<?php echo $row['d4te'] ?? '';?>">
    </div> 

    <div class="form-group">
        <label>Time</label>
        <input type="text" name="time" class="form-control" value="<?php echo $row['event_time'] ?? '';?>">
    </div> 
    <br>
    <button type="button" class="btn btn-secondary cancelUpdate" data-bs-dismiss="modal" onclick="window.location.href='index.php'">Cancel</button>
    <button type="submit" class="btn btn-primary button" name="updateRecord">Save</button> 
    </form>
</form>
</fieldset>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
