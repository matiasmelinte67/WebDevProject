<?php
session_start();

require_once __DIR__ . '/../data/db_connect.php';
require_once "classes/Admin.php";

if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$error = '';

// Handle form submission when the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->connect();
    $admin = new Admin($db, "", "");

    // Get email and password from the submitted form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Attempt to log the admin in
    $result = $admin->login($email, $password);
    
    if ($result) {
        // Login successful, store admin information in session and redirect
        $_SESSION['admin_id'] = $result['Admin_ID'];
        $_SESSION['admin_email'] = $result['Email'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Login failed, set error message
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - The3Guys PC Shop</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <!-- Container for the login form -->
    <div class="auth-container">
        <h2 class="auth-title">Admin Login</h2>
        
        <!-- Display error message if login failed -->
        <?php if ($error): ?>
            <div class="error-messages">
                <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <!-- Login form for admin credentials -->
        <form class="auth-form" method="POST">
            <div class="form-group">
                <input type="email" name="email" class="form-input" placeholder="Admin Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-input" placeholder="Password" required>
            </div>
            <button type="submit" class="auth-button">Login</button>
            
            <!-- Link to return to the main website -->
            <div class="form-footer">
                <a href="index.php">Back to Main Site</a>
            </div>
        </form>
    </div>
</body>
</html>
