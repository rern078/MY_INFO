<?php
session_start();
require_once 'config.php';
require_once 'languages.php';

// Check if user is logged in and is the specific admin user
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'chamrern') {
      header("Location: login.php");
      exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Initialize message variables
$success_message = '';
$error_message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                  case 'update_personal':
                        $name = sanitize_input($_POST['name']);
                        $title = sanitize_input($_POST['title']);
                        $email = sanitize_input($_POST['email']);
                        $phone = sanitize_input($_POST['phone']);
                        $height = sanitize_input($_POST['height']);
                        $weight = sanitize_input($_POST['weight']);
                        $date_of_birth = sanitize_input($_POST['date_of_birth']);
                        $gender = sanitize_input($_POST['gender']);
                        $nationality = sanitize_input($_POST['nationality']);
                        $marital_status = sanitize_input($_POST['marital_status']);
                        $religion = sanitize_input($_POST['religion']);
                        $address = sanitize_input($_POST['address']);
                        $city = sanitize_input($_POST['city']);
                        $state = sanitize_input($_POST['state']);
                        $zip = sanitize_input($_POST['zip']);
                        $country = sanitize_input($_POST['country']);
                        $location = sanitize_input($_POST['location']);

                        $sql = "INSERT INTO personal_info (name, title, email, phone, height, weight, date_of_birth, 
                        gender, nationality, marital_status, religion, address, city, state, zip, country, location) 
                        VALUES ('$name', '$title', '$email', '$phone', '$height', '$weight', '$date_of_birth', 
                        '$gender', '$nationality', '$marital_status', '$religion', '$address', '$city', '$state', 
                        '$zip', '$country', '$location')";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Personal information updated successfully!";
                        } else {
                              $error_message = "Error updating personal information: " . mysqli_error($conn);
                        }
                        break;

                  case 'update_company':
                        $name = sanitize_input($_POST['company_name']);
                        $position = sanitize_input($_POST['position']);
                        $hiring_manager = sanitize_input($_POST['hiring_manager']);
                        $street = sanitize_input($_POST['street']);
                        $city = sanitize_input($_POST['city']);
                        $state = sanitize_input($_POST['state']);
                        $zip = sanitize_input($_POST['zip']);

                        $sql = "INSERT INTO company_info (name, position, hiring_manager, street, city, state, zip) 
                        VALUES ('$name', '$position', '$hiring_manager', '$street', '$city', '$state', '$zip')";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Company information updated successfully!";
                        } else {
                              $error_message = "Error updating company information: " . mysqli_error($conn);
                        }
                        break;

                  case 'update_cover_letter':
                        $introduction = sanitize_input($_POST['introduction']);
                        $body = sanitize_input($_POST['body']);
                        $closing = sanitize_input($_POST['closing']);

                        $sql = "INSERT INTO cover_letter (introduction, body, closing) 
                        VALUES ('$introduction', '$body', '$closing')";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Cover letter updated successfully!";
                        } else {
                              $error_message = "Error updating cover letter: " . mysqli_error($conn);
                        }
                        break;

                  case 'add_language':
                        $name = sanitize_input($_POST['language_name']);
                        $proficiency = (int)$_POST['proficiency'];

                        $sql = "INSERT INTO languages (name, proficiency) VALUES ('$name', $proficiency)";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Language '$name' added successfully!";
                        } else {
                              $error_message = "Error adding language: " . mysqli_error($conn);
                        }
                        break;

                  case 'delete_language':
                        $id = (int)$_POST['language_id'];
                        $sql = "DELETE FROM languages WHERE id = $id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Language deleted successfully!";
                        } else {
                              $error_message = "Error deleting language: " . mysqli_error($conn);
                        }
                        break;

                  case 'add_interest':
                        $name = sanitize_input($_POST['interest_name']);
                        $icon_class = sanitize_input($_POST['icon_class']);

                        $sql = "INSERT INTO interests (name, icon_class) VALUES ('$name', '$icon_class')";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Interest '$name' added successfully!";
                        } else {
                              $error_message = "Error adding interest: " . mysqli_error($conn);
                        }
                        break;

                  case 'delete_interest':
                        $id = (int)$_POST['interest_id'];
                        $sql = "DELETE FROM interests WHERE id = $id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Interest deleted successfully!";
                        } else {
                              $error_message = "Error deleting interest: " . mysqli_error($conn);
                        }
                        break;

                  case 'add_experience':
                        $title = sanitize_input($_POST['title']);
                        $company = sanitize_input($_POST['company']);
                        $start_date = sanitize_input($_POST['start_date']);
                        $end_date = !empty($_POST['end_date']) ? sanitize_input($_POST['end_date']) : null;
                        $is_current = isset($_POST['is_current']) ? 1 : 0;
                        $description = sanitize_input($_POST['description']);
                        $achievements = sanitize_input($_POST['achievements']);

                        $sql = "INSERT INTO experience (user_id, title, company, start_date, end_date, is_current, description, achievements) 
                                VALUES ($user_id, '$title', '$company', '$start_date', " .
                              ($end_date ? "'$end_date'" : "NULL") . ", $is_current, '$description', '$achievements')";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Experience at '$company' added successfully!";
                        } else {
                              $error_message = "Error adding experience: " . mysqli_error($conn);
                        }
                        break;

                  case 'edit_experience':
                        $id = (int)$_POST['experience_id'];
                        $title = sanitize_input($_POST['title']);
                        $company = sanitize_input($_POST['company']);
                        $start_date = sanitize_input($_POST['start_date']);
                        $end_date = !empty($_POST['end_date']) ? sanitize_input($_POST['end_date']) : null;
                        $is_current = isset($_POST['is_current']) ? 1 : 0;
                        $description = sanitize_input($_POST['description']);
                        $achievements = sanitize_input($_POST['achievements']);

                        $sql = "UPDATE experience SET title='$title', company='$company', start_date='$start_date', 
                                end_date=" . ($end_date ? "'$end_date'" : "NULL") . ", is_current=$is_current, 
                                description='$description', achievements='$achievements' WHERE id=$id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Experience at '$company' updated successfully!";
                        } else {
                              $error_message = "Error updating experience: " . mysqli_error($conn);
                        }
                        break;

                  case 'delete_experience':
                        $id = (int)$_POST['experience_id'];
                        $sql = "DELETE FROM experience WHERE id = $id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Experience deleted successfully!";
                        } else {
                              $error_message = "Error deleting experience: " . mysqli_error($conn);
                        }
                        break;

                  case 'add_education':
                        $degree = sanitize_input($_POST['degree']);
                        $field_of_study = sanitize_input($_POST['field_of_study']);
                        $school = sanitize_input($_POST['school']);
                        $start_date = sanitize_input($_POST['start_date']);
                        $end_date = !empty($_POST['end_date']) ? sanitize_input($_POST['end_date']) : null;
                        $is_current = isset($_POST['is_current']) ? 1 : 0;
                        $gpa = !empty($_POST['gpa']) ? (float)$_POST['gpa'] : null;
                        $achievements = sanitize_input($_POST['achievements']);

                        $sql = "INSERT INTO education (user_id, degree, field_of_study, school, start_date, end_date, is_current, gpa, achievements) 
                                VALUES ($user_id, '$degree', '$field_of_study', '$school', '$start_date', " .
                              ($end_date ? "'$end_date'" : "NULL") . ", $is_current, " .
                              ($gpa ? $gpa : "NULL") . ", '$achievements')";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Education at '$school' added successfully!";
                        } else {
                              $error_message = "Error adding education: " . mysqli_error($conn);
                        }
                        break;

                  case 'edit_education':
                        $id = (int)$_POST['education_id'];
                        $degree = sanitize_input($_POST['degree']);
                        $field_of_study = sanitize_input($_POST['field_of_study']);
                        $school = sanitize_input($_POST['school']);
                        $start_date = sanitize_input($_POST['start_date']);
                        $end_date = !empty($_POST['end_date']) ? sanitize_input($_POST['end_date']) : null;
                        $is_current = isset($_POST['is_current']) ? 1 : 0;
                        $gpa = !empty($_POST['gpa']) ? (float)$_POST['gpa'] : null;
                        $achievements = sanitize_input($_POST['achievements']);

                        $sql = "UPDATE education SET degree='$degree', field_of_study='$field_of_study', school='$school', 
                                start_date='$start_date', end_date=" . ($end_date ? "'$end_date'" : "NULL") . ", 
                                is_current=$is_current, gpa=" . ($gpa ? $gpa : "NULL") . ", achievements='$achievements' WHERE id=$id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Education at '$school' updated successfully!";
                        } else {
                              $error_message = "Error updating education: " . mysqli_error($conn);
                        }
                        break;

                  case 'delete_education':
                        $id = (int)$_POST['education_id'];
                        $sql = "DELETE FROM education WHERE id = $id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Education deleted successfully!";
                        } else {
                              $error_message = "Error deleting education: " . mysqli_error($conn);
                        }
                        break;

                  case 'add_social_media':
                        $platform = sanitize_input($_POST['platform']);
                        $username = sanitize_input($_POST['username']);
                        $url = sanitize_input($_POST['url']);
                        $is_active = isset($_POST['is_active']) ? 1 : 0;
                        $display_order = (int)$_POST['display_order'];
                        $icon_class = sanitize_input($_POST['icon_class']);

                        $sql = "INSERT INTO social_media (user_id, platform, username, url, is_active, display_order, icon_class) 
                                VALUES ($user_id, '$platform', '$username', '$url', $is_active, $display_order, '$icon_class')";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Social media '$platform' added successfully!";
                        } else {
                              $error_message = "Error adding social media: " . mysqli_error($conn);
                        }
                        break;

                  case 'edit_social_media':
                        $id = (int)$_POST['social_media_id'];
                        $platform = sanitize_input($_POST['platform']);
                        $username = sanitize_input($_POST['username']);
                        $url = sanitize_input($_POST['url']);
                        $is_active = isset($_POST['is_active']) ? 1 : 0;
                        $display_order = (int)$_POST['display_order'];
                        $icon_class = sanitize_input($_POST['icon_class']);

                        $sql = "UPDATE social_media SET platform='$platform', username='$username', url='$url', 
                                is_active=$is_active, display_order=$display_order, icon_class='$icon_class' WHERE id=$id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Social media '$platform' updated successfully!";
                        } else {
                              $error_message = "Error updating social media: " . mysqli_error($conn);
                        }
                        break;

                  case 'delete_social_media':
                        $id = (int)$_POST['social_media_id'];
                        $sql = "DELETE FROM social_media WHERE id = $id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Social media deleted successfully!";
                        } else {
                              $error_message = "Error deleting social media: " . mysqli_error($conn);
                        }
                        break;

                  case 'add_course':
                        $education_id = (int)$_POST['education_id'];
                        $course_code = sanitize_input($_POST['course_code']);
                        $course_name = sanitize_input($_POST['course_name']);
                        $course_description = sanitize_input($_POST['course_description']);
                        $credits = !empty($_POST['credits']) ? (int)$_POST['credits'] : null;
                        $grade = sanitize_input($_POST['grade']);
                        $semester = sanitize_input($_POST['semester']);
                        $academic_year = sanitize_input($_POST['academic_year']);
                        $instructor = sanitize_input($_POST['instructor']);
                        $course_type = sanitize_input($_POST['course_type']);

                        $sql = "INSERT INTO courses (user_id, education_id, course_code, course_name, course_description, credits, grade, semester, academic_year, instructor, course_type) 
                                VALUES ($user_id, $education_id, '$course_code', '$course_name', '$course_description', " .
                              ($credits ? $credits : "NULL") . ", '$grade', '$semester', '$academic_year', '$instructor', '$course_type')";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Course '$course_name' added successfully!";
                        } else {
                              $error_message = "Error adding course: " . mysqli_error($conn);
                        }
                        break;

                  case 'edit_course':
                        $id = (int)$_POST['course_id'];
                        $education_id = (int)$_POST['education_id'];
                        $course_code = sanitize_input($_POST['course_code']);
                        $course_name = sanitize_input($_POST['course_name']);
                        $course_description = sanitize_input($_POST['course_description']);
                        $credits = !empty($_POST['credits']) ? (int)$_POST['credits'] : null;
                        $grade = sanitize_input($_POST['grade']);
                        $semester = sanitize_input($_POST['semester']);
                        $academic_year = sanitize_input($_POST['academic_year']);
                        $instructor = sanitize_input($_POST['instructor']);
                        $course_type = sanitize_input($_POST['course_type']);

                        $sql = "UPDATE courses SET education_id=$education_id, course_code='$course_code', course_name='$course_name', 
                                course_description='$course_description', credits=" . ($credits ? $credits : "NULL") . ", 
                                grade='$grade', semester='$semester', academic_year='$academic_year', 
                                instructor='$instructor', course_type='$course_type' WHERE id=$id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Course '$course_name' updated successfully!";
                        } else {
                              $error_message = "Error updating course: " . mysqli_error($conn);
                        }
                        break;

                  case 'delete_course':
                        $id = (int)$_POST['course_id'];
                        $sql = "DELETE FROM courses WHERE id = $id";
                        if (mysqli_query($conn, $sql)) {
                              $success_message = "Course deleted successfully!";
                        } else {
                              $error_message = "Error deleting course: " . mysqli_error($conn);
                        }
                        break;
            }
      }
}

