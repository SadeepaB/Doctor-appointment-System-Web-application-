<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../login.php");
    exit();
}
$doctor_id = $_SESSION['doctor_id'];

// Fetch doctor's details
$doctor_query = "SELECT doctor_image FROM doctor WHERE id = ?";
$stmt = $con->prepare($doctor_query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$doctor_result = $stmt->get_result();
$doctor = $doctor_result->fetch_assoc();

// Fetch patients for the logged-in doctor
$patients_query = "SELECT 
                        u.id,
                        u.first_name, 
                        u.last_name, 
                        TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age 
                    FROM 
                        users u 
                    JOIN 
                        appointment a ON u.id = a.user_id 
                    WHERE 
                        a.doctor_id = ? 
                    GROUP BY 
                        u.id, u.first_name, u.last_name, u.dob";
$stmt = $con->prepare($patients_query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$patients_result = $stmt->get_result();

// Handle AJAX request for fetching appointment details
if (isset($_POST['action']) && $_POST['action'] === 'fetch_appointments' && isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];

    $appointments_query = "SELECT 
                            appointment_id,
                            date,
                            time,
                            created_at 
                        FROM 
                            appointment 
                        WHERE 
                            user_id = ? AND doctor_id = ?";
    $stmt = $con->prepare($appointments_query);
    $stmt->bind_param("ii", $patient_id, $doctor_id);
    $stmt->execute();
    $appointments_result = $stmt->get_result();

    if ($appointments_result->num_rows > 0) {
        echo '<ul class="list-group">';
        while ($appointment = $appointments_result->fetch_assoc()) {
            echo '<li class="list-group-item">';
            echo 'Date: ' . htmlspecialchars($appointment['date']) . '<br>';
            echo 'Time: ' . htmlspecialchars($appointment['time']) . '<br>';
            
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No appointments found.';
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .spinner-border {
            margin-right: 10px;
        }
    </style>
    <title>Edoca Doctor</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <main class="flex-fill">
    <nav class="navbar navbar-expand-lg sticky-top py-1" style="background-color: #6295a2;">
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
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="myappointment.php">Appointments</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link active" href="patients.php">My Patients</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="doctordashboard.php">Settings</a>
                  </li>
                  <li class="nav-item d-flex align-items-center">
                    <a href="doctordashboard.php">
                        <img src="<?php echo htmlspecialchars($doctor['doctor_image']); ?>" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40" style="border: 2px solid #fff; background-color: #000;">
                    </a>
                      <a class="nav-link" href="../logout.php"><button class="btn btn-light">Logout</button></a>
                  </li>
                </ul>
              </div>
        </div>
    </nav>

    <!-- Patients Table -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="text-center">
                <?php
                    $patient_count = $patients_result->num_rows;
                ?>
                All Patients (<?php echo $patient_count; ?>)</h4>
                <table class="table table-striped table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($patient = $patients_result->fetch_assoc()): ?>
                            <tr data-patient-id="<?php echo htmlspecialchars($patient['id']); ?>">
                                <td><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($patient['age']); ?></td>
                                <td>
                                    <button class="btn btn-outline-primary view-appointments">
                                        <i class="fas fa-eye"></i> View Appointments
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </main>
    <!-- Include the footer -->
    <?php include('footer.php'); ?>

    <!-- Bootstrap Modal for Appointment Details -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="appointmentDetails">
                        <!-- Appointment details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.view-appointments').on('click', function() {
                var patientId = $(this).closest('tr').data('patient-id');
                
                $.ajax({
                    url: 'patients.php',
                    type: 'POST',
                    data: { action: 'fetch_appointments', patient_id: patientId },
                    success: function(response) {
                        $('#appointmentDetails').html(response);
                        $('#appointmentModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to fetch appointment details.');
                    }
                });
            });
        });
    </script>
</body>
</html>
