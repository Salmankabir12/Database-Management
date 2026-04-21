<?php
session_start();
include("db.php");

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

// ✅ IMPROVED QUERY (UPCOMING FIRST + ASC ORDER)
$sql = "SELECT a.*, d.first_name AS doctor_name, b.branch_name, t.start_time, t.end_time
FROM appointment a
JOIN doctor d ON a.doctor_id = d.doctor_id
JOIN branch b ON a.branch_id = b.branch_id
JOIN timeslot t ON a.slot_id = t.slot_id
WHERE a.patient_id = ?
ORDER BY 
(a.appointment_date >= CURDATE()) DESC,
a.appointment_date ASC,
t.start_time ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>My Appointments</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Doctor</th>
    <th>Branch</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { 

    // 🎨 STATUS COLORS
    $status = $row['appointment_status'];
    $color = "";

    if ($status == "Pending") {
        $color = "orange";
    } elseif ($status == "Confirmed") {
        $color = "blue";
    } elseif ($status == "Completed") {
        $color = "green";
    } elseif ($status == "Cancelled") {
        $color = "red";
    }
?>

<tr>
    <td><?php echo $row['doctor_name']; ?></td>
    <td><?php echo $row['branch_name']; ?></td>
    <td><?php echo $row['appointment_date']; ?></td>
    <td><?php echo $row['start_time'] . " - " . $row['end_time']; ?></td>

    <!-- 🎨 COLORED STATUS -->
    <td style="color: <?php echo $color; ?>; font-weight: bold;">
        <?php echo $status; ?>
    </td>

    <!-- ❌ Cancel only if NOT completed/cancelled -->
    <td>
        <?php if ($status != "Completed" && $status != "Cancelled") { ?>
            <a href="cancel_appointment.php?id=<?php echo $row['appointment_id']; ?>">Cancel</a>
        <?php } else { ?>
            -
        <?php } ?>
    </td>
</tr>

<?php } ?>

</table>

<?php
$stmt->close();
$conn->close();
?>