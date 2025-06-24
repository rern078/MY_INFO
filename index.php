<?php
session_start();
require_once 'config.php';
require_once 'languages.php';

// Check if user is logged in (but don't redirect - allow public access)
$isLoggedIn = isset($_SESSION['user_id']);

// Fetch Personal Information
$personalInfoQuery = "SELECT * FROM personal_info ORDER BY id DESC LIMIT 1";
$personalInfoResult = mysqli_query($conn, $personalInfoQuery);
if (!$personalInfoResult) {
      die("Error fetching personal information: " . mysqli_error($conn));
}
$personalInfo = mysqli_fetch_assoc($personalInfoResult);

// Fetch Skills
$skills = [];
if ($isLoggedIn) {
      $user_id = $_SESSION['user_id'];
      $skillsQuery = "SELECT * FROM skills WHERE user_id = $user_id ORDER BY category, skill_name";
      $skillsResult = mysqli_query($conn, $skillsQuery);
      if (!$skillsResult) {
            die("Error fetching skills: " . mysqli_error($conn));
      }
      while ($row = mysqli_fetch_assoc($skillsResult)) {
            $skills[$row['category']][] = $row;
      }
}

// If no skills found for current user or user not logged in, get all skills data
if (empty($skills)) {
      $skillsQuery = "SELECT * FROM skills ORDER BY category, skill_name";
      $skillsResult = mysqli_query($conn, $skillsQuery);
      while ($row = mysqli_fetch_assoc($skillsResult)) {
            $skills[$row['category']][] = $row;
      }
}

// Fetch Experience
$experience = [];
if ($isLoggedIn) {
      $user_id = $_SESSION['user_id'];
      $experienceQuery = "SELECT * FROM experience WHERE user_id = $user_id ORDER BY start_date DESC";
      $experienceResult = mysqli_query($conn, $experienceQuery);
      if (!$experienceResult) {
            die("Error fetching experience: " . mysqli_error($conn));
      }
      while ($row = mysqli_fetch_assoc($experienceResult)) {
            $experience[] = $row;
      }
}

// If no experience found for current user or user not logged in, get all experience data
if (empty($experience)) {
      $experienceQuery = "SELECT * FROM experience ORDER BY start_date DESC";
      $experienceResult = mysqli_query($conn, $experienceQuery);
      while ($row = mysqli_fetch_assoc($experienceResult)) {
            $experience[] = $row;
      }
}

// Fetch Education
$education = [];
if ($isLoggedIn) {
      $user_id = $_SESSION['user_id'];
      $educationQuery = "SELECT * FROM education WHERE user_id = $user_id ORDER BY start_date DESC";
      $educationResult = mysqli_query($conn, $educationQuery);
      if (!$educationResult) {
            die("Error fetching education: " . mysqli_error($conn));
      }
      while ($row = mysqli_fetch_assoc($educationResult)) {
            $education[] = $row;
      }
}

// If no education found for current user or user not logged in, get all education data
if (empty($education)) {
      $educationQuery = "SELECT * FROM education ORDER BY start_date DESC";
      $educationResult = mysqli_query($conn, $educationQuery);
      while ($row = mysqli_fetch_assoc($educationResult)) {
            $education[] = $row;
      }
}

// Fetch Courses
$courses = [];
if ($isLoggedIn) {
      $user_id = $_SESSION['user_id'];
      $coursesQuery = "SELECT c.*, e.degree, e.school FROM courses c 
                      LEFT JOIN education e ON c.education_id = e.id 
                      WHERE c.user_id = $user_id 
                      ORDER BY e.start_date DESC, c.academic_year DESC, c.semester ASC";
      $coursesResult = mysqli_query($conn, $coursesQuery);
      if (!$coursesResult) {
            die("Error fetching courses: " . mysqli_error($conn));
      }
      while ($row = mysqli_fetch_assoc($coursesResult)) {
            $courses[] = $row;
      }
}

// If no courses found for current user or user not logged in, get all courses data
if (empty($courses)) {
      $coursesQuery = "SELECT c.*, e.degree, e.school FROM courses c 
                      LEFT JOIN education e ON c.education_id = e.id 
                      ORDER BY e.start_date DESC, c.academic_year DESC, c.semester ASC";
      $coursesResult = mysqli_query($conn, $coursesQuery);
      while ($row = mysqli_fetch_assoc($coursesResult)) {
            $courses[] = $row;
      }
}

