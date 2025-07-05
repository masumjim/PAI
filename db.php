<?php

session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Change to your database username
define('DB_PASS', ''); // Change to your database password
define('DB_NAME', 'pai'); // Change to your database name


// Create database connection
$conn = new mysqli(hostname: DB_HOST, username: DB_USER, password: DB_PASS, database: DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user inputs


?>