<?php
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';

// Get current page name
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<style>
      .user-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
      }

      .user-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
      }

      .user-header .container {
            position: relative;
            z-index: 1;
      }

      .nav-buttons {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
      }

      .nav-buttons .btn {
            margin: 5px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
      }

      .nav-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      }

      .nav-buttons .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
      }

      .nav-buttons .btn:hover::before {
            left: 100%;
      }

      /* Active page styling */
      .nav-buttons .btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transform: translateY(-1px);
      }

      .nav-buttons .btn.active:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
      }

      .nav-buttons .btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
      }

      @media (max-width: 768px) {
            .user-header .row {
                  text-align: center;
            }

            .user-header .col-md-6:last-child {
                  margin-top: 10px;
            }

            .nav-buttons .btn {
                  display: block;
                  width: 100%;
                  margin: 5px 0;
            }
      }
</style>

<!-- User Header -->
<?php if ($isLoggedIn): ?>
      <div class="user-header bg-primary text-white py-3 mb-4">
            <div class="container">
                  <div class="row align-items-center">
                        <div class="col-md-6">
                              <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle me-3 fs-3"></i>
                                    <div>
                                          <span class="fw-bold fs-5">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                                          <div class="small opacity-75">You are successfully logged in</div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-6 text-end">
                              <div class="d-flex justify-content-end align-items-center">
                                    <a href="?logout=1" class="btn btn-outline-light btn-sm">
                                          <i class="fas fa-sign-out-alt me-1"></i>Logout
                                    </a>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Navigation for logged in users -->
      <div class="container mb-4">
            <div class="nav-buttons text-center">
                  <a href="index.php" class="btn <?php echo ($current_page === 'index') ? 'active' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-file-alt me-2"></i>View SR1
                  </a>
                  <a href="cover-letter.php" class="btn <?php echo ($current_page === 'cover-letter') ? 'active' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-envelope me-2"></i>View SR2
                  </a>
                  <a href="certificates.php" class="btn <?php echo ($current_page === 'certificates') ? 'active' : 'btn-outline-success'; ?>">
                        <i class="fas fa-certificate me-2"></i>View Certificates
                  </a>
                  <a href="generate_pdf.php?type=cv" class="btn btn-outline-success">
                        <i class="fas fa-download me-2"></i>Download PDF
                  </a>
                  <?php if ($username === 'chamrern'): ?>
                        <a href="admin.php" class="btn <?php echo ($current_page === 'admin') ? 'active' : 'btn-outline-primary'; ?>">
                              <i class="fas fa-cog me-2"></i>Admin Panel
                        </a>
                  <?php else: ?>
                        <a href="user_dashboard.php" class="btn <?php echo ($current_page === 'user_dashboard') ? 'active' : 'btn-outline-primary'; ?>">
                              <i class="fas fa-user me-2"></i>Dashboard
                        </a>
                  <?php endif; ?>
            </div>
      </div>
<?php else: ?>
      <!-- Navigation for non-logged in users -->
      <div class="container mb-4">
            <div class="nav-buttons text-center">
                  <a href="login.php" class="btn <?php echo ($current_page === 'login') ? 'active' : 'btn-primary'; ?>">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                  </a>
                  <a href="register.php" class="btn <?php echo ($current_page === 'register') ? 'active' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-user-plus me-2"></i>Register
                  </a>
            </div>
      </div>
<?php endif; ?>