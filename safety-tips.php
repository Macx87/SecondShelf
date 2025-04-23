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
    <title>Safety Tips - SecondShelf</title>
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
            <h1 class="mb-4">Safety Tips for Buying and Selling Used Books</h1>

            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h2 class="h4 mb-0">For Buyers</h2>
                        </div>
                        <div class="card-body">
                            <h3 class="h5">1. Verify Book Condition</h3>
                            <p>Always check the seller's description of the book's condition. Look for details about:</p>
                            <ul>
                                <li>Highlighting or writing inside the book</li>
                                <li>Damage to covers or spine</li>
                                <li>Missing or damaged pages</li>
                                <li>Water damage or stains</li>
                            </ul>

                            <h3 class="h5">2. Check Seller Ratings</h3>
                            <p>Review the seller's profile and ratings before making a purchase. Sellers with positive reviews are more likely to provide accurate descriptions and good service.</p>

                            <h3 class="h5">3. Secure Payment Methods</h3>
                            <p>Use secure payment methods that offer buyer protection. Avoid direct bank transfers to unknown sellers.</p>

                            <h3 class="h5">4. Meet in Safe Locations</h3>
                            <p>If meeting a seller in person:</p>
                            <ul>
                                <li>Choose public places with plenty of people around</li>
                                <li>Meet during daylight hours</li>
                                <li>Tell someone where you're going</li>
                                <li>Consider bringing a friend</li>
                            </ul>

                            <h3 class="h5">5. Inspect Before Paying</h3>
                            <p>When meeting in person, inspect the book thoroughly before completing the payment to ensure it matches the description.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h2 class="h4 mb-0">For Sellers</h2>
                        </div>
                        <div class="card-body">
                            <h3 class="h5">1. Accurate Descriptions</h3>
                            <p>Be honest and detailed about the condition of your books. Include clear photos showing any defects or wear.</p>

                            <h3 class="h5">2. Protect Your Personal Information</h3>
                            <p>Don't share unnecessary personal details with buyers. Use the platform's messaging system when possible.</p>

                            <h3 class="h5">3. Secure Packaging</h3>
                            <p>If shipping books:</p>
                            <ul>
                                <li>Use appropriate packaging to prevent damage</li>
                                <li>Consider using bubble wrap for valuable books</li>
                                <li>Use tracking numbers for all shipments</li>
                                <li>Take photos of the book and packaging before shipping</li>
                            </ul>

                            <h3 class="h5">4. Safe Meetups</h3>
                            <p>When meeting buyers in person:</p>
                            <ul>
                                <li>Choose public, well-lit locations</li>
                                <li>Bring a friend if possible</li>
                                <li>Accept secure payment methods</li>
                                <li>Trust your instincts - if something feels wrong, cancel the meeting</li>
                            </ul>

                            <h3 class="h5">5. Keep Records</h3>
                            <p>Maintain records of all communications and transactions for reference in case of disputes.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h2 class="h4 mb-0">Online Safety</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="h5">1. Protect Your Account</h3>
                            <p>Use strong, unique passwords for your SecondShelf account and enable two-factor authentication if available.</p>

                            <h3 class="h5">2. Be Wary of Suspicious Links</h3>
                            <p>Don't click on links in emails or messages that claim to be from SecondShelf unless you're certain they're legitimate.</p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="h5">3. Report Suspicious Activity</h3>
                            <p>If you encounter suspicious users or listings, report them to SecondShelf immediately.</p>

                            <h3 class="h5">4. Trust Your Instincts</h3>
                            <p>If a deal seems too good to be true, it probably is. Trust your instincts and proceed with caution.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning">
                <h3 class="h5">Need Help?</h3>
                <p>If you have any concerns about a transaction or need assistance, please contact our customer support team at +91 9876543210.</p>
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