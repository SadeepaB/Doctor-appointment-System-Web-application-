<?php
session_start();
include("../connection.php"); // Include your database connection file

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch admin details
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT admin_id, name, email FROM admin WHERE admin_id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 'i', $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoca Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
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
                    <a class="nav-link" href="appointments.php">Appointments</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="doctors.php">Doctors</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="users.php">Users</a>
                  </li>
                    <li class="nav-item d-flex align-items-center">
                        <a href="admin_profile.php"><img src="../images/profileicon.png" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40"></a>
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
                            <img src="../images/profileicon.png" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4><?php echo htmlspecialchars($admin['name']); ?></h4>
                                <p class="text-muted font-size-sm"><?php echo htmlspecialchars($admin['email']); ?></p>
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
                                <h6 class="mb-0">Admin ID</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo htmlspecialchars($admin['admin_id']); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo htmlspecialchars($admin['name']); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo htmlspecialchars($admin['email']); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-info" href="admin_profile_edit.php">Edit Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
<!-- Include the footer -->
<?php include('footer.php'); ?>

<script src="../js/bootstrap.bundle.min.js"></script>

</body>
</html>
