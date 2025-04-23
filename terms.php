<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_name = $_SESSION['user_name'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions - SecondShelf</title>
    <link rel="icon" href="assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
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
        <div class="container py-5">
            <h1 class="mb-4">Terms and Conditions</h1>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>1. Introduction</h2>
                    <p>Welcome to SecondShelf. These terms and conditions outline the rules and regulations for the use of our website.</p>
                    <p>By accessing this website, we assume you accept these terms and conditions in full. Do not continue to use SecondShelf if you do not accept all of the terms and conditions stated on this page.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>2. User Accounts</h2>
                    <p>When you create an account with us, you guarantee that the information you provide is accurate, complete, and current at all times. Inaccurate, incomplete, or obsolete information may result in the immediate termination of your account on the Service.</p>
                    <p>You are responsible for maintaining the confidentiality of your account and password, including but not limited to the restriction of access to your computer and/or account. You agree to accept responsibility for any and all activities or actions that occur under your account and/or password.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>3. Book Listings</h2>
                    <p>When listing a book for sale, you agree to provide accurate information about the book's condition, edition, and other relevant details. Misrepresentation of books may result in the removal of listings and potential suspension of your account.</p>
                    <p>SecondShelf reserves the right to remove any listing that violates our policies or that we deem inappropriate for our platform.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>4. Transactions</h2>
                    <p>SecondShelf serves as a platform connecting buyers and sellers. We are not responsible for the quality of books, delivery issues, or payment disputes between users.</p>
                    <p>Users are encouraged to communicate clearly and honestly with each other regarding transactions. Any disputes should be resolved between the parties involved.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>5. Prohibited Content</h2>
                    <p>Users are prohibited from posting content that is illegal, harmful, threatening, abusive, harassing, defamatory, or otherwise objectionable.</p>
                    <p>SecondShelf reserves the right to remove any content that violates these terms and to terminate user accounts responsible for such violations.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>6. Changes to Terms</h2>
                    <p>SecondShelf reserves the right to modify these terms at any time. We will notify users of any significant changes via email or through a notice on our website.</p>
                    <p>Your continued use of the platform after such modifications constitutes your acceptance of the updated terms.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>7. Contact Information</h2>
                    <p>If you have any questions about these Terms and Conditions, please contact us at +91 9876543210.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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