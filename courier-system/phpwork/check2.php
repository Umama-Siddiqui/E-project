<?php
include '../phpwork/auth_check.php';

if ($_SESSION['role'] !== 'agent') {
    header("Location: ../login.php"); // ya agent dashboard par redirect karo
    exit;
}
?>
