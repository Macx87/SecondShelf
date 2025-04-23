<?php
session_start();

// Include SEO functions
include "includes/seo_functions.php";

$user_name = $_SESSION['user_name'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo get_page_meta_tags('about.php'); ?>
    <title>About Second-Hand Books</title>
    <link rel="icon" href="assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-10  text-center">
                <div class="about-section">
                    <h1 class="mb-4">📚📖 Welcome to Our Second-Hand Book Universe! 🌍📚</h1>

                    <div class="mb-5">
                        <h2 class="h3">👋 About Our Platform</h2>
                        <ul class="list-unstyled text-center">
                            <li class="mb-2">🎓 A SecondShelf is a Second-Hand Book Selling and Buying Web Application, created as a final year college project</li>
                            <li class="mb-2">🧑‍🎓 Designed for students and avid readers</li>
                            <li class="mb-2">✍️ Easy listing of pre-loved books</li>
                            <li class="mb-2">👀 Browse diverse collection of pre-owned books</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h3">🌱 Our Vision</h2>
                        <ul class="list-unstyled text-center">
                            <li class="mb-2">📚 Every book deserves a new journey with a new reader</li>
                            <li class="mb-2">🤝 Bridging connections between book enthusiasts</li>
                            <li class="mb-2">🏘️ Building a thriving community of readers</li>
                            <li class="mb-2">🧪 A demonstration project showcasing:</li>
                            <ul class="list-unstyled ms-4 text-center">
                                <li class="mb-2">💰 Accessible reading opportunities</li>
                                <li class="mb-2">♻️ Environmentally conscious book sharing</li>
                            </ul>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h3">🛍️ Discover the Demonstrated Features:</h2>
                        <ul class="list-unstyled text-center">
                            <li class="mb-2">✍️ <strong>Effortless Listing</strong>
                                <ul class="list-unstyled ms-4 text-center">
                                    <li>Create detailed listings for cherished books ready for their next adventure</li>
                                </ul>
                            </li>
                            <li class="mb-2">🔎 <strong>Exciting Discoveries</strong>
                                <ul class="list-unstyled ms-4 text-center">
                                    <li>Search by title, author, or category</li>
                                    <li>User-friendly browsing capabilities</li>
                                </ul>
                            </li>
                            <li class="mb-2">💬 <strong>Direct Connections</strong>
                                <ul class="list-unstyled ms-4 text-center">
                                    <li>Connect buyers and sellers directly</li>
                                    <li>Arrange exchange of literary gems</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="h3">🔒 Important Note on Project Scope:</h2>
                        <div class="alert alert-warning mt-3 text-center">
                            <h3 class="h4 mb-3">⚠️ Important Safety Guidelines</h3>
                            <ul class="list-unstyled text-center mb-0">
                                <li class="mb-2">🎯 This is strictly a demonstration platform for a college project</li>
                                <li class="mb-2">🚫 Do not share personal contact information:</li>
                                <ul class="list-unstyled ms-4 text-center">
                                    <li class="mb-2">📱 WhatsApp numbers</li>
                                    <li class="mb-2">📧 Email addresses</li>
                                    <li class="mb-2">📞 Phone numbers</li>
                                </ul>
                                <li class="mb-2">⛔ Not intended for real-world transactions</li>
                                <li>🔒 Focus on demonstrated functionality only</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="lead">😊 Thanks for checking out this project showcasing a community platform for giving pre-loved books new life! 🌟</p>
                    </div>
                </div>
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