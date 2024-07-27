<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['admin_id'])){
    header("Location: ../login.php");
    exit();
}

$isLoggedIn = isset($_SESSION['admin_id']);
$message = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addDoctor'])) {
        // Add Doctor
        $doctorName = $_POST['doctorName'];
        $specialization = $_POST['specialization'];
        $hospital = $_POST['hospital'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

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
    } elseif (isset($_POST['editDoctor'])) {
        // Edit Doctor
        $id = $_POST['id'];
        $name = $_POST['name'];
        $specialization = $_POST['specialization'];
        $hospital = $_POST['hospital'];
        $email = $_POST['email'];
        $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        if ($password) {
            $stmt = $con->prepare("UPDATE doctor SET name = ?, specialization = ?, hospital = ?, email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $name, $specialization, $hospital, $email, $password, $id);
        } else {
            $stmt = $con->prepare("UPDATE doctor SET name = ?, specialization = ?, hospital = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $name, $specialization, $hospital, $email, $id);
        }

        if ($stmt->execute()) {
            $message = "Doctor updated successfully.";
        } else {
            $message = "Failed to update doctor: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['removeDoctor'])) {
        // Remove Doctor
        $id = $_POST['id'];
        $stmt = $con->prepare("DELETE FROM doctor WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "Doctor removed successfully.";
        } else {
            $message = "Failed to remove doctor: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Handle search query
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerm = mysqli_real_escape_string($con, $searchTerm);

// Fetch doctors from the database
$doctors = [];
$query = "SELECT * FROM doctor";
if ($searchTerm) {
    $query .= " WHERE name LIKE '%$searchTerm%' OR specialization LIKE '%$searchTerm%' OR hospital LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
}
$result = $con->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

// Handle AJAX request for doctor details
if (isset($_GET['view_id'])) {
    $id = intval($_GET['view_id']);
    $stmt = $con->prepare("SELECT * FROM doctor WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();
    $stmt->close();
    echo json_encode($doctor);
    exit();
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
    <style>
        .modal-body img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
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
                  <li class="nav-item">
                    <a class="nav-link" href="appointments.php">Appointments</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link active" href="doctors.php">Doctors</a>
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
        <div class="row">
        <div class="col-md-6 d-flex justify-content-center mb-3 mb-md-0">
            <button class="btn btn-outline-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
                <i class="fas fa-plus"></i><strong> Add New Doctor</strong>
            </button>
        </div>
        <div class="col-md-6 d-flex align-items-center">
        <form class="w-100" method="GET" action="doctors.php">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search doctors...">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i> Search</button>
            </div>
        </form>
        </div>
        <?php if ($message): ?>
            <div class="alert alert-info text-center mt-3">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        </div>
    </div>

    <!-- Modal for Adding Doctor -->
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
                            <button type="submit" class="btn btn-primary" name="addDoctor">Save Doctor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Viewing Doctor Details -->
    <div class="modal fade" id="viewDoctorModal" tabindex="-1" aria-labelledby="viewDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDoctorModalLabel">Doctor Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <img id="doctorImage" class="img-fluid rounded" src="" alt="Doctor Image">
                            </div>
                            <div class="col-md-8">
                                <p class="fw-bold">Name: <span id="doctorNameView"></span></p>
                                <p>Id: <span id="doctorIdView"></span></p>
                                <p>Specialization: <span id="specializationView"></span></p>
                                <p>Hospital: <span id="hospitalView"></span></p>
                                <p>Email: <span id="emailView"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Doctor -->
    <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDoctorModalLabel">Edit Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDoctorForm" method="POST" action="">
                        <input type="hidden" id="editDoctorId" name="id">
                        <div class="mb-3">
                            <label for="editDoctorName" class="form-label">Doctor Name</label>
                            <input type="text" class="form-control" id="editDoctorName" name="name" placeholder="Enter doctor's name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSpecialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="editSpecialization" name="specialization" placeholder="Enter specialization" required>
                        </div>
                        <div class="mb-3">
                            <label for="editHospital" class="form-label">Hospital</label>
                            <input type="text" class="form-control" id="editHospital" name="hospital" placeholder="Enter hospital name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password (Leave blank to keep current password)</label>
                            <input type="password" class="form-control" id="editPassword" name="password" placeholder="Enter new password">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="editDoctor">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Removing Doctor -->
    <div class="modal fade" id="removeDoctorModal" tabindex="-1" aria-labelledby="removeDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeDoctorModalLabel">Remove Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this doctor?</p>
                    <form id="removeDoctorForm" method="POST" action="">
                        <input type="hidden" id="removeDoctorId" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" name="removeDoctor">Remove</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Table -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="text-center">All Doctors</h4>
                <table class="table table-striped table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Hospital</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($doctors as $doctor): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($doctor['name']); ?></td>
                                <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
                                <td><?php echo htmlspecialchars($doctor['hospital']); ?></td>
                                <td>
                                    <button class="btn btn-outline-primary view-doctor" data-id="<?php echo $doctor['id']; ?>" data-bs-toggle="modal" data-bs-target="#viewDoctorModal">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-outline-primary edit-doctor" data-id="<?php echo $doctor['id']; ?>" data-bs-toggle="modal" data-bs-target="#editDoctorModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-outline-primary remove-doctor" data-id="<?php echo $doctor['id']; ?>" data-bs-toggle="modal" data-bs-target="#removeDoctorModal">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>
    <!-- Include the footer -->
    <?php include('footer.php'); ?>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // View doctor details
            $('.view-doctor').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'doctors.php',
                    type: 'GET',
                    data: {view_id: id},
                    dataType: 'json',
                    success: function(response) {
                        $('#doctorIdView').text(response.id);
                        $('#doctorNameView').text(response.name);
                        $('#specializationView').text(response.specialization);
                        $('#hospitalView').text(response.hospital);
                        $('#emailView').text(response.email);
                        $('#doctorImage').attr('src', response.doctor_image);
                    }
                });
            });

            // Edit doctor
            $('.edit-doctor').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'doctors.php',
                    type: 'GET',
                    data: {view_id: id},
                    dataType: 'json',
                    success: function(response) {
                        $('#editDoctorId').val(response.id);
                        $('#editDoctorName').val(response.name);
                        $('#editSpecialization').val(response.specialization);
                        $('#editHospital').val(response.hospital);
                        $('#editEmail').val(response.email);
                        $('#editPassword').val('');
                        $('#editDoctorImage').val(''); 
                    }
                });
            });

            // Remove doctor
            $('.remove-doctor').on('click', function() {
                var id = $(this).data('id');
                $('#removeDoctorId').val(id);
            });
        });
    </script>
</body>
</html>
