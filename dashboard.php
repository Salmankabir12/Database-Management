<?php
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['patient_name']; ?> </h2>

<!-- ✅ UPDATED NAVIGATION -->
<p>
    <a href="dashboard.php">🏠 Home</a> |
    <a href="book_appointment.php">📅 Book Appointment</a> |
    <a href="view_appointment.php">📋 My Appointments</a> |
    <a href="my_queue.php">🎟 My Queue</a> |
    <a href="view_medical_history.php">🩺 Medical History</a> |
    <a href="logout.php">🚪 Logout</a>
</p>

</body>
</html>