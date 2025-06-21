<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
      http_response_code(200);
      exit();
}

require_once '../config.php';
// require_once '../../Portfolio_INFO/config.php';

class PortfolioAPI
{
      private $conn;

      public function __construct($conn)
      {
            $this->conn = $conn;
      }

      // Helper method to send JSON response
      private function sendResponse($data, $statusCode = 200)
      {
            http_response_code($statusCode);
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            exit();
      }

      // Helper method to send error response
      private function sendError($message, $statusCode = 400)
      {
            $this->sendResponse(['error' => $message], $statusCode);
      }

      // Helper method to validate required fields
      private function validateRequiredFields($data, $requiredFields)
      {
            foreach ($requiredFields as $field) {
                  if (!isset($data[$field]) || empty($data[$field])) {
                        $this->sendError("Missing required field: $field");
                  }
            }
      }

      // Helper method to sanitize input
      private function sanitizeInput($data)
      {
            if (is_array($data)) {
                  foreach ($data as $key => $value) {
                        $data[$key] = $this->sanitizeInput($value);
                  }
            } else {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  $data = mysqli_real_escape_string($this->conn, $data);
            }
            return $data;
      }

      // Generic GET method for all tables
      public function getAll($table, $conditions = [])
      {
            $sql = "SELECT * FROM $table";
            $params = [];

            if (!empty($conditions)) {
                  $whereClause = [];
                  foreach ($conditions as $key => $value) {
                        $whereClause[] = "$key = ?";
                        $params[] = $value;
                  }
                  $sql .= " WHERE " . implode(' AND ', $whereClause);
            }

            $stmt = mysqli_prepare($this->conn, $sql);
            if ($stmt === false) {
                  $this->sendError("Database error: " . mysqli_error($this->conn), 500);
            }

            if (!empty($params)) {
                  $types = str_repeat('s', count($params));
                  mysqli_stmt_bind_param($stmt, $types, ...$params);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                  $data[] = $row;
            }

            mysqli_stmt_close($stmt);
            $this->sendResponse(['data' => $data, 'count' => count($data)]);
      }

      // Generic GET by ID method
      public function getById($table, $id)
      {
            $sql = "SELECT * FROM $table WHERE id = ?";
            $stmt = mysqli_prepare($this->conn, $sql);

            if ($stmt === false) {
                  $this->sendError("Database error: " . mysqli_error($this->conn), 500);
            }

            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $data = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if (!$data) {
                  $this->sendError("Record not found", 404);
            }

            $this->sendResponse(['data' => $data]);
      }

      // Generic POST method
      public function create($table, $data)
      {
            $data = $this->sanitizeInput($data);

            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = mysqli_prepare($this->conn, $sql);

            if ($stmt === false) {
                  $this->sendError("Database error: " . mysqli_error($this->conn), 500);
            }

            $types = str_repeat('s', count($data));
            mysqli_stmt_bind_param($stmt, $types, ...array_values($data));

            if (mysqli_stmt_execute($stmt)) {
                  $id = mysqli_insert_id($this->conn);
                  mysqli_stmt_close($stmt);
                  $this->sendResponse(['message' => 'Record created successfully', 'id' => $id], 201);
            } else {
                  mysqli_stmt_close($stmt);
                  $this->sendError("Failed to create record: " . mysqli_error($this->conn), 500);
            }
      }

      // Generic PUT method
      public function update($table, $id, $data)
      {
            $data = $this->sanitizeInput($data);

            $setClause = [];
            foreach (array_keys($data) as $column) {
                  $setClause[] = "$column = ?";
            }

            $sql = "UPDATE $table SET " . implode(', ', $setClause) . " WHERE id = ?";
            $stmt = mysqli_prepare($this->conn, $sql);

            if ($stmt === false) {
                  $this->sendError("Database error: " . mysqli_error($this->conn), 500);
            }

            $types = str_repeat('s', count($data)) . 'i';
            $params = array_values($data);
            $params[] = $id;
            mysqli_stmt_bind_param($stmt, $types, ...$params);

            if (mysqli_stmt_execute($stmt)) {
                  $affectedRows = mysqli_stmt_affected_rows($stmt);
                  mysqli_stmt_close($stmt);

                  if ($affectedRows > 0) {
                        $this->sendResponse(['message' => 'Record updated successfully']);
                  } else {
                        $this->sendError("Record not found", 404);
                  }
            } else {
                  mysqli_stmt_close($stmt);
                  $this->sendError("Failed to update record: " . mysqli_error($this->conn), 500);
            }
      }

