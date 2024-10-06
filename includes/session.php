<?php
session_start();

// Check if admin_id and username session variables are set
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['username'])) {
    // Redirect to index.php
    header("Location: index.php");
    exit; // Stop further execution
}

// If session variables are set, you can use them as needed in this file
$admin_id = $_SESSION['admin_id'];
$username = $_SESSION['username'];

// Other code here...
?>
