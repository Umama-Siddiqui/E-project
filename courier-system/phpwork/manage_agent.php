<?php
// DB connection
include '../db_connection.php';

// Helper: sanitize
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// Add Agent
$add_error = $add_success = '';
if (isset($_POST['add_agent'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password']; // Plain text (consider hashing in production)
    $branch = intval($_POST['branch']);

    if ($name && $email && $password && $branch) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $add_error = "Invalid email format.";
        } elseif (strlen($password) < 6) {
            $add_error = "Password must be at least 6 characters.";
        } else {
            $check = $conn->prepare("SELECT agent_id FROM agents WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();
            if ($check->num_rows > 0) {
                $add_error = "Email already exists.";
            } else {
                $stmt = $conn->prepare("INSERT INTO agents (full_name, email, password, branch_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $name, $email, $password, $branch);
                if ($stmt->execute()) {
                    $add_success = "Agent added successfully.";
                } else {
                    $add_error = "Error adding agent.";
                }
                $stmt->close();
            }
            $check->close();
        }
    } else {
        $add_error = "All fields are required.";
    }
}

// Delete Agent
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM agents WHERE agent_id = $id");
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Edit Agent
$edit_error = $edit_success = '';
if (isset($_POST['edit_agent'])) {
    $id = intval($_POST['id']);
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $branch = intval($_POST['branch']);
    $password = $_POST['password'];

    $update_sql = "UPDATE agents SET full_name=?, email=?, branch_id=?";
    $params = [$name, $email, $branch];
    $types = "ssi";

    if (!empty($password)) {
        if (strlen($password) < 6) {
            $edit_error = "Password must be at least 6 characters.";
        } else {
            $update_sql .= ", password=?";
            $params[] = $password;
            $types .= "s";
        }
    }

    $update_sql .= " WHERE agent_id=?";
    $params[] = $id;
    $types .= "i";

    if (!$edit_error) {
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            $edit_success = "Agent updated successfully.";
        } else {
            $edit_error = "Error updating agent.";
        }
        $stmt->close();
    }
}

// Fetch branches for dropdown
$branch_options = [];
$branches_query = $conn->query("SELECT * FROM branches");
while ($row = $branches_query->fetch_assoc()) {
    $branch_options[$row['branch_id']] = $row['branch_name'];
}

// Fetch agents with branch names
$agents = $conn->query("
  SELECT a.*, b.branch_name 
  FROM agents a
  LEFT JOIN branches b ON a.branch_id = b.branch_id
  ORDER BY a.agent_id DESC
");
?>
