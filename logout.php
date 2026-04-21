<?php
session_start();

$role_redirect = "login.php"; // default patient login

if (isset($_SESSION['doctor_id'])) {
    $role_redirect = "doctor_login.php";
}
elseif (isset($_SESSION['admin_id'])) {
    $role_redirect = "admin_login.php";
}

session_unset();
session_destroy();

header("Location: $role_redirect");
exit();
?>