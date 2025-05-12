<?php
include '../db_connection.php';

// Start query with JOINs
$sql = "SELECT 
            p.*, 
            bf.branch_name AS branch_from_name, 
            bt.branch_name AS branch_to_name
        FROM parcels p
        LEFT JOIN branches bf ON p.branch_from = bf.branch_id
        LEFT JOIN branches bt ON p.branch_to = bt.branch_id
        WHERE 1=1";

// Filter by consignment number
if (!empty($_GET['consignment_no'])) {
    $consignment_no = mysqli_real_escape_string($conn, $_GET['consignment_no']);
    $sql .= " AND p.consignment_no LIKE '%$consignment_no%'";
}

// Filter by sender or receiver name
if (!empty($_GET['name'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $sql .= " AND (p.sender_name LIKE '%$name%' OR p.receiver_name LIKE '%$name%')";
}

// Filter by sender or receiver address (city-based search)
if (!empty($_GET['city'])) {
    $city = mysqli_real_escape_string($conn, $_GET['city']);
    $sql .= " AND (p.sender_address LIKE '%$city%' OR p.receiver_address LIKE '%$city%')";
}

// Filter by date range
if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $from = mysqli_real_escape_string($conn, $_GET['from_date']);
    $to = mysqli_real_escape_string($conn, $_GET['to_date']);
    $sql .= " AND p.created_at BETWEEN '$from' AND '$to'";
}

// Additional filter by specific city
if (!empty($_GET['filter_city'])) {
    $f_city = mysqli_real_escape_string($conn, $_GET['filter_city']);
    $sql .= " AND (p.sender_address LIKE '%$f_city%' OR p.receiver_address LIKE '%$f_city%')";
}

// Filter by status
if (!empty($_GET['status'])) {
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    $sql .= " AND p.status = '$status'";
}

$sql .= " ORDER BY p.created_at DESC";

$result = mysqli_query($conn, $sql);

// Result handling
if (mysqli_num_rows($result) > 0) {
    $parcels = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $parcels = [];
}

mysqli_close($conn);
?>
<?php
include '../db_connection.php';

$limit = 10; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

$sql = "SELECT * FROM parcels ORDER BY created_at DESC LIMIT $start_from, $limit";
$result = mysqli_query($conn, $sql);

// Total rows for pagination count
$total_sql = "SELECT COUNT(parcel_id) FROM parcels";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_row($total_result);
$total_pages = ceil($total_row[0] / $limit);

mysqli_close($conn);
?>
