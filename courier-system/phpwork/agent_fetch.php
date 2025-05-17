<?php
// session_start();
include "../db_connection.php";

// Agent ID session se
$agent_id = $_SESSION['user_id'] ?? null;
if (!$agent_id) {
    die("Agent not logged in.");
}

// 1️⃣ Agent ki branch_id lein
$stmt = $conn->prepare("SELECT branch_id FROM users WHERE user_id = ?");
$stmt->bind_param("i", $agent_id);
$stmt->execute();
$stmt->bind_result($agent_branch_id);
$stmt->fetch();
$stmt->close();

if (!$agent_branch_id) {
    die("Branch ID not found for agent.");
}

// 2️⃣ Total parcels for that branch
$stmt = $conn->prepare("SELECT COUNT(*) FROM parcels WHERE branch_from = ?");
$stmt->bind_param("i", $agent_branch_id);
$stmt->execute();
$stmt->bind_result($total_parcels);
$stmt->fetch();
$stmt->close();


// 5️⃣ Parcels by status (Booked)
$stmt = $conn->prepare("SELECT COUNT(*) FROM parcels WHERE status = 'Booked' AND branch_from = ?");
$stmt->bind_param("i", $agent_branch_id);
$stmt->execute();
$stmt->bind_result($booked_parcels);
$stmt->fetch();
$stmt->close();

// 6️⃣ Parcels by status (In Transit)
$stmt = $conn->prepare("SELECT COUNT(*) FROM parcels WHERE status = 'In Transit' AND branch_from = ?");
$stmt->bind_param("i", $agent_branch_id);
$stmt->execute();
$stmt->bind_result($in_transit_parcels);
$stmt->fetch();
$stmt->close();

// 7️⃣ Parcels by status (Delivered)
$stmt = $conn->prepare("SELECT COUNT(*) FROM parcels WHERE status = 'Delivered' AND branch_from = ?");
$stmt->bind_param("i", $agent_branch_id);
$stmt->execute();
$stmt->bind_result($delivered_parcels);
$stmt->fetch();
$stmt->close();