<?php
session_start();
include("../connection.php");
if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch the doctor details using the session doctor_id
$doctor_id = $_SESSION['doctor_id'];

$sql = "SELECT id, name, specialization, hospital, email, doctor_image FROM doctor WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
} else {
    echo "No doctor found";
    exit();
}
$stmt->close();
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
    <link rel="stylesheet" href="../styles.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="myappointment.php">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="patients.php">My Patients</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link active" href="doctordashboard.php">Settings</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                    <a href="doctordashboard.php"><img src="<?php echo $doctor['doctor_image']; ?>" class="rounded-circle img-hover bg-light" alt="Profile Image" width="40" height="40" style="border: 2px solid #fff;"></a>
                    <a class="nav-link" href="../logout.php"><button class="btn btn-light">Logout</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

  <!-- Dashboard -->
  <div class="container">
    <div class="main-body">
        <div class="row gutters-sm">
            <div class="col-md-4">
                <div class="card mt-lg-5">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                        <img src="<?php echo $doctor['doctor_image']; ?>" alt="DOCTOR" class="rounded-circle" width="150" height="150" style="background-color: #29a5c0;">
                            <div class="mt-3">
                                <h4><?php echo $doctor['name']; ?></h4>
                                <p class="text-muted font-size-sm"><?php echo $doctor['specialization']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mt-lg-5" style="transform: none;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $doctor['name']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Specialization</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $doctor['specialization']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Hospital</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $doctor['hospital']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $doctor['email']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-info" href="doctordashboard2.php">Edit Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

<?php include('footer.php'); ?>

<script src="../js/bootstrap.min.js"></script>

</body>
</html>
