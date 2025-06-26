<?php
header('Content-Type: text/plain');

// Test database connection
require_once 'config.php';

ob_implicit_flush(true);
ob_end_flush();

error_reporting(E_ALL);
ini_set('display_errors', 1);

function print_flush($msg)
{
      echo $msg;
      if (ob_get_level()) ob_flush();
      flush();
}

print_flush("Database connection test:\n");
print_flush("Server: " . DB_SERVER . "\n");
print_flush("Database: " . DB_NAME . "\n");
print_flush("Connection status: " . ($conn ? "SUCCESS" : "FAILED") . "\n\n");

if ($conn) {
      // Test if tables exist
      $tables = [
            'users',
            'personal_info',
            'experience',
            'education',
            'skills',
            'social_media',
            'certificates',
            'courses',
            'company_info',
            'cover_letter',
            'languages',
            'interests'
      ];

      print_flush("Table existence check:\n");
      foreach ($tables as $table) {
            $result = @mysqli_query($conn, "SHOW TABLES LIKE '$table'");
            if ($result === false) {
                  print_flush("$table: ERROR: " . mysqli_error($conn) . "\n");
                  continue;
            }
            $exists = mysqli_num_rows($result) > 0;
            print_flush("$table: " . ($exists ? "EXISTS" : "MISSING") . "\n");

            if ($exists) {
                  $structure = @mysqli_query($conn, "DESCRIBE $table");
                  if ($structure === false) {
                        print_flush("  ERROR: " . mysqli_error($conn) . "\n");
                  } else {
                        print_flush("  Columns: ");
                        $columns = [];
                        while ($row = mysqli_fetch_assoc($structure)) {
                              $columns[] = $row['Field'];
                        }
                        print_flush(implode(', ', $columns) . "\n");
                  }
            }
      }

      // Test a simple query
      print_flush("\nTesting simple query:\n");
      $result = @mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
      if ($result) {
            $row = mysqli_fetch_assoc($result);
            print_flush("Users count: " . $row['count'] . "\n");
      } else {
            print_flush("Query failed: " . mysqli_error($conn) . "\n");
      }
} else {
      print_flush("Connection failed: " . mysqli_connect_error() . "\n");
}
