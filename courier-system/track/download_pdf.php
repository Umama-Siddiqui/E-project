<?php
session_start();
require '../db_connection.php';
require '../libs/fpdf/fpdf.php';

if (!isset($_GET['track_no'])) {
    die("Tracking number not provided.");
}

$trackNo = $_GET['track_no'];
$stmt = $conn->prepare("SELECT * FROM parcels WHERE consignment_no = ?");
$stmt->bind_param("s", $trackNo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("No record found.");
}

$row = $result->fetch_assoc();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Parcel Tracking Report', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Consignment No:', 0, 0);
$pdf->Cell(100, 10, $row['consignment_no'], 0, 1);

$pdf->Cell(50, 10, 'Sender:', 0, 0);
$pdf->Cell(100, 10, $row['sender_name'], 0, 1);

$pdf->Cell(50, 10, 'Receiver:', 0, 0);
$pdf->Cell(100, 10, $row['receiver_name'], 0, 1);

$pdf->Cell(50, 10, 'Type:', 0, 0);
$pdf->Cell(100, 10, $row['parcel_type'], 0, 1);

$pdf->Cell(50, 10, 'Status:', 0, 0);
$pdf->Cell(100, 10, $row['status'], 0, 1);

$pdf->Cell(50, 10, 'Created At:', 0, 0);
$pdf->Cell(100, 10, date('d M Y', strtotime($row['created_at'])), 0, 1);

$filename = "parcel_tracking_" . $row['consignment_no'] . ".pdf";
$pdf->Output('D', $filename);
exit;
?>
