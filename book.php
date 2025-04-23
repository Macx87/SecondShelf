<?php
session_start();
include "config/db_connect.php";

// Include SEO functions
include "includes/seo_functions.php";

$user_name = $_SESSION['user_name'] ?? null;

if (!isset($_GET['id'])) {
    echo "<p class='alert alert-danger'>Invalid book ID.</p>";
    exit();
}

$book_id = $_GET['id'];
$sql = "SELECT * FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p class='alert alert-warning'>Book not found.</p>";
    exit();
}

$book = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo get_page_meta_tags('book.php', ['book' => $book]); ?>
    <title><?php echo htmlspecialchars($book['title']); ?></title>
    <link rel="icon" href="assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div class="container book-container">
        <div class="row">
            <div class="col-md-5">
                <img src="uploads/<?php echo $book['image'] ?: 'default-book.jpg'; ?>" class="img-fluid rounded" alt="Book Image">
            </div>
            <div class="col-md-7">
                <h2><?php echo htmlspecialchars($book['title']); ?></h2>
                <p class="text-muted">by <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($book['price']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($book['location']); ?></p>
                <!--<p><strong>Seller Email:</strong> <a href="mailto:<?php echo htmlspecialchars($book['contact_email']); ?>"><?php echo htmlspecialchars($book['contact_email']); ?></a></p> -->

                <a href="mailto:<?php echo htmlspecialchars($book['contact_email']); ?>" class="btn btn-primary mt-3"> Contact on Email </a>

                <?php if (!empty($book['contact_whatsapp'])): ?>
                    <a href="https://wa.me/<?php echo htmlspecialchars($book['contact_whatsapp']); ?>" class="btn btn-primary mt-3">
                        Contact on WhatsApp
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>