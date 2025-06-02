<?php
include '../db_connection.php';

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
?>
