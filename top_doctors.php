<?php
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Top Doctor</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="text-dark">Most Experienced Doctor</h2>

<?php
$sql = "SELECT first_name, last_name, experience_years
FROM doctor
WHERE experience_years = (
    SELECT MAX(experience_years) FROM doctor
)";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    echo "<div class='alert alert-info'>
    Dr. {$row['first_name']} {$row['last_name']} 
    ({$row['experience_years']} years experience)
    </div>";
}
?>

</div>
</body>
</html>