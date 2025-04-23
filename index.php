<?php
session_start();
include "config/db_connect.php";

// Include SEO functions
include "includes/seo_functions.php";

// Optional: Optimize page load
optimize_page_load();

if (isset($_SESSION['user_id'])) {
    $user_name = $_SESSION['user_name'];
} else {
    $user_name = null;
}

$searchQuery = "";
$sql = "SELECT * FROM books";
$params = [];

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM books WHERE title LIKE ?";
    $searchParam = "%$search%";
    $params[] = $searchParam;
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php echo get_page_meta_tags('index.php'); ?>
    <title>SecondShelf</title>
    <link rel="icon" href="assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/secondshelf_logo.jpg" alt="SecondShelf Logo" height="40px" class="d-inline-block align-text-top me-2">
            </a>
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
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="footer-brand">
                        <img src="assets/img/secondshelf_logo.jpg" alt="SecondShelf Logo" height="40" class="mb-2" style="height: 70px;">
                        <p class="m-0">&copy; 2025 SecondShelf </p>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="footer-message">
                        <h5>Share the Joy of Reading</h5>
                        <p>"Every used book finds a new home, every story finds a new heart. Buy, sell, and sustain the cycle of knowledge."</p>
                        <h5 class="mt-3">Customer Care</h5>
                        <p><i class="bi bi-telephone-fill"></i> +91 9876543210</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="about.php" class="footer-link">About Us</a></li>
                        <li><a href="terms.php" class="footer-link">Terms and Conditions</a></li>
                        <li><a href="privacy.php" class="footer-link">Privacy Policy</a></li>
                        <li><a href="safety-tips.php" class="footer-link">Safety Tips</a></li>
                        <li><a href="buy-books-india.php" class="footer-link">Buy Second Hand Books Online In India</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>