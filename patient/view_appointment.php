<?php
include '../config/db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$success = isset($_GET['success']) ? $_GET['success'] : 0;
$patient_id = $_SESSION['patient_id'];
$sql = "SELECT a.*, d.name as doctor_name, t.start_time, t.end_time, b.branch_name 
        FROM appointment a 
        JOIN doctor d ON a.doctor_id = d.doctor_id 
        JOIN timeslot t ON a.timeslot_id = t.timeslot_id 
        JOIN branch b ON a.branch_id = b.branch_id 
        WHERE a.patient_id = $patient_id 
        ORDER BY a.appointment_date DESC";
$appointments = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../common/navbar.php'; ?>
    <div class="container mt-5">
        <h2>My Appointments</h2>
        <?php if ($success): ?>
            <div class="alert alert-success">Appointment booked successfully!</div>
        <?php endif; ?>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['appointment_date']; ?></td>
                    <td><?php echo $row['start_time'] . ' - ' . $row['end_time']; ?></td>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><span class="badge badge-<?php echo $row['status'] == 'Completed' ? 'success' : 'warning'; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                        <a href="../actions/cancel_appointment.php?id=<?php echo $row['appointment_id']; ?>" class="btn btn-sm btn-danger">Cancel</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <?php include '../common/footer.php'; ?>