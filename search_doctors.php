<?php
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Search Doctor</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<h2 class="text-primary">Search Doctor</h2>

<form method="GET" class="mb-4">
<input type="text" name="search" class="form-control" placeholder="Enter specialization">
<button class="btn btn-success mt-2">Search</button>
</form>

<table class="table table-bordered">
<tr>
<th>Name</th>
<th>Specialization</th>
</tr>

<?php
if(isset($_GET['search'])){
    $search = $_GET['search'];

    $sql = "SELECT * FROM doctor 
            WHERE specialization LIKE '%$search%'";

    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()){
        echo "<tr>
        <td>{$row['first_name']} {$row['last_name']}</td>
        <td>{$row['specialization']}</td>
        </tr>";
    }
}
?>

</table>

</div>
</body>
</html>