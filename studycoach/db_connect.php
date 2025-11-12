<?php
$servername = "localhost";
$username = "root";   // Default for XAMPP
$password = "";       // Default for XAMPP (change if you have a password)
$dbname = "studycoach_db";  // Replace with your database name
$port = 3306; // Default MySQL port used by XAMPP

// Try connecting using the configured server name first
$conn = @new mysqli($servername, $username, $password, $dbname, $port);

// If connecting to 'localhost' fails with an active refusal, try 127.0.0.1 to force a TCP connection
if ($conn->connect_error && $servername === 'localhost') {
    $conn = @new mysqli('127.0.0.1', $username, $password, $dbname, $port);
}

if ($conn->connect_error) {
    // Don't echo passwords. Give actionable guidance instead.
    $errno = $conn->connect_errno;
    $error = $conn->connect_error;
    die("Connection failed: ({$errno}) {$error}. Possible causes: MySQL server is not running, wrong host/port, or incorrect credentials.\nOn XAMPP, open the Control Panel and start MySQL (or check port settings).\n");
}

// Successful connection continues; other files can use $conn
?>