      // Generic DELETE method
      public function delete($table, $id)
      {
            $sql = "DELETE FROM $table WHERE id = ?";
            $stmt = mysqli_prepare($this->conn, $sql);

            if ($stmt === false) {
                  $this->sendError("Database error: " . mysqli_error($this->conn), 500);
            }

            mysqli_stmt_bind_param($stmt, 'i', $id);

            if (mysqli_stmt_execute($stmt)) {
                  $affectedRows = mysqli_stmt_affected_rows($stmt);
                  mysqli_stmt_close($stmt);

                  if ($affectedRows > 0) {
                        $this->sendResponse(['message' => 'Record deleted successfully']);
                  } else {
                        $this->sendError("Record not found", 404);
                  }
            } else {
                  mysqli_stmt_close($stmt);
                  $this->sendError("Failed to delete record: " . mysqli_error($this->conn), 500);
            }
      }

      // Specific methods for each table with validation

      // Users API
      public function createUser($data)
      {
            $this->validateRequiredFields($data, ['username', 'email', 'password']);

            // Check if username or email already exists
            $checkSql = "SELECT id FROM users WHERE username = ? OR email = ?";
            $checkStmt = mysqli_prepare($this->conn, $checkSql);
            mysqli_stmt_bind_param($checkStmt, 'ss', $data['username'], $data['email']);
            mysqli_stmt_execute($checkStmt);
            $result = mysqli_stmt_get_result($checkStmt);

            if (mysqli_num_rows($result) > 0) {
                  mysqli_stmt_close($checkStmt);
                  $this->sendError("Username or email already exists");
            }
            mysqli_stmt_close($checkStmt);

            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            $this->create('users', $data);
      }

      public function updateUser($id, $data)
      {
            if (isset($data['password'])) {
                  $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            $this->update('users', $id, $data);
      }

      // Personal Info API
      public function createPersonalInfo($data)
      {
            $requiredFields = [
                  'name',
                  'title',
                  'email',
                  'phone',
                  'height',
                  'weight',
                  'date_of_birth',
                  'gender',
                  'nationality',
                  'marital_status',
                  'religion',
                  'address',
                  'city',
                  'state',
                  'zip',
                  'country',
                  'location'
            ];
            $this->validateRequiredFields($data, $requiredFields);

            $this->create('personal_info', $data);
      }

      // Experience API
      public function createExperience($data)
      {
            $this->validateRequiredFields($data, ['user_id', 'title', 'company', 'start_date']);

            $this->create('experience', $data);
      }

      // Education API
      public function createEducation($data)
      {
            $this->validateRequiredFields($data, ['user_id', 'degree', 'school', 'start_date']);

            $this->create('education', $data);
      }

      // Skills API
      public function createSkill($data)
      {
            $this->validateRequiredFields($data, ['user_id', 'skill_name']);

            $this->create('skills', $data);
      }

      // Social Media API
      public function createSocialMedia($data)
      {
            $this->validateRequiredFields($data, ['user_id', 'platform']);

            $this->create('social_media', $data);
      }

      // Certificates API
      public function createCertificate($data)
      {
            $this->validateRequiredFields($data, ['title', 'issuing_organization', 'issue_date', 'file_type']);

            $this->create('certificates', $data);
      }

      // Courses API
      public function createCourse($data)
      {
            $this->validateRequiredFields($data, ['user_id', 'education_id', 'course_name']);

            $this->create('courses', $data);
      }

      // Company Info API
      public function createCompanyInfo($data)
      {
            $requiredFields = ['name', 'position', 'hiring_manager', 'street', 'city', 'state', 'zip'];
            $this->validateRequiredFields($data, $requiredFields);

            $this->create('company_info', $data);
      }

      // Cover Letter API
      public function createCoverLetter($data)
      {
            $this->validateRequiredFields($data, ['introduction', 'body', 'closing']);

            $this->create('cover_letter', $data);
      }

      // Languages API
      public function createLanguage($data)
      {
            $this->validateRequiredFields($data, ['name', 'proficiency']);

            $this->create('languages', $data);
      }

      // Interests API
      public function createInterest($data)
      {
            $this->validateRequiredFields($data, ['name']);

            $this->create('interests', $data);
      }
}

// Initialize API
$api = new PortfolioAPI($conn);

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));

