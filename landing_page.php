<?php
session_start();
require_once 'src/db_connection.php';
require_once 'src/emailFunctions.php';

$db = new Database();
$conn = $db->getConnection();
$error_message = '';
$success_message = '';

// Function to validate email format
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate password strength (at least 8 characters, 1 uppercase, 1 number)
function validatePasswordStrength($password)
{
    if (strlen($password) < 8) {
        return false;
    }
    if (!preg_match('/[A-Z]/', $password)) { // At least one uppercase letter
        return false;
    }
    if (!preg_match('/\d/', $password)) { // At least one digit
        return false;
    }
    return true;
}

// Function to validate if passwords match
function validatePasswordsMatch($password, $confirm_password)
{
    return $password === $confirm_password;
}

// Function to sanitize inputs (to prevent XSS)
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Login
    if (isset($_POST['login'])) {
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);

        if (!validateEmail($email)) {
            $error_message = "Invalid email format.";
        } else {
            $stmt = $conn->prepare("CALL LoginAccount(?, ?)");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $password);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $message = $result['message'];

            if ($message === "Login successful.") {
                header("Location: user/home.php");
                exit();
            } else {
                $error_message = $message;
            }
        }
    }

    // Signup
    if (isset($_POST['signup'])) {
        $username = sanitizeInput($_POST['username']);
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);
        $confirm_password = sanitizeInput($_POST['confirm_password']);

        // Check if passwords match
        if (!validatePasswordsMatch($password, $confirm_password)) {
            $error_message = "Passwords do not match.";
        }
        // Check if the password is strong
        elseif (!validatePasswordStrength($password)) {
            $error_message = "Password must be at least 8 characters long, contain at least one uppercase letter and one number.";
        }
        // Check if email format is valid
        elseif (!validateEmail($email)) {
            $error_message = "Invalid email format.";
        } else {
            // Proceed to register the user
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $verification_code = rand(100000, 999999); // 6-digit code

            $_SESSION['verification_email'] = $email;
            $_SESSION['verification_code'] = $verification_code;

            $stmt = $conn->prepare("CALL RegisterAccount(?, ?, ?)");
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $password_hash);
            $stmt->execute();

            sendVerificationEmail($email, $verification_code);
            $success_message = "Verification code sent to your email.";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle Login, Signup, Verification...
        if (isset($_POST['verify_code'])) {
            $entered_code = sanitizeInput($_POST['verification_code']);
            if ($entered_code == $_SESSION['verification_code']) {
                $success_message = "Account verified successfully. You can now login.";
                unset($_SESSION['verification_code'], $_SESSION['verification_email']);
                $_SESSION['is_verified'] = true; // Set session variable to indicate success
            } else {
                $error_message = "Invalid verification code.";
                $_SESSION['is_verified'] = false; // Ensure form stays open for retry
            }
        }
    }

    // Resend Code
    if (isset($_POST['resend_code'])) {
        $email = $_SESSION['verification_email'] ?? null;
        if ($email) {
            $verification_code = rand(100000, 999999);
            $_SESSION['verification_code'] = $verification_code;
            sendVerificationEmail($email, $verification_code);
            $success_message = "A new verification code has been sent.";
        } else {
            $error_message = "Session expired. Please register again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php'; ?>
</head>

<body>
    <?php include 'inc/header.php'; ?>
    <!-- Home -->
    <section class="home">
        <div class="form_container">
            <i class="uil uil-times form_close"></i>

            <!-- Login Form -->
            <div class="form login_form">
                <form action="user/home.php" method="POST">
                    <h2>Login</h2>
                    <?php if (isset($error_message) && !empty($error_message)): ?>
                        <div class="error-message"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <div class="input_box">
                        <input type="email" name="email" placeholder="Enter your email" required />
                        <i class="uil uil-envelope-alt email"></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="password" placeholder="Enter your password" required />
                        <i class="uil uil-lock password"></i>
                        <i class="uil uil-eye-slash pw_hide"></i>
                    </div>
                    <div class="option_field">
                        <span class="checkbox">
                            <input type="checkbox" id="check" />
                            <label for="check">Remember me</label>
                        </span>
                        <a href="#" class="forgot_pw">Forgot password?</a>
                    </div>
                    <button type="submit" name="login" class="button">Login Now</button>
                    <div class="login_signup">Don't have an account? <a href="#" id="signup">Signup</a></div>
                </form>
            </div>

            <!-- Signup Form -->
            <?php if (!isset($_SESSION['is_verified'])): ?>
                <div class="form signup_form">
                    <form action="landing_page.php" method="POST">
                        <h2 id="signupTitle">Sign Up</h2>
                        <?php if (isset($error_message) && !empty($error_message)): ?>
                            <div class="error-message"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <div class="progress-container">
                            <div class="progress-bar" id="progressBar">
                                <span class="step-label" id="progressLabel">Step 1 of 2: Signup</span>
                            </div>
                        </div>
                        <h3>Fill in all fields.</h3>
                        <div class="input_box">
                            <i class="uil uil-user"></i>
                            <input type="text" name="username" placeholder="Enter your username" required />

                        </div>
                        <div class="input_box">
                            <input type="email" name="email" placeholder="Enter your email" required />
                            <i class="uil uil-envelope-alt email"></i>
                        </div>
                        <div class="input_box">
                            <input type="password" class="password-field" name="password" placeholder="Create password"
                                required />
                            <i class="uil uil-lock password"></i>
                            <i class="uil uil-eye-slash pw_hide"></i>
                        </div>
                        <div class="input_box">
                            <input type="password" class="password-field" name="confirm_password"
                                placeholder="Confirm password" required />
                            <i class="uil uil-lock password"></i>
                            <i class="uil uil-eye-slash pw_hide"></i>
                        </div>
                        <button type="submit" name="signup" class="button">Signup Now</button>
                        <div class="login_signup">Already have an account? <a href="" id="login">Login</a></div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Verification Form -->
            <?php if (isset($_SESSION['verification_code']) && !isset($_SESSION['is_verified'])): ?>
                <div class="form verification_form">
                    <form action="user/home.php" method="POST">
                        <h2 id="signupTitle">Signup</h2>
                        <!-- Error and Success Messages -->
                        <?php if (isset($error_message) && !empty($error_message)): ?>
                            <div class="message error-message">
                                <i class="uil uil-times-circle"></i> <!-- Error icon -->
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($success_message) && !empty($success_message)): ?>
                            <div class="message success-message">
                                <i class="uil uil-check-circle"></i> <!-- Success icon -->
                                <?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>

                        <div class="progress-container">
                            <div class="progress-bar" id="progressBar">
                                <span class="step-label" id="progressLabel">Step 2 of 2: Verify</span>
                            </div>
                        </div>
                        <h3>Verify Your Account</h3>
                        <div class="input_box">
                            <input type="text" name="verification_code" placeholder="Enter verification code" />
                            <i class="uil uil-key-skeleton"></i>
                        </div>
                        <button type="submit" name="verify_code" class="button">Verify</button>
                        <a href="#" class="resend_link" id="resend_code">Resend Code</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script src="assets/js/script.js"></script>

</body>

</html>