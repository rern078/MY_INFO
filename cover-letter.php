<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit();
}

// Handle logout
if (isset($_GET['logout'])) {
      session_destroy();
      header("Location: index.php");
      exit();
}

// Fetch Personal Information
$personalInfoQuery = "SELECT * FROM personal_info ORDER BY id DESC LIMIT 1";
$personalInfoResult = mysqli_query($conn, $personalInfoQuery);
if (!$personalInfoResult) {
      die("Error fetching personal information: " . mysqli_error($conn));
}
$personalInfo = mysqli_fetch_assoc($personalInfoResult);

// Fetch Company Information
$companyInfoQuery = "SELECT * FROM company_info ORDER BY id DESC LIMIT 1";
$companyInfoResult = mysqli_query($conn, $companyInfoQuery);
if (!$companyInfoResult) {
      die("Error fetching company information: " . mysqli_error($conn));
}
$companyInfo = mysqli_fetch_assoc($companyInfoResult);

// Fetch Cover Letter Content
$coverLetterQuery = "SELECT * FROM cover_letter ORDER BY id DESC LIMIT 1";
$coverLetterResult = mysqli_query($conn, $coverLetterQuery);
if (!$coverLetterResult) {
      die("Error fetching cover letter: " . mysqli_error($conn));
}
$coverLetter = mysqli_fetch_assoc($coverLetterResult);

// Current Date
$currentDate = date('F d, Y');

// Check if required data exists
$hasData = $personalInfo && $companyInfo && $coverLetter;
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Cover Letter - <?php echo htmlspecialchars($personalInfo['name'] ?? 'User'); ?></title>
      <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">
      <div class="container">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        <!-- Navigation -->
                        <div class="nav-buttons text-center">
                              <a href="index.php" class="btn btn-outline-primary">
                                    <i class="fas fa-file-alt me-2"></i>View SR1
                              </a>
                              <a href="cover-letter.php" class="btn btn-primary">
                                    <i class="fas fa-envelope me-2"></i>View SR2
                              </a>
                              <a href="certificates.php" class="btn btn-outline-success">
                                    <i class="fas fa-certificate me-2"></i>View Certificates
                              </a>
                              <a href="generate_pdf.php?type=cover-letter" class="btn btn-outline-success">
                                    <i class="fas fa-download me-2"></i>Download PDF
                              </a>
                              <?php if ($_SESSION['username'] === 'chamrern'): ?>
                                    <a href="admin.php" class="btn btn-outline-primary">
                                          <i class="fas fa-cog me-2"></i>Admin Panel
                                    </a>
                              <?php else: ?>
                                    <a href="user_dashboard.php" class="btn btn-outline-primary">
                                          <i class="fas fa-user me-2"></i>Dashboard
                                    </a>
                              <?php endif; ?>
                              <a href="?logout=1" class="btn btn-outline-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                              </a>
                        </div>

                        <?php if (!$hasData): ?>
                              <div class="alert alert-warning mt-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    No cover letter data available. Please contact the administrator to set up your cover letter.
                              </div>
                        <?php else: ?>
                              <!-- Cover Letter Content -->
                              <div class="card shadow-sm mt-4">
                                    <div class="card-body">
                                          <!-- Header -->
                                          <div class="text-center mb-4">
                                                <h2><?php echo htmlspecialchars($personalInfo['name']); ?></h2>
                                                <p class="text-muted"><?php echo htmlspecialchars($personalInfo['title']); ?></p>
                                                <div class="small text-muted">
                                                      <i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($personalInfo['email']); ?>
                                                      <i class="fas fa-phone ms-3 me-2"></i><?php echo htmlspecialchars($personalInfo['phone']); ?>
                                                      <i class="fas fa-map-marker-alt ms-3 me-2"></i><?php echo htmlspecialchars($personalInfo['location']); ?>
                                                </div>
                                          </div>

                                          <!-- Personal Information -->
                                          <div class="row mb-4">
                                                <div class="col-md-6">
                                                      <h6 class="mb-3">Personal Details</h6>
                                                      <ul class="list-unstyled">
                                                            <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($personalInfo['date_of_birth']); ?></li>
                                                            <li><strong>Gender:</strong> <?php echo htmlspecialchars($personalInfo['gender']); ?></li>
                                                            <li><strong>Nationality:</strong> <?php echo htmlspecialchars($personalInfo['nationality']); ?></li>
                                                            <li><strong>Marital Status:</strong> <?php echo htmlspecialchars($personalInfo['marital_status']); ?></li>
                                                            <li><strong>Religion:</strong> <?php echo htmlspecialchars($personalInfo['religion']); ?></li>
                                                      </ul>
                                                </div>
                                                <div class="col-md-6">
                                                      <h6 class="mb-3">Physical Information</h6>
                                                      <ul class="list-unstyled">
                                                            <li><strong>Height:</strong> <?php echo htmlspecialchars($personalInfo['height']); ?></li>
                                                            <li><strong>Weight:</strong> <?php echo htmlspecialchars($personalInfo['weight']); ?></li>
                                                      </ul>
                                                </div>
                                          </div>

                                          <!-- Address Information -->
                                          <div class="mb-4">
                                                <h6 class="mb-3">Address</h6>
                                                <p>
                                                      <?php echo htmlspecialchars($personalInfo['address']); ?><br>
                                                      <?php echo htmlspecialchars($personalInfo['city'] . ', ' . $personalInfo['state'] . ' ' . $personalInfo['zip']); ?><br>
                                                      <?php echo htmlspecialchars($personalInfo['country']); ?>
                                                </p>
                                          </div>

                                          <!-- Date -->
                                          <div class="text-end mb-4">
                                                <p class="text-muted"><?php echo $currentDate; ?></p>
                                          </div>

                                          <!-- Recipient Information -->
                                          <div class="mb-4">
                                                <p>
                                                      <?php echo htmlspecialchars($companyInfo['hiring_manager']); ?><br>
                                                      <?php echo htmlspecialchars($companyInfo['name']); ?><br>
                                                      <?php echo htmlspecialchars($companyInfo['street']); ?><br>
                                                      <?php echo htmlspecialchars($companyInfo['city'] . ', ' . $companyInfo['state'] . ' ' . $companyInfo['zip']); ?>
                                                </p>
                                          </div>

                                          <!-- Greeting -->
                                          <div class="mb-4">
                                                <p>Dear <?php echo htmlspecialchars($companyInfo['hiring_manager']); ?>,</p>
                                          </div>

                                          <!-- Introduction -->
                                          <div class="mb-4">
                                                <p><?php echo htmlspecialchars($coverLetter['introduction']); ?></p>
                                          </div>

                                          <!-- Body -->
                                          <div class="mb-4">
                                                <p><?php echo nl2br(htmlspecialchars($coverLetter['body'])); ?></p>
                                          </div>

                                          <!-- Closing -->
                                          <div class="mb-4">
                                                <p><?php echo htmlspecialchars($coverLetter['closing']); ?></p>
                                          </div>

                                          <!-- Signature -->
                                          <div>
                                                <p>
                                                      Sincerely,<br>
                                                      <?php echo htmlspecialchars($personalInfo['name']); ?>
                                                </p>
                                          </div>
                                    </div>
                              </div>
                        <?php endif; ?>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>