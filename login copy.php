<?php
session_start();
require_once 'config.php';

// Check for remember me cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
      $cookie_data = json_decode($_COOKIE['remember_user'], true);
      if ($cookie_data && isset($cookie_data['username']) && isset($cookie_data['password'])) {
            $username = sanitize_input($cookie_data['username']);
            $password = $cookie_data['password'];

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
      }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = sanitize_input($_POST['username']);
      $password = $_POST['password'];
      $remember_me = isset($_POST['remember_me']);

      $sql = "SELECT id, username, password FROM users WHERE username = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                  $_SESSION['user_id'] = $user['id'];
                  $_SESSION['username'] = $user['username'];

                  // Handle remember me functionality
                  if ($remember_me) {
                        $cookie_data = json_encode([
                              'username' => $username,
                              'password' => $password
                        ]);
                        setcookie('remember_user', $cookie_data, time() + (30 * 24 * 60 * 60), '/'); // 30 days
                  } else {
                        // Remove remember me cookie if unchecked
                        if (isset($_COOKIE['remember_user'])) {
                              setcookie('remember_user', '', time() - 3600, '/');
                        }
                  }

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
      <style>
            .form-check-input:checked {
                  background-color: #0d6efd;
                  border-color: #0d6efd;
            }

            .form-check-input:focus {
                  border-color: #86b7fe;
                  outline: 0;
                  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            }

            .form-check-label {
                  cursor: pointer;
                  user-select: none;
                  font-weight: 500;
                  color: #495057;
            }

            .form-check {
                  margin-bottom: 1rem;
            }

            .remember-me-container {
                  display: flex;
                  align-items: center;
                  justify-content: space-between;
                  margin-bottom: 1.5rem;
            }

            .form-check-input {
                  width: 1.2em;
                  height: 1.2em;
                  margin-top: 0.25em;
                  margin-right: 0.5em;
                  cursor: pointer;
            }
      </style>
</head>

<body class="bg-light">
      <?php include 'header.php'; ?>

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

                                          <div class="remember-me-container">
                                                <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe">
                                                      <label class="form-check-label" for="rememberMe">
                                                            <i class="fas fa-user-check me-1"></i>
                                                            Remember Me
                                                      </label>
                                                </div>
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