<?php
include '../phpwork/auth_check.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // ya agent dashboard par redirect karo
    exit;
}
?>
