<!DOCTYPE html>
<?php
	require 'database.php';
?>
<html lang="en">
	<head>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap">
	</head>

	<style>	
		.table {
			width: 100%;
			margin-bottom: 20px;
			border-collapse: collapse;
			page-break-before:always;
		}	

		th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

		th {
        	background-color: #f2f2f2;
        }
		
		.table-striped tbody > tr:nth-child(odd) > td,
		.table-striped tbody > tr:nth-child(odd) > th {
			background-color: #f9f9f9;
		}
		
		@media print{
			#print {
				display:none;
			}
		}
		@media print {
			#PrintButton {
				display: none;
			}
		}
		
		@page {
			size: auto;   /* auto is the initial value */
			margin: 0;  /* this affects the margin in the printer settings */
		}
		
		.StoRosarioLogo {
			height: 120px;
			float: left;
			margin-left: 55px;
		}

		.imgContainer {
			overflow: hidden; /* Clear the floats */
            text-align:left; /* Center the text */
		}

		.duck {
			height: 118px;
			float:right;
			margin-right: 60px;
		}

		p.line0 {
			margin-left: 42%;
			margin-bottom: -20px;
			margin-top: 30px;
			font-family: 'UnifrakturMaguntia', sans-serif;
			font-size: larger;
		}

		p.line1 {
			margin-left: 35%;
			margin-bottom: 0;
			font-size: larger;
		}
		p.line2 {
			margin-left: 37%;
			margin-top: -3px;
			font-size: larger;
		}
		p.line3 {
			margin-left: 33%;
			/* margin-top: 10px; */
			margin-top: -15px;
			font-size: larger;
		}

		.blue {
			color: #66a3ff;
			margin-top: -15px;
			word-spacing: 20px;
			margin-left: 31%;
		}
	</style>	

<body>
	<form class="print">
	<div class="imgContainer">
		<h2>
			<img src="updated.png" alt="sto.rosario" class="StoRosarioLogo">
			<img src="duck.png" alt="duck" class="duck">
		</h2>
			<p class="line0">Republika ng Pilipinas</p>
			<p class="line1">Municipality of Pateros Metro Manila</p>
			<p class="line2">Barangay Sto. Rosario Kanluran</p>
			<p class="line3">OFFICE OF THE PUNONG BARANGAY</p>
			<p class="blue">
				8628-3210
				brgystorosariokanluran.pateros@gmail.com
			</p>
			<hr>
	</div>
	<br> <br> 
	<!-- <b style="color:blue;">Date Prepared:</b>
	<?php
		// $date = date("Y-m-d", strtotime("+6 HOURS"));
		// echo $date;
	?> -->
	<table class="">
		<thead>
			<tr>
				<th>#</th>
                <th>Classification</th>
                <th>Complainant</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Complain</th>
                <th>Respondent</th>
                <th>Address</th>
                <th>Action</th>
                <!-- <th>Status</th> -->
                <th>Datetime</th>
			</tr>
		</thead>
		<tbody>
			<?php
				require 'database.php';

				$recordsPerPage = 10;
				
			// Determine the current page for printing
			// if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            //     $currentPage = $_GET['page'];
            // } else {
            //     $currentPage = 1;
            // }

			// Calculate the offset for the SQL query
			// $offset = ($currentPage - 1) * $recordsPerPage;

			$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

			// Calculate the offset for the SQL query
			$offset = ($page - 1) * $recordsPerPage;

			$query = "SELECT * FROM `blotter`";

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($mysqli, $_GET['search']);
                $query .= " WHERE CONCAT(id, classification, complainant, complainant_addr, contact, complain, respondent, respondent_addr, act1on, st4tus, d4te) LIKE '%$search%'";
            }

			$query .= " LIMIT $recordsPerPage OFFSET $offset";

            $result = mysqli_query($mysqli, $query);

            if (!$result) {
                die("Query has failed." . mysqli_error($error));
            } else {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
					
			?>
			
			<tr>
				<td><?php echo $row['id']; ?></td>
                <td><?php echo $row['classification']; ?></td>
                <td><?php echo $row['complainant']; ?></td>
                <td><?php echo $row['complainant_addr']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['complain']; ?></td>
                <td><?php echo $row['respondent']; ?></td>
                <td><?php echo $row['respondent_addr']; ?></td>
                <td><?php echo $row['act1on']; ?></td> 
                <!-- <td><?php echo $row['st4tus']; ?></td>  -->
                <td><?php echo $row['d4te']; ?></td>
			</tr>
			
			<?php
			}
		}
	}
			?>
		</tbody>
	</table>
	</form>
</body>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.loaded = function(){
		
	}
	
	window.addEventListener('DOMContentLoaded', (event) => {
   		PrintPage()
		setTimeout(function(){ window.close() },750)
	});
</script>
</html>


