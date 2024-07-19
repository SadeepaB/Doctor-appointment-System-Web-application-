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
        <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" alt="Logo" width="50" height="40">
        </a>
        <a class="navbar-brand" href="index.html">Edoca</a>
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
              <li class="nav-item active">
                <a class="nav-link active" href="my appointments.php">My Appointments</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact us.php">Contact Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="signup.php"><button class="btn btn-primary" style="background-color: #130FEA; ">Signup</button></a>
              </li>
            </ul>
        </div>
    </div>
  </nav>

  <!--Appinment cards-->

  <!--cars row 1-->
  <div class="container">
    <h1 class="text-center my-4" style="color: #6295a2;">My Appoinments</h1>
    <div class="row">
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-01
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 01</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.20<br>
              Starts: @18.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
  
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-02
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 02</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.21<br>
              Starts: @19.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
  
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-03
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 03</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.22<br>
              Starts: @20.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
    </div>

     <!--cars row 2-->
    <div class="row">
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-01
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 01</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.20<br>
              Starts: @18.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
  
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-02
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 02</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.21<br>
              Starts: @19.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
  
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-03
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 03</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.22<br>
              Starts: @20.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
    </div>

     <!--cars row 3-->
     <div class="row">
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-01
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 01</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.20<br>
              Starts: @18.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
  
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-02
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 02</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.21<br>
              Starts: @19.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
  
      <div class="col-md-4">
        <div class="card text-left m-3">
          <div class="card-header">
            Booking Date: 2024.07.18<br>
            Reference Number: oc-000-03
          </div>
          <div class="card-body">
            <h5 class="card-title">Test Session</h5>
            <p class="card-text">Appoinment Number: 03</p>
            <p><b>Test Doctor</b><br>
              Shedule date: 2024.07.22<br>
              Starts: @20.00 (24h)</p>
          </div>
          <div class="card-footer text-body-secondary">
            <a href="#" class="btn btn-primary">Cancel Booking</a>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Include the footer -->
  <?php include('footer.php'); ?>

  <script src="js/bootstrap.min.js"></script>
</body>
</html>