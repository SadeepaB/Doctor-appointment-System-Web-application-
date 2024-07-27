<?php
session_start(); // Start the session to access session variables

// Database connection
include("connection.php"); // Ensure this file contains your database connection setup

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the user is logged in by checking a session variable
$isLoggedIn = isset($_SESSION['user_id']);
$user_id = $isLoggedIn ? $_SESSION['user_id'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $isLoggedIn) {
    // Debug: Check if POST data is received
    echo "<script>console.log('POST data received');</script>";
    
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $message = $_POST['message'];

    $stmt = $con->prepare("INSERT INTO feedback (user_id, user_name, user_email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $user_name, $user_email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Your message has been sent successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Fetch feedback and replies
$feedback_query = "SELECT * FROM feedback WHERE user_id = ?";
$stmt = $con->prepare($feedback_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$feedback_result = $stmt->get_result();

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

  <!--Nav bar-->
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
              <li class="nav-item">
                <a class="nav-link" href="doctors.php">Doctors</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="my appointments.php">My Appointments</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link active" href="contact us.php">Contact Us</a>
              </li>
              <?php
                if ($isLoggedIn) {
                    echo '<li class="nav-item d-flex align-items-center">';
                    echo '    <a href="userdashboard.php"><img src="images/profileicon.png" class="rounded-circle img-hover" alt="Profile Image" width="40" height="40"></a>';
                    echo '    <a class="nav-link" href="logout.php"><button class="btn btn-light">Logout</button></a>';
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

  <!--Cover image--> 
  <div class="container mt-4">
    <img class="img-fluid rounded mx-auto d-block" loading="lazy" src="images/contact.jpg" alt="About 1">
  </div>

  <!--Contact-->
  <div class="d-flex justify-content-center align-items-center mt-5 container mb-5">
    <div class="contact">
    <form style="width: 50rem;" method="post" action="">
      <h3 class="display-4 fw-bold text-primary">Send us a message</h3>
      <!-- Name input -->
      <div data-mdb-input-init class="form-outline mb-4">
          <input type="text" name="user_name" id="form4Example1" class="form-control text-primary py-4" style="background-color: rgb(195, 225, 255);font-size: 20px; font-style: italic; color: rgb(0, 0, 0) !important;" placeholder="Enter your name"/>
      </div>
      <!-- Email input -->
      <div data-mdb-input-init class="form-outline mb-4">
          <input type="email" name="user_email" id="form4Example2" class="form-control text-primary py-4" style="background-color: rgb(195, 225, 255);font-size: 20px; font-style: italic; color: rgb(0, 0, 0) !important;" placeholder="Enter your email"/>
      </div>
      <!-- Message input -->
      <div data-mdb-input-init class="form-outline mb-4">
          <textarea class="form-control bg-" name="message" id="form4Example3" rows="6" style="background-color: rgb(195, 225, 255);font-size: 20px; font-style: italic;color: rgb(0, 0, 0) !important;" placeholder="Enter your message"></textarea>
      </div>
      <!-- Checkbox -->
      <div class="form-check d-flex justify-content-center mb-4">
          <input class="form-check-input me-2" type="checkbox" name="send_copy" value="1" id="form4Example4" checked />
          <label class="form-check-label" for="form4Example4">
              Send me a copy of this message
          </label>
      </div>
      <!-- Submit button -->
      <div class="text-center">
          <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4 contactsendbutton">Send</button>
      </div>
    </form>
    </div>
  </div>
  
  <!-- Display Feedback and Replies -->
  <div class="container mt-5 mb-5">
    <h3 class="text-primary">Your Feedback and Replies</h3>
    <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Message sent on: <?= htmlspecialchars($feedback['created_at']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($feedback['message']) ?></p>
                <?php if ($feedback['reply']): ?>
                    <p class="card-text"><strong>Reply:</strong> <?= htmlspecialchars($feedback['reply']) ?></p>
                <?php else: ?>
                    <p class="card-text text-muted">No reply yet</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
  </div>
 
  <!-- Include the footer -->
  <?php include('footer.php'); ?>

<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
