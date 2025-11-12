<?php
/*
 * EXAMPLE FILE - How to use database connection
 * 
 * Instructions:
 * 1. At the top of every PHP file that needs database access, add:
 *    require_once 'config/database.php';
 * 
 * 2. You can then use $conn for database operations
 * 
 * Example usage:
 */

// Include the database connection
require_once 'config/database.php';

// Example query with prepared statement
function exampleSelect($user_id) {
    global $conn;
    
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

// Example insert with prepared statement
function exampleInsert($username, $email) {
    global $conn;
    
    $sql = "INSERT INTO users (username, email) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    
    return $stmt->execute();
}

// Example update with prepared statement
function exampleUpdate($user_id, $new_username) {
    global $conn;
    
    $sql = "UPDATE users SET username = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_username, $user_id);
    
    return $stmt->execute();
}

// Example delete with prepared statement
function exampleDelete($user_id) {
    global $conn;
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    return $stmt->execute();
}

// Always use prepared statements to prevent SQL injection
// Always use try-catch blocks for error handling
// Always close statements after use

?>