<?php
$host = "localhost";  // Change this to your hosting DB details when deploying
$user = "root";       // Default XAMPP MySQL username
$pass = "";           // Default XAMPP password (empty)
$dbname = "bookstore"; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