// Fetch latest data
$personalInfoQuery = "SELECT * FROM personal_info ORDER BY id DESC LIMIT 1";
$personalInfoResult = mysqli_query($conn, $personalInfoQuery);
$personalInfo = mysqli_fetch_assoc($personalInfoResult);

$companyInfoQuery = "SELECT * FROM company_info ORDER BY id DESC LIMIT 1";
$companyInfoResult = mysqli_query($conn, $companyInfoQuery);
$companyInfo = mysqli_fetch_assoc($companyInfoResult);

$coverLetterQuery = "SELECT * FROM cover_letter ORDER BY id DESC LIMIT 1";
$coverLetterResult = mysqli_query($conn, $coverLetterQuery);
$coverLetter = mysqli_fetch_assoc($coverLetterResult);

// Fetch Languages
$languagesQuery = "SELECT * FROM languages ORDER BY proficiency DESC";
$languagesResult = mysqli_query($conn, $languagesQuery);
$languages = [];
while ($row = mysqli_fetch_assoc($languagesResult)) {
      $languages[] = $row;
}

// Fetch Interests
$interestsQuery = "SELECT * FROM interests ORDER BY name ASC";
$interestsResult = mysqli_query($conn, $interestsQuery);
$interests = [];
while ($row = mysqli_fetch_assoc($interestsResult)) {
      $interests[] = $row;
}

// Fetch Experience
$experienceQuery = "SELECT * FROM experience WHERE user_id = $user_id ORDER BY start_date DESC";
$experienceResult = mysqli_query($conn, $experienceQuery);
$experience = [];
while ($row = mysqli_fetch_assoc($experienceResult)) {
      $experience[] = $row;
}

// If no experience found for current user, get all experience data
if (empty($experience)) {
      $experienceQuery = "SELECT * FROM experience ORDER BY start_date DESC";
      $experienceResult = mysqli_query($conn, $experienceQuery);
      while ($row = mysqli_fetch_assoc($experienceResult)) {
            $experience[] = $row;
      }
}

// Fetch Education
$educationQuery = "SELECT * FROM education WHERE user_id = $user_id ORDER BY start_date DESC";
$educationResult = mysqli_query($conn, $educationQuery);
$education = [];
while ($row = mysqli_fetch_assoc($educationResult)) {
      $education[] = $row;
}

// If no education found for current user, get all education data
if (empty($education)) {
      $educationQuery = "SELECT * FROM education ORDER BY start_date DESC";
      $educationResult = mysqli_query($conn, $educationQuery);
      while ($row = mysqli_fetch_assoc($educationResult)) {
            $education[] = $row;
      }
}

// Fetch Social Media
$socialMediaQuery = "SELECT * FROM social_media WHERE user_id = $user_id ORDER BY display_order ASC, platform ASC";
$socialMediaResult = mysqli_query($conn, $socialMediaQuery);
$socialMedia = [];
while ($row = mysqli_fetch_assoc($socialMediaResult)) {
      $socialMedia[] = $row;
}

// If no social media found for current user, get all social media data
if (empty($socialMedia)) {
      $socialMediaQuery = "SELECT * FROM social_media ORDER BY display_order ASC, platform ASC";
      $socialMediaResult = mysqli_query($conn, $socialMediaQuery);
      while ($row = mysqli_fetch_assoc($socialMediaResult)) {
            $socialMedia[] = $row;
      }
}

// Fetch Courses
$coursesQuery = "SELECT c.*, e.degree, e.school FROM courses c 
                 LEFT JOIN education e ON c.education_id = e.id 
                 WHERE c.user_id = $user_id 
                 ORDER BY c.academic_year DESC, c.semester ASC, c.course_name ASC";
$coursesResult = mysqli_query($conn, $coursesQuery);
$courses = [];
while ($row = mysqli_fetch_assoc($coursesResult)) {
      $courses[] = $row;
}

