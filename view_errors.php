<?php
// Error Log Viewer - DELETE THIS FILE AFTER DEBUGGING
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>CV Portfolio Error Log Viewer</h2>";
echo "<p><strong>Warning:</strong> This file should be deleted after debugging for security reasons.</p>";

$error_log_file = 'error_log.txt';

if (file_exists($error_log_file)) {
      echo "<h3>Error Log Contents:</h3>";
      echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ccc; max-height: 500px; overflow-y: auto; font-family: monospace;'>";

      $content = file_get_contents($error_log_file);
      echo htmlspecialchars($content);

      echo "</pre>";

      // Show file info
      echo "<p><strong>File Info:</strong></p>";
      echo "<ul>";
      echo "<li>File size: " . filesize($error_log_file) . " bytes</li>";
      echo "<li>Last modified: " . date('Y-m-d H:i:s', filemtime($error_log_file)) . "</li>";
      echo "<li>File permissions: " . substr(sprintf('%o', fileperms($error_log_file)), -4) . "</li>";
      echo "</ul>";
} else {
      echo "<p>Error log file not found: " . $error_log_file . "</p>";
      echo "<p>This might mean no errors have occurred yet, or the log file is in a different location.</p>";
}

// Test database connection
echo "<h3>Database Connection Test:</h3>";
try {
      require_once 'config.php';
      if ($conn) {
            echo "<p style='color: green;'>✓ Database connection successful</p>";

            // Test a simple query
            $result = mysqli_query($conn, "SELECT 1 as test");
            if ($result) {
                  echo "<p style='color: green;'>✓ Database query test successful</p>";
            } else {
                  echo "<p style='color: red;'>✗ Database query test failed: " . mysqli_error($conn) . "</p>";
            }
      } else {
            echo "<p style='color: red;'>✗ Database connection failed</p>";
      }
} catch (Exception $e) {
      echo "<p style='color: red;'>✗ Exception: " . $e->getMessage() . "</p>";
}

// Show PHP and server info
echo "<h3>Server Information:</h3>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion() . "</li>";
echo "<li>Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</li>";
echo "<li>Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</li>";
echo "<li>Current Script: " . __FILE__ . "</li>";
echo "<li>Error Reporting: " . (error_reporting() ? 'Enabled' : 'Disabled') . "</li>";
echo "<li>Display Errors: " . (ini_get('display_errors') ? 'On' : 'Off') . "</li>";
echo "<li>Log Errors: " . (ini_get('log_errors') ? 'On' : 'Off') . "</li>";
echo "<li>Error Log Path: " . (ini_get('error_log') ?: 'Default') . "</li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>Note:</strong> Remember to delete this file after debugging!</p>";
echo "<p><a href='index.php'>← Back to main site</a></p>";
