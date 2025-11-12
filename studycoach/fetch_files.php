<?php
$baseDir = "uploads/";
$result = [];

if (is_dir($baseDir)) {
    $subjects = scandir($baseDir);
    foreach ($subjects as $subject) {
        if ($subject === '.' || $subject === '..') continue;

        $subjectPath = $baseDir . $subject . '/';
        $files = array_diff(scandir($subjectPath), ['.', '..']);
        $result[$subject] = array_values($files);
    }
}

header('Content-Type: application/json');
echo json_encode($result);
?>
