<?php
include '../config/db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];
$sql = "SELECT q.*, a.appointment_date, d.name as doctor_name, t.start_time 
        FROM queue q 
        JOIN appointment a ON q.appointment_id = a.appointment_id 
        JOIN doctor d ON a.doctor_id = d.doctor_id 
        JOIN timeslot t ON a.timeslot_id = t.timeslot_id 
        WHERE a.patient_id = $patient_id 
        AND q.status != 'Done'
        ORDER BY a.appointment_date, q.token_number";
$queue = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Queue - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../common/navbar.php'; ?>
    <div class="container mt-5">
        <h2>My Queue Status</h2>
        <div class="row mt-4">
            <?php if ($queue->num_rows > 0): ?>
                <?php while ($row = $queue->fetch_assoc()): ?>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>Token #<?php echo $row['token_number']; ?></h5>
                            <p>Doctor: <?php echo $row['doctor_name']; ?></p>
                            <p>Date: <?php echo $row['appointment_date']; ?></p>
                            <p>Time: <?php echo $row['start_time']; ?></p>
                            <p>Status: <span class="badge badge-<?php echo $row['status'] == 'Waiting' ? 'warning' : 'info'; ?>">
                                <?php echo $row['status']; ?>
                            </span></p>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">No active queue entries.</div>
                </div>
            <?php endif; ?>
        </div>
        <a href="patient_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
    <?php include '../common/footer.php'; ?>