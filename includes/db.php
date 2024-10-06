<?php
// Database configuration
$dbHost = 'localhost'; // Change this if your database host is different
$dbUsername = 'indiaweb_indiaweb'; // Your database username
$dbPassword = 'bfG$r8Fa@FG)'; // Your database password
$dbName = 'indiaweb_db'; // Your database name

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUsername, $dbPassword);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Display error message
    die("Connection failed: " . $e->getMessage());
}
?>
