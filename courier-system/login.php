<?php
session_start();
include 'db_connection.php';

$error = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['branch_id'] = $user['branch_id'];

            if ($user['role'] == 'admin') {
                header("Location: dashboard/admin.php");
            } elseif ($user['role'] == 'agent') {
                header("Location: agent_dashboard/agent.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>




