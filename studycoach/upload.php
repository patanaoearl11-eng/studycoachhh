<?php
session_start();

// Ensure upload directory exists
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'] ?? 'Uncategorized';
    $file = $_FILES['file'] ?? null;

    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Save info to a log file or database later if needed
            echo json_encode([
                "success" => true,
                "message" => "File uploaded successfully!",
                "filename" => $fileName,
                "subject" => $subject
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Error saving the file."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No file uploaded or upload error."]);
    }
}
?>