// Fetch Languages
$languagesQuery = "SELECT * FROM languages ORDER BY proficiency DESC";
$languagesResult = mysqli_query($conn, $languagesQuery);
if (!$languagesResult) {
      die("Error fetching languages: " . mysqli_error($conn));
}
$languages = [];
while ($row = mysqli_fetch_assoc($languagesResult)) {
      $languages[] = $row;
}

// Fetch Interests
$interestsQuery = "SELECT * FROM interests ORDER BY name ASC";
$interestsResult = mysqli_query($conn, $interestsQuery);
if (!$interestsResult) {
      die("Error fetching interests: " . mysqli_error($conn));
}
$interests = [];
while ($row = mysqli_fetch_assoc($interestsResult)) {
      $interests[] = $row;
}

// Fetch Social Media
$socialMedia = [];
if ($isLoggedIn) {
      $user_id = $_SESSION['user_id'];
      $socialMediaQuery = "SELECT * FROM social_media WHERE user_id = $user_id AND is_active = 1 ORDER BY display_order ASC, platform ASC";
      $socialMediaResult = mysqli_query($conn, $socialMediaQuery);
      if (!$socialMediaResult) {
            die("Error fetching social media: " . mysqli_error($conn));
      }
      while ($row = mysqli_fetch_assoc($socialMediaResult)) {
            $socialMedia[] = $row;
      }
}

// If no social media found for current user or user not logged in, get all active social media data
if (empty($socialMedia)) {
      $socialMediaQuery = "SELECT * FROM social_media WHERE is_active = 1 ORDER BY display_order ASC, platform ASC";
      $socialMediaResult = mysqli_query($conn, $socialMediaQuery);
      while ($row = mysqli_fetch_assoc($socialMediaResult)) {
            $socialMedia[] = $row;
      }
}

// Check if required data exists
$hasData = $personalInfo;
?>

