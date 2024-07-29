<?php
session_start();
include("../connection.php");

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback_id = $_POST['feedback_id'];
    $reply = $_POST['reply'];

    $stmt = $con->prepare("UPDATE feedback SET reply = ? WHERE id = ?");
    $stmt->bind_param("si", $reply, $feedback_id);

    if ($stmt->execute()) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Reply sent successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error: " . $stmt->error . "',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
              </script>";
    }

    $stmt->close();
}

$feedback_query = "SELECT feedback.*, users.first_name, users.last_name FROM feedback JOIN users ON feedback.user_id = users.id";
$feedback_result = $con->query($feedback_query);
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <a class="nav-link" href="appointments.php">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="doctors.php">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">Users</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="feedback.php">Feedback</a>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <a href="admin_profile.php"><img src="../images/profileicon.png" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40"></a>
                    <a class="nav-link" href="../logout.php"><button class="btn btn-light">Logout</button></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Feedback Section -->
<div class="container mt-5">
    <h2 class="fw-bolder mb-4 text-center" style="color: #6295a2;">User Feedback</h2>
    <div class="row gx-5 gy-5">
        <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
            <div class="col-12 col-lg-6">
                <div class="card bg-light shadow border-0 h-100">
                    <div class="row g-0 h-100">
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="card-body p-3">
                                <h5 class="card-title mb-2">Name: <?= htmlspecialchars($feedback['first_name'] . ' ' . $feedback['last_name']) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Email: <?= htmlspecialchars($feedback['user_email']) ?></h6>
                                <p class="card-text mb-2"><?= htmlspecialchars($feedback['message']) ?></p>
                                <?php if ($feedback['reply']): ?>
                                    <p class="card-text"><strong>Reply:</strong> <?= htmlspecialchars($feedback['reply']) ?></p>
                                <?php else: ?>
                                    <form method="post" action="">
                                        <input type="hidden" name="feedback_id" value="<?= $feedback['id'] ?>">
                                        <div class="mb-2">
                                            <label for="reply" class="form-label">Reply</label>
                                            <textarea class="form-control" id="reply" name="reply" rows="2"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Send Reply</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center justify-content-center d-none d-md-flex">
                            <img src="../images/feedbackimg.jpg" class="img-fluid" style="object-fit: cover;" alt="Image description">
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</main>
<!-- Include the footer -->
<?php include('footer.php'); ?>

<script src="../js/bootstrap.bundle.min.js"></script>

</body>
</html>
