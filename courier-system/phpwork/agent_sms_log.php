<?php
include '../db_connection.php';
session_start(); // Add this if not already present
$branch_id = $_SESSION['branch_id'];

$conditions = ["p.branch_from = ?"];
$params = [$branch_id];
$types = "i";

// Pagination setup
$logs_per_page = 20;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $logs_per_page;

// Filters
if (!empty($_GET['mobile'])) {
    $conditions[] = "s.phone_number LIKE ?";
    $params[] = "%" . $_GET['mobile'] . "%";
    $types .= "s";
}

if (!empty($_GET['from']) && !empty($_GET['to'])) {
    $conditions[] = "DATE(s.timestamp) BETWEEN ? AND ?";
    $params[] = $_GET['from'];
    $params[] = $_GET['to'];
    $types .= "ss";
}

if (!empty($_GET['status']) && $_GET['status'] !== 'All') {
    $conditions[] = "s.status = ?";
    $params[] = $_GET['status'];
    $types .= "s";
}

// Combine conditions
$where = "WHERE " . implode(" AND ", $conditions);

// Count total logs
$count_sql = "
    SELECT COUNT(*) as total 
    FROM sms_logs s
    JOIN parcels p ON s.reference_id = p.parcel_id
    $where
";
$count_stmt = $conn->prepare($count_sql);
if ($count_stmt) {
    $count_stmt->bind_param($types, ...$params);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $row = $count_result->fetch_assoc();
    $total_logs = $row['total'];
    $count_stmt->close();
} else {
    die("Count Query Failed: " . $conn->error);
}

// Calculate total pages
$total_pages = ceil($total_logs / $logs_per_page);

// Fetch logs with LIMIT
$sql = "
    SELECT s.* 
    FROM sms_logs s
    JOIN parcels p ON s.reference_id = p.parcel_id
    $where
    ORDER BY s.timestamp DESC
    LIMIT ?, ?
";
$stmt = $conn->prepare($sql);

$sms_logs = [];

if ($stmt) {
    $params_with_pagination = $params;
    $params_with_pagination[] = $offset;
    $params_with_pagination[] = $logs_per_page;
    $types_with_pagination = $types . "ii";

    $stmt->bind_param($types_with_pagination, ...$params_with_pagination);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $sms_logs[] = $row;
    }
    $stmt->close();
} else {
    die("Main Query Failed: " . $conn->error);
}
?>
