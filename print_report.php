<?php
require 'database.php';

// Check if the 'id' parameter is set and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $printId = mysqli_real_escape_string($mysqli, $_GET['id']);

    // Query to retrieve the specific record with the given ID
    $query = "SELECT * FROM `report` WHERE id = $printId";
    $result = mysqli_query($mysqli, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Start printing the document
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofnPENhN6I5a1iVoY+1t4Ug7GPb1CrlNT" crossorigin="anonymous">
    
    <style>
        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        th {
            text-align: center;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
        }

        td {
            height: 200px;
            white-space: pre-line;
        }

        th {
            background-color: #f2f2f2;
        }

        .table-striped tbody > tr:nth-child(odd) > td,
        .table-striped tbody > tr:nth-child(odd) > th {
            background-color: #f9f9f9;
        }

        @media print {
            #print,
            #PrintButton {
                display: none;
            }

            .table {
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #dddddd !important;
            }
        }

        @page {
            size: auto;
            margin: 0;
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
			margin-left: 38%;
			margin-bottom: -14px;
			margin-top: 30px;
			font-family: 'UnifrakturMaguntia', sans-serif;
			font-size: larger;
		}

		p.line1 {
			margin-left: 29%;
			margin-bottom: 0;
			font-size: larger;
		}
		p.line2 {
			margin-left: 32%;
			margin-top: -3px;
			font-size: larger;
		}
		p.line3 {
			margin-left: 30%;
			/* margin-top: 10px; */
			margin-top: -15px;
			font-size: larger;
		}

		.blue {
			color: #66a3ff;
			margin-top: -15px;
			word-spacing: 20px;
			margin-left: 23%;
		}
        h5 {
            margin-left: 305px;
        }

        .signature {
            margin-top: 10vh;
            text-align: right;
            margin-right: 30px;
        }
    </style>
</head>

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
	<br> 

    <h5>Barangay Blotter Report</h5>
            <table border="1">
                <tr>
                    <th>Case #</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Incident</th>
                    <th >Action Taken</th>
                </tr>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['event_time']; ?></td>
                    <td><?php echo $row['incident']; ?></td>
                    <td><?php echo $row['action_taken']; ?></td>
                </tr>
            </table>

            <div class="signature">
                <p>_________________________</p>
                <p><em>Hon. Arthur "Atoy" Cortez</em></p>
            </div>
            <script>
                // Automatically trigger the print dialog when the page loads
                window.onload = function() {
                    window.print();
                    // Close the window after printing
                    window.onafterprint = function() {
                        window.close();
                    }
                };
            </script>
        </body>
        </html>
<?php
    } else {
        echo "<p>No record found for printing.</p>";
    }
} else {
    echo "<p>Invalid request for printing.</p>";
}
?>