<?php
session_start();
include("db.php");

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

$sql = "
SELECT m.*, d.first_name as doctor
FROM medical_history m
JOIN doctor d ON m.doctor_id = d.doctor_id
WHERE m.patient_id=?
ORDER BY m.visit_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
<h2>My Medical History</h2>

<table class="table table-bordered">
<tr class="table-primary">
<th>Date</th>
<th>Doctor</th>
<th>Diagnosis</th>
<th>Medicine</th>
<th>Tests</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?= $row['visit_date'] ?></td>
<td><?= $row['doctor'] ?></td>
<td><?= $row['diagnosis'] ?></td>
<td><?= $row['prescribed_medicine'] ?></td>
<td><?= $row['recommended_tests'] ?></td>
</tr>
<?php } ?>

</table>
</div>