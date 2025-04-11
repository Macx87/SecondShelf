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

    $check = $conn->query("SELECT * FROM pending_users WHERE email='$email' AND otp='$otp'");

    if ($check && $check->num_rows === 1) {
        $pendingUser = $check->fetch_assoc();
        $name = $conn->real_escape_string($pendingUser['name']);
        $password = $conn->real_escape_string($pendingUser['password']);

        $insert = $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

        if ($insert) {
            $conn->query("DELETE FROM pending_users WHERE email='$email'");
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
            <div class="container d-flex align-items-center">
                <!-- Brand/Logo -->
                <a class="navbar-brand" href="/secondhand_books/index.php">📚 Second-Hand Books</a>

                <!-- Toggler Button -->
                <button 
                    class="navbar-toggler" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/secondhand_books/index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/secondhand_books/sell.php">Sell a Book</a></li>
                        <li class="nav-item"><a class="nav-link" href="signup.php">Signup</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
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

        <footer class="footer mt-auto">
            <p class="m-0">&copy; 2025 Second-Hand Book Platform | <a href="about.php">About Us</a></p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="" crossorigin="anonymous"></script>

    </body>
</html>