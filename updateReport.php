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
    
    
        $query = "SELECT * FROM `report` WHERE `id` = '$id'";
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

        $case = $_POST['number'];
        $date = $_POST['date'];
        $event_time = $_POST['time'];
        $incident = $_POST['incident'];
        $action_taken = $_POST['action'];

        $query = "UPDATE `report` SET 
            `id` = '$case', 
            `date` = '$date',
            `event_time` = '$event_time',
            `incident` = '$incident', 
            `action_taken` = '$action_taken' 
          WHERE `id` = '$id'";

        $result = mysqli_query($mysqli, $query);
        if (!$result) {
            die("Query has failed." . mysqli_error($error));
        } else {
            header('location:report.php?update=Record has been updated.');
        
    }
    
    }

?>
<fieldset class="formUpdate">
<form  action="updateReport.php?id=<?php echo $id; ?>" method="POST">
    <div class="form-group">
        <label>Case #</label>
        <input type="number" name="number" class="form-control" required min="0" value="<?php echo $row['id'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Date</label>
        <input type="text" name="date" class="form-control" value="<?php echo $row['date'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Time</label>
        <input type="text" name="time" class="form-control" value="<?php echo $row['event_time'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Case Description</label>
        <textarea name="incident" class="form-control" rows="7"><?php echo $row['incident'] ?? '';?></textarea>
    </div>
    <div class="form-group">
        <label>Action Taken</label>
        <input type="hidden" name="action" class="form-control" value="<?php echo $row['action_taken'] ?? '';?>">
        <select name="action" class="form-select typeSelect" >
            <option selected disabled>Select action:</option>
            <option value="Referred to KT">Referred to KT</option>
            <option value="Issued of CFA">Issued of CFA</option>
            <option value="Immediately Settled">Immediately Settled</option>
        </select>
    </div>
    <br>
    <button type="button" class="btn btn-secondary cancelUpdate" data-bs-dismiss="modal" onclick="window.location.href='report.php'">Cancel</button>
    <button type="submit" class="btn btn-primary button" name="updateRecord">Save</button> 
    </form>
</form>
</fieldset>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
