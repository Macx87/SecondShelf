<?php
session_start();
include "config/db_connect.php";

if (isset($_SESSION['user_id'])) {
    $user_name = $_SESSION['user_name'];
} else {
    $user_name = null;
}

$searchQuery = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $searchQuery = "WHERE title LIKE '%$search%'";
}

$sql = "SELECT * FROM books $searchQuery";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Second-Hand Book Platform</title>
    <link rel="icon" href="assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">📚 Second-Hand Books</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="sell.php">Sell a Book</a></li>
                    <?php if ($user_name): ?>
                        <li class="nav-item"><a class="nav-link" href="profile.php"><?php echo htmlspecialchars($user_name); ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="auth/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth/signup.php">Signup</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content wrapper -->
    <div class="main-content">

        <header class="header">
            <h1 class="display-4">Find & Sell Second-Hand Books</h1>
            <p class="lead">Connecting book lovers for affordable and sustainable reading</p>
            <form method="GET" action="index.php" class="d-flex justify-content-center mt-4">
                <input class="form-control w-50 me-2" type="text" name="search" placeholder="Search books...">
                <button class="btn btn-primary">Search</button>
            </form>
        </header>

        <div class="container my-5">
            <h2 class="text-center mb-4">Available Books</h2>
            <div class="row g-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="uploads/<?php echo $row['image'] ?: 'default-book.jpg'; ?>" class="card-img-top" alt="Book Image">
                            <div class="card-body">
                                <h5 class="card-title"> <?php echo htmlspecialchars($row['title']); ?> </h5>
                                <p class="text-muted">by <?php echo htmlspecialchars($row['author']); ?></p>
                                <p class="fw-bold">Price: ₹<?php echo $row['price']; ?></p>
                                <a href="book.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="alert alert-warning">No books found. Try a different keyword.</p>
                </div>
            <?php endif; ?>
            </div>
        </div>

    </div> <!-- End .main-content -->

    <footer class="footer">
        <p class="m-0">&copy; 2025 Second-Hand Book Platform | <a href="about.php">About Us</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
