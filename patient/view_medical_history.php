<?php
include '../config/db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];
$sql = "SELECT mh.*, d.name as doctor_name, mh.created_at 
        FROM medical_history mh 
        JOIN doctor d ON mh.doctor_id = d.doctor_id 
        WHERE mh.patient_id = $patient_id 
        ORDER BY mh.created_at DESC";
$history = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../common/navbar.php'; ?>
    <div class="container mt-5">
        <h2>Medical History</h2>
        <?php if ($history->num_rows > 0): ?>
            <?php while ($row = $history->fetch_assoc()): ?>
            <div class="card mt-3">
                <div class="card-header">
                    <h5><?php echo $row['doctor_name']; ?></h5>
                    <small class="text-muted"><?php echo $row['created_at']; ?></small>
                </div>
                <div class="card-body">
                    <h6>Diagnosis:</h6>
                    <p><?php echo $row['diagnosis']; ?></p>
                    <h6>Medicines:</h6>
                    <p><?php echo $row['medicines']; ?></p>
                    <h6>Tests:</h6>
                    <p><?php echo $row['tests']; ?></p>
                    <h6>Notes:</h6>
                    <p><?php echo $row['notes']; ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info mt-4">No medical history found.</div>
        <?php endif; ?>
        <a href="patient_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
    <?php include '../common/footer.php'; ?>