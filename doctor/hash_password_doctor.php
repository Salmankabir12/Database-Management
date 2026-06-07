<?php
include '../config/db.php';
$password = "1234";
$hashed = password_hash($password, PASSWORD_DEFAULT);
echo "<h3>Generated Hash:</h3><p>$hashed</p>";
$stmt = $conn->prepare("UPDATE doctor SET password=?");
$stmt->bind_param("s", $hashed);
echo $stmt->execute() ? "<h3 style='color:green;'>Passwords updated successfully!</h3>" : "Error updating password";
