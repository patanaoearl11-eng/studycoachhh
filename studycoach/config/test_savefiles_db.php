<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";          // leave empty unless you set one
$dbname = "test_savefiles_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_email = "name@example.com";
$checkUser = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$checkUser->bind_param("s", $user_email);
$checkUser->execute();
$checkUser->store_result();

if ($checkUser->num_rows == 0) {
    $insertUser = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    $full_name = "John Doe";
    $hashed_password = password_hash("12345", PASSWORD_DEFAULT);
    $role = "user";
    $insertUser->bind_param("ssss", $full_name, $user_email, $hashed_password, $role);
    $insertUser->execute();
    $user_id = $insertUser->insert_id;
    echo "✅ New user added with ID: $user_id<br>";
    $insertUser->close();
} else {
  
    $checkUser->bind_result($user_id);
    $checkUser->fetch();
    echo "ℹ️ User already exists with ID: $user_id<br>";
}
$checkUser->close();

$file_name = "report.pdf";
$file_path = "uploads/report.pdf";
$file_type = "application/pdf";
$file_size = 51200;
$description = "Project report";
$is_approved = 1;

$insertFile = $conn->prepare("
    INSERT INTO files (user_id, file_name, file_path, file_type, file_size, description, is_approved)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
$insertFile->bind_param("isssisi", $user_id, $file_name, $file_path, $file_type, $file_size, $description, $is_approved);

if ($insertFile->execute()) {
    echo "✅ File record inserted successfully!<br>";
    echo "🆔 File ID: " . $insertFile->insert_id;
} else {
    echo "❌ Error inserting file: " . $conn->error;
}

$insertFile->close();
$conn->close();
?>
