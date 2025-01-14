<?php include("database.php"); ?>

<?php 
    if(isset($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = "DELETE from `blotter` where `id` = '$id'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die("Query has failed." . mysqli_error($error));
    } else {
        header('location:' . $_SERVER['HTTP_REFERER']);
    
}
?>

<!-- 'location:' . $_SERVER['HTTP_REFERER'] -->

<!-- 'location:index.php?delete=Record has been deleted.' -->