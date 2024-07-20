<?php
session_start();

include("connection.php");

$doctor_name = isset($_POST['doctor_name']) ? trim($_POST['doctor_name']) : '';
$specialization = isset($_POST['specialization']) ? trim($_POST['specialization']) : '';
$hospital = isset($_POST['hospital']) ? trim($_POST['hospital']) : '';
$date = isset($_POST['date']) ? trim($_POST['date']) : '';

$result = null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($doctor_name) || !empty($specialization) || !empty($hospital) || !empty($date)) {
        $query = "SELECT * FROM doctor WHERE 1=1";

        if (!empty($doctor_name)) {
            $query .= " AND name LIKE '%" . mysqli_real_escape_string($con, $doctor_name) . "%'";
        }
        if (!empty($specialization)) {
            $query .= " AND specialization LIKE '%" . mysqli_real_escape_string($con, $specialization) . "%'";
        }
        if (!empty($hospital)) {
            $query .= " AND hospital LIKE '%" . mysqli_real_escape_string($con, $hospital) . "%'";
        }
        $result = mysqli_query($con, $query);
    } else {
        $message = "Please fill in at least one field to search.";
    }
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

<!--Navbar-->

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
<<<<<<< Updated upstream
                    echo '    <a href="#"><img src="images/profileicon.png" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40"></a>';
                    echo '    <a class="nav-link" href="logout.php"><button class="btn btn-light">Logout</button></a>'; // Logout should link to a logout page
=======
                    echo '    <a href="#"><img src="images/User.png" class="rounded-circle" alt="Profile Image" width="40" height="40"></a>';
                    echo '    <a class="nav-link" href="logout.php"><button class="btn btn-light">Logout</button></a>'; 
>>>>>>> Stashed changes
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

<!--Image slider--> 

    <div id="carouselExampleIndicators" class="carousel slide carousel-fade container" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="3000">
          <img src="images/Doctors 1.jpg" class="d-block w-100" alt="D1">
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <img src="images/Doctors 2.jpg" class="d-block w-100" alt="D2">
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <img src="images/Doctors 3.jpg" class="d-block w-100" alt="D3">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>


<!--Doctor Search Form-->
<div class="container mb-4 rounded-3 text-center p-4 bg-light">
    <form class="row g-3" method="POST" action="">
        <div class="col-md-3">
            <label for="doctor-name" class="form-label">Doctor Name</label>
            <input class="form-control" type="text" id="doctor-name" name="doctor_name" placeholder="Search Doctor Name" value="<?php echo htmlspecialchars($doctor_name); ?>">
        </div>
        <div class="col-md-3">
            <label for="specialization" class="form-label">Specialization</label>
            <input class="form-control" type="text" id="specialization" name="specialization" placeholder="Search specialization" value="<?php echo htmlspecialchars($specialization); ?>">
        </div>
        <div class="col-md-3">
            <label for="hospital" class="form-label">Hospital</label>
            <input class="form-control" type="text" id="hospital" name="hospital" placeholder="Search Hospital" value="<?php echo htmlspecialchars($hospital); ?>">
        </div>
        <div class="col-md-3">
            <label for="date" class="form-label">Date</label>
            <input class="form-control" type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
        </div>
        <div class="col-12 pt-3">
            <button type="submit" class="btn btn-primary" style="--bs-btn-padding-y: 10px;--bs-btn-padding-x: 35px; border-radius: 10px;">Search</button>
        </div>
    </form>
    <?php if (!empty($message)): ?>
        <p class="text-danger"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</div>

<!--Doctor Searched Details--> 
<div class="container mb-4 text-center">
    <div class="row g-4">
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $doctorImage = !empty($row['doctor_image']) ? htmlspecialchars($row['doctor_image']) : 'images/User.png';
                    echo '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">';
                    echo '    <div class="card h-100 bg-light">';
                    echo '        <img src="' . $doctorImage . '" class="card-img-top rounded-circle" alt="Doctor Image">';
                    echo '        <div class="card-body">';
                    echo '            <h5 class="card-title">Dr. ' . htmlspecialchars($row['name']) . '</h5>';
                    echo '            <p class="card-text">' . htmlspecialchars($row['specialization']) . '</p>';
                    echo '            <p class="card-text">' . htmlspecialchars($row['hospital']) . '</p>';
                    echo '            <button onclick="handleChannelNow(' . htmlspecialchars($row['id']) . ')" class="btn btn-primary" style="--bs-btn-padding-y: 10px; --bs-btn-padding-x: 35px; border-radius: 10px;">Channel Now</button>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No doctors found matching the criteria.</p>';
            }
        }
        mysqli_close($con);
        ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Sign Up Required</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>You need to sign up or log in to channel a doctor. Please <a href="signup.php">sign up</a> or <a href="login.php">log in</a>.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!--Wellness and Health Tips-->

  <div class="container mb-4">
    <h3 class="text-center mb-4">Wellness and Health Tips</h3>
    <div class="row g-4">
      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="ratio ratio-16x9 rounded-3">
          <iframe src="https://www.youtube.com/embed/zdjWnvbaUZo" title="YouTube video" class="rounded-3" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="ratio ratio-16x9 rounded-3">
          <iframe src="https://www.youtube.com/embed/Cg_GW7yhq20" title="YouTube video" class="rounded-3" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="ratio ratio-16x9 rounded-3">
          <iframe src="https://www.youtube.com/embed/6ajmuRg2o3Q" title="YouTube video" class="rounded-3" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>

  <!-- Include the footer -->
  <?php include('footer.php'); ?>

  <script src="js/bootstrap.min.js"></script>

  <script>
    function handleChannelNow(doctorId) {
    var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>; // Assuming $isLoggedIn is defined in PHP

    if (isLoggedIn) {
        window.location.href = 'channel.php?doctor_id=' + doctorId;
    } else {
        var myModal = new bootstrap.Modal(document.getElementById('signupModal'), {
            keyboard: false
        });
        myModal.show();
    }
}
</script>


</body>
</html>