<?php
// Include the database connection
require_once 'db_connect.php';

// Function to test if a table exists
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

// Function to create a test table if it doesn't exist
function createTestTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS test_connection (
        id INT AUTO_INCREMENT PRIMARY KEY,
        test_message VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    return $conn->query($sql);
}

// Function to insert a test record
function insertTestRecord($conn) {
    $message = "Test record created at " . date('Y-m-d H:i:s');
    $sql = "INSERT INTO test_connection (test_message) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $message);
    return $stmt->execute();
}

// Function to get all test records
function getTestRecords($conn) {
    $sql = "SELECT * FROM test_connection ORDER BY created_at DESC LIMIT 5";
    return $conn->query($sql);
}

// Start the tests
echo "<html><head><title>Database Connection Test</title>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .test-section { margin: 20px 0; padding: 10px; border: 1px solid #ccc; }
</style></head><body>";

echo "<h1>Database Connection Test</h1>";

// Test 1: Basic Connection
echo "<div class='test-section'>";
echo "<h3>1. Testing Database Connection</h3>";
if ($conn) {
    echo "<p class='success'>✓ Successfully connected to database: {$dbname}</p>";
} else {
    echo "<p class='error'>× Failed to connect to database</p>";
}
echo "</div>";

// Test 2: Database Information
echo "<div class='test-section'>";
echo "<h3>2. Database Server Information</h3>";
echo "<p>Server Info: " . $conn->server_info . "</p>";
echo "<p>Server Version: " . $conn->server_version . "</p>";
echo "<p>Character Set: " . $conn->character_set_name() . "</p>";
echo "</div>";

// Test 3: Show Tables
echo "<div class='test-section'>";
echo "<h3>3. Existing Tables in Database</h3>";
$result = $conn->query("SHOW TABLES");
if ($result) {
    echo "<ul>";
    while ($row = $result->fetch_array()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p class='error'>Could not fetch tables</p>";
}
echo "</div>";

// Test 4: Create and Use Test Table
echo "<div class='test-section'>";
echo "<h3>4. Test Table Operations</h3>";
if (createTestTable($conn)) {
    echo "<p class='success'>✓ Test table created/verified successfully</p>";
    
    // Try to insert a record
    if (insertTestRecord($conn)) {
        echo "<p class='success'>✓ Test record inserted successfully</p>";
        
        // Try to read records
        $records = getTestRecords($conn);
        if ($records) {
            echo "<h4>Last 5 Test Records:</h4>";
            echo "<ul>";
            while ($row = $records->fetch_assoc()) {
                echo "<li>{$row['test_message']} (ID: {$row['id']})</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p class='error'>× Failed to insert test record</p>";
    }
} else {
    echo "<p class='error'>× Failed to create test table</p>";
}
echo "</div>";

// Close the connection
$conn->close();
echo "<p>Database connection closed.</p>";
echo "</body></html>";
?>