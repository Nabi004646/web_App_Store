<?php
// ====================================
// DATABASE CONNECTION FILE
// File: includes/db.php
// ====================================

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'web_playstore');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Function to close database connection
function closeConnection($connection) {
    if ($connection) {
        mysqli_close($connection);
    }
}
?>
