<?php
include("db.php");

$password = "1234"; // your current password
$hashed = password_hash($password, PASSWORD_DEFAULT);

echo $hashed;
?>