<?php
include "config/db_connect.php";

if (isset($_GET['query'])) {
    $search = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT title FROM books WHERE title LIKE '%$search%' LIMIT 5";
    $result = $conn->query($sql);

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['title'];
    }

    echo json_encode($suggestions);
}
?>
