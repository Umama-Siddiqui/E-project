<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
include '../db_connection.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trackingNumber = $_POST['trackingNumber'] ?? '';
    $senderName = $_POST['senderName'] ?? '';
    $senderPhone = $_POST['senderContact'] ?? '';
    $senderAddress = $_POST['senderAddress'] ?? '';
    $receiverName = $_POST['receiverName'] ?? '';
    $receiverPhone = $_POST['receiverContact'] ?? '';
    $receiverAddress = $_POST['receiverAddress'] ?? '';
    $receiveremail = $_POST['receiveremail'] ?? '';
    $parcelType = $_POST['parcelType'] ?? '';
    $weight = floatval($_POST['parcelWeight'] ?? 0);
    $branchFrom = $_POST['branchFrom'] ?? '';
    $branchTo = $_POST['branchTo'] ?? '';
    $expectedDate = $_POST['expectedDate'] ?? '';
    $notes = $_POST['parcelNotes'] ?? '';

    $status = 'Booked';
    $createdAt = date('Y-m-d H:i:s');

    $ratePerKg = 100;
    if ($parcelType === 'Express') $ratePerKg = 150;
    if ($parcelType === 'Same-Day') $ratePerKg = 200;
    $price = $weight * $ratePerKg;

    if (
        empty($trackingNumber) || empty($senderName) || empty($senderPhone) || empty($senderAddress) ||
        empty($receiverName) || empty($receiverPhone) || empty($receiverAddress) || empty($receiveremail) ||
        empty($parcelType) || empty($weight) || empty($branchFrom) ||
        empty($branchTo) || empty($expectedDate)
    ) {
        $message = "❌ Please fill all required fields.";
    } else {
        $sql = "INSERT INTO parcels (
            consignment_no, sender_name, sender_phone, sender_address,
            receiver_name, receiver_phone, receiver_address, receiver_email, parcel_type,
            weight, price, status, branch_from, branch_to, expected_delivery_date,
            created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $message = "❌ SQL Error: " . $conn->error;
        } else {
            $stmt->bind_param(
                "sssssssssddsssss",
                $trackingNumber, $senderName, $senderPhone, $senderAddress,
                $receiverName, $receiverPhone, $receiverAddress, $receiveremail, $parcelType,
                $weight, $price, $status, $branchFrom, $branchTo, $expectedDate, $createdAt
            );

            if ($stmt->execute()) {
                // ✅ Email Send
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'umama19708@gmail.com'; // ✅ YOUR EMAIL
                    $mail->Password = 'sknlvwioijsvyayx';    // ✅ YOUR APP PASSWORD
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;;
                    $mail->Port = 465;

                    $mail->setFrom('umama19708@gmail.com', 'Courier Service');
                    $mail->addAddress($receiveremail,'Courier Support');

                    $mail->isHTML(true);
                    $mail->Subject = "Courier $status";
                    $mail->Body = "
                        Dear $receiverName,<br><br>
                        Your parcel has been booked successfully.<br>
                        Tracking Number: <strong>$trackingNumber</strong><br>
                        Current Status: <strong>$status</strong><br><br>
                        Thank you for using our service!
                    ";

                    $mail->send();
                    $message = "✅ Courier added and email sent to $receiveremail";
                } catch (Exception $e) {
                    $message = "✅ Courier added but email failed: {$mail->ErrorInfo}";
                }
            } else {
                $message = "❌ Database Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $conn->close();
    }

    echo "<script>alert(" . json_encode($message) . ");
    window.location.href = '../dashboard/add_courier.php';</script>";
}
?>
