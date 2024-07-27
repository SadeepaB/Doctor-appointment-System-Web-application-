<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch doctor details
$doctor_query = "SELECT * FROM doctor WHERE id = ?";
$stmt = $con->prepare($doctor_query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

// Check if doctor image exists
$doctor_image = !empty($doctor['doctor_image']) ? $doctor['doctor_image'] : "../images/profileicon.png";

// Fetch status counts
$all_doctors_query = "SELECT COUNT(*) AS total_doctors FROM doctor";
$all_doctors_result = $con->query($all_doctors_query);
$total_doctors = $all_doctors_result->fetch_assoc()['total_doctors'];

$all_patients_query = "SELECT COUNT(DISTINCT u.id) AS total_patients FROM users u JOIN appointment a ON u.id = a.user_id WHERE a.doctor_id = ?";
$stmt = $con->prepare($all_patients_query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$all_patients_result = $stmt->get_result();
$total_patients = $all_patients_result->fetch_assoc()['total_patients'];

$new_appointments_query = "SELECT COUNT(*) AS new_appointments FROM appointment WHERE doctor_id = ? AND date >= CURDATE()";
$stmt = $con->prepare($new_appointments_query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$new_appointments_result = $stmt->get_result();
$new_appointments = $new_appointments_result->fetch_assoc()['new_appointments'];

$all_appointments_query = "SELECT COUNT(*) AS all_appointments FROM appointment WHERE doctor_id = ?";
$stmt = $con->prepare($all_appointments_query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$all_appointments_result = $stmt->get_result();
$all_appointments = $all_appointments_result->fetch_assoc()['all_appointments'];

// Fetch upcoming appointments
$appointments_query = "SELECT a.*, u.first_name, u.last_name 
                       FROM appointment a 
                       JOIN users u ON a.user_id = u.id 
                       WHERE a.doctor_id = ? AND a.date > CURDATE() OR (a.date = CURDATE() AND a.time > CURRENT_TIME)
                       ORDER BY a.date, a.time";
$stmt = $con->prepare($appointments_query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$appointments_result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];

    $cancel_query = "DELETE FROM appointment WHERE appointment_id = ?";
    $stmt = $con->prepare($cancel_query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .status {
            max-width: 400px;
        }
        .status-item, .doctor-profile {
            transition: transform 0.3s ease;
        }
        .status-item:hover, .doctor-profile:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #6295a2;">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../images/logo.png" alt="Logo" width="50" height="40">
            </a>
            <a class="navbar-brand" href="index.php">Edoca</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item active">
                        <a class="nav-link active" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="myappointment.php">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="patients.php">My Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="doctordashboard.php">Settings</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a href="doctordashboard.php"><img src="<?php echo $doctor_image; ?>" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40" style="border: 2px solid #fff;background-color: #000;"></a>
                        <a class="nav-link" href="../logout.php"><button class="btn btn-light">Logout</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex flex-column align-items-start">
                <span class="fs-4 mb-4"><strong>Doctor Profile</strong></span>
                <section class="doctor-profile text-center p-4 text-white rounded w-100" style="background-color:#6295a2;">
                    <img src="<?php echo htmlspecialchars($doctor_image); ?>" alt="Doctor Profile Picture" class="rounded-circle mb-3" style="width: 150px;">
                    <h2><?php echo htmlspecialchars($doctor['name']); ?></h2>
                    <p><?php echo htmlspecialchars($doctor['specialization']); ?></p>
                    <p><?php echo htmlspecialchars($doctor['hospital']); ?></p>
                </section>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex flex-column align-items-start">
                <span class="fs-4 mb-3"><strong>Status</strong></span>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="status-item text-center p-4 text-white rounded card" style="background-color:#6295a2;">
                            <p><strong>All Doctors</strong></p>
                            <p><strong><?php echo $total_doctors; ?></strong></p>
                            <i class="fa fa-user-md fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="status-item text-center p-4 text-white rounded card" style="background-color:#6295a2;">
                            <p><strong>All Patients</strong></p>
                            <p><strong><?php echo $total_patients; ?></strong></p>
                            <i class="fa fa-wheelchair fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="status-item text-center p-4 text-white rounded card" style="background-color:#6295a2;">
                            <p><strong>New Appointments</strong></p>
                            <p><strong><?php echo $new_appointments; ?></strong></p>
                            <i class="fas fa-calendar-plus fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="status-item text-center p-4 text-white rounded card" style="background-color:#6295a2;">
                            <p><strong>All Appointments</strong></p>
                            <p><strong><?php echo $all_appointments; ?></strong></p>
                            <i class="fas fa-calendar-check fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="text-center">
        <span class="fs-4 mb-3"><strong>My Appointments</strong></span>
    </div>
    <div class="bd-example">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($appointment = $appointments_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['first_name']) . ' ' . htmlspecialchars($appointment['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['time']); ?></td>
                        <td>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmCancelModal" data-id="<?php echo htmlspecialchars($appointment['appointment_id']); ?>">Cancel</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmCancelModalLabel">Confirm Cancellation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel this appointment?
            </div>
            <div class="modal-footer">
                <form method="post" action="index.php">
                    <input type="hidden" name="appointment_id" id="appointment_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include the footer -->
<?php include('footer.php'); ?>
<script src="../js/bootstrap.bundle.min.js"></script>
<script>
    // Set appointment ID in modal
    var confirmCancelModal = document.getElementById('confirmCancelModal');
    confirmCancelModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var appointmentId = button.getAttribute('data-id');
        var inputAppointmentId = confirmCancelModal.querySelector('#appointment_id');
        inputAppointmentId.value = appointmentId;
    });
</script>
</body>
</html>
