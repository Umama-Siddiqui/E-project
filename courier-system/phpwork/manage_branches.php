<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $branch_name = trim($_POST['branch_name']);
    $location = trim($_POST['address']);

    // Validation
    if (empty($branch_name)) {
        die("Branch name is required.");
    }

    // Check for duplicate
    $stmt = $conn->prepare("SELECT * FROM branches WHERE branch_name = ?");
    $stmt->bind_param("s", $branch_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Branch already exists!");
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO branches (branch_name, address) VALUES (?, ?)");
    $stmt->bind_param("ss", $branch_name, $location);

    if ($stmt->execute()) {
        echo "Branch added successfully!";
    } else {
        echo "Error adding branch: " . $conn->error;
    }
}
function getBranches($conn) {
    $branches = [];

    $sql = "SELECT * FROM branches ORDER BY branch_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $branches[] = $row;
    }

    return $branches;
}

$branches = getBranches($conn);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $branch_id = intval($_POST['branch_id']);
    $branch_name = trim($_POST['branch_name']);
    $city = trim($_POST['city']);
    $address = trim($_POST['address']);

    if (empty($branch_name)) {
        exit('Branch name is required.');
    }

    // Duplicate check except current branch
    $stmt = $conn->prepare("SELECT COUNT(*) FROM branches WHERE branch_name = ? AND branch_id != ?");
    $stmt->bind_param("si", $branch_name, $branch_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        exit('Branch name already exists.');
    }

    // Update query
    $stmt = $conn->prepare("UPDATE branches SET branch_name = ?, city = ?, address = ? WHERE branch_id = ?");
    $stmt->bind_param("sssi", $branch_name, $city, $address, $branch_id);

    if ($stmt->execute()) {
        header("Location: branches.php?msg=updated");
        exit;
    } else {
        exit("Database update error: " . $conn->error);
    }
}





if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $branch_id = intval($_POST['branch_id']);

    // Check if agents assigned to this branch
    $stmt = $conn->prepare("SELECT COUNT(*) FROM agents WHERE branch_id = ?");
    $stmt->bind_param("i", $branch_id);
    $stmt->execute();
    $stmt->bind_result($count_agents);
    $stmt->fetch();
    $stmt->close();

    if ($count_agents > 0) {
        exit('Cannot delete branch. There are agents assigned to this branch.');
    }

    // Delete branch if no agents linked
    $stmt = $conn->prepare("DELETE FROM branches WHERE branch_id = ?");
    $stmt->bind_param("i", $branch_id);

    if ($stmt->execute()) {
        header("Location: branches.php?msg=deleted");
        exit;
    } else {
        exit("Error deleting branch: " . $conn->error);
    }
}
  $branchIdToViewAgents = isset($_GET['view_agents']) ? intval($_GET['view_agents']) : null;

// Fetch all branches
$branches = mysqli_query($conn, "SELECT * FROM branches ORDER BY branch_id ");

// Fetch agents if branch id given
$agents = [];
if ($branchIdToViewAgents) {
    $stmt = $conn->prepare("SELECT user_id, full_name, email, phone, created_at FROM users WHERE branch_id = ? AND role = 'agent' ORDER BY created_at DESC");
    $stmt->bind_param("i", $branchIdToViewAgents);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $agents[] = $row;
    }
    $stmt->close();

    // Get branch name for modal title
    $branchNameRow = $conn->query("SELECT branch_name FROM branches WHERE branch_id = $branchIdToViewAgents")->fetch_assoc();
    $branchName = $branchNameRow ? $branchNameRow['branch_name'] : '';
}






?>