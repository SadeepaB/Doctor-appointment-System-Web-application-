<?php
session_start();
include("connection.php"); // Ensure this file contains your database connection setup

// Initialize variables
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;
$message = '';
$user = $doctor = null;

// Retrieve user details from the database
if ($user_id > 0) {
    $stmt = $con->prepare("SELECT first_name, last_name, email, address, mobile_number FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if (!$user) $message = "User not found.";
} else {
    $message = "Invalid user ID.";
}

// Retrieve doctor details from the database
if ($doctor_id > 0) {
    $stmt = $con->prepare("SELECT id, name, specialization, hospital, doctor_image FROM doctor WHERE id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $doctor = $stmt->get_result()->fetch_assoc();
    if (!$doctor) $message = "Doctor not found.";
} else {
    $message = "Invalid doctor ID.";
}

// Handle AJAX form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $stmt = $con->prepare("INSERT INTO appointment (user_id, doctor_id, date, time) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("iiss", $user_id, $doctor_id, $_POST['date'], $_POST['time']);
  $success = $stmt->execute();
  $response = [
      'success' => $success,
      'message' => $success ? 'Appointment booked successfully!' : 'Failed to book appointment: ' . $stmt->error
  ];
  $stmt->close();
  mysqli_close($con);
  echo json_encode($response);
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #6295a2;">
    <div class="container">
        <a class="navbar-brand" href="index.php">
          <img src="images/logo.png" alt="Logo" width="50" height="40">
        </a>
        <a class="navbar-brand" href="index.php">Edoca</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav ms-auto align-items-center">
              <li class="nav-item active">
                <a class="nav-link active" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="doctors.php">Doctors</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="my appointments.php">My Appointments</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact us.php">Contact Us</a>
              </li>
              <?php
                $isLoggedIn = isset($_SESSION['user_id']); 
                if ($isLoggedIn) {
                    echo '<li class="nav-item d-flex align-items-center">';
                    echo '    <a href="#"><img src="images/User.png" class="rounded-circle" alt="Profile Image" width="40" height="40"></a>';
                    echo '    <a class="nav-link" href="logout.php"><button class="btn btn-light">Logout</button></a>'; 
                    echo '</li>';
                } else {
                    echo '<li class="nav-item">';
                    echo '    <a class="nav-link" href="signup.php">';
                    echo '        <button class="btn btn-primary" style="background-color: #130FEA;">Signup</button>';
                    echo '    </a>';
                    echo '</li>';
                }
              ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Doctor Searched Details --> 
<div class="container mb-4">
    <h2 class="mt-5 mb-5 text-center" style="color: #6295a2;">Make Appointment</h2>
    <div class="row g-4">
    <?php if ($doctor): ?>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12">
                <div class="card bg-light text-center">
                <h4 class="text-center mt-2">Doctor Details</h4>
                    <?php 
                    $doctorImage = !empty($doctor['doctor_image']) ? htmlspecialchars($doctor['doctor_image']) : 'images/user.png';
                    ?>
                    <img src="<?php echo $doctorImage; ?>" class="card-img-top rounded-circle" alt="Doctor Image">
                    <div class="card-body">
                        <h5 class="card-title">Dr. <?php echo htmlspecialchars($doctor['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($doctor['specialization']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars($doctor['hospital']); ?></p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
          <div class="card mb-3 bg-light" style="transform: none;">
            <h4 class="text-center mt-2">Your Details</h4>
              <div class="card-body text-center">
                  <?php if ($user): ?>
                  <div class="row">
                      <div class="col-sm-3">
                          <h6 class="mb-0">Name</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?>
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-sm-3">
                          <h6 class="mb-0">Email</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <?php echo htmlspecialchars($user['email']); ?>
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-sm-3">
                          <h6 class="mb-0">Address</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <?php echo htmlspecialchars($user['address']); ?>
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-sm-3">
                          <h6 class="mb-0">Phone Number</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <?php echo htmlspecialchars($user['mobile_number']); ?>
                      </div>
                  </div>
                  <hr>
                  <?php else: ?>
                      <p><?php echo htmlspecialchars($message); ?></p>
                  <?php endif; ?>

                  <form id="appointmentForm" method="post" class="text-center mt-4" style="background-color:;">
                  <div class="row justify-content-center">
                    <h4 class="mt-2">Select Date and Time</h4>
                      <div class="col-md-3">
                          <label for="date" class="form-label">Date</label>
                          <input type="date" class="form-control" id="date" name="date" required>
                      </div>
                      <div class="col-md-3">
                          <label for="time" class="form-label">Time</label>
                          <select class="form-control" id="time" name="time" required></select>
                      </div>
                      <div class="col-12 pt-3">
                          <h6 class="mb-0">Please select date and time</h6>
                      </div>
                      <div class="col-12 pt-3">
                          <button type="submit" class="btn btn-primary" style="--bs-btn-padding-y: 10px;--bs-btn-padding-x: 35px; border-radius: 10px;">Book Appointment</button>
                      </div>
                  </div>
                  </form>
              </div>
          </div>
      </div>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Appointment Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Your appointment has been booked successfully!</p>
      </div>
      <div class="modal-footer">
        <a href="my appointments.php" class="btn btn-primary">View Appointments</a>
      </div>
    </div>
  </div>
</div>

<!-- Include the footer -->
<?php include('footer.php'); ?>

<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));

        $('#appointmentForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        successModal.show();
                    } else {
                        alert('Failed to book appointment: ' + result.message);
                    }
                },
                error: function () {
                    alert('An error occurred while booking the appointment.');
                }
            });
        });
    });

    // Redirect to index.php when the modal is closed
    $('#successModal').on('hidden.bs.modal', function () {
        window.location.href = 'index.php';
    });

    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        
        // Set the min attribute of date input to tomorrow's date
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        dateInput.min = tomorrow.toISOString().split('T')[0];

        // Populate time input with options from 8 AM to 9 PM in half-hour intervals
        const startHour = 8; // 8 AM
        const endHour = 21; // 9 PM
        const timeStep = 30; // Minutes
        
        function padNumber(number) {
            return number.toString().padStart(2, '0');
        }

        for (let hour = startHour; hour < endHour; hour++) {
            for (let minute = 0; minute < 60; minute += timeStep) {
                const hourString = hour > 12 ? hour - 12 : hour;
                const period = hour >= 12 ? 'PM' : 'AM';
                const timeString = `${padNumber(hourString)}:${padNumber(minute)} ${period}`;
                const option = document.createElement('option');
                option.value = `${padNumber(hour)}:${padNumber(minute)}`;
                option.text = timeString;
                timeInput.appendChild(option);
            }
        }
    });
</script>

</body>
</html>