// If no courses found for current user, get all courses data
if (empty($courses)) {
      $coursesQuery = "SELECT c.*, e.degree, e.school FROM courses c 
                       LEFT JOIN education e ON c.education_id = e.id 
                       ORDER BY c.academic_year DESC, c.semester ASC, c.course_name ASC";
      $coursesResult = mysqli_query($conn, $coursesQuery);
      while ($row = mysqli_fetch_assoc($coursesResult)) {
            $courses[] = $row;
      }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $current_language; ?>" dir="<?php echo getLanguageDirection(); ?>">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin - Cover Letter Management</title>
      <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

            html[lang="km"] body,
            html[lang="km"] * {
                  font-family: var(--font-khmer) !important;
            }
      </style>
</head>

<body class="bg-light">
      <?php include 'header.php'; ?>

      <div class="container mb-4">
            <div class="row justify-content-center">
                  <div class="col-lg-12">
                        <h1 class="text-center mb-4">School Management</h1>

                        <!-- Alert Messages -->
                        <?php if (!empty($success_message)): ?>
                              <div class="alert-container">
                                    <div class="custom-alert custom-alert-success" id="successAlert">
                                          <div class="alert-content">
                                                <div class="alert-icon">
                                                      <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div class="alert-message">
                                                      <h6>Success!</h6>
                                                      <p><?php echo htmlspecialchars($success_message); ?></p>
                                                </div>
                                                <button type="button" class="alert-close" onclick="closeAlert('successAlert')">
                                                      <i class="fas fa-times"></i>
                                                </button>
                                          </div>
                                          <div class="alert-progress"></div>
                                    </div>
                              </div>
                        <?php endif; ?>

                        <?php if (!empty($error_message)): ?>
                              <div class="alert-container">
                                    <div class="custom-alert custom-alert-error" id="errorAlert">
                                          <div class="alert-content">
                                                <div class="alert-icon">
                                                      <i class="fas fa-exclamation-triangle"></i>
                                                </div>
                                                <div class="alert-message">
                                                      <h6>Error!</h6>
                                                      <p><?php echo htmlspecialchars($error_message); ?></p>
                                                </div>
                                                <button type="button" class="alert-close" onclick="closeAlert('errorAlert')">
                                                      <i class="fas fa-times"></i>
                                                </button>
                                          </div>
                                          <div class="alert-progress"></div>
                                    </div>
                              </div>
                        <?php endif; ?>

                        <!-- Personal Information Form -->
                        <div class="card shadow-sm mb-4">
                              <div class="card-header">
                                    <h5 class="mb-0">Personal Information</h5>
                              </div>
                              <div class="card-body">
                                    <form method="POST" action="">
                                          <input type="hidden" name="action" value="update_personal">

                                          <!-- Basic Information -->
                                          <h6 class="mb-3">Basic Information</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($personalInfo['name'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Title</label>
                                                      <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($personalInfo['title'] ?? ''); ?>" required>
                                                </div>
                                          </div>

                                          <!-- Contact Information -->
                                          <h6 class="mb-3 mt-4">Contact Information</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($personalInfo['email'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Phone</label>
                                                      <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($personalInfo['phone'] ?? ''); ?>" required>
                                                </div>
                                          </div>

                                          <!-- Physical Information -->
                                          <h6 class="mb-3 mt-4">Physical Information</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Height</label>
                                                      <input type="text" class="form-control" name="height" value="<?php echo htmlspecialchars($personalInfo['height'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Weight</label>
                                                      <input type="text" class="form-control" name="weight" value="<?php echo htmlspecialchars($personalInfo['weight'] ?? ''); ?>" required>
                                                </div>
                                          </div>

                                          <!-- Personal Details -->
                                          <h6 class="mb-3 mt-4">Personal Details</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Date of Birth</label>
                                                      <input type="date" class="form-control" name="date_of_birth" value="<?php echo htmlspecialchars($personalInfo['date_of_birth'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Gender</label>
                                                      <select class="form-select" name="gender" required>
                                                            <option value="">Select Gender</option>
                                                            <option value="Male" <?php echo ($personalInfo['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                                                            <option value="Female" <?php echo ($personalInfo['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                                                            <option value="Other" <?php echo ($personalInfo['gender'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                                                      </select>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Nationality</label>
                                                      <input type="text" class="form-control" name="nationality" value="<?php echo htmlspecialchars($personalInfo['nationality'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Marital Status</label>
                                                      <select class="form-select" name="marital_status" required>
                                                            <option value="">Select Status</option>
                                                            <option value="Single" <?php echo ($personalInfo['marital_status'] ?? '') === 'Single' ? 'selected' : ''; ?>>Single</option>
                                                            <option value="Married" <?php echo ($personalInfo['marital_status'] ?? '') === 'Married' ? 'selected' : ''; ?>>Married</option>
                                                            <option value="Divorced" <?php echo ($personalInfo['marital_status'] ?? '') === 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                                                            <option value="Widowed" <?php echo ($personalInfo['marital_status'] ?? '') === 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                                                      </select>
                                                </div>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Religion</label>
                                                <input type="text" class="form-control" name="religion" value="<?php echo htmlspecialchars($personalInfo['religion'] ?? ''); ?>" required>
                                          </div>

                                          <!-- Address Information -->
                                          <h6 class="mb-3 mt-4">Address Information</h6>
                                          <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($personalInfo['address'] ?? ''); ?>" required>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">City</label>
                                                      <input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($personalInfo['city'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">State</label>
                                                      <input type="text" class="form-control" name="state" value="<?php echo htmlspecialchars($personalInfo['state'] ?? ''); ?>" required>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">ZIP Code</label>
                                                      <input type="text" class="form-control" name="zip" value="<?php echo htmlspecialchars($personalInfo['zip'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Country</label>
                                                      <input type="text" class="form-control" name="country" value="<?php echo htmlspecialchars($personalInfo['country'] ?? ''); ?>" required>
                                                </div>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Location (for display)</label>
                                                <input type="text" class="form-control" name="location" value="<?php echo htmlspecialchars($personalInfo['location'] ?? ''); ?>" required>
                                          </div>

                                          <button type="submit" class="btn btn-primary">Update Personal Information</button>
                                    </form>
                              </div>
                        </div>

                        <!-- Company Information Form -->
                        <div class="card shadow-sm mb-4">
                              <div class="card-header">
                                    <h5 class="mb-0">Company Information</h5>
                              </div>
                              <div class="card-body">
                                    <form method="POST" action="">
                                          <input type="hidden" name="action" value="update_company">
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Company Name</label>
                                                      <input type="text" class="form-control" name="company_name" value="<?php echo htmlspecialchars($companyInfo['name'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Position</label>
                                                      <input type="text" class="form-control" name="position" value="<?php echo htmlspecialchars($companyInfo['position'] ?? ''); ?>" required>
                                                </div>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Hiring Manager</label>
                                                <input type="text" class="form-control" name="hiring_manager" value="<?php echo htmlspecialchars($companyInfo['hiring_manager'] ?? ''); ?>" required>
                                          </div>
                                          <div class="row">
                                                <div class="col-12 mb-3">
                                                      <label class="form-label">Street Address</label>
                                                      <input type="text" class="form-control" name="street" value="<?php echo htmlspecialchars($companyInfo['street'] ?? ''); ?>" required>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">City</label>
                                                      <input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($companyInfo['city'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">State</label>
                                                      <input type="text" class="form-control" name="state" value="<?php echo htmlspecialchars($companyInfo['state'] ?? ''); ?>" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">ZIP Code</label>
                                                      <input type="text" class="form-control" name="zip" value="<?php echo htmlspecialchars($companyInfo['zip'] ?? ''); ?>" required>
                                                </div>
                                          </div>
                                          <button type="submit" class="btn btn-primary">Update Company Information</button>
                                    </form>
                              </div>
                        </div>

                        <!-- Cover Letter Content Form -->
                        <div class="card shadow-sm">
                              <div class="card-header">
                                    <h5 class="mb-0">Cover Letter Content</h5>
                              </div>
                              <div class="card-body">
                                    <form method="POST" action="">
                                          <input type="hidden" name="action" value="update_cover_letter">
                                          <div class="mb-3">
                                                <label class="form-label">Introduction</label>
                                                <textarea class="form-control" name="introduction" rows="3" required><?php echo htmlspecialchars($coverLetter['introduction'] ?? ''); ?></textarea>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Body</label>
                                                <textarea class="form-control" name="body" rows="6" required><?php echo htmlspecialchars($coverLetter['body'] ?? ''); ?></textarea>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Closing</label>
                                                <textarea class="form-control" name="closing" rows="3" required><?php echo htmlspecialchars($coverLetter['closing'] ?? ''); ?></textarea>
                                          </div>
                                          <button type="submit" class="btn btn-primary">Update Cover Letter</button>
                                    </form>
                              </div>
                        </div>

                        <!-- Languages Management Form -->
                        <div class="card shadow-sm mt-4">
                              <div class="card-header">
                                    <h5 class="mb-0">Languages Management</h5>
                              </div>
                              <div class="card-body">
                                    <!-- Add New Language Form -->
                                    <form method="POST" action="" class="mb-4">
                                          <input type="hidden" name="action" value="add_language">
                                          <h6 class="mb-3">Add New Language</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Language Name</label>
                                                      <input type="text" class="form-control" name="language_name" placeholder="e.g., English, Spanish, French" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Proficiency Level</label>
                                                      <select class="form-select" name="proficiency" required>
                                                            <option value="">Select Level</option>
                                                            <option value="1">1 - Beginner</option>
                                                            <option value="2">2 - Elementary</option>
                                                            <option value="3">3 - Intermediate</option>
                                                            <option value="4">4 - Advanced</option>
                                                            <option value="5">5 - Native/Fluent</option>
                                                      </select>
                                                </div>
                                          </div>
                                          <button type="submit" class="btn btn-success">Add Language</button>
                                    </form>

                                    <!-- Existing Languages List -->
                                    <h6 class="mb-3">Current Languages</h6>
                                    <?php if (empty($languages)): ?>
                                          <p class="text-muted">No languages added yet.</p>
                                    <?php else: ?>
                                          <div class="table-responsive">
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Language</th>
                                                                  <th>Proficiency Level</th>
                                                                  <th>Actions</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            <?php foreach ($languages as $language): ?>
                                                                  <tr>
                                                                        <td><?php echo htmlspecialchars($language['name']); ?></td>
                                                                        <td>
                                                                              <?php
                                                                              $level = '';
                                                                              switch ($language['proficiency']) {
                                                                                    case 1:
                                                                                          $level = 'Beginner';
                                                                                          break;
                                                                                    case 2:
                                                                                          $level = 'Elementary';
                                                                                          break;
                                                                                    case 3:
                                                                                          $level = 'Intermediate';
                                                                                          break;
                                                                                    case 4:
                                                                                          $level = 'Advanced';
                                                                                          break;
                                                                                    case 5:
                                                                                          $level = 'Native/Fluent';
                                                                                          break;
                                                                                    default:
                                                                                          $level = 'Unknown';
                                                                                          break;
                                                                              }
                                                                              echo $level . ' (' . $language['proficiency'] . '/5)';
                                                                              ?>
                                                                        </td>
                                                                        <td>
                                                                              <form method="POST" action="" style="display: inline;">
                                                                                    <input type="hidden" name="action" value="delete_language">
                                                                                    <input type="hidden" name="language_id" value="<?php echo $language['id']; ?>">
                                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this language?')">
                                                                                          <i class="fas fa-trash"></i> Delete
                                                                                    </button>
                                                                              </form>
                                                                        </td>
                                                                  </tr>
                                                            <?php endforeach; ?>
                                                      </tbody>
                                                </table>
                                          </div>
                                    <?php endif; ?>
                              </div>
                        </div>

                        <!-- Interests Management Form -->
                        <div class="card shadow-sm mt-4">
                              <div class="card-header">
                                    <h5 class="mb-0">Interests Management</h5>
                              </div>
                              <div class="card-body">
                                    <!-- Add New Interest Form -->
                                    <form method="POST" action="" class="mb-4">
                                          <input type="hidden" name="action" value="add_interest">
                                          <h6 class="mb-3">Add New Interest</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Interest Name</label>
                                                      <input type="text" class="form-control" name="interest_name" placeholder="e.g., Photography, Cooking, Gaming" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Icon Class (FontAwesome)</label>
                                                      <select class="form-select" name="icon_class" required>
                                                            <option value="">Select Icon</option>
                                                            <option value="fas fa-plane">✈️ Travel</option>
                                                            <option value="fas fa-book-open">📚 Reading</option>
                                                            <option value="fas fa-camera">📷 Photography</option>
                                                            <option value="fas fa-utensils">🍳 Cooking</option>
                                                            <option value="fas fa-gamepad">🎮 Gaming</option>
                                                            <option value="fas fa-music">🎵 Music</option>
                                                            <option value="fas fa-palette">🎨 Art</option>
                                                            <option value="fas fa-dumbbell">💪 Fitness</option>
                                                            <option value="fas fa-hiking">🏔️ Hiking</option>
                                                            <option value="fas fa-swimming-pool">🏊 Swimming</option>
                                                            <option value="fas fa-chess">♟️ Chess</option>
                                                            <option value="fas fa-puzzle-piece">🧩 Puzzles</option>
                                                            <option value="fas fa-seedling">🌱 Gardening</option>
                                                            <option value="fas fa-car">🚗 Cars</option>
                                                            <option value="fas fa-bicycle">🚴 Cycling</option>
                                                            <option value="fas fa-running">🏃 Running</option>
                                                            <option value="fas fa-yoga">🧘 Yoga</option>
                                                            <option value="fas fa-paint-brush">🖌️ Painting</option>
                                                            <option value="fas fa-code">💻 Coding</option>
                                                            <option value="fas fa-robot">🤖 Technology</option>
                                                            <option value="fas fa-heart">❤️ Other</option>
                                                      </select>
                                                </div>
                                          </div>
                                          <button type="submit" class="btn btn-success">Add Interest</button>
                                    </form>

                                    <!-- Existing Interests List -->
                                    <h6 class="mb-3">Current Interests</h6>
                                    <?php if (empty($interests)): ?>
                                          <p class="text-muted">No interests added yet.</p>
                                    <?php else: ?>
                                          <div class="table-responsive">
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Icon</th>
                                                                  <th>Interest</th>
                                                                  <th>Actions</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            <?php foreach ($interests as $interest): ?>
                                                                  <tr>
                                                                        <td>
                                                                              <i class="<?php echo htmlspecialchars($interest['icon_class']); ?>" style="font-size: 1.2rem; color: var(--primary-color);"></i>
                                                                        </td>
                                                                        <td><?php echo htmlspecialchars($interest['name']); ?></td>
                                                                        <td>
                                                                              <form method="POST" action="" style="display: inline;">
                                                                                    <input type="hidden" name="action" value="delete_interest">
                                                                                    <input type="hidden" name="interest_id" value="<?php echo $interest['id']; ?>">
                                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this interest?')">
                                                                                          <i class="fas fa-trash"></i> Delete
                                                                                    </button>
                                                                              </form>
                                                                        </td>
                                                                  </tr>
                                                            <?php endforeach; ?>
                                                      </tbody>
                                                </table>
                                          </div>
                                    <?php endif; ?>
                              </div>
                        </div>

                        <!-- Experience Management Form -->
                        <div class="card shadow-sm mt-4">
                              <div class="card-header">
                                    <h5 class="mb-0">Experience Management</h5>
                              </div>
                              <div class="card-body">
                                    <!-- Add New Experience Form -->
                                    <form method="POST" action="" class="mb-4">
                                          <input type="hidden" name="action" value="add_experience">
                                          <h6 class="mb-3">Add New Experience</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Job Title</label>
                                                      <input type="text" class="form-control" name="title" placeholder="e.g., Senior Software Developer" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Company</label>
                                                      <input type="text" class="form-control" name="company" placeholder="e.g., Tech Solutions Co., Ltd." required>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">Start Date</label>
                                                      <input type="date" class="form-control" name="start_date" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">End Date</label>
                                                      <input type="date" class="form-control" name="end_date">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">Current Position</label>
                                                      <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="is_current" id="is_current">
                                                            <label class="form-check-label" for="is_current">
                                                                  I currently work here
                                                            </label>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Job Description</label>
                                                <textarea class="form-control" name="description" rows="3" placeholder="Describe your role and responsibilities" required></textarea>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Key Achievements</label>
                                                <textarea class="form-control" name="achievements" rows="3" placeholder="List your key achievements and accomplishments"></textarea>
                                          </div>
                                          <button type="submit" class="btn btn-success">Add Experience</button>
                                    </form>

                                    <!-- Existing Experience List -->
                                    <h6 class="mb-3">Current Experience</h6>
                                    <?php if (empty($experience)): ?>
                                          <p class="text-muted">No experience added yet.</p>
                                    <?php else: ?>
                                          <div class="table-responsive">
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Title</th>
                                                                  <th>Company</th>
                                                                  <th>Period</th>
                                                                  <th>Actions</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            <?php foreach ($experience as $exp): ?>
                                                                  <tr>
                                                                        <td><?php echo htmlspecialchars($exp['title']); ?></td>
                                                                        <td><?php echo htmlspecialchars($exp['company']); ?></td>
                                                                        <td>
                                                                              <?php
                                                                              echo date('M Y', strtotime($exp['start_date']));
                                                                              echo ' - ';
                                                                              echo $exp['is_current'] ? 'Present' : date('M Y', strtotime($exp['end_date']));
                                                                              ?>
                                                                        </td>
                                                                        <td>
                                                                              <button type="button" class="btn btn-primary btn-sm me-2" onclick="editExperience(<?php echo $exp['id']; ?>)">
                                                                                    <i class="fas fa-edit"></i> Edit
                                                                              </button>
                                                                              <form method="POST" action="" style="display: inline;">
                                                                                    <input type="hidden" name="action" value="delete_experience">
                                                                                    <input type="hidden" name="experience_id" value="<?php echo $exp['id']; ?>">
                                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this experience?')">
                                                                                          <i class="fas fa-trash"></i> Delete
                                                                                    </button>
                                                                              </form>
                                                                        </td>
                                                                  </tr>
                                                            <?php endforeach; ?>
                                                      </tbody>
                                                </table>
                                          </div>
                                    <?php endif; ?>
                              </div>
                        </div>

                        <!-- Education Management Form -->
                        <div class="card shadow-sm mt-4">
                              <div class="card-header">
                                    <h5 class="mb-0">Education Management</h5>
                              </div>
                              <div class="card-body">
                                    <!-- Add New Education Form -->
                                    <form method="POST" action="" class="mb-4">
                                          <input type="hidden" name="action" value="add_education">
                                          <h6 class="mb-3">Add New Education</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Degree</label>
                                                      <input type="text" class="form-control" name="degree" placeholder="e.g., Master of Science" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Field of Study</label>
                                                      <input type="text" class="form-control" name="field_of_study" placeholder="e.g., Computer Science">
                                                </div>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">School/University</label>
                                                <input type="text" class="form-control" name="school" placeholder="e.g., Chulalongkorn University" required>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">Start Date</label>
                                                      <input type="date" class="form-control" name="start_date" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">End Date</label>
                                                      <input type="date" class="form-control" name="end_date">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">Current Student</label>
                                                      <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="is_current" id="is_current_edu">
                                                            <label class="form-check-label" for="is_current_edu">
                                                                  I am currently studying here
                                                            </label>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">GPA (Optional)</label>
                                                      <input type="number" class="form-control" name="gpa" id="edit_edu_gpa" step="0.01" min="0" max="4">
                                                </div>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Achievements & Activities</label>
                                                <textarea class="form-control" name="achievements" id="edit_edu_achievements" rows="3"></textarea>
                                          </div>
                                          <button type="submit" class="btn btn-success">Add Education</button>
                                    </form>

                                    <!-- Existing Education List -->
                                    <h6 class="mb-3">Current Education</h6>
                                    <?php if (empty($education)): ?>
                                          <p class="text-muted">No education added yet.</p>
                                    <?php else: ?>
                                          <div class="table-responsive">
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Degree</th>
                                                                  <th>School</th>
                                                                  <th>Period</th>
                                                                  <th>GPA</th>
                                                                  <th>Actions</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            <?php foreach ($education as $edu): ?>
                                                                  <tr>
                                                                        <td>
                                                                              <?php echo htmlspecialchars($edu['degree']); ?>
                                                                              <?php if ($edu['field_of_study']): ?>
                                                                                    <br><small class="text-muted"><?php echo htmlspecialchars($edu['field_of_study']); ?></small>
                                                                              <?php endif; ?>
                                                                        </td>
                                                                        <td><?php echo htmlspecialchars($edu['school']); ?></td>
                                                                        <td>
                                                                              <?php
                                                                              echo date('M Y', strtotime($edu['start_date']));
                                                                              echo ' - ';
                                                                              echo $edu['is_current'] ? 'Present' : date('M Y', strtotime($edu['end_date']));
                                                                              ?>
                                                                        </td>
                                                                        <td><?php echo $edu['gpa'] ? number_format($edu['gpa'], 2) : '-'; ?></td>
                                                                        <td>
                                                                              <button type="button" class="btn btn-primary btn-sm me-2" onclick="editEducation(<?php echo $edu['id']; ?>)">
                                                                                    <i class="fas fa-edit"></i> Edit
                                                                              </button>
                                                                              <form method="POST" action="" style="display: inline;">
                                                                                    <input type="hidden" name="action" value="delete_education">
                                                                                    <input type="hidden" name="education_id" value="<?php echo $edu['id']; ?>">
                                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this education?')">
                                                                                          <i class="fas fa-trash"></i> Delete
                                                                                    </button>
                                                                              </form>
                                                                        </td>
                                                                  </tr>
                                                            <?php endforeach; ?>
                                                      </tbody>
                                                </table>
                                          </div>
                                    <?php endif; ?>
                              </div>
                        </div>

                        <!-- Courses Management Form -->
                        <div class="card shadow-sm mt-4">
                              <div class="card-header">
                                    <h5 class="mb-0">Courses Management</h5>
                              </div>
                              <div class="card-body">
                                    <!-- Add New Course Form -->
                                    <form method="POST" action="" class="mb-4">
                                          <input type="hidden" name="action" value="add_course">
                                          <h6 class="mb-3">Add New Course</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Education Program</label>
                                                      <select class="form-select" name="education_id" required>
                                                            <option value="">Select Education Program</option>
                                                            <?php foreach ($education as $edu): ?>
                                                                  <option value="<?php echo $edu['id']; ?>">
                                                                        <?php echo htmlspecialchars($edu['degree'] . ' - ' . $edu['school']); ?>
                                                                  </option>
                                                            <?php endforeach; ?>
                                                      </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Course Type</label>
                                                      <select class="form-select" name="course_type" required>
                                                            <option value="">Select Course Type</option>
                                                            <option value="Core">Core</option>
                                                            <option value="Elective">Elective</option>
                                                            <option value="General Education">General Education</option>
                                                            <option value="Thesis">Thesis</option>
                                                            <option value="Project">Project</option>
                                                            <option value="Internship">Internship</option>
                                                      </select>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">Course Code</label>
                                                      <input type="text" class="form-control" name="course_code" placeholder="e.g., CS501, CE201">
                                                </div>
                                                <div class="col-md-8 mb-3">
                                                      <label class="form-label">Course Name</label>
                                                      <input type="text" class="form-control" name="course_name" placeholder="e.g., Advanced Algorithms and Data Structures" required>
                                                </div>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Course Description</label>
                                                <textarea class="form-control" name="course_description" rows="3" placeholder="Brief description of the course content and objectives"></textarea>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">Credits</label>
                                                      <input type="number" class="form-control" name="credits" min="1" max="12" placeholder="e.g., 3">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">Grade</label>
                                                      <select class="form-select" name="grade">
                                                            <option value="">Select Grade</option>
                                                            <option value="A">A (4.0)</option>
                                                            <option value="A-">A- (3.7)</option>
                                                            <option value="B+">B+ (3.3)</option>
                                                            <option value="B">B (3.0)</option>
                                                            <option value="B-">B- (2.7)</option>
                                                            <option value="C+">C+ (2.3)</option>
                                                            <option value="C">C (2.0)</option>
                                                            <option value="C-">C- (1.7)</option>
                                                            <option value="D+">D+ (1.3)</option>
                                                            <option value="D">D (1.0)</option>
                                                            <option value="F">F (0.0)</option>
                                                            <option value="P">Pass</option>
                                                            <option value="I">Incomplete</option>
                                                            <option value="W">Withdrawn</option>
                                                      </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">Semester</label>
                                                      <select class="form-select" name="semester">
                                                            <option value="">Select Semester</option>
                                                            <option value="Fall">Fall</option>
                                                            <option value="Spring">Spring</option>
                                                            <option value="Summer">Summer</option>
                                                            <option value="Winter">Winter</option>
                                                            <option value="Fall-Spring">Fall-Spring</option>
                                                            <option value="Spring-Summer">Spring-Summer</option>
                                                      </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                      <label class="form-label">Academic Year</label>
                                                      <input type="text" class="form-control" name="academic_year" placeholder="e.g., 2022-2023">
                                                </div>
                                          </div>
                                          <div class="mb-3">
                                                <label class="form-label">Instructor</label>
                                                <input type="text" class="form-control" name="instructor" placeholder="e.g., Dr. John Smith">
                                          </div>
                                          <button type="submit" class="btn btn-success">Add Course</button>
                                    </form>

                                    <!-- Existing Courses List -->
                                    <h6 class="mb-3">Current Courses</h6>
                                    <?php if (empty($courses)): ?>
                                          <p class="text-muted">No courses added yet.</p>
                                    <?php else: ?>
                                          <div class="table-responsive">
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Course</th>
                                                                  <th>Program</th>
                                                                  <th>Type</th>
                                                                  <th>Semester</th>
                                                                  <th>Grade</th>
                                                                  <th>Actions</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            <?php foreach ($courses as $course): ?>
                                                                  <tr>
                                                                        <td>
                                                                              <strong><?php echo htmlspecialchars($course['course_name']); ?></strong>
                                                                              <?php if ($course['course_code']): ?>
                                                                                    <br><small class="text-muted"><?php echo htmlspecialchars($course['course_code']); ?></small>
                                                                              <?php endif; ?>
                                                                              <?php if ($course['course_description']): ?>
                                                                                    <br><small class="text-muted"><?php echo htmlspecialchars(substr($course['course_description'], 0, 100)) . (strlen($course['course_description']) > 100 ? '...' : ''); ?></small>
                                                                              <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                              <?php echo htmlspecialchars($course['degree'] . ' - ' . $course['school']); ?>
                                                                        </td>
                                                                        <td>
                                                                              <span class="badge bg-<?php
                                                                                                      echo $course['course_type'] === 'Core' ? 'primary' : ($course['course_type'] === 'Elective' ? 'success' : ($course['course_type'] === 'Thesis' ? 'warning' : ($course['course_type'] === 'Project' ? 'info' : 'secondary')));
                                                                                                      ?>">
                                                                                    <?php echo htmlspecialchars($course['course_type']); ?>
                                                                              </span>
                                                                        </td>
                                                                        <td>
                                                                              <?php echo htmlspecialchars($course['semester']); ?>
                                                                              <?php if ($course['academic_year']): ?>
                                                                                    <br><small class="text-muted"><?php echo htmlspecialchars($course['academic_year']); ?></small>
                                                                              <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                              <?php if ($course['grade']): ?>
                                                                                    <span class="badge bg-<?php
                                                                                                            echo in_array($course['grade'], ['A', 'A-']) ? 'success' : (in_array($course['grade'], ['B+', 'B', 'B-']) ? 'warning' : (in_array($course['grade'], ['C+', 'C', 'C-']) ? 'info' : 'danger'));
                                                                                                            ?>">
                                                                                          <?php echo htmlspecialchars($course['grade']); ?>
                                                                                    </span>
                                                                              <?php else: ?>
                                                                                    <span class="text-muted">-</span>
                                                                              <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                              <button type="button" class="btn btn-primary btn-sm me-2" onclick="editCourse(<?php echo $course['id']; ?>)">
                                                                                    <i class="fas fa-edit"></i> Edit
                                                                              </button>
                                                                              <form method="POST" action="" style="display: inline;">
                                                                                    <input type="hidden" name="action" value="delete_course">
                                                                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">
                                                                                          <i class="fas fa-trash"></i> Delete
                                                                                    </button>
                                                                              </form>
                                                                        </td>
                                                                  </tr>
                                                            <?php endforeach; ?>
                                                      </tbody>
                                                </table>
                                          </div>
                                    <?php endif; ?>
                              </div>
                        </div>

                        <!-- Social Media Management Form -->
                        <div class="card shadow-sm mt-4">
                              <div class="card-header">
                                    <h5 class="mb-0">Social Media Management</h5>
                              </div>
                              <div class="card-body">
                                    <!-- Add New Social Media Form -->
                                    <form method="POST" action="" class="mb-4">
                                          <input type="hidden" name="action" value="add_social_media">
                                          <h6 class="mb-3">Add New Social Media</h6>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Platform</label>
                                                      <select class="form-select" name="platform" required>
                                                            <option value="">Select Platform</option>
                                                            <option value="Email">📧 Email</option>
                                                            <option value="Telegram">📱 Telegram</option>
                                                            <option value="Facebook">📘 Facebook</option>
                                                            <option value="LinkedIn">💼 LinkedIn</option>
                                                            <option value="GitHub">💻 GitHub</option>
                                                            <option value="Instagram">📷 Instagram</option>
                                                            <option value="Twitter">🐦 Twitter</option>
                                                            <option value="YouTube">📺 YouTube</option>
                                                            <option value="WhatsApp">💬 WhatsApp</option>
                                                            <option value="Discord">🎮 Discord</option>
                                                            <option value="Skype">📞 Skype</option>
                                                            <option value="Slack">💼 Slack</option>
                                                            <option value="Reddit">🤖 Reddit</option>
                                                            <option value="TikTok">🎵 TikTok</option>
                                                            <option value="Snapchat">👻 Snapchat</option>
                                                            <option value="Pinterest">📌 Pinterest</option>
                                                            <option value="Behance">🎨 Behance</option>
                                                            <option value="Dribbble">🏀 Dribbble</option>
                                                            <option value="Stack Overflow">💡 Stack Overflow</option>
                                                            <option value="Medium">📝 Medium</option>
                                                            <option value="Dev.to">💻 Dev.to</option>
                                                            <option value="Other">🔗 Other</option>
                                                      </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Username/Handle</label>
                                                      <input type="text" class="form-control" name="username" placeholder="e.g., @username, john.doe, or email@example.com" required>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-8 mb-3">
                                                      <label class="form-label">URL</label>
                                                      <input type="url" class="form-control" name="url" placeholder="https://platform.com/username" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                      <label class="form-label">Display Order</label>
                                                      <input type="number" class="form-control" name="display_order" value="0" min="0" required>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Icon Class (FontAwesome)</label>
                                                      <select class="form-select" name="icon_class" required>
                                                            <option value="">Select Icon</option>
                                                            <option value="fas fa-envelope">📧 Email</option>
                                                            <option value="fab fa-telegram">📱 Telegram</option>
                                                            <option value="fab fa-facebook">📘 Facebook</option>
                                                            <option value="fab fa-linkedin">💼 LinkedIn</option>
                                                            <option value="fab fa-github">💻 GitHub</option>
                                                            <option value="fab fa-instagram">📷 Instagram</option>
                                                            <option value="fab fa-twitter">🐦 Twitter</option>
                                                            <option value="fab fa-youtube">📺 YouTube</option>
                                                            <option value="fab fa-whatsapp">💬 WhatsApp</option>
                                                            <option value="fab fa-discord">🎮 Discord</option>
                                                            <option value="fab fa-skype">📞 Skype</option>
                                                            <option value="fab fa-slack">💼 Slack</option>
                                                            <option value="fab fa-reddit">🤖 Reddit</option>
                                                            <option value="fab fa-tiktok">🎵 TikTok</option>
                                                            <option value="fab fa-snapchat">👻 Snapchat</option>
                                                            <option value="fab fa-pinterest">📌 Pinterest</option>
                                                            <option value="fab fa-behance">🎨 Behance</option>
                                                            <option value="fab fa-dribbble">🏀 Dribbble</option>
                                                            <option value="fab fa-stack-overflow">💡 Stack Overflow</option>
                                                            <option value="fab fa-medium">📝 Medium</option>
                                                            <option value="fas fa-link">🔗 Other</option>
                                                      </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                      <label class="form-label">Status</label>
                                                      <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active_social" checked>
                                                            <label class="form-check-label" for="is_active_social">
                                                                  Active (visible on profile)
                                                            </label>
                                                      </div>
                                                </div>
                                          </div>
                                          <button type="submit" class="btn btn-success">Add Social Media</button>
                                    </form>

                                    <!-- Existing Social Media List -->
                                    <h6 class="mb-3">Current Social Media Links</h6>
                                    <?php if (empty($socialMedia)): ?>
                                          <p class="text-muted">No social media links added yet.</p>
                                    <?php else: ?>
                                          <div class="table-responsive">
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Platform</th>
                                                                  <th>Username</th>
                                                                  <th>URL</th>
                                                                  <th>Order</th>
                                                                  <th>Status</th>
                                                                  <th>Actions</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            <?php foreach ($socialMedia as $social): ?>
                                                                  <tr>
                                                                        <td>
                                                                              <i class="<?php echo htmlspecialchars($social['icon_class']); ?> me-2"></i>
                                                                              <?php echo htmlspecialchars($social['platform']); ?>
                                                                        </td>
                                                                        <td><?php echo htmlspecialchars($social['username']); ?></td>
                                                                        <td>
                                                                              <a href="<?php echo htmlspecialchars($social['url']); ?>" target="_blank" class="text-decoration-none">
                                                                                    <?php echo htmlspecialchars($social['url']); ?>
                                                                              </a>
                                                                        </td>
                                                                        <td><?php echo $social['display_order']; ?></td>
                                                                        <td>
                                                                              <?php if ($social['is_active']): ?>
                                                                                    <span class="badge bg-success">Active</span>
                                                                              <?php else: ?>
                                                                                    <span class="badge bg-secondary">Inactive</span>
                                                                              <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                              <button type="button" class="btn btn-primary btn-sm me-2" onclick="editSocialMedia(<?php echo $social['id']; ?>)">
                                                                                    <i class="fas fa-edit"></i> Edit
                                                                              </button>
                                                                              <form method="POST" action="" style="display: inline;">
                                                                                    <input type="hidden" name="action" value="delete_social_media">
                                                                                    <input type="hidden" name="social_media_id" value="<?php echo $social['id']; ?>">
                                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this social media link?')">
                                                                                          <i class="fas fa-trash"></i> Delete
                                                                                    </button>
                                                                              </form>
                                                                        </td>
                                                                  </tr>
                                                            <?php endforeach; ?>
                                                      </tbody>
                                                </table>
                                          </div>
                                    <?php endif; ?>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

      <!-- Edit Modals -->
      <!-- Social Media Edit Modal -->
      <div class="modal fade" id="editSocialMediaModal" tabindex="-1" aria-labelledby="editSocialMediaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title" id="editSocialMediaModalLabel">Edit Social Media</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="">
                              <div class="modal-body">
                                    <input type="hidden" name="action" value="edit_social_media">
                                    <input type="hidden" name="social_media_id" id="edit_social_media_id">

                                    <div class="row">
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Platform</label>
                                                <select class="form-select" name="platform" id="edit_platform" required>
                                                      <option value="">Select Platform</option>
                                                      <option value="Email">📧 Email</option>
                                                      <option value="Telegram">📱 Telegram</option>
                                                      <option value="Facebook">📘 Facebook</option>
                                                      <option value="LinkedIn">💼 LinkedIn</option>
                                                      <option value="GitHub">💻 GitHub</option>
                                                      <option value="Instagram">📷 Instagram</option>
                                                      <option value="Twitter">🐦 Twitter</option>
                                                      <option value="YouTube">📺 YouTube</option>
                                                      <option value="WhatsApp">💬 WhatsApp</option>
                                                      <option value="Discord">🎮 Discord</option>
                                                      <option value="Skype">📞 Skype</option>
                                                      <option value="Slack">💼 Slack</option>
                                                      <option value="Reddit">🤖 Reddit</option>
                                                      <option value="TikTok">🎵 TikTok</option>
                                                      <option value="Snapchat">👻 Snapchat</option>
                                                      <option value="Pinterest">📌 Pinterest</option>
                                                      <option value="Behance">🎨 Behance</option>
                                                      <option value="Dribbble">🏀 Dribbble</option>
                                                      <option value="Stack Overflow">💡 Stack Overflow</option>
                                                      <option value="Medium">📝 Medium</option>
                                                      <option value="Dev.to">💻 Dev.to</option>
                                                      <option value="Other">🔗 Other</option>
                                                </select>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Username/Handle</label>
                                                <input type="text" class="form-control" name="username" id="edit_username" required>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-8 mb-3">
                                                <label class="form-label">URL</label>
                                                <input type="url" class="form-control" name="url" id="edit_url" required>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                                <label class="form-label">Display Order</label>
                                                <input type="number" class="form-control" name="display_order" id="edit_display_order" min="0" required>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Icon Class</label>
                                                <select class="form-select" name="icon_class" id="edit_icon_class" required>
                                                      <option value="">Select Icon</option>
                                                      <option value="fas fa-envelope">📧 Email</option>
                                                      <option value="fab fa-telegram">📱 Telegram</option>
                                                      <option value="fab fa-facebook">📘 Facebook</option>
                                                      <option value="fab fa-linkedin">💼 LinkedIn</option>
                                                      <option value="fab fa-github">💻 GitHub</option>
                                                      <option value="fab fa-instagram">📷 Instagram</option>
                                                      <option value="fab fa-twitter">🐦 Twitter</option>
                                                      <option value="fab fa-youtube">📺 YouTube</option>
                                                      <option value="fab fa-whatsapp">💬 WhatsApp</option>
                                                      <option value="fab fa-discord">🎮 Discord</option>
                                                      <option value="fab fa-skype">📞 Skype</option>
                                                      <option value="fab fa-slack">💼 Slack</option>
                                                      <option value="fab fa-reddit">🤖 Reddit</option>
                                                      <option value="fab fa-tiktok">🎵 TikTok</option>
                                                      <option value="fab fa-snapchat">👻 Snapchat</option>
                                                      <option value="fab fa-pinterest">📌 Pinterest</option>
                                                      <option value="fab fa-behance">🎨 Behance</option>
                                                      <option value="fab fa-dribbble">🏀 Dribbble</option>
                                                      <option value="fab fa-stack-overflow">💡 Stack Overflow</option>
                                                      <option value="fab fa-medium">📝 Medium</option>
                                                      <option value="fas fa-link">🔗 Other</option>
                                                </select>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Status</label>
                                                <div class="form-check mt-2">
                                                      <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active">
                                                      <label class="form-check-label" for="edit_is_active">
                                                            Active (visible on profile)
                                                      </label>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Social Media</button>
                              </div>
                        </form>
                  </div>
            </div>
      </div>

      <!-- Experience Edit Modal -->
      <div class="modal fade" id="editExperienceModal" tabindex="-1" aria-labelledby="editExperienceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title" id="editExperienceModalLabel">Edit Experience</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="">
                              <div class="modal-body">
                                    <input type="hidden" name="action" value="edit_experience">
                                    <input type="hidden" name="experience_id" id="edit_experience_id">

                                    <div class="row">
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Job Title</label>
                                                <input type="text" class="form-control" name="title" id="edit_exp_title" required>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Company</label>
                                                <input type="text" class="form-control" name="company" id="edit_exp_company" required>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-4 mb-3">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control" name="start_date" id="edit_exp_start_date" required>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                                <label class="form-label">End Date</label>
                                                <input type="date" class="form-control" name="end_date" id="edit_exp_end_date">
                                          </div>
                                          <div class="col-md-4 mb-3">
                                                <label class="form-label">Current Position</label>
                                                <div class="form-check mt-2">
                                                      <input class="form-check-input" type="checkbox" name="is_current" id="edit_exp_is_current">
                                                      <label class="form-check-label" for="edit_exp_is_current">
                                                            I currently work here
                                                      </label>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Description</label>
                                          <textarea class="form-control" name="description" id="edit_exp_description" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Achievements</label>
                                          <textarea class="form-control" name="achievements" id="edit_exp_achievements" rows="3"></textarea>
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Experience</button>
                              </div>
                        </form>
                  </div>
            </div>
      </div>

      <!-- Education Edit Modal -->
      <div class="modal fade" id="editEducationModal" tabindex="-1" aria-labelledby="editEducationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title" id="editEducationModalLabel">Edit Education</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="">
                              <div class="modal-body">
                                    <input type="hidden" name="action" value="edit_education">
                                    <input type="hidden" name="education_id" id="edit_education_id">

                                    <div class="row">
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Degree</label>
                                                <input type="text" class="form-control" name="degree" id="edit_edu_degree" required>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Field of Study</label>
                                                <input type="text" class="form-control" name="field_of_study" id="edit_edu_field">
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">School/University</label>
                                          <input type="text" class="form-control" name="school" id="edit_edu_school" required>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-4 mb-3">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control" name="start_date" id="edit_edu_start_date" required>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                                <label class="form-label">End Date</label>
                                                <input type="date" class="form-control" name="end_date" id="edit_edu_end_date">
                                          </div>
                                          <div class="col-md-4 mb-3">
                                                <label class="form-label">Current Student</label>
                                                <div class="form-check mt-2">
                                                      <input class="form-check-input" type="checkbox" name="is_current" id="edit_edu_is_current">
                                                      <label class="form-check-label" for="edit_edu_is_current">
                                                            I am currently studying here
                                                      </label>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">GPA (Optional)</label>
                                                <input type="number" class="form-control" name="gpa" id="edit_edu_gpa" step="0.01" min="0" max="4">
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Achievements & Activities</label>
                                          <textarea class="form-control" name="achievements" id="edit_edu_achievements" rows="3"></textarea>
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Education</button>
                              </div>
                        </form>
                  </div>
            </div>
      </div>

      <!-- Course Edit Modal -->
      <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="">
                              <div class="modal-body">
                                    <input type="hidden" name="action" value="edit_course">
                                    <input type="hidden" name="course_id" id="edit_course_id">

                                    <div class="row">
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Education Program</label>
                                                <select class="form-select" name="education_id" id="edit_course_education_id" required>
                                                      <option value="">Select Education Program</option>
                                                      <?php foreach ($education as $edu): ?>
                                                            <option value="<?php echo $edu['id']; ?>">
                                                                  <?php echo htmlspecialchars($edu['degree'] . ' - ' . $edu['school']); ?>
                                                            </option>
                                                      <?php endforeach; ?>
                                                </select>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                                <label class="form-label">Course Type</label>
                                                <select class="form-select" name="course_type" id="edit_course_type" required>
                                                      <option value="">Select Course Type</option>
                                                      <option value="Core">Core</option>
                                                      <option value="Elective">Elective</option>
                                                      <option value="General Education">General Education</option>
                                                      <option value="Thesis">Thesis</option>
                                                      <option value="Project">Project</option>
                                                      <option value="Internship">Internship</option>
                                                </select>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-4 mb-3">
                                                <label class="form-label">Course Code</label>
                                                <input type="text" class="form-control" name="course_code" id="edit_course_code">
                                          </div>
                                          <div class="col-md-8 mb-3">
                                                <label class="form-label">Course Name</label>
                                                <input type="text" class="form-control" name="course_name" id="edit_course_name" required>
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Course Description</label>
                                          <textarea class="form-control" name="course_description" id="edit_course_description" rows="3"></textarea>
                                    </div>
                                    <div class="row">
                                          <div class="col-md-3 mb-3">
                                                <label class="form-label">Credits</label>
                                                <input type="number" class="form-control" name="credits" id="edit_course_credits" min="1" max="12">
                                          </div>
                                          <div class="col-md-3 mb-3">
                                                <label class="form-label">Grade</label>
                                                <select class="form-select" name="grade" id="edit_course_grade">
                                                      <option value="">Select Grade</option>
                                                      <option value="A">A (4.0)</option>
                                                      <option value="A-">A- (3.7)</option>
                                                      <option value="B+">B+ (3.3)</option>
                                                      <option value="B">B (3.0)</option>
                                                      <option value="B-">B- (2.7)</option>
                                                      <option value="C+">C+ (2.3)</option>
                                                      <option value="C">C (2.0)</option>
                                                      <option value="C-">C- (1.7)</option>
                                                      <option value="D+">D+ (1.3)</option>
                                                      <option value="D">D (1.0)</option>
                                                      <option value="F">F (0.0)</option>
                                                      <option value="P">Pass</option>
                                                      <option value="I">Incomplete</option>
                                                      <option value="W">Withdrawn</option>
                                                </select>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                                <label class="form-label">Semester</label>
                                                <select class="form-select" name="semester" id="edit_course_semester">
                                                      <option value="">Select Semester</option>
                                                      <option value="Fall">Fall</option>
                                                      <option value="Spring">Spring</option>
                                                      <option value="Summer">Summer</option>
                                                      <option value="Winter">Winter</option>
                                                      <option value="Fall-Spring">Fall-Spring</option>
                                                      <option value="Spring-Summer">Spring-Summer</option>
                                                </select>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                                <label class="form-label">Academic Year</label>
                                                <input type="text" class="form-control" name="academic_year" id="edit_course_academic_year">
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Instructor</label>
                                          <input type="text" class="form-control" name="instructor" id="edit_course_instructor">
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Course</button>
                              </div>
                        </form>
                  </div>
            </div>
      </div>

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

            // Function to edit social media
            function editSocialMedia(id) {
                  // Find the social media data from the PHP array
                  const socialMediaData = <?php echo json_encode($socialMedia); ?>;
                  const social = socialMediaData.find(item => item.id == id);

                  if (social) {
                        // Populate the modal fields
                        document.getElementById('edit_social_media_id').value = social.id;
                        document.getElementById('edit_platform').value = social.platform;
                        document.getElementById('edit_username').value = social.username;
                        document.getElementById('edit_url').value = social.url;
                        document.getElementById('edit_display_order').value = social.display_order;
                        document.getElementById('edit_icon_class').value = social.icon_class;
                        document.getElementById('edit_is_active').checked = social.is_active == 1;

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('editSocialMediaModal'));
                        modal.show();
                  } else {
                        alert('Social media data not found!');
                  }
            }

            // Function to edit experience
            function editExperience(id) {
                  // Find the experience data from the PHP array
                  const experienceData = <?php echo json_encode($experience); ?>;
                  const exp = experienceData.find(item => item.id == id);

                  if (exp) {
                        // Populate the modal fields
                        document.getElementById('edit_experience_id').value = exp.id;
                        document.getElementById('edit_exp_title').value = exp.title;
                        document.getElementById('edit_exp_company').value = exp.company;
                        document.getElementById('edit_exp_start_date').value = exp.start_date;
                        document.getElementById('edit_exp_end_date').value = exp.end_date || '';
                        document.getElementById('edit_exp_is_current').checked = exp.is_current == 1;
                        document.getElementById('edit_exp_description').value = exp.description || '';
                        document.getElementById('edit_exp_achievements').value = exp.achievements || '';

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('editExperienceModal'));
                        modal.show();
                  } else {
                        alert('Experience data not found!');
                  }
            }

            // Function to edit education
            function editEducation(id) {
                  // Find the education data from the PHP array
                  const educationData = <?php echo json_encode($education); ?>;
                  const edu = educationData.find(item => item.id == id);

                  if (edu) {
                        // Populate the modal fields
                        document.getElementById('edit_education_id').value = edu.id;
                        document.getElementById('edit_edu_degree').value = edu.degree;
                        document.getElementById('edit_edu_field').value = edu.field_of_study || '';
                        document.getElementById('edit_edu_school').value = edu.school;
                        document.getElementById('edit_edu_start_date').value = edu.start_date;
                        document.getElementById('edit_edu_end_date').value = edu.end_date || '';
                        document.getElementById('edit_edu_is_current').checked = edu.is_current == 1;
                        document.getElementById('edit_edu_gpa').value = edu.gpa || '';
                        document.getElementById('edit_edu_achievements').value = edu.achievements || '';

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('editEducationModal'));
                        modal.show();
                  } else {
                        alert('Education data not found!');
                  }
            }

            // Function to edit course
            function editCourse(id) {
                  // Find the course data from the PHP array
                  const coursesData = <?php echo json_encode($courses); ?>;
                  const course = coursesData.find(item => item.id == id);

                  if (course) {
                        // Populate the modal fields
                        document.getElementById('edit_course_id').value = course.id;
                        document.getElementById('edit_course_education_id').value = course.education_id;
                        document.getElementById('edit_course_type').value = course.course_type;
                        document.getElementById('edit_course_code').value = course.course_code || '';
                        document.getElementById('edit_course_name').value = course.course_name;
                        document.getElementById('edit_course_description').value = course.course_description || '';
                        document.getElementById('edit_course_credits').value = course.credits || '';
                        document.getElementById('edit_course_grade').value = course.grade || '';
                        document.getElementById('edit_course_semester').value = course.semester || '';
                        document.getElementById('edit_course_academic_year').value = course.academic_year || '';
                        document.getElementById('edit_course_instructor').value = course.instructor || '';

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('editCourseModal'));
                        modal.show();
                  } else {
                        alert('Course data not found!');
                  }
            }

            // Auto-hide end date when "current" is checked
            document.addEventListener('DOMContentLoaded', function() {
                  const isCurrentCheckbox = document.getElementById('is_current');
                  const endDateInput = document.querySelector('input[name="end_date"]');

                  if (isCurrentCheckbox && endDateInput) {
                        isCurrentCheckbox.addEventListener('change', function() {
                              if (this.checked) {
                                    endDateInput.disabled = true;
                                    endDateInput.value = '';
                              } else {
                                    endDateInput.disabled = false;
                              }
                        });
                  }

                  const isCurrentEduCheckbox = document.getElementById('is_current_edu');
                  const endDateEduInput = document.querySelector('input[name="end_date"]');

                  if (isCurrentEduCheckbox && endDateEduInput) {
                        isCurrentEduCheckbox.addEventListener('change', function() {
                              if (this.checked) {
                                    endDateEduInput.disabled = true;
                                    endDateEduInput.value = '';
                              } else {
                                    endDateEduInput.disabled = false;
                              }
                        });
                  }
            });
      </script>
</body>

</html>