<?php
session_start();
require_once 'config.php';

// Handle logout - clear session and remember me cookie
if (isset($_GET['logout'])) {
      // Unset all session variables
      $_SESSION = array();

      // Destroy the session cookie
      if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                  session_name(),
                  '',
                  time() - 42000,
                  $params["path"],
                  $params["domain"],
                  $params["secure"],
                  $params["httponly"]
            );
      }

      // Destroy the session
      session_destroy();

      // Clear remember me cookie
      if (isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, '/');
      }

      header("Location: index.php");
      exit();
}

// Variables to store saved credentials
$saved_username = '';
$saved_password = '';
$remember_checked = false;

// Check for remember me cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user']) && !isset($_GET['show_saved'])) {
      $cookie_data = json_decode($_COOKIE['remember_user'], true);
      if ($cookie_data && isset($cookie_data['username']) && isset($cookie_data['password'])) {
            $saved_username = sanitize_input($cookie_data['username']);
            $saved_password = $cookie_data['password'];
            $remember_checked = true;

            // Auto-login if credentials are valid
            $sql = "SELECT id, username, password FROM users WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $saved_username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result)) {
                  if (password_verify($saved_password, $user['password'])) {
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

// If user wants to see saved credentials, load them from cookie
if (isset($_GET['show_saved']) && isset($_COOKIE['remember_user'])) {
      $cookie_data = json_decode($_COOKIE['remember_user'], true);
      if ($cookie_data && isset($cookie_data['username']) && isset($cookie_data['password'])) {
            $saved_username = sanitize_input($cookie_data['username']);
            $saved_password = $cookie_data['password'];
            $remember_checked = true;
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

      // If login failed, preserve the entered values
      $saved_username = $username;
      $saved_password = $password;
      $remember_checked = $remember_me;
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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <div class="container py-5">
            <div class="row justify-content-center">
                  <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                              <div class="card-body p-4">
                                    <h2 class="text-center mb-4">Login</h2>

                                    <form method="POST" action="" id="loginForm" onsubmit="return validateLoginForm()">
                                          <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($saved_username); ?>">
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <div class="input-group">
                                                      <input type="password" class="form-control" name="password" id="password" value="<?php echo htmlspecialchars($saved_password); ?>">
                                                      <?php if (isset($_GET['show_saved']) && isset($_COOKIE['remember_user'])): ?>
                                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                                  <i class="fas fa-eye" id="toggleIcon"></i>
                                                            </button>
                                                      <?php endif; ?>
                                                </div>
                                          </div>

                                          <div class="remember-me-container">
                                                <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe" <?php echo $remember_checked ? 'checked' : ''; ?>>
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
                                          <?php if (isset($_COOKIE['remember_user'])): ?>
                                                <p class="mt-2 mb-0">
                                                      <a href="login.php?show_saved=1" class="text-muted small">
                                                            <i class="fas fa-key me-1"></i>View saved credentials
                                                      </a>
                                                </p>
                                          <?php endif; ?>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

      <script>
            // Password toggle functionality
            document.addEventListener('DOMContentLoaded', function() {
                  const togglePassword = document.getElementById('togglePassword');
                  const password = document.getElementById('password');
                  const toggleIcon = document.getElementById('toggleIcon');

                  if (togglePassword && password && toggleIcon) {
                        togglePassword.addEventListener('click', function() {
                              const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                              password.setAttribute('type', type);

                              // Toggle icon
                              if (type === 'text') {
                                    toggleIcon.classList.remove('fa-eye');
                                    toggleIcon.classList.add('fa-eye-slash');
                              } else {
                                    toggleIcon.classList.remove('fa-eye-slash');
                                    toggleIcon.classList.add('fa-eye');
                              }
                        });
                  }

                  // Show success message for logout if present
                  <?php if (isset($_GET['logout'])): ?>
                        Swal.fire({
                              icon: 'success',
                              title: 'Logged Out Successfully',
                              text: 'You have been successfully logged out.',
                              confirmButtonColor: '#28a745',
                              timer: 3000,
                              timerProgressBar: true
                        });
                  <?php endif; ?>

                  // Show info message for saved credentials if present
                  <?php if (isset($_GET['show_saved']) && isset($_COOKIE['remember_user'])): ?>
                        Swal.fire({
                              icon: 'info',
                              title: 'Saved Credentials',
                              text: 'Showing your saved credentials. You can modify them and login again.',
                              confirmButtonColor: '#17a2b8'
                        });
                  <?php endif; ?>

                  // Show error message if login failed
                  <?php if (isset($error)): ?>
                        Swal.fire({
                              icon: 'error',
                              title: 'Login Failed',
                              text: '<?php echo addslashes($error); ?>',
                              confirmButtonColor: '#dc3545'
                        });
                  <?php endif; ?>
            });

            // Form validation function
            function validateLoginForm() {
                  const username = document.getElementById('username');
                  const password = document.getElementById('password');

                  // Check for empty fields
                  if (!username.value.trim()) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Username cannot be empty!',
                              confirmButtonColor: '#dc3545'
                        });
                        username.focus();
                        return false;
                  }

                  if (!password.value.trim()) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Password cannot be empty!',
                              confirmButtonColor: '#dc3545'
                        });
                        password.focus();
                        return false;
                  }

                  // Show loading state
                  Swal.fire({
                        title: 'Logging in...',
                        text: 'Please wait while we authenticate your credentials.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                              Swal.showLoading();
                        }
                  });

                  // Allow form submission
                  return true;
            }
      </script>
</body>

</html>