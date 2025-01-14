<?php include("database.php"); ?>

<?php 
    if(isset($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = "DELETE FROM `report` WHERE `id` = '$id'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die("Query has failed." . mysqli_error($error));
    } else {
        header('location:report.php?delete=Record has been deleted.');
    
}
?>