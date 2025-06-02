<?php
include '../phpwork/auth_check.php';

if ($_SESSION['role'] !== 'agent') {
    header("Location: ../index.php"); // ya agent dashboard par redirect karo
    exit;
}
?>