<!DOCTYPE html>
<html lang="<?php echo $current_language; ?>" dir="<?php echo getLanguageDirection(); ?>">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo t('cv'); ?> - <?php echo htmlspecialchars($personalInfo['name'] ?? t('user')); ?></title>
      <link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
      <?php include 'header.php'; ?>

      <div class="container">
            <?php if (!$hasData): ?>
                  <div class="alert alert-warning fade-in">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><?php echo t('no_cv_data_available'); ?></span>
                  </div>
            <?php else: ?>
                  <div class="cv-header fade-in">
                        <h1><?php echo htmlspecialchars($personalInfo['name']); ?></h1>
                        <!-- <div class="title"><?php echo htmlspecialchars($personalInfo['title']); ?></div> -->
                        <div class="contact-details">
                              <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span><?php echo htmlspecialchars($personalInfo['email']); ?></span>
                              </div>
                              <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <span><?php echo htmlspecialchars($personalInfo['phone']); ?></span>
                              </div>
                              <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo htmlspecialchars($personalInfo['location']); ?></span>
                              </div>
                              <?php if (!empty($socialMedia)): ?>
                                    <div class="social-media-links">
                                          <?php foreach ($socialMedia as $social): ?>
                                                <a href="<?php echo htmlspecialchars($social['url']); ?>" target="_blank" class="social-link" title="<?php echo htmlspecialchars($social['platform']); ?>">
                                                      <i class="<?php echo htmlspecialchars($social['icon_class']); ?>"></i>
                                                </a>
                                          <?php endforeach; ?>
                                    </div>
                              <?php endif; ?>
                        </div>
                  </div>

                  <!-- CV Content -->
                  <div class="cv-content slide-in-left">
                        <div class="card-body">
                              <!-- Personal Information Section -->
                              <div class="section-header">
                                    <i class="fas fa-user"></i>
                                    <h3>Personal Information</h3>
                              </div>

                              <div class="info-grid">
                                    <!-- Personal Details -->
                                    <div class="info-card">
                                          <h4><i class="fas fa-id-card"></i>Personal Details</h4>
                                          <ul class="info-list">
                                                <li>
                                                      <strong>Date of Birth:</strong>
                                                      <span><?php echo htmlspecialchars($personalInfo['date_of_birth']); ?></span>
                                                </li>
                                                <li>
                                                      <strong>Gender:</strong>
                                                      <span><?php echo htmlspecialchars($personalInfo['gender']); ?></span>
                                                </li>
                                                <li>
                                                      <strong>Nationality:</strong>
                                                      <span><?php echo htmlspecialchars($personalInfo['nationality']); ?></span>
                                                </li>
                                                <li>
                                                      <strong>Marital Status:</strong>
                                                      <span><?php echo htmlspecialchars($personalInfo['marital_status']); ?></span>
                                                </li>
                                                <li>
                                                      <strong>Religion:</strong>
                                                      <span><?php echo htmlspecialchars($personalInfo['religion']); ?></span>
                                                </li>
                                          </ul>
                                    </div>

                                    <!-- Physical Information -->
                                    <div class="info-card">
                                          <h4><i class="fas fa-ruler"></i>Physical Information</h4>
                                          <ul class="info-list">
                                                <li>
                                                      <strong>Height:</strong>
                                                      <span><?php echo htmlspecialchars($personalInfo['height']); ?></span>
                                                </li>
                                                <li>
                                                      <strong>Weight:</strong>
                                                      <span><?php echo htmlspecialchars($personalInfo['weight']); ?></span>
                                                </li>
                                          </ul>
                                    </div>

                                    <!-- Address Information -->
                                    <div class="info-card">
                                          <h4><i class="fas fa-home"></i>Address</h4>
                                          <div class="address-info">
                                                <p><?php echo htmlspecialchars($personalInfo['address']); ?></p>
                                                <p><?php echo htmlspecialchars($personalInfo['city'] . ', ' . $personalInfo['state'] . ' ' . $personalInfo['zip']); ?></p>
                                                <p><?php echo htmlspecialchars($personalInfo['country']); ?></p>
                                          </div>
                                    </div>
                              </div>

                              <!-- Skills Section -->
                              <div class="section-header">
                                    <i class="fas fa-tools"></i>
                                    <h3>Skills & Expertise</h3>
                              </div>

                              <div class="skills-container">
                                    <?php foreach ($skills as $category => $categorySkills): ?>
                                          <div class="skill-category">
                                                <h4><?php echo htmlspecialchars($category); ?></h4>
                                                <div class="skills-grid">
                                                      <?php foreach ($categorySkills as $skill): ?>
                                                            <span class="skill-badge">
                                                                  <?php echo htmlspecialchars($skill['skill_name']); ?>
                                                                  <?php if ($skill['proficiency_level']): ?>
                                                                        <small>(<?php echo htmlspecialchars($skill['proficiency_level']); ?>)</small>
                                                                  <?php endif; ?>
                                                            </span>
                                                      <?php endforeach; ?>
                                                </div>
                                          </div>
                                    <?php endforeach; ?>
                              </div>

                              <!-- Experience Section -->
                              <div class="section-header">
                                    <i class="fas fa-briefcase"></i>
                                    <h3>Professional Experience</h3>
                              </div>

                              <?php foreach ($experience as $exp): ?>
                                    <div class="timeline-item">
                                          <h4><?php echo htmlspecialchars($exp['title']); ?></h4>
                                          <h5>
                                                <i class="fas fa-building"></i>
                                                <?php echo htmlspecialchars($exp['company']); ?>
                                                <span class="period">
                                                      <?php
                                                      echo date('M Y', strtotime($exp['start_date']));
                                                      echo ' - ';
                                                      echo $exp['is_current'] ? 'Present' : date('M Y', strtotime($exp['end_date']));
                                                      ?>
                                                </span>
                                          </h5>
                                          <?php if ($exp['description']): ?>
                                                <div class="description"><?php echo nl2br(htmlspecialchars($exp['description'])); ?></div>
                                          <?php endif; ?>
                                          <?php if ($exp['achievements']): ?>
                                                <div class="achievements">
                                                      <ul>
                                                            <?php foreach (preg_split('/\r\n|\r|\n/', trim($exp['achievements'])) as $line): ?>
                                                                  <?php if (trim($line) !== ''): ?>
                                                                        <li><?php echo htmlspecialchars($line); ?></li>
                                                                  <?php endif; ?>
                                                            <?php endforeach; ?>
                                                      </ul>
                                                </div>
                                          <?php endif; ?>
                                    </div>
                              <?php endforeach; ?>

                              <!-- Education Section -->
                              <div class="section-header">
                                    <i class="fas fa-graduation-cap"></i>
                                    <h3>Education</h3>
                              </div>

                              <?php foreach ($education as $edu): ?>
                                    <div class="timeline-item">
                                          <h4><?php echo htmlspecialchars($edu['degree']); ?></h4>
                                          <h5>
                                                <i class="fas fa-university"></i>
                                                <?php echo htmlspecialchars($edu['school']); ?>
                                                <?php if ($edu['field_of_study']): ?>
                                                      <span class="text-muted">| <?php echo htmlspecialchars($edu['field_of_study']); ?></span>
                                                <?php endif; ?>
                                                <span class="period">
                                                      <?php
                                                      echo date('M Y', strtotime($edu['start_date']));
                                                      echo ' - ';
                                                      echo $edu['is_current'] ? 'Present' : date('M Y', strtotime($edu['end_date']));
                                                      ?>
                                                </span>
                                          </h5>
                                          <?php if ($edu['gpa']): ?>
                                                <div class="description">GPA: <?php echo number_format($edu['gpa'], 2); ?></div>
                                          <?php endif; ?>
                                          <?php if ($edu['achievements']): ?>
                                                <div class="achievements">
                                                      <ul>
                                                            <?php foreach (preg_split('/\r\n|\r|\n/', trim($edu['achievements'])) as $line): ?>
                                                                  <?php if (trim($line) !== ''): ?>
                                                                        <li><?php echo htmlspecialchars($line); ?></li>
                                                                  <?php endif; ?>
                                                            <?php endforeach; ?>
                                                      </ul>
                                                </div>
                                          <?php endif; ?>
                                    </div>
                              <?php endforeach; ?>

                              <!-- Courses Section -->
                              <div class="section-header">
                                    <i class="fas fa-book"></i>
                                    <h3>Courses</h3>
                              </div>

                              <?php
                              // Group courses by education program
                              $coursesByEducation = [];
                              foreach ($courses as $course) {
                                    $educationKey = $course['degree'] . ' - ' . $course['school'];
                                    $coursesByEducation[$educationKey][] = $course;
                              }
                              ?>

                              <?php foreach ($coursesByEducation as $educationProgram => $educationCourses): ?>
                                    <div class="education-program">
                                          <h4 class="program-title">
                                                <i class="fas fa-graduation-cap"></i>
                                                <?php echo htmlspecialchars($educationProgram); ?>
                                          </h4>

                                          <div class="courses-grid">
                                                <?php foreach ($educationCourses as $course): ?>
                                                      <div class="course-item">
                                                            <div class="course-header">
                                                                  <h5 class="course-name">
                                                                        <?php if ($course['course_code']): ?>
                                                                              <span class="course-code"><?php echo htmlspecialchars($course['course_code']); ?></span>
                                                                        <?php endif; ?>
                                                                        <?php echo htmlspecialchars($course['course_name']); ?>
                                                                  </h5>
                                                                  <div class="course-meta">
                                                                        <?php if ($course['credits']): ?>
                                                                              <span class="course-credits">
                                                                                    <i class="fas fa-credit-card"></i>
                                                                                    <?php echo $course['credits']; ?> Credits
                                                                              </span>
                                                                        <?php endif; ?>
                                                                        <?php if ($course['grade']): ?>
                                                                              <span class="course-grade">
                                                                                    <i class="fas fa-star"></i>
                                                                                    Grade: <?php echo htmlspecialchars($course['grade']); ?>
                                                                              </span>
                                                                        <?php endif; ?>
                                                                  </div>
                                                            </div>

                                                            <div class="course-details">
                                                                  <?php if ($course['semester'] && $course['academic_year']): ?>
                                                                        <div class="course-period">
                                                                              <i class="fas fa-calendar"></i>
                                                                              <?php echo htmlspecialchars($course['semester']); ?>
                                                                              (<?php echo htmlspecialchars($course['academic_year']); ?>)
                                                                        </div>
                                                                  <?php endif; ?>

                                                                  <?php if ($course['instructor']): ?>
                                                                        <div class="course-instructor">
                                                                              <i class="fas fa-user-tie"></i>
                                                                              Instructor: <?php echo htmlspecialchars($course['instructor']); ?>
                                                                        </div>
                                                                  <?php endif; ?>

                                                                  <?php if ($course['course_type']): ?>
                                                                        <div class="course-type">
                                                                              <i class="fas fa-tag"></i>
                                                                              <?php echo htmlspecialchars($course['course_type']); ?>
                                                                        </div>
                                                                  <?php endif; ?>
                                                            </div>

                                                            <?php if ($course['course_description']): ?>
                                                                  <div class="course-description">
                                                                        <?php echo nl2br(htmlspecialchars($course['course_description'])); ?>
                                                                  </div>
                                                            <?php endif; ?>
                                                      </div>
                                                <?php endforeach; ?>
                                          </div>
                                    </div>
                              <?php endforeach; ?>

                              <!-- Languages Section -->
                              <div class="section-header">
                                    <i class="fas fa-language"></i>
                                    <h3>Languages</h3>
                              </div>

                              <div class="languages-container">
                                    <?php foreach ($languages as $language): ?>
                                          <div class="language-item">
                                                <div class="language-info">
                                                      <span class="language-name"><?php echo htmlspecialchars($language['name']); ?></span>
                                                      <div class="proficiency-bar">
                                                            <div class="proficiency-fill" style="width: <?php echo ($language['proficiency'] / 5) * 100; ?>%"></div>
                                                      </div>
                                                      <span class="proficiency-level">
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
                                                            echo $level;
                                                            ?>
                                                      </span>
                                                </div>
                                          </div>
                                    <?php endforeach; ?>
                              </div>

                              <!-- Interests Section -->
                              <div class="section-header">
                                    <i class="fas fa-heart"></i>
                                    <h3>Interests & Hobbies</h3>
                              </div>

                              <div class="interests-container">
                                    <?php foreach ($interests as $interest): ?>
                                          <div class="interest-item">
                                                <i class="<?php echo htmlspecialchars($interest['icon_class']); ?>"></i>
                                                <span class="interest-name"><?php echo htmlspecialchars($interest['name']); ?></span>
                                          </div>
                                    <?php endforeach; ?>
                              </div>

                              <!-- Social Media Section -->
                              <?php if (!empty($socialMedia)): ?>
                                    <div class="section-header">
                                          <i class="fas fa-share-alt"></i>
                                          <h3>Connect With Me</h3>
                                    </div>

                                    <div class="social-media-container">
                                          <?php foreach ($socialMedia as $social): ?>
                                                <div class="social-media-item">
                                                      <a href="<?php echo htmlspecialchars($social['url']); ?>" target="_blank" class="social-media-link">
                                                            <div class="social-icon">
                                                                  <i class="<?php echo htmlspecialchars($social['icon_class']); ?>"></i>
                                                            </div>
                                                            <div class="social-info">
                                                                  <span class="social-platform"><?php echo htmlspecialchars($social['platform']); ?></span>
                                                                  <span class="social-username"><?php echo htmlspecialchars($social['username']); ?></span>
                                                            </div>
                                                      </a>
                                                </div>
                                          <?php endforeach; ?>
                                    </div>
                              <?php endif; ?>
                        </div>
                  </div>
            <?php endif; ?>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
            // Add animation classes to elements as they come into view
            document.addEventListener('DOMContentLoaded', function() {
                  const observerOptions = {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                  };

                  const observer = new IntersectionObserver(function(entries) {
                        entries.forEach(entry => {
                              if (entry.isIntersecting) {
                                    entry.target.style.opacity = '1';
                                    entry.target.style.transform = 'translateY(0)';
                              }
                        });
                  }, observerOptions);

                  // Observe all timeline items and info cards
                  document.querySelectorAll('.timeline-item, .info-card, .skill-category').forEach(el => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(20px)';
                        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                        observer.observe(el);
                  });
            });
      </script>
</body>

</html>