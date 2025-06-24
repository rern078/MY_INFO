<?php
// Database configuration
// Local development settings (commented out for live server)
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'cv_portfolio');

// Live server settings (InfinityFree)
define('DB_SERVER', 'sql107.infinityfree.com');
define('DB_USERNAME', 'if0_39279429');
define('DB_PASSWORD', 'o0yt6R9MGyCh');
define('DB_NAME', 'if0_39279429_cv_portfolio');


// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't show errors to users
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt'); // Create error log file in current directory

// Attempt to connect to MySQL database with database name included
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if (!$conn) {
    $error_msg = "Database connection failed: " . mysqli_connect_error();
    error_log($error_msg);
    die("Database connection failed. Please check your configuration.");
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");

// Create tables if they don't exist (for shared hosting, database should already exist)
$tables = [
    // Users table
    "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Personal Information table
    "CREATE TABLE IF NOT EXISTS personal_info (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        title VARCHAR(100) NOT NULL,
        professional_profile TEXT,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        height VARCHAR(20) NOT NULL,
        weight VARCHAR(20) NOT NULL,
        date_of_birth DATE NOT NULL,
        gender VARCHAR(20) NOT NULL,
        nationality VARCHAR(50) NOT NULL,
        marital_status VARCHAR(20) NOT NULL,
        religion VARCHAR(50) NOT NULL,
        address VARCHAR(100) NOT NULL,
        city VARCHAR(50) NOT NULL,
        state VARCHAR(50) NOT NULL,
        zip VARCHAR(20) NOT NULL,
        country VARCHAR(50) NOT NULL,
        location VARCHAR(100) NOT NULL,
        website VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Company Information table
    "CREATE TABLE IF NOT EXISTS company_info (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        position VARCHAR(100) NOT NULL,
        hiring_manager VARCHAR(100) NOT NULL,
        street VARCHAR(100) NOT NULL,
        city VARCHAR(50) NOT NULL,
        state VARCHAR(50) NOT NULL,
        zip VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Cover Letter Content table
    "CREATE TABLE IF NOT EXISTS cover_letter (
        id INT PRIMARY KEY AUTO_INCREMENT,
        introduction TEXT NOT NULL,
        body TEXT NOT NULL,
        closing TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Experience table
    "CREATE TABLE IF NOT EXISTS experience (
        id INT PRIMARY KEY AUTO_INCREMENT,
        position VARCHAR(100) NOT NULL,
        company VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Education table
    "CREATE TABLE IF NOT EXISTS education (
        id INT PRIMARY KEY AUTO_INCREMENT,
        degree VARCHAR(100) NOT NULL,
        institution VARCHAR(100) NOT NULL,
        field_of_study VARCHAR(100) NOT NULL,
        graduation_date DATE NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Skills table
    "CREATE TABLE IF NOT EXISTS skills (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        category VARCHAR(50) NOT NULL,
        proficiency INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Languages table
    "CREATE TABLE IF NOT EXISTS languages (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        proficiency INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Interests table
    "CREATE TABLE IF NOT EXISTS interests (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        icon_class VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

// Execute each table creation query
foreach ($tables as $sql) {
    if (!mysqli_query($conn, $sql)) {
        $error_msg = "Error creating table: " . mysqli_error($conn);
        error_log($error_msg);
    }
}

// Function to sanitize input data
function sanitize_input($data)
{
    global $conn;
    if ($conn) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return mysqli_real_escape_string($conn, $data);
    }
    return htmlspecialchars(trim(stripslashes($data)));
}
