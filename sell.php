<?php
session_start();

// Include SEO functions
include "includes/seo_functions.php";

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to sell a book";
    header("Location: auth/login.php?redirect=sell.php");
    exit;
}

include "config/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? $conn->real_escape_string($_POST['title']) : '';
    $author = isset($_POST['author']) ? $conn->real_escape_string($_POST['author']) : '';
    $price = isset($_POST['price']) ? $conn->real_escape_string($_POST['price']) : 0;
    $description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : '';
    $contact_email = isset($_POST['contact_email']) ? $conn->real_escape_string($_POST['contact_email']) : '';
    $contact_whatsapp = isset($_POST['contact_whatsapp']) ? $conn->real_escape_string($_POST['contact_whatsapp']) : '';
    $location = isset($_POST['location']) ? $conn->real_escape_string($_POST['location']) : '';
    $user_id = $_SESSION['user_id'];

    $targetDir = "uploads/";
    $imageName = "";

    // Image Upload Handling
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];

        if (in_array($imageFileType, $allowedTypes)) {
            $imageName = time() . "_" . basename($_FILES["image"]["name"]); // Unique name
            $targetFile = $targetDir . $imageName;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Resize Image to 300x400
                resizeImage($targetFile, $targetFile, 300, 400);
            } else {
                echo "<p class='alert alert-danger'>Error uploading file.</p>";
                exit();
            }
        } else {
            echo "<p class='alert alert-danger'>Invalid file type. Only JPG, JPEG, and PNG are allowed.</p>";
            exit();
        }
    }

    // Insert into Database
    $sql = "INSERT INTO books (title, author, price, description, image, contact_email, contact_whatsapp, location, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssssss", $title, $author, $price, $description, $imageName, $contact_email, $contact_whatsapp, $location, $user_id);

    if ($stmt->execute()) {
        echo "<p class='alert alert-success'>Book added successfully! Redirecting to homepage...</p>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 3000);
            </script>";
    } else {
        echo "<p class='alert alert-danger'>Error: " . $conn->error . "</p>";
    }
    exit();
}

// Function to Resize Image
function resizeImage($source, $destination, $newWidth, $newHeight)
{
    list($width, $height, $type) = getimagesize($source);

    $srcImage = match ($type) {
        IMAGETYPE_JPEG => imagecreatefromjpeg($source),
        IMAGETYPE_PNG => imagecreatefrompng($source),
        default => null
    };

    if (!$srcImage) return false;

    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    match ($type) {
        IMAGETYPE_JPEG => imagejpeg($newImage, $destination, 90),
        IMAGETYPE_PNG => imagepng($newImage, $destination, 9)
    };

    imagedestroy($srcImage);
    imagedestroy($newImage);
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
    <title>Sell a Book</title>
    <link rel="icon" href="assets/favicon.ico?v=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="sell-container">
            <h2>Sell a Book</h2>
            <form method="POST" action="sell.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Book Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter book title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Describe your book" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (₹)</label>
                    <input type="number" name="price" class="form-control" placeholder="Enter price" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">WhatsApp Number</label>
                    <input type="text" name="contact_whatsapp" class="form-control" placeholder="Enter WhatsApp number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Enter location" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Add Book</button>
            </form>
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