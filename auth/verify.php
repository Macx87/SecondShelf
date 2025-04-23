<?php
session_start();
include "../config/db_connect.php";

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../profile.php");
    exit;
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $otp = $conn->real_escape_string($_POST['otp']);

    $stmt = $conn->prepare("SELECT * FROM pending_users WHERE email=? AND otp=?");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check && $check->num_rows === 1) {
        $pendingUser = $check->fetch_assoc();
        $name = $pendingUser['name'];
        $password = $pendingUser['password'];

        $insertStmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $insertStmt->bind_param("sss", $name, $email, $password);
        $insertStmt->execute();

        if ($insertStmt->affected_rows > 0) {
            $deleteStmt = $conn->prepare("DELETE FROM pending_users WHERE email=?");
            $deleteStmt->bind_param("s", $email);
            $deleteStmt->execute();
            $_SESSION['success'] = "Email verified successfully. You can now login.";
            header("Location: login.php");
            exit();
        } else {
            $error = "Something went wrong. Please try again.";
        }
    } else {
        $error = "Invalid OTP or email.";
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
    <title>Verify Email</title>
    <link rel="icon" href="../assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
</head>

<body>

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

    <div class="main-content">
        <div class="auth-container">
            <h2>Email Verification</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <label for="email" class="fw-semibold mt-2">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="otp" class="fw-semibold mt-3">OTP</label>
                <input type="text" id="otp" name="otp" placeholder="Enter OTP received" required>

                <button type="submit">Verify Email</button>
            </form>

            <div class="text-center mt-3">
                Didn't receive the email? Check your spam folder or <a href="signup.php" style="color: var(--secondary); text-decoration: underline;">signup again</a>.
            </div>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="" crossorigin="anonymous"></script>

</body>

</html>