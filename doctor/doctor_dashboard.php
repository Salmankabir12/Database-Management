<?php
include '../config/db.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];
$sql = "SELECT a.*, p.name as patient_name, t.start_time, t.end_time, b.branch_name 
        FROM appointment a 
        JOIN patient p ON a.patient_id = p.patient_id 
        JOIN timeslot t ON a.timeslot_id = t.timeslot_id 
        JOIN branch b ON a.branch_id = b.branch_id 
        WHERE a.doctor_id = $doctor_id 
        AND a.status IN ('Confirmed', 'Ongoing')
        ORDER BY a.appointment_date, t.start_time";
$appointments = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">Doctor Portal</a>
            <div class="navbar-nav ml-auto">
                <a class="nav-link" href="add_medical_history.php">Add Medical History</a>
                <a class="nav-link" href="../actions/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Welcome, Dr. <?php echo $_SESSION['doctor_name']; ?>!</h2>
        <h3 class="mt-4">Today's Appointments</h3>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['start_time'] . ' - ' . $row['end_time']; ?></td>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><span class="badge badge-<?php echo $row['status'] == 'Ongoing' ? 'info' : 'warning'; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>
                    <td>
                        <?php if ($row['status'] == 'Confirmed'): ?>
                        <a href="../actions/update_status.php?id=<?php echo $row['appointment_id']; ?>&status=Ongoing" class="btn btn-sm btn-primary">Start</a>
                        <?php else: ?>
                        <a href="../actions/update_status.php?id=<?php echo $row['appointment_id']; ?>&status=Completed" class="btn btn-sm btn-success">Complete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include '../common/footer.php'; ?>