<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit();
}

// Check if user is chamrern (admin) for management functions
$is_admin = isset($_SESSION['username']) && $_SESSION['username'] === 'chamrern';

// Handle file upload directory
$upload_dir = 'uploads/certificates/';
if (!file_exists($upload_dir)) {
      mkdir($upload_dir, 0777, true);
}

// Handle form submissions - only allow if user is admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $is_admin) {
      if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                  case 'add':
                        $title = sanitize_input($_POST['title']);
                        $issuing_organization = sanitize_input($_POST['issuing_organization']);
                        $issue_date = sanitize_input($_POST['issue_date']);
                        $expiry_date = !empty($_POST['expiry_date']) ? sanitize_input($_POST['expiry_date']) : null;
                        $credential_id = sanitize_input($_POST['credential_id']);
                        $credential_url = sanitize_input($_POST['credential_url']);
                        $description = sanitize_input($_POST['description']);

                        $file_path = '';
                        $file_type = '';

                        // Handle file upload
                        if (isset($_FILES['certificate_file']) && $_FILES['certificate_file']['error'] == 0) {
                              $file = $_FILES['certificate_file'];
                              $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                              // Check file type
                              if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    $file_type = 'image';
                              } elseif ($file_extension == 'pdf') {
                                    $file_type = 'pdf';
                              } else {
                                    $error = "Invalid file type. Only images (JPG, PNG, GIF) and PDF files are allowed.";
                                    break;
                              }

                              // Generate unique filename
                              $filename = uniqid() . '_' . time() . '.' . $file_extension;
                              $file_path = $upload_dir . $filename;

                              if (move_uploaded_file($file['tmp_name'], $file_path)) {
                                    $file_path = $file_path;
                              } else {
                                    $error = "Failed to upload file.";
                                    break;
                              }
                        }

                        $sql = "INSERT INTO certificates (title, issuing_organization, issue_date, expiry_date, credential_id, credential_url, file_path, file_type, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "sssssssss", $title, $issuing_organization, $issue_date, $expiry_date, $credential_id, $credential_url, $file_path, $file_type, $description);

                        if (mysqli_stmt_execute($stmt)) {
                              $success = "Certificate added successfully!";
                        } else {
                              $error = "Error adding certificate: " . mysqli_error($conn);
                        }
                        mysqli_stmt_close($stmt);
                        break;

                  case 'edit':
                        $id = (int)$_POST['id'];
                        $title = sanitize_input($_POST['title']);
                        $issuing_organization = sanitize_input($_POST['issuing_organization']);
                        $issue_date = sanitize_input($_POST['issue_date']);
                        $expiry_date = !empty($_POST['expiry_date']) ? sanitize_input($_POST['expiry_date']) : null;
                        $credential_id = sanitize_input($_POST['credential_id']);
                        $credential_url = sanitize_input($_POST['credential_url']);
                        $description = sanitize_input($_POST['description']);

                        $file_path = '';
                        $file_type = '';

                        // Handle file upload for edit
                        if (isset($_FILES['certificate_file']) && $_FILES['certificate_file']['error'] == 0) {
                              $file = $_FILES['certificate_file'];
                              $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                              // Check file type
                              if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    $file_type = 'image';
                              } elseif ($file_extension == 'pdf') {
                                    $file_type = 'pdf';
                              } else {
                                    $error = "Invalid file type. Only images (JPG, PNG, GIF) and PDF files are allowed.";
                                    break;
                              }

                              // Generate unique filename
                              $filename = uniqid() . '_' . time() . '.' . $file_extension;
                              $file_path = $upload_dir . $filename;

                              if (move_uploaded_file($file['tmp_name'], $file_path)) {
                                    // Delete old file if exists
                                    $old_file_query = "SELECT file_path FROM certificates WHERE id = ?";
                                    $old_stmt = mysqli_prepare($conn, $old_file_query);
                                    mysqli_stmt_bind_param($old_stmt, "i", $id);
                                    mysqli_stmt_execute($old_stmt);
                                    $old_result = mysqli_stmt_get_result($old_stmt);
                                    if ($old_row = mysqli_fetch_assoc($old_result)) {
                                          if (!empty($old_row['file_path']) && file_exists($old_row['file_path'])) {
                                                unlink($old_row['file_path']);
                                          }
                                    }
                                    mysqli_stmt_close($old_stmt);
                              } else {
                                    $error = "Failed to upload file.";
                                    break;
                              }
                        }

                        if (!empty($file_path)) {
                              $sql = "UPDATE certificates SET title=?, issuing_organization=?, issue_date=?, expiry_date=?, credential_id=?, credential_url=?, file_path=?, file_type=?, description=? WHERE id=?";
                              $stmt = mysqli_prepare($conn, $sql);
                              mysqli_stmt_bind_param($stmt, "sssssssssi", $title, $issuing_organization, $issue_date, $expiry_date, $credential_id, $credential_url, $file_path, $file_type, $description, $id);
                        } else {
                              $sql = "UPDATE certificates SET title=?, issuing_organization=?, issue_date=?, expiry_date=?, credential_id=?, credential_url=?, description=? WHERE id=?";
                              $stmt = mysqli_prepare($conn, $sql);
                              mysqli_stmt_bind_param($stmt, "sssssssi", $title, $issuing_organization, $issue_date, $expiry_date, $credential_id, $credential_url, $description, $id);
                        }

                        if (mysqli_stmt_execute($stmt)) {
                              $success = "Certificate updated successfully!";
                        } else {
                              $error = "Error updating certificate: " . mysqli_error($conn);
                        }
                        mysqli_stmt_close($stmt);
                        break;

                  case 'delete':
                        $id = (int)$_POST['id'];

                        // Get file path before deletion
                        $file_query = "SELECT file_path FROM certificates WHERE id = ?";
                        $file_stmt = mysqli_prepare($conn, $file_query);
                        mysqli_stmt_bind_param($file_stmt, "i", $id);
                        mysqli_stmt_execute($file_stmt);
                        $file_result = mysqli_stmt_get_result($file_stmt);
                        if ($file_row = mysqli_fetch_assoc($file_result)) {
                              if (!empty($file_row['file_path']) && file_exists($file_row['file_path'])) {
                                    unlink($file_row['file_path']);
                              }
                        }
                        mysqli_stmt_close($file_stmt);

                        $sql = "DELETE FROM certificates WHERE id = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $id);

                        if (mysqli_stmt_execute($stmt)) {
                              $success = "Certificate deleted successfully!";
                        } else {
                              $error = "Error deleting certificate: " . mysqli_error($conn);
                        }
                        mysqli_stmt_close($stmt);
                        break;
            }
      }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !$is_admin) {
      // Non-admin users trying to perform management actions
      $error = "Access denied. Only administrators can manage certificates.";
}

