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
    <title>Buy Second Hand Books Online In India - SecondShelf</title>
    <meta name="description" content="Find affordable second-hand books online in India. Wide selection of used books with verified quality and secure transactions.">
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
            <h1 class="mb-4">Buy Second Hand Books Online In India</h1>

            <div class="row mb-5">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2>Why Buy Second Hand Books?</h2>
                            <p>SecondShelf is your trusted platform for buying high-quality second-hand books across India. We connect book lovers with affordable reading options while promoting sustainability and knowledge sharing.</p>

                            <div class="row mt-4">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="bi bi-piggy-bank text-primary" style="font-size: 2rem;"></i>
                                        </div>
                                        <div>
                                            <h3 class="h5">Save Money</h3>
                                            <p>Get books at 30-70% off original prices, making reading affordable for everyone.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="bi bi-tree text-success" style="font-size: 2rem;"></i>
                                        </div>
                                        <div>
                                            <h3 class="h5">Eco-Friendly</h3>
                                            <p>Reduce paper waste and save trees by giving books a second life.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="bi bi-gem text-info" style="font-size: 2rem;"></i>
                                        </div>
                                        <div>
                                            <h3 class="h5">Find Rare Treasures</h3>
                                            <p>Discover out-of-print editions and rare books not available in regular stores.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="bi bi-shield-check text-warning" style="font-size: 2rem;"></i>
                                        </div>
                                        <div>
                                            <h3 class="h5">Verified Quality</h3>
                                            <p>All books on our platform come with detailed condition descriptions and photos.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h3 class="h4 mb-3">Popular Categories</h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-light"><i class="bi bi-book me-2 text-primary"></i>Academic & Textbooks</li>
                                <li class="list-group-item bg-light"><i class="bi bi-book me-2 text-primary"></i>Fiction & Literature</li>
                                <li class="list-group-item bg-light"><i class="bi bi-book me-2 text-primary"></i>Children's Books</li>
                                <li class="list-group-item bg-light"><i class="bi bi-book me-2 text-primary"></i>Competitive Exam Books</li>
                                <li class="list-group-item bg-light"><i class="bi bi-book me-2 text-primary"></i>Self-Help & Motivation</li>
                                <li class="list-group-item bg-light"><i class="bi bi-book me-2 text-primary"></i>Business & Management</li>
                                <li class="list-group-item bg-light"><i class="bi bi-book me-2 text-primary"></i>Comics & Graphic Novels</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>How It Works</h2>
                    <div class="row mt-4">
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-search" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="h5">Browse</h3>
                            <p>Search for books by title, author, category, or location across India</p>
                        </div>
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-chat-dots" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="h5">Connect</h3>
                            <p>Contact sellers directly through our secure messaging system</p>
                        </div>
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-credit-card" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="h5">Purchase</h3>
                            <p>Complete your transaction securely through our platform</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-book" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="h5">Enjoy</h3>
                            <p>Receive your books and start reading!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h2>Serving All of India</h2>
                    <p>SecondShelf connects book lovers across India. Our platform has active users in major cities including:</p>

                    <div class="row mt-4">
                        <div class="col-md-3 col-6 mb-3">
                            <ul class="list-unstyled">
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Delhi</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Mumbai</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Bangalore</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Chennai</li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <ul class="list-unstyled">
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Hyderabad</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Kolkata</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Pune</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Ahmedabad</li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <ul class="list-unstyled">
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Jaipur</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Lucknow</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Chandigarh</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Bhopal</li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <ul class="list-unstyled">
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Kochi</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Guwahati</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>Indore</li>
                                <li><i class="bi bi-geo-alt-fill text-danger me-2"></i>And many more!</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2>Customer Testimonials</h2>
                    <div class="row mt-4">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                    <p class="card-text">"I found my college textbooks at 60% off the original price. SecondShelf saved me thousands of rupees on my education!"</p>
                                    <p class="card-text"><small class="text-muted">- Priya S., Delhi</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-half text-warning"></i>
                                    </div>
                                    <p class="card-text">"I found a rare edition of my favorite novel that had been out of print for years. The condition was exactly as described!"</p>
                                    <p class="card-text"><small class="text-muted">- Rahul M., Mumbai</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                    <p class="card-text">"The platform is so easy to use, and I love that I'm helping reduce waste by buying used books. Great customer service too!"</p>
                                    <p class="card-text"><small class="text-muted">- Ananya K., Bangalore</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="index.php" class="btn btn-primary btn-lg">Start Browsing Books</a>
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