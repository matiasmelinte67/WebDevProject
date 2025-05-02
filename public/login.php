<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../data/db_connect.php';
require_once "classes/User.php";

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$database = new Database();
$db = $database->connect();

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($errors)) {
        $user = new User($db, $email, $password, "", "");
        $loggedInUser = $user->login($email, $password);

        if ($loggedInUser) {
            $_SESSION['user_id'] = $loggedInUser['User_ID'];
            $_SESSION['user_email'] = $loggedInUser['Email'];
            $_SESSION['user_name'] = $loggedInUser['First_Name'] . " " . $loggedInUser['Last_Name'];

            // Redirect to previous page if set, otherwise to index
            $redirect = $_SESSION['redirect_url'] ?? 'index.php';
            unset($_SESSION['redirect_url']);
            header("Location: " . $redirect);
            exit();
        } else {
            $errors[] = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - The3Guys PC Shop</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="auth-container">
        <h2 class="auth-title">Log In</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="login.php">
            <div class="form-group">
                <input type="email" class="form-input" name="email" placeholder="Email Address*" 
                    value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
            </div>
            <div class="form-group">
                <div class="password-wrapper">
                    <input type="password" class="form-input" name="password" placeholder="Password*" required>
                    <button type="button" class="password-toggle">👁️</button>
                </div>
            </div>
            <div class="form-footer">
            </div>
            <button type="submit" class="auth-button">Log In</button>
            <div class="form-footer">
                Don't have an account? <a href="register.php">Sign Up</a>
            </div>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
    document.querySelectorAll('.password-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    });
    </script>
</body>
</html>