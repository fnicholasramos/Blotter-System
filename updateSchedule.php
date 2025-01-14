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

    @media (max-width: 600px) {
    .formUpdate {
        width: 100%; /* Full width for mobile view */
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
            header('location:scheduled.php?update=Record has been updated.');
        ob_end_flush();
        
    }
    
    }

?>
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
        <button type="button" class="btn btn-secondary cancelUpdate" data-bs-dismiss="modal" onclick="window.location.href='scheduled.php'">Cancel</button>
        <button type="submit" class="btn btn-primary button" name="update">Save</button> 
    </form>
</form>
</fieldset>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
