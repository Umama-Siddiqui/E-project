<?php
require '../vendor/autoload.php';
require_once '../db_connection.php'; // Update path as needed

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headings
$sheet->setCellValue('A1', 'Parcel ID');
$sheet->setCellValue('B1', 'Consignment No');
$sheet->setCellValue('C1', 'Sender Name');
$sheet->setCellValue('D1', 'Receiver Name');
$sheet->setCellValue('E1', 'Status');
$sheet->setCellValue('F1', 'Created At');

// Fetch data
$query = "SELECT * FROM parcels ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$rowNumber = 2;

while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue("A$rowNumber", $row['parcel_id']);
    $sheet->setCellValue("B$rowNumber", $row['consignment_no']);
    $sheet->setCellValue("C$rowNumber", $row['sender_name']);
    $sheet->setCellValue("D$rowNumber", $row['receiver_name']);
    $sheet->setCellValue("E$rowNumber", $row['status']);
    $sheet->setCellValue("F$rowNumber", $row['created_at']);
    $rowNumber++;
}

// Output file
$filename = "parcel_report_" . date('Ymd_His') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
