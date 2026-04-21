<?php 
include("db.php");

$password = "1234";

// generate hash
$hashed = password_hash($password, PASSWORD_DEFAULT);

// show hash (🔥 THIS WAS MISSING)
echo "<h3>Generated Hash:</h3>";
echo "<p>$hashed</p>";

// update doctor password
$sql = "UPDATE doctor SET password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashed);

if ($stmt->execute()) {
    echo "<h3 style='color:green;'>Passwords updated successfully!</h3>";
} else {
    echo "Error updating password";
}
?>