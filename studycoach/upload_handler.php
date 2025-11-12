<?php
session_start();
include('db_connect.php');

// Make sure file and subject are provided
if (isset($_FILES['file']) && isset($_POST['subject'])) {
    $user = $_SESSION['user'] ?? 'guest';
    $subject = $_POST['subject'];
    $uploadDir = "uploads/" . $subject . "/";

    // Create folder if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES['file']['name']);
    $targetFile = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

    if (in_array($fileType, $allowed)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            // Save to database
            $stmt = $conn->prepare("INSERT INTO uploads (user, filename, filepath, filetype) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user, $fileName, $targetFile, $fileType]);

            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "invalid";
    }
} else {
    echo "missing";
}
?>
