<?php
session_start();
require_once 'config.php';

echo "<h2>Database Test Results - Achievements Data</h2>";

// Show all experience data regardless of user login
echo "<h3>All Experience Data:</h3>";
$allExperienceQuery = "SELECT * FROM experience ORDER BY start_date DESC";
$allExperienceResult = mysqli_query($conn, $allExperienceQuery);
if (!$allExperienceResult) {
      echo "Error: " . mysqli_error($conn);
} else {
      $count = mysqli_num_rows($allExperienceResult);
      echo "<p>Found $count total experience records</p>";
      while ($row = mysqli_fetch_assoc($allExperienceResult)) {
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
            echo "<strong>User ID:</strong> " . $row['user_id'] . "<br>";
            echo "<strong>Title:</strong> " . $row['title'] . "<br>";
            echo "<strong>Company:</strong> " . $row['company'] . "<br>";
            echo "<strong>Description:</strong> " . $row['description'] . "<br>";
            echo "<strong>Achievements (Raw):</strong> <pre>" . htmlspecialchars($row['achievements']) . "</pre><br>";
            echo "<strong>Achievements Length:</strong> " . strlen($row['achievements']) . " characters<br>";
            echo "<strong>Achievements Empty:</strong> " . (empty($row['achievements']) ? 'Yes' : 'No') . "<br>";
            echo "</div>";
      }
}

// Show all education data regardless of user login
echo "<h3>All Education Data:</h3>";
$allEducationQuery = "SELECT * FROM education ORDER BY start_date DESC";
$allEducationResult = mysqli_query($conn, $allEducationQuery);
if (!$allEducationResult) {
      echo "Error: " . mysqli_error($conn);
} else {
      $count = mysqli_num_rows($allEducationResult);
      echo "<p>Found $count total education records</p>";
      while ($row = mysqli_fetch_assoc($allEducationResult)) {
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
            echo "<strong>User ID:</strong> " . $row['user_id'] . "<br>";
            echo "<strong>Degree:</strong> " . $row['degree'] . "<br>";
            echo "<strong>School:</strong> " . $row['school'] . "<br>";
            echo "<strong>GPA:</strong> " . $row['gpa'] . "<br>";
            echo "<strong>Achievements (Raw):</strong> <pre>" . htmlspecialchars($row['achievements']) . "</pre><br>";
            echo "<strong>Achievements Length:</strong> " . strlen($row['achievements']) . " characters<br>";
            echo "<strong>Achievements Empty:</strong> " . (empty($row['achievements']) ? 'Yes' : 'No') . "<br>";
            echo "</div>";
      }
}

// Check if user is logged in and show their specific data
if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      echo "<h3>Current User ($user_id) Experience Data:</h3>";
      $userExperienceQuery = "SELECT * FROM experience WHERE user_id = $user_id ORDER BY start_date DESC";
      $userExperienceResult = mysqli_query($conn, $userExperienceQuery);
      if (!$userExperienceResult) {
            echo "Error: " . mysqli_error($conn);
      } else {
            $count = mysqli_num_rows($userExperienceResult);
            echo "<p>Found $count experience records for user $user_id</p>";
            while ($row = mysqli_fetch_assoc($userExperienceResult)) {
                  echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
                  echo "<strong>Title:</strong> " . $row['title'] . "<br>";
                  echo "<strong>Company:</strong> " . $row['company'] . "<br>";
                  echo "<strong>Achievements:</strong> <pre>" . htmlspecialchars($row['achievements']) . "</pre><br>";
                  echo "</div>";
            }
      }
} else {
      echo "<p>No user logged in</p>";
}
