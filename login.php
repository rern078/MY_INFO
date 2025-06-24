<?php
session_start();
require_once 'config.php';
require_once 'languages.php';

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
      $error = t('invalid_credentials');

      // If login failed, preserve the entered values
      $saved_username = $username;
      $saved_password = $password;
      $remember_checked = $remember_me;
}
?>

<!DOCTYPE html>
<html lang="<?php echo $current_language; ?>" dir="<?php echo getLanguageDirection(); ?>">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo t('login'); ?> - Cover Letter Management</title>
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
      <?php include 'header.php'; ?>

      <div class="container py-5">
            <div class="row justify-content-center">
                  <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                              <div class="card-body p-4">
                                    <h2 class="text-center mb-4"><?php echo t('login'); ?></h2>

                                    <?php if (isset($error)): ?>
                                          <div class="alert alert-danger" role="alert">
                                                <?php echo htmlspecialchars($error); ?>
                                          </div>
                                    <?php endif; ?>

                                    <form method="POST" action="" id="loginForm" onsubmit="return validateLoginForm()">
                                          <div class="mb-3">
                                                <label class="form-label"><?php echo t('username'); ?></label>
                                                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($saved_username); ?>">
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label"><?php echo t('password'); ?></label>
                                                <div class="input-group">
                                                      <input type="password" class="form-control" name="password" id="password" value="<?php echo htmlspecialchars($saved_password); ?>">
                                                      <?php if (isset($_GET['show_saved']) && isset($_COOKIE['remember_user'])): ?>
                                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                                  <i class="fas fa-eye"></i>
                                                            </button>
                                                      <?php endif; ?>
                                                </div>
                                          </div>

                                          <div class="remember-me-container">
                                                <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe" <?php echo $remember_checked ? 'checked' : ''; ?>>
                                                      <label class="form-check-label" for="rememberMe">
                                                            <?php echo t('remember_me'); ?>
                                                      </label>
                                                </div>
                                                <?php if (isset($_COOKIE['remember_user'])): ?>
                                                      <a href="?show_saved=1" class="text-decoration-none small">
                                                            <?php echo t('show_saved_credentials'); ?>
                                                      </a>
                                                <?php endif; ?>
                                          </div>

                                          <button type="submit" class="btn btn-primary w-100 mb-3">
                                                <?php echo t('login'); ?>
                                          </button>

                                          <div class="text-center">
                                                <p class="mb-0">
                                                      <?php echo t('dont_have_account'); ?>
                                                      <a href="register.php" class="text-decoration-none">
                                                            <?php echo t('register_here'); ?>
                                                      </a>
                                                </p>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
            function validateLoginForm() {
                  const username = document.querySelector('input[name="username"]').value.trim();
                  const password = document.querySelector('input[name="password"]').value.trim();

                  if (!username) {
                        Swal.fire({
                              icon: 'error',
                              title: '<?php echo t('error'); ?>',
                              text: '<?php echo t('username_required'); ?>'
                        });
                        return false;
                  }

                  if (!password) {
                        Swal.fire({
                              icon: 'error',
                              title: '<?php echo t('error'); ?>',
                              text: '<?php echo t('password_required'); ?>'
                        });
                        return false;
                  }

                  return true;
            }

            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                  togglePassword.addEventListener('click', function() {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);

                        const icon = this.querySelector('i');
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                  });
            }
      </script>
</body>

</html>