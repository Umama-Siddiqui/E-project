<?php
include '../db_connection.php';

if (isset($_POST['delete_customer'])) {
    $user_id = $_POST['user_id'];

    // Check if the user exists and is a customer
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ? AND role = 'customer'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $delete->bind_param("i", $user_id);

        if ($delete->execute()) {
            header("Location: ../dashboard/manage_customers.php?deleted=1");
        } else {
            echo "<script>alert('Error deleting customer.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Customer not found or invalid role.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
