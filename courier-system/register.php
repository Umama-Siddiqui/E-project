<?php
include 'db_connection.php';

if (isset($_POST['register'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = trim($_POST['address']);
    $role = 'customer';

    // Check if email already exists
    $check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: index.php?register_error=Email already registered!");
        exit;
    }

    // Password match check
    if ($password !== $confirm_password) {
        header("Location: index.php?register_error=Passwords do not match!");
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user (with address)
    $insert_query = "INSERT INTO users (full_name, email, password, role, address) 
                     VALUES ('$full_name', '$email', '$hashed_password', '$role', '$address')";

    if (mysqli_query($conn, $insert_query)) {
        header("Location: index.php?success=Registration successful!");
    } else {
        header("Location: index.php?register_error=Something went wrong!");
    }
}
?>
