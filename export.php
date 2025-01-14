<?php 
require 'database.php';

if(isset($_POST["export"]))
{
    $query = "SELECT * FROM blotter";
    $result = mysqli_query($mysqli, $query);

    if(mysqli_num_rows($result) > 0)
    {
        $output = '
        <table style="border-collapse: collapse; width: 100%;" border="1">
            <tr> 
                <th style="background-color: #f2f2f2;">#</th>
                <th style="background-color: #f2f2f2;">Klasipikasyon</th>
                <th style="background-color: #f2f2f2;">Nagrereklamo</th>
                <th style="background-color: #f2f2f2;">Address</th>
                <th style="background-color: #f2f2f2;">Contact</th>
                <th style="background-color: #f2f2f2;">Reklamo</th>
                <th style="background-color: #f2f2f2;">Inirereklamo</th>
                <th style="background-color: #f2f2f2;">Address</th>
                <th style="background-color: #f2f2f2;">Aksyon</th>
                <th style="background-color: #f2f2f2;">Istado</th>
                <th style="background-color: #f2f2f2;">Petsa</th>
            </tr>';
        
        while($row = mysqli_fetch_array($result)) {
            $output .= '
            <tr>  
                <td>'.$row["id"].'</td>  
                <td>'.$row["classification"].'</td>  
                <td>'.$row["complainant"].'</td>  
                <td>'.$row["complainant_addr"].'</td>  
                <td>'.$row["contact"].'</td>
                <td>'.$row["complain"].'</td>  
                <td>'.$row["respondent"].'</td>  
                <td>'.$row["respondent_addr"].'</td>  
                <td>'.$row["act1on"].'</td>  
                <td>'.$row["st4tus"].'</td>
                <td>'.$row["d4te"].'</td>
            </tr>';
        }

        $output .= '</table>';

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=blotter.xls');
        echo $output;
    }
}
?>
