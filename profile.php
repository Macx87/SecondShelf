<?php 
session_start();
include "config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$userQuery = "SELECT name, email FROM users WHERE id = '$user_id'";
$userResult = $conn->query($userQuery);

if (!$userResult) {
    die("User query failed: " . $conn->error);
}
$user = $userResult->fetch_assoc();

// Fetch books listed by the user
$booksQuery = "SELECT * FROM books WHERE user_id = '$user_id'";
$booksResult = $conn->query($booksQuery);

if (!$booksResult) {
    die("Books query failed: " . $conn->error);
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        $newName = $conn->real_escape_string($_POST['name']);
        $newEmail = $conn->real_escape_string($_POST['email']);
        $conn->query("UPDATE users SET name='$newName', email='$newEmail' WHERE id='$user_id'");
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    }
    if (isset($_POST['update_password'])) {
        $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $conn->query("UPDATE users SET password='$newPassword' WHERE id='$user_id'");
        $_SESSION['success'] = "Password changed successfully!";
        header("Location: profile.php");
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
    <title>Your Profile</title>
    <link rel="icon" href="assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php">📚 Second-Hand Books</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="sell.php">Sell a Book</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php"><?php echo htmlspecialchars($user_name); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="container my-5">
        <h2 class="text-center mb-4">Your Profile</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success text-center">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="card p-4 mb-4">
            <h4 class="mb-3">Welcome, <?php echo htmlspecialchars($user['name']); ?></h4>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <div class="d-flex flex-column flex-md-row gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProfileModal">Delete Profile</button>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>

        <h3 class="mb-3 text-center text-md-start">My Book Listings</h3>
        <div class="text-center mb-3">
            <a href="sell.php" class="btn btn-primary">+ Add New Book</a>
        </div>

        <div class="row">
            <?php while ($row = $booksResult->fetch_assoc()): ?>
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="Book Image">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="fw-bold">Price: ₹<?php echo $row['price']; ?></p>
                            <a href="book.php?id=<?php echo $row['id']; ?>" class="btn btn-success w-100 mb-2">View Details</a>
                            <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-danger w-100">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<footer class="footer mt-auto">
    <p class="m-0">&copy; 2025 Second-Hand Book Platform | <a href="about.php">About Us</a></p>
</footer>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    <label class="mt-2">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    <button type="submit" name="update_profile" class="btn btn-primary mt-3">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <label>New Password:</label>
                    <input type="password" name="password" class="form-control" required>
                    <button type="submit" name="update_password" class="btn btn-success mt-3">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Profile Modal -->
<div class="modal fade" id="deleteProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Delete Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger">Warning: This action cannot be undone. You must delete all your listed books before deleting your profile.</p>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                    <a href="delete_profile.php" class="btn btn-danger">Delete Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
