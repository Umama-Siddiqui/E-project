<?php
require '../libs/fpdf/fpdf.php'; // Manual download wale path
require_once '../db_connection.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Parcel Report',0,1,'C');
$pdf->Ln(5);

// Table headings
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,10,'ID',1);
$pdf->Cell(40,10,'Consignment',1);
$pdf->Cell(40,10,'Sender',1);
$pdf->Cell(40,10,'Receiver',1);
$pdf->Cell(30,10,'Status',1);
$pdf->Ln();

// Data rows
$pdf->SetFont('Arial','',10);
$query = "SELECT * FROM parcels ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(20,8,$row['parcel_id'],1);
    $pdf->Cell(40,8,$row['consignment_no'],1);
    $pdf->Cell(40,8,$row['sender_name'],1);
    $pdf->Cell(40,8,$row['receiver_name'],1);
    $pdf->Cell(30,8,$row['status'],1);
    $pdf->Ln();
}

$filename = "parcel_report_" . date('Ymd_His') . ".pdf";
$pdf->Output('D', $filename);
exit;
?>
