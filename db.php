<?php
$host = "localhost";
$user = "root";
$password = ""; // default XAMPP password is empty
$database = "healthcare_system";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8");

?>