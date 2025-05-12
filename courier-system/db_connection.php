<?php
// Database credentials
$servername = "localhost";
$username = "root";  // Default username for MySQL
$password = "";  // Default password for MySQL
$dbname = "courier_management";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
