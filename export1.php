<?php
require 'database.php';
require 'vendor/autoload.php'; // Include PhpSpreadsheet autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST["export"]))
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers
    $headers = ["#", "Klasipikasyon", "Nagrereklamo", "Address", "Contact", "Reklamo", "Inirereklamo", "Address", "Aksyon", "Istado", "Petsa"];
    $sheet->fromArray([$headers], null, 'A1');

    $query = "SELECT * FROM blotter";
    $result = mysqli_query($mysqli, $query);

    if(mysqli_num_rows($result) > 0)
    {
        $rowNumber = 2;
        while($row = mysqli_fetch_array($result)) {
            $rowData = [$row["id"], $row["classification"], $row["complainant"], $row["complainant_addr"], $row["contact"], $row["complain"], $row["respondent"], $row["respondent_addr"], $row["act1on"], $row["st4tus"], $row["d4te"]];
            $sheet->fromArray([$rowData], null, 'A' . $rowNumber);
            $rowNumber++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="blotter.xlsx"');
        $writer->save('php://output');
        exit;
    }
}
?>
