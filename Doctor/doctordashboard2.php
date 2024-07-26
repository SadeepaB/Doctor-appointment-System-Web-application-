<?php
session_start();
include("../connection.php"); // Ensure the connection file is included

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];


// Initialize variables for form values
$name = $specialization = $hospital = $email = $password = $new_password = "";
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = htmlspecialchars($_POST['name']);
    $specialization = htmlspecialchars($_POST['specialization']);
    $hospital = htmlspecialchars($_POST['hospital']);
    $new_password = htmlspecialchars($_POST['new_password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Check if new password and confirm password match
    if (!empty($new_password) && ($new_password === $confirm_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = null;
    }

    // Update the doctor details in the database
    if ($hashed_password) {
        $sql = "UPDATE doctor SET name = ?, specialization = ?, hospital = ?, password = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $name, $specialization, $hospital, $hashed_password, $doctor_id);
    } else {
        $sql = "UPDATE doctor SET name = ?, specialization = ?, hospital = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssi", $name, $specialization, $hospital, $doctor_id);
    }

    if ($stmt->execute()) {
        header("Location: doctordashboard.php"); // Redirect to the dashboard
        exit();
    } else {
        $_SESSION['message'] = "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch doctor details
$sql = "SELECT name, specialization, hospital, email ,doctor_image FROM doctor WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
    $name = $doctor['name'];
    $specialization = $doctor['specialization'];
    $hospital = $doctor['hospital'];
    $email = $doctor['email'];
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
                    <a href="doctordashboard.php"><img src="<?php echo $doctor['doctor_image']; ?>" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40" style="border: 2px solid #fff;background-color: #000;"></a>
                        <a class="nav-link" href="../logout.php"><button class="btn btn-light">Logout</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  <!-- Dashboard -->
  <div class="container">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mt-lg-5">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                        <img src="<?php echo $doctor['doctor_image']; ?>" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4><?php echo htmlspecialchars($name); ?></h4>
                                <p class="text-muted font-size-sm"><?php echo htmlspecialchars($email); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <form method="POST" action="">
                    <div class="card mt-lg-5" style="transform: none;">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Specialization</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="specialization" value="<?php echo htmlspecialchars($specialization); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Hospital</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="hospital" value="<?php echo htmlspecialchars($hospital); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">New Password</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="password" class="form-control" name="new_password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Confirm Password</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="password" class="form-control" name="confirm_password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" id="saveButton" value="Save Changes">
                                    <a href="doctordashboard.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['message'])): ?>
                                <div class="alert alert-info mt-3" role="alert">
                                    <?php echo htmlspecialchars($_SESSION['message']); ?>
                                </div>
                                <?php unset($_SESSION['message']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

  <!-- Include the footer -->
  <?php include('footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('saveButton').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            Swal.fire({
                icon: "success",
                title: "Profile updated successfully!",
                showConfirmButton: false,
                timer: 1500,
                willClose: () => {
                    // Redirect after the alert is closed
                    document.forms[0].submit();
                }
            });
        });
    });
  </script>
  <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
