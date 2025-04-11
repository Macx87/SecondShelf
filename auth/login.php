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
            <a class="navbar-brand" href="../index.php">📚 Second-Hand Books</a>
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
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="signup.php">Signup</a></li>
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
        <p class="m-0">&copy; 2025 Second-Hand Book Platform | <a href="../about.php">About Us</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
