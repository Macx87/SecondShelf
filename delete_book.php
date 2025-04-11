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

    $sql = "DELETE FROM books WHERE id = '$book_id' AND user_id = '$user_id'";
    if ($conn->query($sql)) {
        echo "Book deleted successfully!";
        header("Location: profile.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
