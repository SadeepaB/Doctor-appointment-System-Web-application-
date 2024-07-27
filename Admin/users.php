<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['admin_id'])){
    header("Location: ../login.php");
    exit();
}

$isLoggedIn = isset($_SESSION['admin_id']);

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'get_user' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $con->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    echo json_encode($user);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'remove_user' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    $stmt->close();
    exit();
}

// Handle search
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
$search_query = "%$search%";
$stmt = $con->prepare("SELECT id, first_name, last_name, email FROM users WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ?");
$stmt->bind_param("sss", $search_query, $search_query, $search_query);
$stmt->execute();
$results = $stmt->get_result();
$users = [];
while ($user = $results->fetch_assoc()) {
    $users[] = $user;
}

// Fetch the total number of users
$count_result = $con->query("SELECT COUNT(*) as count FROM users");
$count_row = $count_result->fetch_assoc();
$user_count = $count_row['count'];
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
<body class="d-flex flex-column min-vh-100">
    <main class="flex-fill">
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
                            <a class="nav-link" href="appointments.php">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="doctors.php">Doctors</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link active" href="users.php">Users</a>
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

        <!-- Users Table -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h4 class="text-center">
                        All Users (<?php echo $user_count; ?>)
                    </h4>
                    <form method="GET" action="" class="mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search users..." aria-label="Search users" value="<?php echo htmlspecialchars($search); ?>">
                            <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </form>
                    <table class="table table-striped table-hover text-center mt-4">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <button class="btn btn-outline-primary view-user" data-id="<?php echo $user['id']; ?>" data-bs-toggle="modal" data-bs-target="#viewUserModal">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-outline-primary remove-user" data-id="<?php echo $user['id']; ?>" data-bs-toggle="modal" data-bs-target="#removeUserModal">
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

        <!-- Modal for Viewing User Details -->
        <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="fw-bold">ID: <span id="userIdView"></span></h5>
                                    <p class="fw-bold">Name: <span id="userNameView"></span></p>
                                    <p class="fw-bold">Email: <span id="userEmailView"></span></p>
                                    <p class="fw-bold">Address: <span id="userAddressView"></span></p>
                                    <p class="fw-bold">NIC: <span id="userNicView"></span></p>
                                    <p class="fw-bold">Date of Birth: <span id="userDobView"></span></p>
                                    <p class="fw-bold">Mobile Number: <span id="userMobileView"></span></p>
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

        <!-- Modal for Removing User -->
        <div class="modal fade" id="removeUserModal" tabindex="-1" aria-labelledby="removeUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeUserModalLabel">Remove User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove this user?</p>
                        <form id="removeUserForm" method="POST" action="">
                            <input type="hidden" id="removeUserId" name="id" value="">
                            <input type="hidden" name="action" value="remove_user">
                            <button type="submit" class="btn btn-danger">Remove</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include the footer -->
    <?php include('footer.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // View User Modal
            document.querySelectorAll('.view-user').forEach(button => {
                button.addEventListener('click', function () {
                    const userId = this.getAttribute('data-id');
                    fetch(`users.php?action=get_user&id=${userId}`)
                        .then(response => response.json())
                        .then(user => {
                            document.getElementById('userIdView').textContent = user.id;
                            document.getElementById('userNameView').textContent = user.first_name + ' ' + user.last_name;
                            document.getElementById('userEmailView').textContent = user.email;
                            document.getElementById('userAddressView').textContent = user.address;
                            document.getElementById('userNicView').textContent = user.nic;
                            document.getElementById('userDobView').textContent = user.dob;
                            document.getElementById('userMobileView').textContent = user.mobile_number;
                        });
                });
            });

            // Remove User Modal
            document.querySelectorAll('.remove-user').forEach(button => {
                button.addEventListener('click', function () {
                    const userId = this.getAttribute('data-id');
                    document.getElementById('removeUserId').value = userId;
                });
            });

            document.getElementById('removeUserForm').addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('users.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                  .then(result => {
                      if (result.status === 'success') {
                          window.location.reload();
                      } else {
                          alert('Error removing user. Please try again.');
                      }
                  });
            });
        });
    </script>
</body>
</html>
