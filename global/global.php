<?php
// Handle random profile image functionality
function getRandomProfileImage()
{
      $randomImagesDir = 'images/random/';
      $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

      // Check if directory exists
      if (!is_dir($randomImagesDir)) {
            return null;
      }

      // Get all image files from the random directory
      $imageFiles = [];
      $files = scandir($randomImagesDir);

      foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                  $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                  if (in_array($extension, $allowedExtensions)) {
                        $imageFiles[] = $file;
                  }
            }
      }

      // If no images found, return null
      if (empty($imageFiles)) {
            return null;
      }

      // If user doesn't have a profile image assigned in session, assign one randomly
      if (!isset($_SESSION['profile_image'])) {
            $_SESSION['profile_image'] = $imageFiles[array_rand($imageFiles)];
      }

      return $randomImagesDir . $_SESSION['profile_image'];
}

// Fetch all portfolio data
function fetchPortfolioData($conn)
{
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

      // Return all data as an array
      return [
            'isLoggedIn' => $isLoggedIn,
            'personalInfo' => $personalInfo,
            'skills' => $skills,
            'experience' => $experience,
            'education' => $education,
            'courses' => $courses,
            'languages' => $languages,
            'interests' => $interests,
            'socialMedia' => $socialMedia,
            'hasData' => $hasData
      ];
}
