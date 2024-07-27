<?php
session_start();
include("../connection.php");
if (!isset($_SESSION['admin_id'])){
    header("Location: ../login.php");
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
    <title>Edoca Admin</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top py-1" style="background-color: #6295a2;">
        <div class="container">
            <a class="navbar-brand" href="index.html">
              <img src="../images/logo.png" alt="Logo" width="50" height="40">
            </a>
            <a class="navbar-brand" href="index.html">Edoca</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
              <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto align-items-center">
                  <li class="nav-item active">
                    <a class="nav-link active" href="index.php">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="appointments.php">Appointments</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="doctors.php">Doctors</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="users.php">Users</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="feedback.php">Feedback</a>
                  </li>
                    <li class="nav-item d-flex align-items-center">
                        <a href="admin_profile.php"><img src="../images/profileicon.png" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40"></a>
                        <a class="nav-link" href="../logout.php"><button class="btn btn-light">Logout</button></a>
                    </li>
                </ul>
              </div>
        </div>
    </nav>

    <div class="container mt-5">
  <!-- Status Section -->
  <div class="row text-center">
      <div class="col-12 mb-4">
          <h2 class="fw-bolder" style="color: #6295a2;">Status</h2>
      </div>
      <?php
      include '../connection.php'; // Ensure the connection file is included

      // Fetch the count of all doctors
      $sqlDoctors = "SELECT COUNT(*) AS doctor_count FROM doctor";
      $resultDoctors = $con->query($sqlDoctors);
      $doctorCount = $resultDoctors->fetch_assoc()['doctor_count'];

      // Fetch the count of all users
      $sqlUsers = "SELECT COUNT(*) AS user_count FROM users";
      $resultUsers = $con->query($sqlUsers);
      $userCount = $resultUsers->fetch_assoc()['user_count'];

      // Fetch the count of new (upcoming) appointments
      $sqlNewAppointments = "SELECT COUNT(*) AS new_appointment_count FROM appointment 
                             WHERE date > CURDATE() OR (date = CURDATE() AND time >= CURTIME())";
      $resultNewAppointments = $con->query($sqlNewAppointments);
      $newAppointmentCount = $resultNewAppointments->fetch_assoc()['new_appointment_count'];

      // Fetch the count of all appointments
      $sqlAllAppointments = "SELECT COUNT(*) AS appointment_count FROM appointment";
      $resultAllAppointments = $con->query($sqlAllAppointments);
      $appointmentCount = $resultAllAppointments->fetch_assoc()['appointment_count'];
      ?>
      <div class="col-xl-3 col-md-6">
          <div class="card text-white mb-4" style="background-color: #6295a2;">
              <div class="card-body">
                <a href="doctors.php" class="text-decoration-none text-reset">
                  <h5 class="card-title fw-bold">All Doctors</h5>
                  <h5 class="card-text fw-bold"><?php echo $doctorCount; ?></h5>
                  <i class="fas fa-user-md fa-3x" aria-hidden="true"></i>
                </a>
              </div>
          </div>
      </div>
      <div class="col-xl-3 col-md-6">
          <div class="card text-white mb-4" style="background-color: #6295a2;">
              <div class="card-body">
                <a href="users.php" class="text-decoration-none text-reset">
                  <h5 class="card-title fw-bold">All Users</h5>
                  <h5 class="card-text fw-bold"><?php echo $userCount; ?></h5>
                  <i class="fas fa-users fa-3x" aria-hidden="true"></i>
                </a>
              </div>
          </div>
      </div>
      <div class="col-xl-3 col-md-6">
          <div class="card text-white mb-4" style="background-color: #6295a2;">
              <div class="card-body">
                <a href="appointments.php" class="text-decoration-none text-reset">
                  <h5 class="card-title fw-bold">New Appointments</h5>
                  <h5 class="card-text fw-bold" aria-hidden="true"><?php echo $newAppointmentCount; ?></h5>
                  <i class="fas fa-calendar-check fa-3x"></i>
                </a>
              </div>
          </div>
      </div>
      <div class="col-xl-3 col-md-6">
          <div class="card text-white mb-4" style="background-color: #6295a2;">
              <div class="card-body">
                <a href="appointments.php" class="text-decoration-none text-reset">
                  <h5 class="card-title fw-bold">All Appointments</h5>
                  <h5 class="card-text fw-bold"><?php echo $appointmentCount; ?></h5>
                  <i class="fas fa-calendar-alt fa-3x" aria-hidden="true"></i>
                </a>
                </div>
          </div>
      </div>
  </div>
</div>
<?php
$con->close();
?>

  
<!-- Appointments and Doctors Section -->
<div class="container">
<div class="row mt-4">
    <div class="col-md-6">
        <h3 class="text-center">New Appointments</h3>
        <?php
        include '../connection.php'; // Ensure the connection file is included

        // Fetch top 3 upcoming appointments from today onwards
        $sqlUpcoming = "SELECT 
                            a.appointment_id,
                            u.first_name,
                            u.last_name,
                            d.name AS doctor_name
                        FROM 
                            appointment a
                        JOIN 
                            doctor d ON a.doctor_id = d.id
                        JOIN 
                            users u ON a.user_id = u.id
                        WHERE 
                            a.date > CURDATE() OR (a.date = CURDATE() AND a.time >= CURTIME())
                        ORDER BY 
                            a.date ASC, a.time ASC
                        LIMIT 3"; // Limit to top 3 upcoming appointments

        $resultUpcoming = $con->query($sqlUpcoming);

        if ($resultUpcoming->num_rows > 0) {
            echo "
            <table class='table table-striped table-hover mt-3'>
                <thead class='table-light'>
                    <tr>
                        <th>Appointment Number</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                    </tr>
                </thead>
                <tbody>";
            while ($row = $resultUpcoming->fetch_assoc()) {
                $appointmentId = $row['appointment_id'];
                $patientName = $row['first_name'] . ' ' . $row['last_name'];
                $doctorName = $row['doctor_name'];
                echo "
                    <tr>
                        <td>$appointmentId</td>
                        <td>$patientName</td>
                        <td>Dr. $doctorName</td>
                    </tr>";
            }
            echo "
                </tbody>
            </table>";
        } else {
            echo "<p>No new appointments found.</p>";
        }

        $con->close();
        ?>

        <div class="text-center mt-3">
            <button class="btn btn-primary" onclick="window.location.href='appointments.php'">Show all Appointments</button>
        </div>
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Top Doctors</h3>
        <?php
        include '../connection.php'; // Ensure the connection file is included

        // Fetch top 3 doctors based on the number of appointments
        $sqlTopDoctors = "SELECT 
                            d.name AS doctor_name,
                            d.specialization,
                            COUNT(a.appointment_id) AS appointment_count
                        FROM 
                            doctor d
                        LEFT JOIN 
                            appointment a ON d.id = a.doctor_id
                        GROUP BY 
                            d.id
                        ORDER BY 
                            appointment_count DESC
                        LIMIT 3"; // Limit to top 3 doctors

        $resultTopDoctors = $con->query($sqlTopDoctors);

        if ($resultTopDoctors->num_rows > 0) {
            echo "
            <table class='table table-striped table-hover mt-3'>
                <thead class='table-light'>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Specialization</th>
                        <th>Appointments Count</th>
                    </tr>
                </thead>
                <tbody>";
            while ($row = $resultTopDoctors->fetch_assoc()) {
                $doctorName = $row['doctor_name'];
                $specialization = $row['specialization'];
                $appointmentCount = $row['appointment_count'];
                echo "
                    <tr>
                        <td>Dr. $doctorName</td>
                        <td>$specialization</td>
                        <td class='text-center'>$appointmentCount</td>
                    </tr>";
            }
            echo "
                </tbody>
            </table>";
        } else {
            echo "<p>No top doctors found.</p>";
        }

        $con->close();
        ?>

        <div class="text-center mt-3">
            <button class="btn btn-primary" onclick="window.location.href='doctors.php'">Show all Doctors</button>
        </div>
    </div>
    </div>    
    </div>

    
    <!-- Include the footer -->
    <?php include('footer.php'); ?>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>
