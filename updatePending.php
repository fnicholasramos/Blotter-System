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
    
    
        $query = "SELECT * FROM `online_report` WHERE `id` = '$id'";
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
        $classification = $_POST['classification'];
        $respondent = $_POST['respondent'];
        $addr2 = $_POST['respondent_addr'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        $query = "UPDATE `online_report` SET 
        `classification` = '$classification',
        `respondent` = '$respondent', 
        `addrRespo` = '$addr2',
        `d4te` = '$date', 
        `tim3` = '$time' 
          WHERE `id` = '$id'";

        $result = mysqli_query($mysqli, $query);
        if (!$result) {
            die("Query has failed." . mysqli_error($error));
        } else {
            header('location:pendingTable.php?update=Record has been updated.');
        
    }
    
    }

?>



<fieldset class="formUpdate">
    <form action="updatePending.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label>Classification</label>
            <input type="text" name="classification" class="form-control" value="<?php echo $row['classification'] ?? ''; ?>">
        </div>
        <div class="form-group">
            <label>Respondent</label>
            <input type="text" name="respondent" class="form-control" value="<?php echo $row['respondent'] ?? ''; ?>">
        </div> 
        <div class="form-group">
            <label>Address of Respondent</label>
            <input type="text" name="respondent_addr" class="form-control" value="<?php echo $row['addrRespo'] ?? ''; ?>">
        </div> 
        <div class="form-group">
            <label>Date</label>
            <input type="text" name="date" class="form-control" placeholder="MM-DD-YY" value="<?php echo $row['d4te'] ?? ''; ?>">
        </div> 
        <div class="form-group">
            <label>Time</label>
            <input type="text" name="time" class="form-control" value="<?php echo $row['tim3'] ?? ''; ?>">
        </div> 
        <br>
        <button type="button" class="btn btn-secondary cancelUpdate" data-bs-dismiss="modal" onclick="window.location.href='pendingTable.php'">Cancel</button>
        <button type="submit" class="btn btn-primary button" name="update">Save</button> 
    </form>
</fieldset>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
