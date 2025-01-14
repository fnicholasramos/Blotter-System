<?php include("database.php"); ?>

<?php 
    if(isset($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = "DELETE FROM `tbl_resident` WHERE `resident_id` = '$id'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die("Query has failed." . mysqli_error($error));
    } else {
        header('location:residents.php?delete=Record has been deleted.');
    
}
?>