<?php
session_start();
require_once 'config.php';
require_once 'vendor/autoload.php'; // You'll need to install TCPDF via Composer

// Start output buffering
ob_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit();
}

// Function to generate CV PDF
function generateCVPDF($personalInfo, $skills, $experience, $education, $languages, $interests)
{
      // Create new PDF document
      $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // Set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor($personalInfo['name']);
      $pdf->SetTitle('CV - ' . $personalInfo['name']);

      // Remove default header/footer
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);

      // Set margins
      $pdf->SetMargins(15, 15, 15);

      // Add a page
      $pdf->AddPage();

      // Set font
      $pdf->SetFont('helvetica', '', 11);

      // Header
      $pdf->SetFont('helvetica', 'B', 20);
      $pdf->Cell(0, 10, $personalInfo['name'], 0, 1, 'C');
      $pdf->SetFont('helvetica', 'I', 14);
      $pdf->Cell(0, 10, $personalInfo['title'], 0, 1, 'C');
      $pdf->Ln(5);

      // Contact Information
      $pdf->SetFont('helvetica', '', 10);
      $contact = $personalInfo['email'] . ' | ' . $personalInfo['phone'] . ' | ' . $personalInfo['location'];
      $pdf->Cell(0, 10, $contact, 0, 1, 'C');
      $pdf->Ln(5);

      // Personal Information
      $pdf->SetFont('helvetica', 'B', 12);
      $pdf->Cell(0, 10, 'Personal Information', 0, 1);
      $pdf->SetFont('helvetica', '', 10);
      $personal = "Date of Birth: " . $personalInfo['date_of_birth'] . "\n";
      $personal .= "Gender: " . $personalInfo['gender'] . "\n";
      $personal .= "Nationality: " . $personalInfo['nationality'] . "\n";
      $personal .= "Marital Status: " . $personalInfo['marital_status'] . "\n";
      $personal .= "Religion: " . $personalInfo['religion'];
      $pdf->MultiCell(0, 7, $personal);
      $pdf->Ln(5);

      // Skills
      $pdf->SetFont('helvetica', 'B', 12);
      $pdf->Cell(0, 10, 'Skills', 0, 1);
      $pdf->SetFont('helvetica', '', 10);
      foreach ($skills as $category => $categorySkills) {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 7, $category, 0, 1);
            $pdf->SetFont('helvetica', '', 10);
            $skillList = '';
            foreach ($categorySkills as $skill) {
                  $skillList .= $skill['skill_name'];
                  if ($skill['proficiency_level']) {
                        $skillList .= ' (' . $skill['proficiency_level'] . ')';
                  }
                  $skillList .= ', ';
            }
            $pdf->MultiCell(0, 7, rtrim($skillList, ', '));
      }
      $pdf->Ln(5);

      // Languages
      if (!empty($languages)) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Languages', 0, 1);
            $pdf->SetFont('helvetica', '', 10);
            $languageList = '';
            foreach ($languages as $language) {
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
                  $languageList .= $language['name'] . ' (' . $level . '), ';
            }
            $pdf->MultiCell(0, 7, rtrim($languageList, ', '));
            $pdf->Ln(5);
      }

      // Interests
      if (!empty($interests)) {
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Interests & Hobbies', 0, 1);
            $pdf->SetFont('helvetica', '', 10);
            $interestList = '';
            foreach ($interests as $interest) {
                  $interestList .= $interest['name'] . ', ';
            }
            $pdf->MultiCell(0, 7, rtrim($interestList, ', '));
            $pdf->Ln(5);
      }

      // Experience
      $pdf->SetFont('helvetica', 'B', 12);
      $pdf->Cell(0, 10, 'Professional Experience', 0, 1);
      foreach ($experience as $exp) {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 7, $exp['title'], 0, 1);
            $pdf->SetFont('helvetica', 'I', 10);
            $date = date('M Y', strtotime($exp['start_date'])) . ' - ';
            $date .= $exp['is_current'] ? 'Present' : date('M Y', strtotime($exp['end_date']));
            $pdf->Cell(0, 7, $exp['company'] . ' | ' . $date, 0, 1);
            $pdf->SetFont('helvetica', '', 10);
            if ($exp['description']) {
                  $pdf->MultiCell(0, 7, $exp['description']);
            }
            if ($exp['achievements']) {
                  $pdf->MultiCell(0, 7, $exp['achievements']);
            }
            $pdf->Ln(3);
      }

      // Education
      $pdf->SetFont('helvetica', 'B', 12);
      $pdf->Cell(0, 10, 'Education', 0, 1);
      foreach ($education as $edu) {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 7, $edu['degree'], 0, 1);
            $pdf->SetFont('helvetica', 'I', 10);
            $date = date('M Y', strtotime($edu['start_date'])) . ' - ';
            $date .= $edu['is_current'] ? 'Present' : date('M Y', strtotime($edu['end_date']));
            $eduInfo = $edu['school'];
            if ($edu['field_of_study']) {
                  $eduInfo .= ' | ' . $edu['field_of_study'];
            }
            $eduInfo .= ' | ' . $date;
            $pdf->Cell(0, 7, $eduInfo, 0, 1);
            $pdf->SetFont('helvetica', '', 10);
            if ($edu['gpa']) {
                  $pdf->Cell(0, 7, 'GPA: ' . number_format($edu['gpa'], 2), 0, 1);
            }
            if ($edu['achievements']) {
                  $pdf->MultiCell(0, 7, $edu['achievements']);
            }
            $pdf->Ln(3);
      }

      return $pdf;
}

