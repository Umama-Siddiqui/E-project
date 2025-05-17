<?php
// DB connection
include '../db_connection.php';

// Helper: sanitize
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// Initialize messages
$add_error = $add_success = '';
$edit_error = $edit_success = '';

// ==== ADD AGENT ====
if (isset($_POST['add_agent'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password']; // Plain text from form
    $branch = intval($_POST['branch']);

    if ($name && $email && $password && $branch) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $add_error = "Invalid email format.";
        } elseif (strlen($password) < 6) {
            $add_error = "Password must be at least 6 characters.";
        } else {
            // Check if email exists in users table with role 'agent'
            $check = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND role = 'agent'");
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();
            if ($check->num_rows > 0) {
                $add_error = "Email already exists.";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role, branch_id) VALUES (?, ?, ?, 'agent', ?)");
                $stmt->bind_param("sssi", $name, $email, $hashed_password, $branch);
                if ($stmt->execute()) {
                    $add_success = "Agent added successfully.";
                } else {
                    $add_error = "Error adding agent: " . $stmt->error;
                }
                $stmt->close();
            }
            $check->close();
        }
    } else {
        $add_error = "All fields are required.";
    }
}

// ==== DELETE AGENT ====
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Delete only if role = 'agent' for safety
    $del_stmt = $conn->prepare("DELETE FROM users WHERE user_id = ? AND role = 'agent'");
    $del_stmt->bind_param("i", $id);
    $del_stmt->execute();
    $del_stmt->close();

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// ==== EDIT AGENT ====
if (isset($_POST['edit_agent'])) {
    $id = intval($_POST['id']);  // user_id from form
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $branch = intval($_POST['branch']);
    $password = $_POST['password'];

    if ($name && $email && $branch) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $edit_error = "Invalid email format.";
        } else {
            // Start building update query and params
            $update_sql = "UPDATE users SET full_name = ?, email = ?, branch_id = ? WHERE user_id = ? AND role = 'agent'";
            $params = [$name, $email, $branch, $id];
            $types = "ssii";

            // If password is provided, validate and hash it, then add to update query
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $edit_error = "Password must be at least 6 characters.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $update_sql = "UPDATE users SET full_name = ?, email = ?, branch_id = ?, password = ? WHERE user_id = ? AND role = 'agent'";
                    $params = [$name, $email, $branch, $hashed_password, $id];
                    $types = "ssssi";
                }
            }

            if (!$edit_error) {
                $stmt = $conn->prepare($update_sql);
                if ($stmt === false) {
                    $edit_error = "Prepare failed: " . $conn->error;
                } else {
                    $stmt->bind_param($types, ...$params);
                    if ($stmt->execute()) {
                        $edit_success = "Agent updated successfully.";
                    } else {
                        $edit_error = "Update failed: " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
        }
    } else {
        $edit_error = "Name, Email and Branch are required.";
    }
}

// ==== FETCH BRANCHES FOR DROPDOWN ====
$branch_options = [];
$branches_query = $conn->query("SELECT * FROM branches ORDER BY branch_name");
while ($row = $branches_query->fetch_assoc()) {
    $branch_options[$row['branch_id']] = $row['branch_name'];
}

// ==== FETCH AGENTS WITH BRANCH NAME ====
$agents = $conn->query("
    SELECT u.*, b.branch_name 
    FROM users u
    LEFT JOIN branches b ON u.branch_id = b.branch_id
    WHERE u.role = 'agent'
    ORDER BY u.user_id DESC
");

?>
