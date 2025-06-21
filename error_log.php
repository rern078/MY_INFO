<?php
// Simple error log viewer - DELETE THIS FILE AFTER DEBUGGING
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Error Log Viewer</h2>";
echo "<p><strong>Warning:</strong> This file should be deleted after debugging for security reasons.</p>";

// Check if error log file exists
$error_log_path = ini_get('error_log');
if (empty($error_log_path)) {
      $error_log_path = 'error_log'; // Default fallback
}

echo "<p><strong>Error log path:</strong> " . $error_log_path . "</p>";

if (file_exists($error_log_path)) {
      echo "<h3>Recent Error Log Entries:</h3>";
      echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ccc; max-height: 400px; overflow-y: auto;'>";

      // Read last 50 lines of error log
      $lines = file($error_log_path);
      $recent_lines = array_slice($lines, -50);

      foreach ($recent_lines as $line) {
            echo htmlspecialchars($line);
      }

      echo "</pre>";
} else {
      echo "<p>Error log file not found at: " . $error_log_path . "</p>";

      // Try common error log locations
      $common_paths = [
            '/var/log/apache2/error.log',
            '/var/log/httpd/error_log',
            '/var/log/nginx/error.log',
            'error_log',
            'logs/error.log'
      ];

      echo "<h3>Checking common error log locations:</h3>";
      foreach ($common_paths as $path) {
            if (file_exists($path)) {
                  echo "<p>Found error log at: " . $path . "</p>";
                  echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ccc; max-height: 200px; overflow-y: auto;'>";
                  $lines = file($path);
                  $recent_lines = array_slice($lines, -20);
                  foreach ($recent_lines as $line) {
                        echo htmlspecialchars($line);
                  }
                  echo "</pre>";
                  break;
            }
      }
}

echo "<hr>";
echo "<p><strong>PHP Info:</strong></p>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion() . "</li>";
echo "<li>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</li>";
echo "<li>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "<li>Current Script: " . __FILE__ . "</li>";
echo "</ul>";

echo "<p><strong>Note:</strong> Remember to delete this file after debugging!</p>";
