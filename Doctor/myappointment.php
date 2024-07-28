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
$doctor = $stmt->get_result()->fetch_assoc();

$doctor_image = !empty($doctor['doctor_image']) ? $doctor['doctor_image'] : "../images/profileicon.png";

// Handle appointment cancellation
if (isset($_GET['cancel_appointment_id']) && is_numeric($_GET['cancel_appointment_id'])) {
    $appointmentIdToCancel = intval($_GET['cancel_appointment_id']);
    $sql = "DELETE FROM appointment WHERE appointment_id = ? AND doctor_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $appointmentIdToCancel, $doctor_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        
    } else {
        $msg = "Error canceling appointment.";
    }
}

// Fetch upcoming appointments
$sqlUpcoming = "SELECT 
                    a.appointment_id,
                    a.date AS booking_date,
                    a.time,
                    u.first_name,
                    u.last_name,
                    TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age,
                    a.created_at
                FROM 
                    appointment a
                JOIN 
                    users u ON a.user_id = u.id
                WHERE 
                    a.doctor_id = ? AND (a.date > CURDATE() OR (a.date = CURDATE() AND a.time >= CURTIME()))
                ORDER BY 
                    a.date ASC, a.time ASC";
$stmt = $con->prepare($sqlUpcoming);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$resultUpcoming = $stmt->get_result();

// Fetch past appointments
$sqlPast = "SELECT 
                a.appointment_id,
                a.date AS booking_date,
                a.time,
                a.created_at
            FROM 
                appointment a
            WHERE 
                a.doctor_id = ? AND (a.date < CURDATE() OR (a.date = CURDATE() AND a.time < CURTIME()))
            ORDER BY 
                a.date DESC, a.time DESC";
$stmt = $con->prepare($sqlPast);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$resultPast = $stmt->get_result();

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Edoca Doctor</title>
    <style>
        .nav-link {
            font-size: larger;
            font-weight: normal;
            color: black;
        }

        .nav-link.active {
            color: white !important;
        }

        .navbar-brand {
            font-weight: bolder;
            font-size: x-large;
        }

        .nav-item {
            padding: 0 10px;
            border-radius: 10px;
        }

        .nav-item.active {
            background-color: black;
        }

        .nav-link:hover {
            transition: ease-in-out 300ms;
            color: white;
        }

        .section {
            display: none;
        }

        .active-section {
            display: block;
        }

        .btn-primary, .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-primary.active, .btn-secondary.active {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <main class="flex-fill">
    <!-- Navbar -->
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
                    <li class="nav-item active">
                        <a class="nav-link active" href="myappointment.php">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="patients.php">My Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="doctordashboard.php">Settings</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a href="doctordashboard.php"><img src="<?php echo $doctor_image; ?>" class="rounded-circle img-hover bg-light" alt="Profile Image" width="40" height="40" style="border: 2px solid #fff;"></a>
                        <a class="nav-link" href="../logout.php"><button class="btn btn-light">Logout</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Appointment -->
    <div class="container my-4">
        <h1 class="text-center" style="color: #6295a2;">My Appointments</h1>
        <div class="text-center mb-4 mt-5">
            <button class="btn btn-primary mx-5 active" id="upcomingButton">Upcoming Appointments</button>
            <button class="btn btn-secondary mx-5" id="pastButton">Past Appointments</button>
        </div>

        <!-- Upcoming Appointments Section -->
        <div id="upcomingAppointments" class="section active-section">
            <div class="row">
                <?php
                if (isset($msg)) {
                    echo "<div class='alert alert-success'>$msg</div>";
                }

                if ($resultUpcoming->num_rows > 0) {
                    while($row = $resultUpcoming->fetch_assoc()) {
                        $appointmentId = $row['appointment_id'];
                        $patientName = $row['first_name'] . ' ' . $row['last_name'];
                        $patientAge = $row['age'];
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
                                    <h5 class='card-title'>Patient: $patientName</h5>
                                    <p class='card-text' style='margin-bottom: 10px;'>Age: $patientAge</p>
                                <h6 class='card-text d-flex justify-content-between' style='margin-bottom: 5px;'>
                                    <span><i class='fas fa-calendar-day'></i> $scheduleDate</span>
                                    <span><i class='fas fa-clock'></i> $time</span>
                                </h6>
                                </div>
                                <div class='card-footer text-body-secondary'>
                                    <button class='btn btn-danger cancel-button' data-bs-toggle='modal' data-bs-target='#confirmCancelModal' data-appointment-id='$appointmentId'>Cancel Appointment</button>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p>No upcoming appointments found.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Past Appointments Section -->
        <div id="pastAppointments" class="section">
            <div class="row">
                <?php
                if ($resultPast->num_rows > 0) {
                    while($row = $resultPast->fetch_assoc()) {
                        $appointmentId = $row['appointment_id'];
                        $createdAt = $row['created_at'];
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
                                    <h5 class='card-title'>Patient: $patientName</h5>
                                    <p class='card-text' style='margin-bottom: 10px;'>Age: $patientAge</p>
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
                ?>
            </div>
        </div>
    </div>

    <!-- Confirm Cancel Appointment Modal -->
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
                    <a id="confirmCancelLink" class="btn btn-danger" href="#">Confirm Cancel</a>
                </div>
            </div>
        </div>
    </div>
    </main>
    <!-- Include the footer -->
    <?php include('footer.php'); ?>
    <!-- Handle section toggling -->
    <script>
        document.getElementById('upcomingButton').addEventListener('click', function() {
            document.getElementById('upcomingAppointments').classList.add('active-section');
            document.getElementById('pastAppointments').classList.remove('active-section');
            this.classList.add('active');
            document.getElementById('pastButton').classList.remove('active');
        });

        document.getElementById('pastButton').addEventListener('click', function() {
            document.getElementById('pastAppointments').classList.add('active-section');
            document.getElementById('upcomingAppointments').classList.remove('active-section');
            this.classList.add('active');
            document.getElementById('upcomingButton').classList.remove('active');
        });

        // Set the href of the cancel button in the modal
        var cancelButtons = document.querySelectorAll('.cancel-button');
        cancelButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var appointmentId = this.getAttribute('data-appointment-id');
                document.getElementById('confirmCancelLink').href = 'myappointment.php?cancel_appointment_id=' + appointmentId;
            });
        });
    </script>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
