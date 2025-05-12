<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parcel_id = mysqli_real_escape_string($conn, $_POST['parcel_id']);
    $receiver_name = mysqli_real_escape_string($conn, $_POST['receiver_name']);
    $receiver_address = mysqli_real_escape_string($conn, $_POST['receiver_address']);
    $receiver_phone = mysqli_real_escape_string($conn, $_POST['receiver_phone']);

    $sql = "UPDATE parcels SET 
                receiver_name = '$receiver_name',
                receiver_address = '$receiver_address',
                receiver_phone = '$receiver_phone'
            WHERE parcel_id = '$parcel_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../dashboard/view_couriers.php?success=1");
        exit();
    } else {
        echo "Error updating parcel: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
