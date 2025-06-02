<?php
include '../db_connection.php';
include 'sms_function.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parcel_id = mysqli_real_escape_string($conn, $_POST['parcel_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Get parcel data
    $query = "SELECT receiver_name, receiver_phone, receiver_email, consignment_no FROM parcels WHERE parcel_id = '$parcel_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $receiver_name = $row['receiver_name'];
        $receiver_phone = $row['receiver_phone'];
        $receiver_email = $row['receiver_email'];
        $trackingNumber = $row['consignment_no'];

        // Message banayein
        $sms_message = "Your parcel (Tracking ID: $trackingNumber) status updated to: $status.";
        $email_subject = "Update: Your Parcel Status is now '$status'";
        $email_body = "
            Dear $receiver_name,<br><br>
            Your parcel with Tracking Number <strong>$trackingNumber</strong> has been updated.<br>
            <strong>Current Status: $status</strong><br><br>
            Thank you for using our courier service.
        ";

        // Send SMS
        send_sms($receiver_phone, $sms_message);

        // Log SMS (optional)
        $log_sql = "INSERT INTO sms_logs (phone_number, message_body, status, reference_id) 
                    VALUES ('$receiver_phone', '$sms_message', 'Sent', '$parcel_id')";
        mysqli_query($conn, $log_sql);

        // ✅ Send Email
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'umama19708@gmail.com'; // ✅ Aapki Gmail
            $mail->Password = 'sknlvwioijsvyayx';     // ✅ App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('umama19708@gmail.com', 'Courier Service');
            $mail->addAddress($receiver_email, $receiver_name);
            $mail->isHTML(true);
            $mail->Subject = $email_subject;
            $mail->Body = $email_body;

            $mail->send();
        } catch (Exception $e) {
            // Aap chahein to log bhi kar sakte hain
        }
    }

    // Update status in database
    $sql = "UPDATE parcels SET status = '$status' WHERE parcel_id = '$parcel_id'";
    mysqli_query($conn, $sql);

    mysqli_close($conn);
    header("Location: ../dashboard/view_couriers.php?status_updated=1");
}
?>
