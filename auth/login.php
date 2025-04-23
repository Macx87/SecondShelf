<?php
include "../config/db_connect.php";
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../profile.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, name, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: ../index.php"); // Redirect to homepage
            exit;
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found!";
    }
}
?>

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
    <title>Login</title>
    <link rel="icon" href="../assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../assets/img/secondshelf_logo.jpg" alt="SecondShelf Logo" height="40px" class="d-inline-block align-text-top me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../sell.php">Sell a Book</a></li>
                    <?php if ($user_name): ?>
                        <li class="nav-item"><a class="nav-link" href="../profile.php"><?php echo htmlspecialchars($user_name); ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="../auth/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="../auth/signup.php">Signup</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content wrapper -->
    <div class="main-content">

        <!-- Login Form -->
        <div class="auth-container">
            <h2>Login</h2>
            <form action="" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit">Login</button>

                <div class="text-center">
                    Don't have an account? <a href="signup.php">Sign up</a>
                </div>
            </form>
        </div>
    </div> <!-- End .main-content -->


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="footer-brand">
                        <img src="../assets/img/secondshelf_logo.jpg" alt="SecondShelf Logo" height="40" class="mb-2" style="height: 70px;">
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
                        <li><a href="../about.php" class="footer-link">About Us</a></li>
                        <li><a href="../terms.php" class="footer-link">Terms and Conditions</a></li>
                        <li><a href="../privacy.php" class="footer-link">Privacy Policy</a></li>
                        <li><a href="../safety-tips.php" class="footer-link">Safety Tips</a></li>
                        <li><a href="../buy-books-india.php" class="footer-link">Buy Second Hand Books Online In India</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>