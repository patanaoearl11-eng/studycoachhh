<?php
// Database configuration
define('DB_HOST', 'localhost');     // Database host (usually localhost)
define('DB_USERNAME', 'root');      // Database username
define('DB_PASSWORD', '');          // Database password
define('DB_NAME', 'studycoach');    // Database name

// Create database connection
try {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Set charset to UTF8 (optional but recommended)
$conn->set_charset("utf8mb4");
?>