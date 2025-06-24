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

      // Validate username maximum length (50 characters to match database field)
      if (strlen($username) > 50) {
            $errors[] = "Username must not exceed 50 characters";
      }

      // Validate username contains only alphabets
      if (!preg_match('/^[a-zA-Z]+$/', $username)) {
            $errors[] = "Username must contain only alphabets (letters)";
      }

      // Validate email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
      }

      // Validate password
      if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long";
      }

      // Validate password contains only alphanumeric characters
      if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
            $errors[] = "Password must contain only letters and numbers";
      }

      if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
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
                        $errors[] = "Username or email already exists";
                  }
                  mysqli_stmt_close($check_stmt);
            } else {
                  $errors[] = "Database error occurred. Please try again.";
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
                        $errors[] = "Registration failed. Please try again.";
                        error_log("Registration failed: " . mysqli_error($conn));
                  }
                  mysqli_stmt_close($stmt);
            } else {
                  $errors[] = "Database error occurred. Please try again.";
                  error_log("Prepare statement failed: " . mysqli_error($conn));
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
                                                            <li><?php echo htmlspecialchars($error); ?></li>
                                                      <?php endforeach; ?>
                                                </ul>
                                          </div>
                                    <?php endif; ?>

                                    <form method="POST" action="" id="registerForm" onsubmit="return validateForm()">
                                          <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" name="username" id="username" maxlength="50"
                                                      oninput="validateUsername(this)"
                                                      onfocus="showHelpText('username-help')"
                                                      onblur="hideHelpText('username-help')">
                                                <small class="text-muted help-text" id="username-help" style="display: none;">Only alphabets (a-z, A-Z) allowed, 3-50 characters</small>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                      onfocus="showHelpText('email-help')"
                                                      onblur="hideHelpText('email-help')">
                                                <small class="text-muted help-text" id="email-help" style="display: none;">Enter a valid email address</small>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <div class="password-field">
                                                      <input type="password" class="form-control" name="password" id="password"
                                                            oninput="validatePassword(this)"
                                                            onfocus="showHelpText('password-help')"
                                                            onblur="hideHelpText('password-help')">
                                                      <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                                            <i class="fas fa-eye" id="password-icon"></i>
                                                      </button>
                                                </div>
                                                <small class="text-muted help-text" id="password-help" style="display: none;">Only letters and numbers (a-z, A-Z, 0-9) allowed, minimum 6 characters</small>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <div class="password-field">
                                                      <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                                            onfocus="showHelpText('confirm-password-help')"
                                                            onblur="hideHelpText('confirm-password-help')">
                                                      <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                                                            <i class="fas fa-eye" id="confirm_password-icon"></i>
                                                      </button>
                                                </div>
                                                <small class="text-muted help-text" id="confirm-password-help" style="display: none;">Re-enter your password to confirm</small>
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
      <script>
            function togglePassword(fieldId) {
                  const passwordField = document.getElementById(fieldId);
                  const icon = document.getElementById(fieldId + '-icon');

                  if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                  } else {
                        passwordField.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                  }
            }

            function validateUsername(input) {
                  const value = input.value;
                  const alphabetOnly = /^[a-zA-Z]*$/;

                  // Truncate if longer than 50 characters
                  if (value.length > 50) {
                        input.value = value.substring(0, 50);
                  }

                  if (value && !alphabetOnly.test(value)) {
                        input.classList.remove('valid');
                        input.classList.add('error');
                        input.value = value.replace(/[^a-zA-Z]/g, '');
                  } else if (value) {
                        input.classList.remove('error');
                        input.classList.add('valid');
                  } else {
                        input.classList.remove('error', 'valid');
                  }
            }

            function validatePassword(input) {
                  const value = input.value;
                  const alphanumericOnly = /^[a-zA-Z0-9]*$/;

                  if (value && !alphanumericOnly.test(value)) {
                        input.classList.remove('valid');
                        input.classList.add('error');
                        input.value = value.replace(/[^a-zA-Z0-9]/g, '');
                  } else if (value) {
                        input.classList.remove('error');
                        input.classList.add('valid');
                  } else {
                        input.classList.remove('error', 'valid');
                  }
            }

            function showHelpText(textId) {
                  const helpText = document.getElementById(textId);
                  if (helpText) {
                        helpText.style.display = 'block';
                  }
            }

            function hideHelpText(textId) {
                  const helpText = document.getElementById(textId);
                  if (helpText) {
                        helpText.style.display = 'none';
                  }
            }

            function validateForm() {
                  const username = document.getElementById('username');
                  const email = document.getElementById('email');
                  const password = document.getElementById('password');
                  const confirmPassword = document.getElementById('confirm_password');

                  // Check for empty fields sequentially
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

                  if (!email.value.trim()) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Email cannot be empty!',
                              confirmButtonColor: '#dc3545'
                        });
                        email.focus();
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

                  if (!confirmPassword.value.trim()) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Confirm Password cannot be empty!',
                              confirmButtonColor: '#dc3545'
                        });
                        confirmPassword.focus();
                        return false;
                  }

                  // Only proceed with format validation if fields are not empty
                  // Validate username format
                  if (!/^[a-zA-Z]+$/.test(username.value)) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Username must contain only alphabets (letters)!',
                              confirmButtonColor: '#dc3545'
                        });
                        username.focus();
                        return false;
                  }

                  // Check username length
                  if (username.value.length < 3) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Username must be at least 3 characters long!',
                              confirmButtonColor: '#dc3545'
                        });
                        username.focus();
                        return false;
                  }

                  // Check username maximum length
                  if (username.value.length > 50) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Username must not exceed 50 characters!',
                              confirmButtonColor: '#dc3545'
                        });
                        username.focus();
                        return false;
                  }

                  // Validate password format
                  if (!/^[a-zA-Z0-9]+$/.test(password.value)) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Password must contain only letters and numbers!',
                              confirmButtonColor: '#dc3545'
                        });
                        password.focus();
                        return false;
                  }

                  // Check password length
                  if (password.value.length < 6) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Password must be at least 6 characters long!',
                              confirmButtonColor: '#dc3545'
                        });
                        password.focus();
                        return false;
                  }

                  // Check if passwords match
                  if (password.value !== confirmPassword.value) {
                        Swal.fire({
                              icon: 'error',
                              title: 'Validation Error',
                              text: 'Passwords do not match!',
                              confirmButtonColor: '#dc3545'
                        });
                        confirmPassword.focus();
                        return false;
                  }

                  // If no errors, allow form submission
                  return true;
            }
      </script>
</body>

</html>