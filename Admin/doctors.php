<?php
session_start();
include("../connection.php");

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}
$isLoggedIn = isset($_SESSION['admin_id']);

// Initialize an empty message variable
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctorName = $_POST['doctorName'];
    $specialization = $_POST['specialization'];
    $hospital = $_POST['hospital'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO doctor (name, specialization, hospital, email, password) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssss", $doctorName, $specialization, $hospital, $email, $password);

        if ($stmt->execute()) {
            $message = "Doctor added successfully.";
        } else {
            $message = "Failed to add doctor: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Failed to prepare statement: " . $con->error;
    }
}

// Fetch doctors from the database
$doctors = [];
$query = "SELECT * FROM doctor";
$result = $con->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}
$con->close();
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
                  <li class="nav-item active">
                    <a class="nav-link active" href="doctors.php">Doctors</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="users.php">Users</a>
                  </li>
                    <li class="nav-item d-flex align-items-center">
                        <a href="../userdashboard.php"><img src="../images/profileicon.png" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40"></a>
                        <a class="nav-link" href="../logout.php"><button class="btn btn-light">Logout</button></a>
                    </li>
                </ul>
              </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="mb-4">Add Doctor</h2>
                <?php if ($message): ?>
                    <div class="alert alert-info">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
                    <i class="fas fa-plus"></i> Add Doctor
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDoctorModalLabel">Add New Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="doctorName" class="form-label">Doctor Name</label>
                            <input type="text" class="form-control" id="doctorName" name="doctorName" placeholder="Enter doctor's name" required>
                        </div>
                        <div class="mb-3">
                            <label for="specialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Enter specialization" required>
                        </div>
                        <div class="mb-3">
                            <label for="hospital" class="form-label">Hospital</label>
                            <input type="text" class="form-control" id="hospital" name="hospital" placeholder="Enter hospital name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Doctor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <!-- Wrap table in table-responsive to enable horizontal scrolling on small screens -->
        <div class="table-responsive" style="max-height: 400px; overflow-y: scroll;">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">Doctor Name</th>
                        <th scope="col">Specialization</th>
                        <th scope="col">Hospital</th>
                        <th scope="col">Email</th>
                        <th scope="col">Events</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doctors as $doctor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($doctor['name']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['hospital']); ?></td>
                        <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                        <td>
                            <button class="btn btn-outline-primary"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-outline-primary"><i class="fas fa-eye"></i> View</button>
                            <button class="btn btn-outline-primary"><i class="fas fa-trash"></i> Remove</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include the footer -->
    <?php include('footer.php'); ?>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
