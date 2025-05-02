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

// Connect to the database
$database = new Database();
$db = $database->connect();

// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim(strip_tags($_POST['firstName']));
    $lastName = trim(strip_tags($_POST['lastName']));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $errors = [];

    // Validate inputs
    if (empty($firstName) || empty($lastName)) {
        $errors[] = "Name fields cannot be empty";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        $errors[] = "Password must be at least 8 characters long, contain 1 uppercase letter, 1 number, and 1 symbol.";
    }

    if (empty($errors)) {
        $user = new User($db, $email, $password, $firstName, $lastName);

        if ($user->register()) {
            $_SESSION['user_id'] = $db->lastInsertId();
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $firstName . " " . $lastName;
            
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Registration failed. Email may already be in use.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - The3Guys PC Shop</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="auth-container">
        <h2 class="auth-title">Sign Up</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="register.php">
            <div class="form-group">
                <input type="text" class="form-input" name="firstName" placeholder="First Name*" 
                    value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-input" name="lastName" placeholder="Last Name*" 
                    value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>" required>
            </div>
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
            <div class="form-group">
                <div class="password-wrapper">
                    <input type="password" class="form-input" name="confirmPassword" placeholder="Confirm Password*" required>
                    <button type="button" class="password-toggle">👁️</button>
                </div>
                <small>At least 8 characters, 1 uppercase letter, 1 number & 1 symbol</small>
            </div>
            <button type="submit" class="auth-button">Sign Up</button>
            <div class="form-footer">
                Already have an account? <a href="login.php">Log In</a>
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