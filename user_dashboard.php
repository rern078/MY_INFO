<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
      header("Location: index.php");
      exit();
}

// Handle logout
if (isset($_GET['logout'])) {
      session_destroy();
      header("Location: index.php");
      exit();
}

// Fetch user's information
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>User Dashboard - Cover Letter Management</title>
      <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">
      <div class="container py-5">
            <div class="row justify-content-center">
                  <div class="col-lg-8">
                        <div class="card shadow-sm">
                              <div class="card-body p-4">
                                    <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>

                                    <div class="text-center mb-4">
                                          <p class="lead">You are logged in as a regular user.</p>
                                          <!-- <p>You can view your CV and cover letter, but cannot modify them.</p> -->
                                          <p>You can view class list and certificate, but cannot modify them.</p>
                                    </div>

                                    <div class="nav-buttons text-center">
                                          <a href="index.php" class="btn btn-outline-primary me-2 mb-2">
                                                <i class="fas fa-file-alt me-2"></i>View SR1
                                          </a>
                                          <a href="cover-letter.php" class="btn btn-outline-primary me-2 mb-2">
                                                <i class="fas fa-envelope me-2"></i>View SR2
                                          </a>
                                          <a href="certificates.php" class="btn btn-outline-success me-2 mb-2">
                                                <i class="fas fa-certificate me-2"></i>View Certificates
                                          </a>
                                          <a href="?logout=1" class="btn btn-outline-danger me-2 mb-2">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                          </a>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>