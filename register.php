<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = sanitize_input($_POST['username']);
      $email = sanitize_input($_POST['email']);
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];

      $errors = [];

      // Validate username
      if (strlen($username) < 3) {
            $errors[] = "Username must be at least 3 characters long";
      }

      // Validate email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
      }

      // Validate password
      if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long";
      }

      if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
      }

      // Check if username or email already exists
      $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
      $check_stmt = mysqli_prepare($conn, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $errors[] = "Username or email already exists";
      }

      if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                  $_SESSION['user_id'] = mysqli_insert_id($conn);
                  $_SESSION['username'] = $username;
                  if ($_SESSION['username'] === 'chamrern') {
                        header("Location: admin.php");
                  } else {
                        header("Location: index.php");
                  }
                  exit();
            } else {
                  $errors[] = "Registration failed. Please try again.";
            }
      }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Register - Cover Letter Management</title>
      <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">
     
      <div class="container py-5">
            <div class="row justify-content-center">
                  <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                              <div class="card-body p-4">
                                    <h2 class="text-center mb-4">Register</h2>

                                    <?php if (!empty($errors)): ?>
                                          <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                      <?php foreach ($errors as $error): ?>
                                                            <li><?php echo $error; ?></li>
                                                      <?php endforeach; ?>
                                                </ul>
                                          </div>
                                    <?php endif; ?>

                                    <form method="POST" action="">
                                          <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" name="username" required>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" required>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password" required>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" name="confirm_password" required>
                                          </div>
                                          <button type="submit" class="btn btn-primary w-100">Register</button>
                                    </form>

                                    <div class="text-center mt-3">
                                          <p class="mb-0">Already have an account? <a href="login.php">Login here</a></p>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>