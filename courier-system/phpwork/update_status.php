<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parcel_id = mysqli_real_escape_string($conn, $_POST['parcel_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update status
    $sql = "UPDATE parcels SET status = '$status' WHERE parcel_id = '$parcel_id'";
    $result = mysqli_query($conn, $sql);
    header("Location: ../dashboard/view_couriers.php?status_updated=1");
 
    mysqli_close($conn);
}
?>
