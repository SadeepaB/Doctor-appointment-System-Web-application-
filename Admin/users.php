<?php
session_start();
include("../connection.php");
if (!isset($_SESSION['admin_id'])){
    header("Location: ../login.php");
    exit();
}
$isLoggedIn = isset($_SESSION['admin_id']);
?>

<?php
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
    exit();
}
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
                  <li class="nav-item active">
                    <a class="nav-link active" href="users.php">Users</a>
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
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="text-center">
                <?php
                    // Fetch the total number of users
                    $count_result = $con->query("SELECT COUNT(*) as count FROM users");
                    $count_row = $count_result->fetch_assoc();
                    $user_count = $count_row['count'];
                ?>
                All Users (<?php echo $user_count; ?>)</h4>
                <table class="table table-striped table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Fetch users from database
                        $result = $con->query("SELECT id, first_name, last_name, email FROM users");
                        while($user = $result->fetch_assoc()): 
                        ?>
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
                        <?php endwhile; ?>
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
                                <p class="fw-bold">Name : <span id="userNameView"></span></p>
                                <p class="fw-bold">Email : <span id="userEmailView"></span></p>
                                <p class="fw-bold">Address : <span id="userAddressView"></span></p>
                                <p class="fw-bold">NIC : <span id="userNicView"></span></p>
                                <p class="fw-bold">Date of Birth : <span id="userDobView"></span></p>
                                <p class="fw-bold">Mobile Number : <span id="userMobileView"></span></p>
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
                        <input type="hidden" id="removeUserId" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" name="removeUser">Remove</button>
                        </div>
                    </form>
                </div>
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
            // View user details
            $('.view-user').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '',
                    type: 'GET',
                    data: {id: id, action: 'get_user'},
                    dataType: 'json',
                    success: function(response) {
                        $('#userIdView').text(response.id);
                        $('#userNameView').text(response.first_name + ' ' + response.last_name);
                        $('#userEmailView').text(response.email);
                        $('#userAddressView').text(response.address);
                        $('#userNicView').text(response.nic);
                        $('#userDobView').text(response.dob);
                        $('#userMobileView').text(response.mobile_number);
                    }
                });
            });

            // Remove user
            $('.remove-user').on('click', function() {
                var id = $(this).data('id');
                $('#removeUserId').val(id);
            });

            // Handle remove user form submission
            $('#removeUserForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#removeUserId').val();
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {id: id, action: 'remove_user'},
                    success: function(response) {
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>


