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
    .box {
        width: 50%;
    }

    hr {
        width: 50%;
        color: black;
    }

    .priv {
        width: 55px;
    }

    .thirdColumn {
        width: 35%;
    }

    .update {
        background-color: #228b22;
        border-color: #228b22;
    }

    .update:hover {
        background-color: #0ca031;
        border-color: #0ca031;
    }

    .table {
        border: 1px solid #bebebe;
    }
    .note {
        text-align: left;
        margin-top: -223px; /* Adjust the margin as needed */
        width: 500px;
        height: 208px;
        border: 1px solid #bebebe;
        padding: 20px;
        margin-left: 105%;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .red {
        color: red;
    }

    .text {
        text-align: justify;
    }
</style>

<h2>User privilege</h2>
<hr>
<fieldset class="box">
    <table class="table table-bordered table-stripped table2">
        <thead>
            <tr>
                <th>User</th>
                <th>Privilege</th>
                <th>Grant</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM `users`";

            // Search functionality
            // if (isset($_GET['search']) && !empty($_GET['search'])) {
            //     $search = mysqli_real_escape_string($mysqli, $_GET['search']);
            //     $query = " WHERE CONCAT(username, privilege) LIKE '%$search%'";
            // }

            $result = mysqli_query($mysqli, $query);

            if (!$result) {
                die("Query has failed." . mysqli_error($error));
            } else {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <form action="update-privilege.php" method="POST">
                            <tr>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['privilege']; ?></td>
                                <td class="thirdColumn">
                                    <div class="dropdown">
                                        <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                                        <select name="role" class="form-select">
                                            <option selected disabled>Select privilege:</option>
                                            <option value="administrator">Admin privilege</option>
                                            <option value="user">User privilege</option>
                                        </select>
                                    </div>
                                </td>
                                <td width="5">
                                    <button type="submit" class="btn btn-primary update" name="update">Update</button>
                                </td>
                            </tr>
                        </form>
                    <?php
                    
                    }
                }
            }
            ?>
        </tbody>
    </table>
    <fieldset class="note">
        <p class="red"><Strong>Note!</Strong></p>
        <p class="text"><strong>Administrator:</strong> Administrators oversee system settings, user accounts, and overall functionality, ensuring security and performing system maintenance.</p>
        <p class="text"><strong>User:</strong> User can only interact based on assigned roles, limited access in system features to support their tasks.</p>
    </fieldset>
</fieldset>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>