// Extract endpoint from URL
$endpoint = end($pathParts);

// If the endpoint is the filename itself, check for a table parameter
if ($endpoint === 'api_submitter.php') {
      // Check if there's a table parameter in the URL
      if (isset($_GET['table'])) {
            $endpoint = $_GET['table'];
      } else {
            // Default to users if no table specified
            $endpoint = 'users';
      }
}

// Get request body for POST/PUT requests
$input = json_decode(file_get_contents('php://input'), true);
if ($input === null && $method !== 'GET' && $method !== 'DELETE') {
      $input = $_POST; // Fallback to POST data
}

// Route handling
try {
      switch ($method) {
            case 'GET':
                  if (isset($_GET['id'])) {
                        // Get specific record by ID
                        $table = $endpoint;
                        $id = (int)$_GET['id'];
                        $api->getById($table, $id);
                  } else {
                        // Get all records with optional filters
                        $table = $endpoint;
                        $conditions = [];

                        // Add user_id filter if provided
                        if (isset($_GET['user_id'])) {
                              $conditions['user_id'] = (int)$_GET['user_id'];
                        }

                        // Add education_id filter for courses
                        if ($table === 'courses' && isset($_GET['education_id'])) {
                              $conditions['education_id'] = (int)$_GET['education_id'];
                        }

                        $api->getAll($table, $conditions);
                  }
                  break;

            case 'POST':
                  switch ($endpoint) {
                        case 'users':
                              $api->createUser($input);
                              break;
                        case 'personal_info':
                              $api->createPersonalInfo($input);
                              break;
                        case 'experience':
                              $api->createExperience($input);
                              break;
                        case 'education':
                              $api->createEducation($input);
                              break;
                        case 'skills':
                              $api->createSkill($input);
                              break;
                        case 'social_media':
                              $api->createSocialMedia($input);
                              break;
                        case 'certificates':
                              $api->createCertificate($input);
                              break;
                        case 'courses':
                              $api->createCourse($input);
                              break;
                        case 'company_info':
                              $api->createCompanyInfo($input);
                              break;
                        case 'cover_letter':
                              $api->createCoverLetter($input);
                              break;
                        case 'languages':
                              $api->createLanguage($input);
                              break;
                        case 'interests':
                              $api->createInterest($input);
                              break;
                        default:
                              $api->sendError("Invalid endpoint: $endpoint", 404);
                  }
                  break;

            case 'PUT':
                  if (!isset($_GET['id'])) {
                        $api->sendError("ID parameter required for update", 400);
                  }

                  $id = (int)$_GET['id'];
                  $table = $endpoint;

                  if ($table === 'users') {
                        $api->updateUser($id, $input);
                  } else {
                        $api->update($table, $id, $input);
                  }
                  break;

            case 'DELETE':
                  if (!isset($_GET['id'])) {
                        $api->sendError("ID parameter required for deletion", 400);
                  }

                  $id = (int)$_GET['id'];
                  $table = $endpoint;
                  $api->delete($table, $id);
                  break;

            default:
                  $api->sendError("Method not allowed", 405);
      }
} catch (Exception $e) {
      $api->sendError("Server error: " . $e->getMessage(), 500);
}

// Close database connection
mysqli_close($conn);
