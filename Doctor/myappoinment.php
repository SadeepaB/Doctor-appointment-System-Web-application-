<?php 
session_start();
include("../connection.php"); 


// Handle cancel appointment
if (isset($_GET['cancel_appointment'])) {
    $appointment_id = intval($_GET['cancel_appointment']);
    
    $stmt = $con->prepare("DELETE FROM appointment WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);
    
    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Appointment canceled successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to cancel appointment. Please try again.</div>';
    }
    
    $stmt->close();
}

// Fetch appointments
$doctor_id = 1; // Assuming doctor ID is 1, replace with actual logic to get the logged-in doctor's ID

$sql = "SELECT a.appointment_id, a.date, a.time, u.first_name, u.last_name, 
        TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS age 
        FROM appointment a 
        JOIN users u ON a.user_id = u.id 
        WHERE a.doctor_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
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
        .custom-card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .custom-card-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-custom-width {
            width: 150px;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<main class="flex-fill">

<!--Navbar-->

  <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #6295a2;">
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
              <li class="nav-item">
                <a class="nav-link" href="index.php">Dashboard</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link active" href="">My Appointments</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">My Patients</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">Settings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php"><button class="btn btn-light">Logout</button></a>
              </li>
            </ul>
        </div>
    </div>
  </nav>

  <!--cards-->
  
  <div class="container my-4">
    <h1 class="text-center pb-3" style="color: #6295a2;">My Appointments</h1>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-6">
                <div class="col-12 pb-3">
                    <div class="card h-auto flex-row p-1 bg-light px-4 custom-card-hover shadow border border-bottom-0">
                        <div class="card-body d-flex flex-column px-4">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']); ?></h5>
                            <h5 class="card-text">Age: <?php echo htmlspecialchars($row['age']); ?></h5>
                            <h5 class="card-text">Schedule Date: <?php echo htmlspecialchars($row['date']); ?></h5>
                            <h5 class="card-text">Schedule Time: <?php echo htmlspecialchars($row['time']); ?></h5>
                            <a href="?cancel_appointment=<?php echo $row['appointment_id']; ?>" class="btn btn-danger btn-custom-width d-block">Cancel Appointment</a>
                        </div>
                    </div>
                </div> 
            </div>
        <?php endwhile; ?>
    </div>
  </div>

</main>
<?php include('footer.php'); ?>

<script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$con->close();
?>
