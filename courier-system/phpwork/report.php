<?php
include '../db_connection.php';

$filters = [];
$params = [];
$where = "WHERE 1=1";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Date range filter
    if (!empty($_POST['from_date']) && !empty($_POST['to_date'])) {
        $filters[] = "p.created_at BETWEEN ? AND ?";
        $params[] = $_POST['from_date'];
        $params[] = $_POST['to_date'];
    }

    // Status filter
    if (!empty($_POST['status']) && $_POST['status'] !== 'All') {
        $filters[] = "p.status = ?";
        $params[] = $_POST['status'];
    }

    // Branch filter (either from or to)
    if (!empty($_POST['branch'])) {
        $filters[] = "(p.branch_from = ? OR p.branch_to = ?)";
        $params[] = $_POST['branch'];
        $params[] = $_POST['branch'];
    }

    // Combine filters
    if (count($filters)) {
        $where .= " AND " . implode(" AND ", $filters);
    }
}

// Final SQL query with branch name joins
$sql = "SELECT 
            p.*, 
            bf.branch_name AS branch_from_name, 
            bt.branch_name AS branch_to_name
        FROM parcels p
        LEFT JOIN branches bf ON p.branch_from = bf.branch_id
        LEFT JOIN branches bt ON p.branch_to = bt.branch_id
        $where";

// Prepare and bind if there are params
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    // Generate types string (e.g. 'sss' for 3 string params)
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>
