<?php
// Simple PHP Test File
echo "<h1>PHP Test Page</h1>";
echo "<p>If you can see this, PHP is working on your server!</p>";

echo "<h2>Basic Information:</h2>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion() . "</li>";
echo "<li>Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</li>";
echo "<li>Current Time: " . date('Y-m-d H:i:s') . "</li>";
echo "</ul>";

echo "<h2>Testing Database Connection:</h2>";
try {
      require_once 'config.php';
      if ($conn) {
            echo "<p style='color: green;'>✓ Database connection successful!</p>";

            // Test a simple query
            $result = mysqli_query($conn, "SHOW TABLES");
            if ($result) {
                  $table_count = mysqli_num_rows($result);
                  echo "<p style='color: green;'>✓ Database query successful! Found $table_count tables.</p>";

                  echo "<h3>Available Tables:</h3>";
                  echo "<ul>";
                  while ($row = mysqli_fetch_array($result)) {
                        echo "<li>" . $row[0] . "</li>";
                  }
                  echo "</ul>";
            } else {
                  echo "<p style='color: red;'>✗ Database query failed: " . mysqli_error($conn) . "</p>";
            }
      } else {
            echo "<p style='color: red;'>✗ Database connection failed!</p>";
      }
} catch (Exception $e) {
      echo "<p style='color: red;'>✗ Exception occurred: " . $e->getMessage() . "</p>";
}

echo "<h2>File System Test:</h2>";
$test_file = 'test_write.txt';
$content = "Test write at " . date('Y-m-d H:i:s');
if (file_put_contents($test_file, $content)) {
      echo "<p style='color: green;'>✓ File write test successful</p>";
      echo "<p>Created file: $test_file</p>";

      // Clean up
      unlink($test_file);
      echo "<p>✓ Test file cleaned up</p>";
} else {
      echo "<p style='color: red;'>✗ File write test failed</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>← Go to main site</a></p>";
echo "<p><a href='view_errors.php'>← View error log</a></p>";
