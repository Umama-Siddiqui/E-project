<?php
include "../db_connection.php"
?>



<?php
$result = mysqli_query($conn, "SELECT COUNT(*) AS total_parcels FROM parcels");
$data = mysqli_fetch_assoc($result);
$total_parcels = $data['total_parcels'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total_agents FROM agents");
$data = mysqli_fetch_assoc($result);
$total_agents = $data['total_agents'];


$result = mysqli_query($conn, "SELECT COUNT(*) AS total_customers FROM customers");
$data = mysqli_fetch_assoc($result);
$total_customers = $data['total_customers'];

?>
<?php
// Booked Parcels
$booked_result = mysqli_query($conn, "SELECT COUNT(*) AS booked FROM parcels WHERE status = 'Booked'");
$booked_parcels = mysqli_fetch_assoc($booked_result)['booked'] ?? 0;

// In Transit Parcels
$transit_result = mysqli_query($conn, "SELECT COUNT(*) AS transit FROM parcels WHERE status = 'In Transit'");
$in_transit_parcels = mysqli_fetch_assoc($transit_result)['transit'] ?? 0;

// Delivered Parcels
$delivered_result = mysqli_query($conn, "SELECT COUNT(*) AS delivered FROM parcels WHERE status = 'Delivered'");
$delivered_parcels = mysqli_fetch_assoc($delivered_result)['delivered'] ?? 0;
?>
