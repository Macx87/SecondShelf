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
    <title>Privacy Policy - SecondShelf</title>
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
            <h1 class="mb-4">Privacy Policy</h1>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>1. Information We Collect</h2>
                    <p>At SecondShelf, we collect several types of information to provide and improve our service to you:</p>
                    <ul>
                        <li><strong>Personal Information:</strong> When you create an account, we collect your name, email address, and password.</li>
                        <li><strong>Transaction Information:</strong> When you buy or sell books, we collect information about the transaction, including payment details and shipping addresses.</li>
                        <li><strong>Usage Data:</strong> We collect information about how you interact with our website, including the pages you visit and the actions you take.</li>
                        <li><strong>Device Information:</strong> We collect information about the device you use to access our website, including your IP address, browser type, and operating system.</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>2. How We Use Your Information</h2>
                    <p>We use the information we collect for various purposes, including:</p>
                    <ul>
                        <li>To provide and maintain our service</li>
                        <li>To process transactions and send transaction-related communications</li>
                        <li>To improve our website and user experience</li>
                        <li>To communicate with you about your account or transactions</li>
                        <li>To detect and prevent fraudulent or unauthorized activity</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>3. Information Sharing</h2>
                    <p>We may share your information in the following circumstances:</p>
                    <ul>
                        <li><strong>With Other Users:</strong> When you buy or sell a book, we share necessary information with the other party to facilitate the transaction.</li>
                        <li><strong>With Service Providers:</strong> We may share your information with third-party service providers who help us operate our website and provide our services.</li>
                        <li><strong>For Legal Reasons:</strong> We may share your information if required by law or to protect our rights or the rights of others.</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>4. Data Security</h2>
                    <p>We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>5. Your Rights</h2>
                    <p>You have certain rights regarding your personal information, including:</p>
                    <ul>
                        <li>The right to access and update your personal information</li>
                        <li>The right to request deletion of your personal information</li>
                        <li>The right to object to processing of your personal information</li>
                        <li>The right to data portability</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>6. Changes to This Privacy Policy</h2>
                    <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>7. Contact Us</h2>
                    <p>If you have any questions about this Privacy Policy, please contact us at +91 9876543210.</p>
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