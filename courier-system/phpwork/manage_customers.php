<?php
include '../db_connection.php';

$search = '';
$sql = "SELECT * FROM users WHERE role = 'customer'";  // sirf customers ka data
$params = [];
$types = '';

// Search filter
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " AND (full_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $like = "%" . $search . "%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types = 'sss';
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$customers = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();



if (isset($_POST['update_customer'])) {
    $user_id = $_POST['user_id'];
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Check for unique email and phone (excluding current user)
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE (email = ? OR phone = ?) AND user_id != ?");
    $stmt->bind_param("ssi", $email, $phone, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email/Phone already exists
        echo "<script>alert('Email or Phone already exists.'); window.history.back();</script>";
    } else {
        // Update
        $update = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ? WHERE user_id = ?");
        $update->bind_param("sssi", $name, $email, $phone, $user_id);

        if ($update->execute()) {
            header("Location: manage_customers.php?success=1");
        } else {
            echo "<script>alert('Update failed.'); window.history.back();</script>";
        }
    }

    $stmt->close();
    $conn->close();
}



if (isset($_POST['delete_customer'])) {
    $user_id = $_POST['user_id'];

    // Optionally: Check for existing parcels
    $check = $conn->prepare("SELECT COUNT(*) FROM parcels WHERE customer_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $check->bind_result($parcelCount);
    $check->fetch();
    $check->close();

    if ($parcelCount > 0) {
        // If you want to prevent delete when parcels exist
        echo "<script>alert('Customer has existing parcels. Cannot delete.'); window.history.back();</script>";
        // OR if you want to delete parcels too, do:
        // $conn->query("DELETE FROM parcels WHERE customer_id = $user_id");
    } else {
        $delete = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $delete->bind_param("i", $user_id);
        if ($delete->execute()) {
            header("Location: manage_customers.php?deleted=1");
        } else {
            echo "<script>alert('Delete failed.'); window.history.back();</script>";
        }
        $delete->close();
    }

    $conn->close();
}
?>