// Fetch all certificates
$certificates_query = "SELECT * FROM certificates ORDER BY issue_date DESC";
$certificates_result = mysqli_query($conn, $certificates_query);
$certificates = [];
while ($row = mysqli_fetch_assoc($certificates_result)) {
      $certificates[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Certificates - CV Portfolio</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">

      <!-- Custom Alert Styles -->
      <style>
            /* Alert Container */
            .alert-container {
                  position: fixed;
                  top: 20px;
                  right: 20px;
                  z-index: 9999;
                  max-width: 400px;
                  width: 100%;
            }

            /* Custom Alert */
            .custom-alert {
                  background: white;
                  border-radius: 12px;
                  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
                  margin-bottom: 16px;
                  overflow: hidden;
                  transform: translateX(100%);
                  animation: slideInRight 0.5s ease-out forwards;
                  border-left: 4px solid;
            }

            .custom-alert-success {
                  border-left-color: #10b981;
            }

            .custom-alert-error {
                  border-left-color: #ef4444;
            }

            /* Alert Content */
            .alert-content {
                  display: flex;
                  align-items: flex-start;
                  padding: 16px 20px;
                  position: relative;
            }

            /* Alert Icon */
            .alert-icon {
                  flex-shrink: 0;
                  width: 24px;
                  height: 24px;
                  margin-right: 12px;
                  margin-top: 2px;
            }

            .custom-alert-success .alert-icon i {
                  color: #10b981;
                  font-size: 20px;
            }

            .custom-alert-error .alert-icon i {
                  color: #ef4444;
                  font-size: 20px;
            }

            /* Alert Message */
            .alert-message {
                  flex: 1;
                  min-width: 0;
            }

            .alert-message h6 {
                  margin: 0 0 4px 0;
                  font-weight: 600;
                  font-size: 14px;
                  color: #1f2937;
            }

            .custom-alert-success .alert-message h6 {
                  color: #065f46;
            }

            .custom-alert-error .alert-message h6 {
                  color: #991b1b;
            }

            .alert-message p {
                  margin: 0;
                  font-size: 13px;
                  color: #6b7280;
                  line-height: 1.4;
            }

            /* Alert Close Button */
            .alert-close {
                  background: none;
                  border: none;
                  color: #9ca3af;
                  cursor: pointer;
                  padding: 4px;
                  margin-left: 8px;
                  border-radius: 4px;
                  transition: all 0.2s ease;
                  flex-shrink: 0;
            }

            .alert-close:hover {
                  background: #f3f4f6;
                  color: #6b7280;
            }

            /* Alert Progress Bar */
            .alert-progress {
                  height: 3px;
                  background: #e5e7eb;
                  position: relative;
                  overflow: hidden;
            }

            .custom-alert-success .alert-progress::after {
                  content: '';
                  position: absolute;
                  top: 0;
                  left: 0;
                  height: 100%;
                  width: 100%;
                  background: #10b981;
                  animation: progressBar 5s linear forwards;
            }

            .custom-alert-error .alert-progress::after {
                  content: '';
                  position: absolute;
                  top: 0;
                  left: 0;
                  height: 100%;
                  width: 100%;
                  background: #ef4444;
                  animation: progressBar 8s linear forwards;
            }

            /* Animations */
            @keyframes slideInRight {
                  from {
                        transform: translateX(100%);
                        opacity: 0;
                  }

                  to {
                        transform: translateX(0);
                        opacity: 1;
                  }
            }

            @keyframes slideOutRight {
                  from {
                        transform: translateX(0);
                        opacity: 1;
                  }

                  to {
                        transform: translateX(100%);
                        opacity: 0;
                  }
            }

            @keyframes progressBar {
                  from {
                        width: 100%;
                  }

                  to {
                        width: 0%;
                  }
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                  .alert-container {
                        top: 10px;
                        right: 10px;
                        left: 10px;
                        max-width: none;
                  }

                  .custom-alert {
                        margin-bottom: 12px;
                  }

                  .alert-content {
                        padding: 14px 16px;
                  }

                  .alert-message h6 {
                        font-size: 13px;
                  }

                  .alert-message p {
                        font-size: 12px;
                  }
            }

            /* Hover Effects */
            .custom-alert:hover {
                  transform: translateY(-2px);
                  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
                  transition: all 0.3s ease;
            }

            /* Success Alert Specific Styles */
            .custom-alert-success {
                  background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
            }

            /* Error Alert Specific Styles */
            .custom-alert-error {
                  background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
            }
      </style>
</head>

<body class="bg-light">
      <?php include 'header.php'; ?>

      <div class="container mb-4">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        <div class="card shadow-sm">
                              <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">
                                          <i class="fas fa-certificate me-2"></i>Certificates
                                          <?php if (!$is_admin): ?>
                                                <span class="badge bg-warning text-dark ms-2">
                                                      <i class="fas fa-eye me-1"></i>View Only
                                                </span>
                                          <?php endif; ?>
                                    </h3>
                              </div>
                              <div class="card-body">
                                    <!-- Alert Messages -->
                                    <?php if (isset($success)): ?>
                                          <div class="alert-container">
                                                <div class="custom-alert custom-alert-success" id="successAlert">
                                                      <div class="alert-content">
                                                            <div class="alert-icon">
                                                                  <i class="fas fa-check-circle"></i>
                                                            </div>
                                                            <div class="alert-message">
                                                                  <h6>Success!</h6>
                                                                  <p><?php echo htmlspecialchars($success); ?></p>
                                                            </div>
                                                            <button type="button" class="alert-close" onclick="closeAlert('successAlert')">
                                                                  <i class="fas fa-times"></i>
                                                            </button>
                                                      </div>
                                                      <div class="alert-progress"></div>
                                                </div>
                                          </div>
                                    <?php endif; ?>

                                    <?php if (isset($error)): ?>
                                          <div class="alert-container">
                                                <div class="custom-alert custom-alert-error" id="errorAlert">
                                                      <div class="alert-content">
                                                            <div class="alert-icon">
                                                                  <i class="fas fa-exclamation-triangle"></i>
                                                            </div>
                                                            <div class="alert-message">
                                                                  <h6>Error!</h6>
                                                                  <p><?php echo htmlspecialchars($error); ?></p>
                                                            </div>
                                                            <button type="button" class="alert-close" onclick="closeAlert('errorAlert')">
                                                                  <i class="fas fa-times"></i>
                                                            </button>
                                                      </div>
                                                      <div class="alert-progress"></div>
                                                </div>
                                          </div>
                                    <?php endif; ?>

                                    <!-- Add Certificate Button - Only for admin -->
                                    <?php if ($is_admin): ?>
                                          <div class="text-end mb-4">
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCertificateModal">
                                                      <i class="fas fa-plus me-2"></i>Add Certificate
                                                </button>
                                          </div>
                                    <?php else: ?>
                                          <div class="alert alert-info mb-4">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>View Only Mode:</strong> You can view certificates but cannot add, edit, or delete them. Only administrators can manage certificates.
                                          </div>
                                    <?php endif; ?>

                                    <!-- Certificates Grid -->
                                    <div class="row">
                                          <?php if (empty($certificates)): ?>
                                                <div class="col-12 text-center py-5">
                                                      <i class="fas fa-certificate fa-3x text-muted mb-3"></i>
                                                      <h5 class="text-muted">No certificates found</h5>
                                                      <p class="text-muted">
                                                            <?php if ($is_admin): ?>
                                                                  Add your first certificate to get started!
                                                            <?php else: ?>
                                                                  No certificates are available at the moment.
                                                            <?php endif; ?>
                                                      </p>
                                                </div>
                                          <?php else: ?>
                                                <?php foreach ($certificates as $cert): ?>
                                                      <div class="col-md-6 col-lg-4 mb-4">
                                                            <div class="card certificate-card h-100 position-relative">
                                                                  <?php if (!$is_admin): ?>
                                                                        <div class="view-only-badge">
                                                                              <span class="badge bg-secondary">
                                                                                    <i class="fas fa-eye me-1"></i>View Only
                                                                              </span>
                                                                        </div>
                                                                  <?php endif; ?>
                                                                  <div class="card-body">
                                                                        <div class="text-center mb-3">
                                                                              <?php if (!empty($cert['file_path'])): ?>
                                                                                    <?php if ($cert['file_type'] == 'image'): ?>
                                                                                          <img src="<?php echo htmlspecialchars($cert['file_path']); ?>"
                                                                                                alt="<?php echo htmlspecialchars($cert['title']); ?>"
                                                                                                class="file-preview img-fluid rounded">
                                                                                    <?php else: ?>
                                                                                          <div class="pdf-preview rounded">
                                                                                                <i class="fas fa-file-pdf fa-3x"></i>
                                                                                          </div>
                                                                                    <?php endif; ?>
                                                                              <?php else: ?>
                                                                                    <div class="pdf-preview rounded">
                                                                                          <i class="fas fa-certificate fa-3x text-muted"></i>
                                                                                    </div>
                                                                              <?php endif; ?>
                                                                        </div>

                                                                        <h6 class="card-title"><?php echo htmlspecialchars($cert['title']); ?></h6>
                                                                        <p class="card-text text-muted">
                                                                              <i class="fas fa-building me-1"></i>
                                                                              <?php echo htmlspecialchars($cert['issuing_organization']); ?>
                                                                        </p>
                                                                        <p class="card-text small">
                                                                              <i class="fas fa-calendar me-1"></i>
                                                                              Issued: <?php echo date('M Y', strtotime($cert['issue_date'])); ?>
                                                                              <?php if ($cert['expiry_date']): ?>
                                                                                    <br><i class="fas fa-clock me-1"></i>
                                                                                    Expires: <?php echo date('M Y', strtotime($cert['expiry_date'])); ?>
                                                                              <?php endif; ?>
                                                                        </p>

                                                                        <?php if (!empty($cert['credential_id'])): ?>
                                                                              <p class="card-text small">
                                                                                    <i class="fas fa-id-card me-1"></i>
                                                                                    ID: <?php echo htmlspecialchars($cert['credential_id']); ?>
                                                                              </p>
                                                                        <?php endif; ?>

                                                                        <div class="btn-group w-100" role="group">
                                                                              <?php if (!empty($cert['file_path'])): ?>
                                                                                    <a href="<?php echo htmlspecialchars($cert['file_path']); ?>"
                                                                                          target="_blank"
                                                                                          class="btn btn-outline-primary btn-sm">
                                                                                          <i class="fas fa-eye me-1"></i>View
                                                                                    </a>
                                                                              <?php endif; ?>

                                                                              <?php if ($is_admin): ?>
                                                                                    <button class="btn btn-outline-secondary btn-sm"
                                                                                          onclick="editCertificate(<?php echo htmlspecialchars(json_encode($cert)); ?>)">
                                                                                          <i class="fas fa-edit me-1"></i>Edit
                                                                                    </button>
                                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                                          onclick="deleteCertificate(<?php echo $cert['id']; ?>, '<?php echo htmlspecialchars($cert['title']); ?>')">
                                                                                          <i class="fas fa-trash me-1"></i>Delete
                                                                                    </button>
                                                                              <?php endif; ?>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                <?php endforeach; ?>
                                          <?php endif; ?>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Add Certificate Modal - Only show for admin -->
      <?php if ($is_admin): ?>
            <div class="modal fade" id="addCertificateModal" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                              <div class="modal-header">
                                    <h5 class="modal-title">
                                          <i class="fas fa-plus me-2"></i>Add Certificate
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                          <input type="hidden" name="action" value="add">

                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="title" class="form-label">Certificate Title *</label>
                                                            <input type="text" class="form-control" id="title" name="title" required>
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="issuing_organization" class="form-label">Issuing Organization *</label>
                                                            <input type="text" class="form-control" id="issuing_organization" name="issuing_organization" required>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="issue_date" class="form-label">Issue Date *</label>
                                                            <input type="date" class="form-control" id="issue_date" name="issue_date" required>
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="expiry_date" class="form-label">Expiry Date</label>
                                                            <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="credential_id" class="form-label">Credential ID</label>
                                                            <input type="text" class="form-control" id="credential_id" name="credential_id">
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="credential_url" class="form-label">Credential URL</label>
                                                            <input type="url" class="form-control" id="credential_url" name="credential_url">
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="mb-3">
                                                <label for="certificate_file" class="form-label">Certificate File (Image or PDF)</label>
                                                <input type="file" class="form-control" id="certificate_file" name="certificate_file" accept=".jpg,.jpeg,.png,.gif,.pdf">
                                                <div class="form-text">Supported formats: JPG, PNG, GIF, PDF. Max size: 5MB</div>
                                          </div>

                                          <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                          </div>
                                    </div>
                                    <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save me-2"></i>Save Certificate
                                          </button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>

            <!-- Edit Certificate Modal - Only show for admin -->
            <div class="modal fade" id="editCertificateModal" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                              <div class="modal-header">
                                    <h5 class="modal-title">
                                          <i class="fas fa-edit me-2"></i>Edit Certificate
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                          <input type="hidden" name="action" value="edit">
                                          <input type="hidden" name="id" id="edit_id">

                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="edit_title" class="form-label">Certificate Title *</label>
                                                            <input type="text" class="form-control" id="edit_title" name="title" required>
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="edit_issuing_organization" class="form-label">Issuing Organization *</label>
                                                            <input type="text" class="form-control" id="edit_issuing_organization" name="issuing_organization" required>
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="edit_issue_date" class="form-label">Issue Date *</label>
                                                            <input type="date" class="form-control" id="edit_issue_date" name="issue_date" required>
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="edit_expiry_date" class="form-label">Expiry Date</label>
                                                            <input type="date" class="form-control" id="edit_expiry_date" name="expiry_date">
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="edit_credential_id" class="form-label">Credential ID</label>
                                                            <input type="text" class="form-control" id="edit_credential_id" name="credential_id">
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="mb-3">
                                                            <label for="edit_credential_url" class="form-label">Credential URL</label>
                                                            <input type="url" class="form-control" id="edit_credential_url" name="credential_url">
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="mb-3">
                                                <label for="edit_certificate_file" class="form-label">Certificate File (Image or PDF)</label>
                                                <input type="file" class="form-control" id="edit_certificate_file" name="certificate_file" accept=".jpg,.jpeg,.png,.gif,.pdf">
                                                <div class="form-text">Leave empty to keep existing file. Supported formats: JPG, PNG, GIF, PDF. Max size: 5MB</div>
                                          </div>

                                          <div class="mb-3">
                                                <label for="edit_description" class="form-label">Description</label>
                                                <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                                          </div>
                                    </div>
                                    <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Update Certificate
                                          </button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>

            <!-- Delete Confirmation Modal - Only show for admin -->
            <div class="modal fade" id="deleteCertificateModal" tabindex="-1">
                  <div class="modal-dialog">
                        <div class="modal-content">
                              <div class="modal-header">
                                    <h5 class="modal-title">
                                          <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Confirm Delete
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                    <p>Are you sure you want to delete the certificate "<span id="delete_certificate_name"></span>"?</p>
                                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                              </div>
                              <form method="POST">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" id="delete_certificate_id">
                                    <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash me-2"></i>Delete Certificate
                                          </button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      <?php endif; ?>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
            // Function to close alerts
            function closeAlert(alertId) {
                  const alert = document.getElementById(alertId);
                  if (alert) {
                        alert.style.animation = 'slideOutRight 0.5s ease-out forwards';
                        setTimeout(() => {
                              alert.remove();
                        }, 500);
                  }
            }

            // Auto-hide alerts after a certain time
            document.addEventListener('DOMContentLoaded', function() {
                  const successAlert = document.getElementById('successAlert');
                  const errorAlert = document.getElementById('errorAlert');

                  // Auto-hide success alerts after 5 seconds
                  if (successAlert) {
                        setTimeout(() => {
                              closeAlert('successAlert');
                        }, 5000);
                  }

                  // Auto-hide error alerts after 8 seconds
                  if (errorAlert) {
                        setTimeout(() => {
                              closeAlert('errorAlert');
                        }, 8000);
                  }
            });

            <?php if ($is_admin): ?>

                  function editCertificate(certificate) {
                        document.getElementById('edit_id').value = certificate.id;
                        document.getElementById('edit_title').value = certificate.title;
                        document.getElementById('edit_issuing_organization').value = certificate.issuing_organization;
                        document.getElementById('edit_issue_date').value = certificate.issue_date;
                        document.getElementById('edit_expiry_date').value = certificate.expiry_date || '';
                        document.getElementById('edit_credential_id').value = certificate.credential_id || '';
                        document.getElementById('edit_credential_url').value = certificate.credential_url || '';
                        document.getElementById('edit_description').value = certificate.description || '';

                        new bootstrap.Modal(document.getElementById('editCertificateModal')).show();
                  }

                  function deleteCertificate(id, name) {
                        document.getElementById('delete_certificate_id').value = id;
                        document.getElementById('delete_certificate_name').textContent = name;
                        new bootstrap.Modal(document.getElementById('deleteCertificateModal')).show();
                  }
            <?php endif; ?>
      </script>
</body>

</html>