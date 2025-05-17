<?php
include '../db_connection.php';
include 'auth_check.php'; // Ensure user is logged in

$message = ''; // Message ko initialize karo

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitParcel'])) {

    // Agent ki branch ID session se lo
    $branchFrom = $_SESSION['branch_id'] ?? null;
    if (!$branchFrom) {
        echo "<script>alert('❌ Branch information missing from session.'); window.history.back();</script>";
        exit;
    }

    $trackingNumber = $_POST['trackingNumber'] ?? '';
    $senderName = $_POST['senderName'] ?? '';
    $senderPhone = $_POST['senderContact'] ?? '';
    $senderAddress = $_POST['senderAddress'] ?? '';
    $receiverName = $_POST['receiverName'] ?? '';
    $receiverPhone = $_POST['receiverContact'] ?? '';
    $receiverAddress = $_POST['receiverAddress'] ?? '';
    $parcelType = $_POST['parcelType'] ?? '';
    $weight = floatval($_POST['parcelWeight'] ?? 0);
    $branchTo = $_POST['branchTo'] ?? '';
    $expectedDate = $_POST['expectedDate'] ?? '';
    $notes = $_POST['parcelNotes'] ?? '';

    $status = 'Booked';
    $createdAt = date('Y-m-d H:i:s');

    // Pricing logic
    $ratePerKg = 100;
    if ($parcelType === 'Express') $ratePerKg = 150;
    if ($parcelType === 'Same-Day') $ratePerKg = 200;
    $price = $weight * $ratePerKg;

    // Validation
    if (
        empty($trackingNumber) || empty($senderName) || empty($senderPhone) || empty($senderAddress) ||
        empty($receiverName) || empty($receiverPhone) || empty($receiverAddress) ||
        empty($parcelType) || empty($weight) || empty($branchTo) || empty($expectedDate)
    ) {
        $message = "❌ Please fill all required fields.";
    } else {
        $sql = "INSERT INTO parcels (
            consignment_no, sender_name, sender_phone, sender_address,
            receiver_name, receiver_phone, receiver_address, parcel_type,
            weight, price, status, branch_from, branch_to, expected_delivery_date,
            created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $message = "❌ SQL Error: " . $conn->error;
        } else {
            $stmt->bind_param(
                "ssssssssddsssss",
                $trackingNumber, $senderName, $senderPhone, $senderAddress,
                $receiverName, $receiverPhone, $receiverAddress, $parcelType,
                $weight, $price, $status, $branchFrom, $branchTo, $expectedDate,
                $createdAt
            );

            if ($stmt->execute()) {
                $message = "✅ Courier added successfully! Tracking ID: $trackingNumber";
            } else {
                $message = "❌ Database Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $conn->close();
    }

    echo "<script>alert(" . json_encode($message) . "); window.location.href = '../agent_dashboard/add_courier.php';</script>";
}
?>
