<?php
session_start();
include("../connection.php");
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}
$isLoggedIn = isset($_SESSION['admin_id']);
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
    <style>
        .section {display: none;}
        .active-section {display: block;}
        .btn-primary {background-color: #007bff; color: white;}
        .btn-secondary {background-color: #6c757d; color: white;}
    </style>
<body class="d-flex flex-column min-vh-100">
<main class="flex-fill">

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
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">Dashboard</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link active" href="appointments.php">Appointments</a>
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

  <!-- Appointment buttons -->
  <div class="container my-4">
    <h1 class="text-center" style="color: #6295a2;">All Appointments</h1>
    <div class="text-center mb-4 mt-5">
      <button class="btn btn-primary mx-5" id="upcomingButton">Upcoming Appointments</button>
      <button class="btn btn-secondary mx-5" id="pastButton">Past Appointments</button>
    </div>

    <!-- Upcoming Appointments Section -->
    <div id="upcomingAppointments" class="section active-section">
        <div class="row">
        <?php
            include '../connection.php';

            if (isset($_GET['cancel_appointment_id'])) {
                $appointmentIdToCancel = $_GET['cancel_appointment_id'];
                $sql = "SELECT * FROM appointment WHERE appointment_id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("i", $appointmentIdToCancel);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $deleteSql = "DELETE FROM appointment WHERE appointment_id = ?";
                    $deleteStmt = $con->prepare($deleteSql);
                    $deleteStmt->bind_param("i", $appointmentIdToCancel);
                    $deleteStmt->execute();
                    if ($deleteStmt->affected_rows > 0) {
                        echo "<div class='alert alert-success'>Appointment canceled successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error canceling appointment.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Invalid appointment or permission denied.</div>";
                }
            }

            $sqlUpcoming = "SELECT 
                    a.appointment_id,
                    a.date AS booking_date,
                    a.time,
                    d.name AS doctor_name,
                    d.specialization,
                    d.hospital,
                    u.first_name,
                    u.last_name,
                    a.created_at
                FROM 
                    appointment a
                JOIN 
                    doctor d ON a.doctor_id = d.id
                JOIN 
                    users u ON a.user_id = u.id
                WHERE 
                    (a.date > CURDATE() OR (a.date = CURDATE() AND a.time >= CURTIME()))
                ORDER BY 
                    a.date ASC, a.time ASC";
            $resultUpcoming = $con->query($sqlUpcoming);
            if ($resultUpcoming->num_rows > 0) {
                while($row = $resultUpcoming->fetch_assoc()) {
                    $appointmentId = $row['appointment_id'];
                    $doctorName = $row['doctor_name'];
                    $specialization = $row['specialization'];
                    $hospital = $row['hospital'];
                    $firstName = $row['first_name'];
                    $lastName = $row['last_name'];
                    $scheduleDate = $row['booking_date'];
                    $time = $row['time'];
                    $createdAt = $row['created_at'];
                    $dateTime = new DateTime($createdAt);
                    $createdDate = $dateTime->format('Y-m-d');
                    echo "
                    <div class='col-xl-4 col-md-6'>
                        <div class='card text-left m-3'>
                            <div class='card-header'>
                            <h5 class='card-title'>Appointment Number: $appointmentId</h5>
                            Booking Date: $createdDate<br>
                            </div>
                            <div class='card-body'>
                                <h5 class='card-text' style='margin-bottom: 10px;'><i class='fas fa-user'></i> $firstName $lastName</h5>
                                <h5 class='card-title'><i class='fas fa-user-md'></i> Dr. $doctorName</h5>
                                <p class='card-text' style='margin-bottom: 5px;'>$specialization</p>
                                <p class='card-text' style='margin-bottom: 10px;'>$hospital</p>
                                <h6 class='card-text d-flex justify-content-between' style='margin-bottom: 5px;'>
                                    <span><i class='fas fa-calendar-day'></i> $scheduleDate</span>
                                    <span><i class='fas fa-clock'></i> $time</span>
                                </h6>
                            </div>
                            <div class='card-footer text-body-secondary'>
                                <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#confirmCancelModal' data-appointment-id='$appointmentId'>Cancel Booking</button>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No upcoming appointments found.</p>";
            }
            $con->close();
        ?>

        </div>
    </div>

    <!-- Past Appointments Section -->
    <div id="pastAppointments" class="section">
        <div class="row">
        <?php
            include '../connection.php';

            $sqlPast = "SELECT 
                a.appointment_id,
                a.date AS booking_date,
                a.time,
                d.name AS doctor_name,
                d.specialization,
                d.hospital,
                u.first_name,
                u.last_name,
                a.created_at
            FROM 
                appointment a
            JOIN 
                doctor d ON a.doctor_id = d.id
            JOIN 
                users u ON a.user_id = u.id
            WHERE 
                (a.date < CURDATE() OR (a.date = CURDATE() AND a.time < CURTIME()))
            ORDER BY 
                a.date DESC, a.time DESC";

            $resultPast = $con->query($sqlPast);
            if ($resultPast->num_rows > 0) {
                while($row = $resultPast->fetch_assoc()) {
                    $appointmentId = $row['appointment_id'];
                    $createdAt = $row['created_at'];
                    $doctorName = $row['doctor_name'];
                    $specialization = $row['specialization'];
                    $hospital = $row['hospital'];
                    $firstName = $row['first_name'];
                    $lastName = $row['last_name'];
                    $scheduleDate = $row['booking_date'];
                    $time = $row['time'];
                    $dateTime = new DateTime($createdAt);
                    $createdDate = $dateTime->format('Y-m-d');
                    echo "
                    <div class='col-xl-4 col-md-6'>
                        <div class='card text-left m-3'>
                            <div class='card-header'>
                            <h5 class='card-title'>Appointment Number: $appointmentId</h5>
                            Booking Date: $createdDate<br>
                            </div>
                            <div class='card-body'>
                                <h5 class='card-text' style='margin-bottom: 10px;'><i class='fas fa-user'></i> $firstName $lastName</h5>
                                <h5 class='card-title'><i class='fas fa-user-md'></i> Dr. $doctorName</h5>
                                <p class='card-text' style='margin-bottom: 5px;'>$specialization</p>
                                <p class='card-text' style='margin-bottom: 10px;'>$hospital</p>
                                <h6 class='card-text d-flex justify-content-between' style='margin-bottom: 5px;'>
                                    <span><i class='fas fa-calendar-day'></i> $scheduleDate</span>
                                    <span><i class='fas fa-clock'></i> $time</span>
                                </h6>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No past appointments found.</p>";
            }
            $con->close();
        ?>
        </div>
    </div>
  </div>

  <!-- Modal for cancellation confirmation -->
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="confirmCancelButton">Yes, Cancel</button>
        </div>
      </div>
    </div>
  </div>
</main>
    <!-- Include the footer -->
    <?php include('footer.php'); ?>

    <script src="js/bootstrap.min.js"></script>
  <!-- JavaScript to toggle between upcoming and past appointments -->
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script>
        document.getElementById('upcomingButton').addEventListener('click', function() {
            document.getElementById('upcomingAppointments').classList.add('active-section');
            document.getElementById('pastAppointments').classList.remove('active-section');
            this.classList.add('btn-primary');
            this.classList.remove('btn-secondary');
            document.getElementById('pastButton').classList.add('btn-secondary');
            document.getElementById('pastButton').classList.remove('btn-primary');
        });

        document.getElementById('pastButton').addEventListener('click', function() {
            document.getElementById('upcomingAppointments').classList.remove('active-section');
            document.getElementById('pastAppointments').classList.add('active-section');
            this.classList.add('btn-primary');
            this.classList.remove('btn-secondary');
            document.getElementById('upcomingButton').classList.add('btn-secondary');
            document.getElementById('upcomingButton').classList.remove('btn-primary');
        });

        // JavaScript to handle appointment cancellation
        var confirmCancelModal = document.getElementById('confirmCancelModal');
        var confirmCancelButton = document.getElementById('confirmCancelButton');
        var appointmentIdToCancel;

        confirmCancelModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            appointmentIdToCancel = button.getAttribute('data-appointment-id');
        });

        confirmCancelButton.addEventListener('click', function() {
            window.location.href = 'appointments.php?cancel_appointment_id=' + appointmentIdToCancel;
        });
    </script>
</body>
</html>
