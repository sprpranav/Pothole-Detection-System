<?php
$host = "localhost";
$dbname = "pothole_system";
$username = "root";  // Change this if needed
$password = "";      // Change this if needed

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
