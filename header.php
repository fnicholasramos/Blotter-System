<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotter</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofnPENhN6I5a1iVoY+1t4Ug7GPb1CrlNT" crossorigin="anonymous">
</head>

<style>
    .logo {
    height: auto;
    width: 55px;
    margin-left: -10px;
    }

    .toggle-color {
    background-color: #424242;
    border-color: #424242;
    margin-left: -10px; 
    }

    .toggle-color:hover {
        background-color: #424242;
        border-color: #424242;
        color: red;
    }

    .home {
        color: white;
        text-decoration: none;
        font-size: 16px;
        margin-left: 300px;
        font-family: Arial, Helvetica, sans-serif;
        
    }

    .home:hover {
        color: #9dffff;
    }

    .residents {
        color: white;
        text-decoration: none;
        font-size: 16px;
        margin-left: 15px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .residents:hover {
        color: #9dffff;
    }

    .blotter {
        color: white;
        text-decoration: none;
        font-size: 16px;
        margin-left: 15px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .blotter:hover  {
        color: #9dffff;
    }

    .officials {
        color: white;
        text-decoration: none;
        font-size: 15px;
        margin-left: 15px;
    }

    .officials:hover {
        color: #9dffff;
    }



</style>
<body>
    <h2 id="title">
        <img src="duck.png" alt="logo" class="logo">
        BSRKP
    <span>

        <button class="btn home" onclick="window.location.href='home.php'">
            <i class="fa fa-home" aria-hidden="true"></i> Home
        </button>
        <button class="btn officials" onclick="window.location.href='admin-privilege.php'">
            <i class="fas fa-user-alt"></i> Users
        </button>
        <button class="btn residents" onclick="window.location.href='residents.php'">
            <i class="fas fa-address-card"></i> Residents
        </button>
        <button class="btn blotter" onclick="window.location.href='#'" id="certificatesDropdown" data-bs-toggle="dropdown" >
            <i class="fa-solid fa-book"></i> Blotter
        </button>
        <ul class="dropdown-menu" aria-labelledby="certificatesDropdown">
            <li><a class="dropdown-item" href="index.php">Blotter Record</a></li> 
            <li><a class="dropdown-item" href="report.php">Summary Report</a></li> 
            <li><a class="dropdown-item" href="scheduled.php">Scheduled Report</a></li> 
            <li><a class="dropdown-item" href="pendingTable.php">Pending Validation</a></li>  
        </ul>

        <button class="btn blotter" id="notificationBell" data-bs-toggle="modal" data-bs-target="#notificationModal">
            <i class="fa-solid fa-bell"></i>  Notification
        </button>


        
        <button label="Action" class="btn btn-secondary dropdown-toggle toggle-color" data-bs-toggle="dropdown">
        <i class="fa fa-power-off" aria-hidden="true"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
            <li><a class="dropdown-item" name="" href="logout.php"><i class="fa fa-sign-out"></i>Log out</a></li>
        </ul>
    </span>
        
    </h2>
    
    <div class="container">

    


    