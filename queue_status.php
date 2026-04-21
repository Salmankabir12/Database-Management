<?php
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Queue Status</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- ✅ SIMPLIFIED NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
<div class="container-fluid">
<a class="navbar-brand fw-bold" href="#">Healthcare System</a>
</div>
</nav>

<div class="container mt-5">

<h2 class="text-primary mb-4">Queue Status</h2>

<?php
// 🟢 1. NOW SERVING
$serving = $conn->query("
SELECT queue_number
FROM queue
WHERE queue_status='Serving'
ORDER BY queue_number ASC
LIMIT 1
");

echo "<h4 class='mt-4'>Now Serving:</h4>";

if ($serving && $serving->num_rows > 0) {
    $row = $serving->fetch_assoc();
    echo "<div class='alert alert-success shadow'>Token ".$row['queue_number']."</div>";
} else {
    echo "<div class='alert alert-warning shadow'>No one is being served</div>";
}

// 🟢 2. WAITING LIST
$waiting = $conn->query("
SELECT queue_number
FROM queue
WHERE queue_status='Waiting'
ORDER BY queue_number ASC
");

echo "<h4 class='mt-4'>Waiting List:</h4>";

if ($waiting && $waiting->num_rows > 0) {
    echo "<ul class='list-group mb-4 shadow'>";
    while($row = $waiting->fetch_assoc()){
        echo "<li class='list-group-item'>Token ".$row['queue_number']."</li>";
    }
    echo "</ul>";
} else {
    echo "<div class='alert alert-info shadow'>No waiting patients</div>";
}

// 🟢 3. COMPLETED
$done = $conn->query("
SELECT queue_number
FROM queue
WHERE queue_status='Done'
ORDER BY queue_number ASC
");

echo "<h4 class='mt-4'>Completed:</h4>";

if ($done && $done->num_rows > 0) {
    echo "<ul class='list-group shadow'>";
    while($row = $done->fetch_assoc()){
        echo "<li class='list-group-item'>Token ".$row['queue_number']."</li>";
    }
    echo "</ul>";
} else {
    echo "<div class='alert alert-secondary shadow'>No completed patients</div>";
}
?>

</div>
</body>
</html>