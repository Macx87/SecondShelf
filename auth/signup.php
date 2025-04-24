<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../profile.php");
    exit;
}

include "../config/db_connect.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";
require "../PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $otp = rand(100000, 999999); // 6-digit OTP

    // Check if user already exists in users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $check = $stmt->get_result();
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Email already registered.";
        header("Location: signup.php");
        exit();
    }

    // Check if email exists in pending_users
    $stmt = $conn->prepare("SELECT * FROM pending_users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $check_pending = $stmt->get_result();
    if ($check_pending->num_rows > 0) {
        // Update existing record with new OTP
        $updateStmt = $conn->prepare("UPDATE pending_users SET otp=? WHERE email=?");
        $updateStmt->bind_param("ss", $otp, $email);
        $updateStmt->execute();
    } else {
        // Insert new record
        $insertStmt = $conn->prepare("INSERT INTO pending_users (name, email, password, otp) VALUES (?, ?, ?, ?)");
        $insertStmt->bind_param("ssss", $name, $email, $password, $otp);
        $insertStmt->execute();
    }

    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_email'; // your Gmail
        $mail->Password   = 'your_password';          // your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('your_email', 'Secondhand Books');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Email Verification - Second-Hand Books';
        $mail->Body = "
            <table width='100%' cellpadding='0' cellspacing='0' style='min-width:100%;background-color:#f8f9fa'>
                <tr>
                    <td style='padding:20px'>
                        <table width='100%' cellpadding='0' cellspacing='0' style='max-width:600px;margin:0 auto;background-color:#ffffff;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1)'>
                            <!-- Header -->
                            <tr>
                                <td style='background-color:#0d6efd;padding:30px;text-align:center;border-radius:8px 8px 0 0'>
                                    <h1 style='color:#ffffff;margin:0;font-family:Arial,sans-serif;font-size:24px'>📚 Second-Hand Books</h1>
                                </td>
                            </tr>
                            <!-- Content -->
                            <tr>
                                <td style='padding:40px 30px'>
                                    <h2 style='color:#333;font-family:Arial,sans-serif;margin:0 0 20px'>Hello $name,</h2>
                                    <p style='color:#666;font-family:Arial,sans-serif;font-size:16px;line-height:1.6;margin:0 0 20px'>Welcome to Second-Hand Books! Please use the verification code below to complete your registration:</p>
                                    <!-- OTP Box -->
                                    <table width='100%' cellpadding='0' cellspacing='0' style='margin:30px 0'>
                                        <tr>
                                            <td style='background-color:#e8f0fe;border-radius:6px;padding:20px;text-align:center'>
                                                <span style='font-family:Arial,sans-serif;font-size:32px;font-weight:bold;color:#0d6efd;letter-spacing:5px'>$otp</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <p style='color:#666;font-family:Arial,sans-serif;font-size:14px;line-height:1.6;margin:20px 0 0'>This code will expire in 10 minutes. Please do not share this code with anyone.</p>
                                </td>
                            </tr>
                            <!-- Footer -->
                            <tr>
                                <td style='background-color:#f8f9fa;padding:20px;text-align:center;border-radius:0 0 8px 8px'>
                                    <p style='color:#999;font-family:Arial,sans-serif;font-size:12px;margin:0'>© 2025 Second-Hand Books. All rights reserved.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>";

        $mail->send();
        $_SESSION['email_to_verify'] = $email;

        // Safe redirect fallback
        header("Location: verify.php");
        echo "Redirecting to verification page... <a href='verify.php'>Click here if not redirected</a>.";
        exit();
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        exit();
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
    <title>Signup</title>
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="auth-container">
            <h2>Signup</h2>

            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger text-center'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" pattern=".{8,}" title="Password must be at least 8 characters long" required>
                    <small class="form-text text-muted">Password must be at least 8 characters long</small>
                </div>
                <button type="submit" class="btn btn-primary w-100">Signup</button>
                <div class="text-center mt-3">
                    <a href="login.php">Already have an account? Login</a>
                </div>
            </form>
        </div>
    </div>

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
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long');
            }
        });
    </script>
</body>

</html>