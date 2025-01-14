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
    
    
        $query = "SELECT * FROM `tbl_resident` WHERE `resident_id` = '$id'";
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

        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $purok = $_POST['purok'];
        $birthday = $_POST['birthday'];
        $age = $_POST['age'];
        $civilStatus= $_POST['civil'];
        $nationality = $_POST['nationality'];

        $query = "UPDATE `tbl_resident` SET 
            `name` = '$name', 
            `contact` = '$contact',
            `address` = '$address',
            `purok` = '$purok',
            `birthday` = '$birthday', 
            `age` = '$age', 
            `civilStatus` = '$civilStatus', 
            `nationality` = '$nationality'
          WHERE `resident_id` = '$id'";
        ob_start();
        $result = mysqli_query($mysqli, $query);
        if (!$result) {
            die("Query has failed." . mysqli_error($error));
        } else {
            header('location:residents.php?update=Record has been updated.');
        ob_end_flush();
        
    }
    
    }

?>
<fieldset class="formUpdate">
<form  action="updateResident.php?id=<?php echo $id; ?>" method="POST">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $row['name'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control" value="<?php echo $row['contact'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="<?php echo $row['address'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Purok</label>
        <input type="text" name="purok" class="form-control" value="<?php echo $row['purok'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Birthday</label>
        <input type="text" name="birthday" class="form-control" value="<?php echo $row['birthday'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Age</label>
        <input type="number" name="age" class="form-control" value="<?php echo $row['age'] ?? '';?>">
    </div>
    <div class="form-group">
        <label>Civil Status</label> 
        <select name="civil" class="form-select typeSelect" value="<?php echo $row['civilStatus'] ?? '';?>" required>
            <option selected disabled>Select --</option>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Widowed">Widowed</option>
            <option value="Divorced">Divorced</option>
        </select>
    </div> 
    <div class="form-group">
        <label>Nationality</label>
        <input type="text" name="nationality" class="form-control" value="<?php echo $row['nationality'] ?? '';?>">
    </div> 
    <br>
        <button type="button" class="btn btn-secondary cancelUpdate" data-bs-dismiss="modal" onclick="window.location.href='residents.php'">Cancel</button>
        <button type="submit" class="btn btn-primary button" name="updateRecord">Save</button> 
    </form>
</form>
</fieldset>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
