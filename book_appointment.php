<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
<title>Book Appointment</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Book Appointment</h2>

<form action="book_process.php" method="POST">

<!-- SPECIALIZATION -->
<select id="specialization" class="form-control mb-3">
<option value="">Select Specialization</option>
<?php
$res = $conn->query("SELECT DISTINCT specialization FROM doctor");
while($row = $res->fetch_assoc()){
echo "<option value='".$row['specialization']."'>".$row['specialization']."</option>";
}
?>
</select>

<!-- DOCTOR -->
<select name="doctor_id" id="doctor" class="form-control mb-3" required>
<option value="">Select Doctor</option>
<?php
$res = $conn->query("SELECT doctor_id, first_name, specialization FROM doctor");
while($row = $res->fetch_assoc()){
echo "<option value='".$row['doctor_id']."' data-spec='".$row['specialization']."'>".$row['first_name']."</option>";
}
?>
</select>

<!-- DOCTOR SCHEDULE (NEW FIX) -->
<div id="scheduleBox" class="mb-3"></div>

<!-- DATE -->
<input type="date" name="appointment_date" id="date"
class="form-control mb-3"
min="<?php echo date('Y-m-d'); ?>" required>

<!-- BRANCH -->
<select name="branch_id" id="branch" class="form-control mb-3" required>
<option value="">Select Branch</option>
</select>

<!-- SLOT -->
<select name="slot_id" id="slot" class="form-control mb-3" required>
<option value="">Select Time Slot</option>
</select>

<!-- REASON -->
<textarea name="reason_for_visit" class="form-control mb-3"
placeholder="Reason for visit" required></textarea>

<button class="btn btn-success">Book Appointment</button>

</form>

</div>

<script>

const spec = document.getElementById("specialization");
const doctor = document.getElementById("doctor");
const branch = document.getElementById("branch");
const date = document.getElementById("date");
const slot = document.getElementById("slot");
const scheduleBox = document.getElementById("scheduleBox");

const allDoctors = Array.from(doctor.options);

// ---------------- FILTER DOCTOR ----------------
spec.addEventListener("change", () => {

doctor.innerHTML = '<option value="">Select Doctor</option>';

allDoctors.forEach(d => {
if (!d.value) return;
if (d.getAttribute("data-spec") === spec.value) {
doctor.appendChild(d);
}
});

scheduleBox.innerHTML = "";
branch.innerHTML = '<option value="">Select Branch</option>';
slot.innerHTML = '<option value="">Select Time Slot</option>';
});

// ---------------- LOAD SCHEDULE ----------------
function loadSchedule(){

let d = doctor.value;

scheduleBox.innerHTML = "";

if(!d) return;

fetch("get_doctor_schedule.php?doctor_id=" + d)
.then(res => res.json())
.then(data => {

if(data.length === 0){
scheduleBox.innerHTML = "<div class='alert alert-danger'>No schedule found</div>";
return;
}

let html = `
<h5>Doctor Schedule</h5>
<table class="table table-bordered">
<tr>
<th>Branch</th>
<th>Day</th>
<th>Start</th>
<th>End</th>
</tr>
`;

data.forEach(s => {
html += `
<tr>
<td>${s.branch_name}</td>
<td>${s.day_of_week}</td>
<td>${s.start_time}</td>
<td>${s.end_time}</td>
</tr>
`;
});

html += "</table>";

scheduleBox.innerHTML = html;

});
}

// ---------------- LOAD BRANCH ----------------
function loadBranchSchedule(){

let d = doctor.value;
let dt = date.value;

branch.innerHTML = '<option value="">Select Branch</option>';
slot.innerHTML = '<option value="">Select Time Slot</option>';

if(!d || !dt) return;

fetch(`get_branches.php?doctor_id=${d}&date=${dt}`)
.then(r=>r.json())
.then(data=>{

if(data.length === 0){
scheduleBox.innerHTML += "<div class='alert alert-warning'>Doctor not available on this date</div>";
return;
}

data.forEach(b=>{
let opt = document.createElement("option");
opt.value = b.branch_id;
opt.text = b.branch_name;
branch.appendChild(opt);
});

});
}

// ---------------- LOAD SLOT ----------------
branch.addEventListener("change", ()=>{

let d = doctor.value;
let dt = date.value;
let b = branch.value;

slot.innerHTML = '<option value="">Select Time Slot</option>';

fetch(`get_slots.php?doctor_id=${d}&date=${dt}&branch_id=${b}`)
.then(r=>r.json())
.then(data=>{

if(data.length === 0){
slot.innerHTML = '<option>No slots available</option>';
return;
}

data.forEach(s=>{
let opt = document.createElement("option");
opt.value = s.slot_id;
opt.text = s.start_time + " - " + s.end_time;
slot.appendChild(opt);
});

});

});

doctor.addEventListener("change", ()=>{
loadSchedule();
loadBranchSchedule();
});

date.addEventListener("change", loadBranchSchedule);

</script>

</body>
</html>