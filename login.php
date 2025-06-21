<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = sanitize_input($_POST['username']);
      $password = $_POST['password'];

      $sql = "SELECT id, username, password FROM users WHERE username = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                  $_SESSION['user_id'] = $user['id'];
                  $_SESSION['username'] = $user['username'];

                  // Check if the user is "chamrern"
                  if ($user['username'] === 'chamrern') {
                        header("Location: admin.php");
                  } else {
                        header("Location: index.php");
                  }
                  exit();
            }
      }
      $error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login - Cover Letter Management</title>
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
                                    <h2 class="text-center mb-4">Login</h2>

                                    <?php if (isset($error)): ?>
                                          <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php endif; ?>

                                    <form method="POST" action="">
                                          <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" name="username" required>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password" required>
                                          </div>
                                          <button type="submit" class="btn btn-primary w-100">Login</button>
                                    </form>

                                    <div class="text-center mt-3">
                                          <p class="mb-0">Don't have an account? <a href="register.php">Register here</a></p>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>