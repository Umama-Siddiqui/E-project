<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parcel_id = mysqli_real_escape_string($conn, $_POST['parcel_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update status
    $sql = "UPDATE parcels SET status = '$status' WHERE parcel_id = '$parcel_id'";
    $result = mysqli_query($conn, $sql);
    header("Location: ../agent_dashboard/view_couriers.php?status_updated=1");
 
    mysqli_close($conn);
}
?>
<?php
include '../db_connection.php';
include 'sms_function.php'; // ← SMS wala function bhi include karo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parcel_id = mysqli_real_escape_string($conn, $_POST['parcel_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Get receiver phone number using parcel_id
    $query = "SELECT receiver_phone FROM parcels WHERE parcel_id = '$parcel_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $receiver_phone = $row['receiver_phone'];

        // Message banayein
        $message = "Your parcel (ID: $parcel_id) status has been updated to: $status. Thank you for choosing us!";

        // Send SMS
        $sms_response = send_sms($receiver_phone, $message);

        // (Optional) Log SMS
        $log_sql = "INSERT INTO sms_logs (phone_number, message_body, status, reference_id) 
                    VALUES ('$receiver_phone', '$message', 'Sent', '$parcel_id')";
        mysqli_query($conn, $log_sql);
    }

    // Update parcel status
    $sql = "UPDATE parcels SET status = '$status' WHERE parcel_id = '$parcel_id'";
    mysqli_query($conn, $sql);

    mysqli_close($conn);
    header("Location: ../agent_dashboard/view_couriers.php?status_updated=1");
}
?>
