<?php
session_start();
include "config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM books WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $book_id, $user_id);
    if ($stmt->execute()) {
        echo "Book deleted successfully!";
        header("Location: profile.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
