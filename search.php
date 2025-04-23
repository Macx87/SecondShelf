<?php
include "config/db_connect.php";

if (isset($_GET['query'])) {
    $search = $_GET['query'];
    $searchParam = "%$search%";
    $sql = "SELECT title FROM books WHERE title LIKE ? LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['title'];
    }

    echo json_encode($suggestions);
}
