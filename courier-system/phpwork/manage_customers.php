<?php


// Handle Add Customer
if (isset($_POST['add_customer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $reg_date = date("Y-m-d");

    $sql = "INSERT INTO customers (name, email, phone, password, registration_date) VALUES ('$name', '$email', '$phone', '$password', '$reg_date')";
    $conn->query($sql);
}

// Handle Edit Customer
if (isset($_POST['edit_customer'])) {
    $id = $_POST['customer_id'];
    $name = $_POST['edit_name'];
    $email = $_POST['edit_email'];
    $phone = $_POST['edit_phone'];

    $sql = "UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE customer_id='$id'";
    $conn->query($sql);
}

// Handle Delete Customer
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM customers WHERE customer_id='$id'");
}

// Fetch customers
$customers = $conn->query("SELECT * FROM customers ORDER BY customer_id DESC");
?>