// Function to generate Cover Letter PDF
function generateCoverLetterPDF($personalInfo, $companyInfo, $coverLetter)
{
      // Create new PDF document
      $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // Set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor($personalInfo['name']);
      $pdf->SetTitle('Cover Letter - ' . $personalInfo['name']);

      // Remove default header/footer
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);

      // Set margins
      $pdf->SetMargins(15, 15, 15);

      // Add a page
      $pdf->AddPage();

      // Set font
      $pdf->SetFont('helvetica', '', 11);

      // Date
      $pdf->Cell(0, 10, date('F d, Y'), 0, 1, 'R');
      $pdf->Ln(10);

      // Company Information
      $pdf->SetFont('helvetica', '', 10);
      $companyAddress = $companyInfo['hiring_manager'] . "\n";
      $companyAddress .= $companyInfo['name'] . "\n";
      $companyAddress .= $companyInfo['street'] . "\n";
      $companyAddress .= $companyInfo['city'] . ', ' . $companyInfo['state'] . ' ' . $companyInfo['zip'];
      $pdf->MultiCell(0, 7, $companyAddress);
      $pdf->Ln(10);

      // Salutation
      $pdf->SetFont('helvetica', '', 11);
      $pdf->Cell(0, 10, 'Dear ' . $companyInfo['hiring_manager'] . ',', 0, 1);
      $pdf->Ln(5);

      // Cover Letter Content
      $pdf->MultiCell(0, 7, $coverLetter['introduction']);
      $pdf->Ln(5);
      $pdf->MultiCell(0, 7, $coverLetter['body']);
      $pdf->Ln(5);
      $pdf->MultiCell(0, 7, $coverLetter['closing']);
      $pdf->Ln(10);

      // Signature
      $pdf->Cell(0, 10, 'Sincerely,', 0, 1);
      $pdf->Ln(5);
      $pdf->Cell(0, 10, $personalInfo['name'], 0, 1);

      return $pdf;
}

// Clear any previous output
ob_clean();

// Handle PDF generation requests
if (isset($_GET['type'])) {
      // Fetch required data
      $personalInfoQuery = "SELECT * FROM personal_info ORDER BY id DESC LIMIT 1";
      $personalInfoResult = mysqli_query($conn, $personalInfoQuery);
      $personalInfo = mysqli_fetch_assoc($personalInfoResult);

      if ($_GET['type'] === 'cv') {
            // Fetch additional data for CV
            $user_id = $_SESSION['user_id'];
            $skillsQuery = "SELECT * FROM skills WHERE user_id = $user_id ORDER BY category, skill_name";
            $skillsResult = mysqli_query($conn, $skillsQuery);
            $skills = [];
            while ($row = mysqli_fetch_assoc($skillsResult)) {
                  $skills[$row['category']][] = $row;
            }

            // If no skills found for current user, get all skills data
            if (empty($skills)) {
                  $skillsQuery = "SELECT * FROM skills ORDER BY category, skill_name";
                  $skillsResult = mysqli_query($conn, $skillsQuery);
                  while ($row = mysqli_fetch_assoc($skillsResult)) {
                        $skills[$row['category']][] = $row;
                  }
            }

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

            $pdf = generateCVPDF($personalInfo, $skills, $experience, $education, $languages, $interests);
            $pdf->Output('CV_' . $personalInfo['name'] . '.pdf', 'D');
      } elseif ($_GET['type'] === 'cover-letter') {
            // Fetch additional data for cover letter
            $companyInfoQuery = "SELECT * FROM company_info ORDER BY id DESC LIMIT 1";
            $companyInfoResult = mysqli_query($conn, $companyInfoQuery);
            $companyInfo = mysqli_fetch_assoc($companyInfoResult);

            $coverLetterQuery = "SELECT * FROM cover_letter ORDER BY id DESC LIMIT 1";
            $coverLetterResult = mysqli_query($conn, $coverLetterQuery);
            $coverLetter = mysqli_fetch_assoc($coverLetterResult);

            $pdf = generateCoverLetterPDF($personalInfo, $companyInfo, $coverLetter);
            $pdf->Output('Cover_Letter_' . $personalInfo['name'] . '.pdf', 'D');
      }
}

// End output buffering
ob_end_flush();
