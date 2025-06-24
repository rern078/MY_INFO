<?php
session_start();
require_once 'config.php';
require_once 'languages.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = sanitize_input($_POST['username']);
      $email = sanitize_input($_POST['email']);
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];

      $errors = [];

      // Validate username
      if (strlen($username) < 3) {
            $errors[] = t('username_min_length');
      }

      // Validate username maximum length (50 characters to match database field)
      if (strlen($username) > 50) {
            $errors[] = t('username_max_length');
      }

      // Validate username contains only alphabets
      if (!preg_match('/^[a-zA-Z]+$/', $username)) {
            $errors[] = t('username_alphabets_only');
      }

      // Validate email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = t('invalid_email_format');
      }

      // Validate password
      if (strlen($password) < 6) {
            $errors[] = t('password_min_length');
      }

      // Validate password contains only alphanumeric characters
      if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
            $errors[] = t('password_alphanumeric_only');
      }

      if ($password !== $confirm_password) {
            $errors[] = t('password_mismatch');
      }

      // Check if username or email already exists
      if (empty($errors)) {
            $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
            $check_stmt = mysqli_prepare($conn, $check_sql);

            if ($check_stmt) {
                  mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
                  mysqli_stmt_execute($check_stmt);
                  mysqli_stmt_store_result($check_stmt);

                  if (mysqli_stmt_num_rows($check_stmt) > 0) {
                        $errors[] = t('username_or_email_exists');
                  }
                  mysqli_stmt_close($check_stmt);
            } else {
                  $errors[] = t('database_error');
            }
      }

      if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                  mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

                  if (mysqli_stmt_execute($stmt)) {
                        $_SESSION['user_id'] = mysqli_insert_id($conn);
                        $_SESSION['username'] = $username;
                        mysqli_stmt_close($stmt);

                        if ($_SESSION['username'] === 'chamrern') {
                              header("Location: admin.php");
                        } else {
                              header("Location: index.php");
                        }
                        exit();
                  } else {
                        $errors[] = t('registration_failed');
                        error_log("Registration failed: " . mysqli_error($conn));
                  }
                  mysqli_stmt_close($stmt);
            } else {
                  $errors[] = t('database_error');
                  error_log("Prepare statement failed: " . mysqli_error($conn));
            }
      }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $current_language; ?>" dir="<?php echo getLanguageDirection(); ?>">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo t('register'); ?> - Cover Letter Management</title>
      <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <style>
            .password-field {
                  position: relative;
            }

            .password-toggle {
                  position: absolute;
                  right: 10px;
                  top: 50%;
                  transform: translateY(-50%);
                  background: none;
                  border: none;
                  color: #6c757d;
                  cursor: pointer;
                  z-index: 10;
            }

            .password-toggle:hover {
                  color: #495057;
            }

            .form-control[type="password"] {
                  padding-right: 40px;
            }

            .form-control.error {
                  border-color: #dc3545;
                  box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            }

            .form-control.valid {
                  border-color: #28a745;
                  box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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
                                    <h2 class="text-center mb-4"><?php echo t('register'); ?></h2>

                                    <?php if (!empty($errors)): ?>
                                          <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                      <?php foreach ($errors as $error): ?>
                                                            <li><?php echo htmlspecialchars($error); ?></li>
                                                      <?php endforeach; ?>
                                                </ul>
                                          </div>
                                    <?php endif; ?>

                                    <form method="POST" action="" id="registerForm" onsubmit="return validateForm()">
                                          <div class="mb-3">
                                                <label class="form-label"><?php echo t('username'); ?></label>
                                                <input type="text" class="form-control" name="username" id="username" maxlength="50"
                                                      oninput="validateUsername(this)"
                                                      onfocus="showHelpText('username-help')"
                                                      onblur="hideHelpText('username-help')">
                                                <small class="text-muted help-text" id="username-help" style="display: none;"><?php echo t('username_help_text'); ?></small>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label"><?php echo t('email'); ?></label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                      onfocus="showHelpText('email-help')"
                                                      onblur="hideHelpText('email-help')">
                                                <small class="text-muted help-text" id="email-help" style="display: none;"><?php echo t('email_help_text'); ?></small>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label"><?php echo t('password'); ?></label>
                                                <div class="password-field">
                                                      <input type="password" class="form-control" name="password" id="password"
                                                            oninput="validatePassword(this)"
                                                            onfocus="showHelpText('password-help')"
                                                            onblur="hideHelpText('password-help')">
                                                      <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                                            <i class="fas fa-eye" id="password-icon"></i>
                                                      </button>
                                                </div>
                                                <small class="text-muted help-text" id="password-help" style="display: none;"><?php echo t('password_help_text'); ?></small>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label"><?php echo t('confirm_password'); ?></label>
                                                <div class="password-field">
                                                      <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                                            onfocus="showHelpText('confirm-password-help')"
                                                            onblur="hideHelpText('confirm-password-help')">
                                                      <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                                                            <i class="fas fa-eye" id="confirm-password-icon"></i>
                                                      </button>
                                                </div>
                                                <small class="text-muted help-text" id="confirm-password-help" style="display: none;"><?php echo t('confirm_password_help_text'); ?></small>
                                          </div>

                                          <button type="submit" class="btn btn-primary w-100 mb-3">
                                                <?php echo t('register'); ?>
                                          </button>

                                          <div class="text-center">
                                                <p class="mb-0">
                                                      <?php echo t('already_have_account'); ?>
                                                      <a href="login.php" class="text-decoration-none">
                                                            <?php echo t('login_here'); ?>
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
            function validateForm() {
                  const username = document.getElementById('username').value.trim();
                  const email = document.getElementById('email').value.trim();
                  const password = document.getElementById('password').value.trim();
                  const confirmPassword = document.getElementById('confirm_password').value.trim();

                  if (!username) {
                        Swal.fire({
                              icon: 'error',
                              title: '<?php echo t('error'); ?>',
                              text: '<?php echo t('username_required'); ?>'
                        });
                        return false;
                  }

                  if (!email) {
                        Swal.fire({
                              icon: 'error',
                              title: '<?php echo t('error'); ?>',
                              text: '<?php echo t('email_required'); ?>'
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

                  if (!confirmPassword) {
                        Swal.fire({
                              icon: 'error',
                              title: '<?php echo t('error'); ?>',
                              text: '<?php echo t('confirm_password_required'); ?>'
                        });
                        return false;
                  }

                  return true;
            }

            function validateUsername(input) {
                  const value = input.value;
                  const isValid = /^[a-zA-Z]{3,50}$/.test(value);

                  input.classList.remove('error', 'valid');
                  input.classList.add(isValid ? 'valid' : 'error');
            }

            function validatePassword(input) {
                  const value = input.value;
                  const isValid = /^[a-zA-Z0-9]{6,}$/.test(value);

                  input.classList.remove('error', 'valid');
                  input.classList.add(isValid ? 'valid' : 'error');
            }

            function togglePassword(fieldId) {
                  const field = document.getElementById(fieldId);
                  const icon = document.getElementById(fieldId + '-icon');

                  if (field.type === 'password') {
                        field.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                  } else {
                        field.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                  }
            }

            function showHelpText(elementId) {
                  document.getElementById(elementId).style.display = 'block';
            }

            function hideHelpText(elementId) {
                  document.getElementById(elementId).style.display = 'none';
            }
      </script>
</body>

</html>