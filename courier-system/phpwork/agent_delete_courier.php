<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parcel_id = mysqli_real_escape_string($conn, $_POST['parcel_id']);

    $sql = "DELETE FROM parcels WHERE parcel_id = '$parcel_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../agent_dashboard/view_couriers.php?deleted=1");
        exit();
    } else {
        echo "Error deleting parcel: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
