<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootsrap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link active" href="doctors.php">Doctors</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="my appointments.php">My Appointments</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact us.php">Contact Us</a>
              </li>
              <?php
                session_start(); // Start the session to access session variables

                // Check if the user is logged in by checking a session variable
                $isLoggedIn = isset($_SESSION['user_id']); // or any other condition to check login status

                if ($isLoggedIn) {
                    // Code to display if the user is logged in
                    echo '<li class="nav-item d-flex align-items-center">';
                    echo '    <a href="userdashboard.php"><img src="images/profileicon.png" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40"></a>';
                    echo '    <a class="nav-link" href="logout.php"><button class="btn btn-light">Logout</button></a>'; // Logout should link to a logout page
                    echo '</li>';
                } else {
                    // Code to display if the user is not logged in
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

<!--Doctors-->
  <div class="container mt-4">
    <h1 class="text-center mb-4" style="color: #6295a2;">All Doctors</h1>
    <div class="row g-4">
    <?php
      $servername = "localhost";
      $username = "root";
      $password = ""; 
      $dbname = "edoca"; 
      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT name, specialization, hospital, doctor_image FROM doctor";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $doctorImage = !empty($row['doctor_image']) ? htmlspecialchars($row['doctor_image']) : 'images/user.png';
              echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                      <div class="card h-auto flex-row p-1 bg-light px-4">
                        <img src="' . $doctorImage . '" class="card-img rounded-circle m-auto" style="width: 75px; height: 75px; object-fit: cover;">
                        <div class="card-body d-flex flex-column px-4">
                          <h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>
                          <h6 class="card-text">' . htmlspecialchars($row["specialization"]) . '</h6>
                          <h6 class="card-text">' . htmlspecialchars($row["hospital"]) . '</h6>
                        </div>
                      </div>
                    </div>';
          }
      } else {
          echo "No results found.";
      }

      $conn->close();
    ?>

    </div>
  </div>

  <!-- Include the footer -->
  <?php include('footer.php'); ?>

  <script src="js/bootstrap.min.js"></script>
</body>
</html>