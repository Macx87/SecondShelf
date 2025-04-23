<?php
session_start();
include "config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if user has any books listed
$checkBooksQuery = "SELECT COUNT(*) as book_count FROM books WHERE user_id = ?";
$stmt = $conn->prepare($checkBooksQuery);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$checkBooksResult = $stmt->get_result();
$bookCount = $checkBooksResult->fetch_assoc()['book_count'];

if ($bookCount > 0) {
    $_SESSION['error'] = "Please delete all your listed books before deleting your profile.";
    header("Location: profile.php");
    exit();
}

// If no books found, proceed with profile deletion
$deleteUserQuery = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($deleteUserQuery);
$stmt->bind_param("s", $user_id);
if ($stmt->execute()) {
    session_destroy();
    header("Location: auth/login.php");
    exit();
} else {
    $_SESSION['error'] = "Error deleting profile: " . $conn->error;
    header("Location: profile.php");
    exit();
}
