<?php
ob_start();
session_start();
require_once 'src/db_connection.php';
require_once 'src/emailFunctions.php';

$db = new Database();
$conn = $db->getConnection();
$error_message = '';
$success_message = '';

// ========== Validation and Sanitize Functions ==========
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePasswordStrength($password)
{
    return strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/\d/', $password);
}

function validatePasswordsMatch($password, $confirm_password)
{
    return $password === $confirm_password;
}

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

// ========== Main Form Handler ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ========== LOGIN ==========
    if (isset($_POST['login'])) {
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);

        if (!validateEmail($email)) {
            $error_message = "Invalid email format.";
        } else {
            $stmt = $conn->prepare("CALL LoginAccount(?)");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $hashedPassword = $result['password_hash'];
                $isVerified = $result['is_verified'];

                if (!$isVerified) {
                    $error_message = "Account not verified. Please check your email.";
                } elseif (!password_verify($password, $hashedPassword)) {
                    $error_message = "Incorrect password.";
                } else {
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['username'] = $result['username'];
                    $_SESSION['role'] = $result['role'];

                    switch ($result['role']) {
                        case 'admin':
                            header("Location: admin/dashboard.php");
                            break;
                        case 'staff':
                            header("Location: staff/dashboard.php");
                            break;
                        default:
                            header("Location: user/home.php");
                    }
                    exit();
                }
            } else {
                $error_message = "No account found with this email.";
            }
        }
    }

    // ========== SIGNUP ==========
    if (isset($_POST['signup'])) {
        $username = sanitizeInput($_POST['username']);
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);
        $confirm_password = sanitizeInput($_POST['confirm_password']);

        if (!validatePasswordsMatch($password, $confirm_password)) {
            $error_message = "Passwords do not match.";
        } elseif (!validatePasswordStrength($password)) {
            $error_message = "Password must be at least 8 characters long, with one uppercase letter and one number.";
        } elseif (!validateEmail($email)) {
            $error_message = "Invalid email format.";
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $verification_code = rand(100000, 999999);

            $_SESSION['verification_email'] = $email;
            $_SESSION['verification_code'] = $verification_code;

            $stmt = $conn->prepare("CALL RegisterAccount(?, ?, ?, ?)");
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $password_hash);
            $stmt->bindParam(4, $verification_code);
            $stmt->execute();

            sendVerificationEmail($email, $verification_code);
            $success_message = "Verification code sent to your email.";
        }
    }

    // ========== VERIFY CODE ==========
    if (isset($_POST['verify_code'])) {
        $entered_code = sanitizeInput($_POST['verification_code']);
        $email = $_SESSION['verification_email'] ?? '';

        if ($email && $entered_code) {
            $stmt = $conn->prepare("CALL VerifyAccount(?, ?)");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $entered_code);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($result['message']) && $result['message'] === 'Account successfully verified.') {
                $success_message = $result['message'];
                unset($_SESSION['verification_code'], $_SESSION['verification_email']);
            } else {
                $error_message = $result['message'];
            }
        } else {
            $error_message = "Verification code or session expired.";
        }
    }

    // ========== RESEND CODE ==========
    if (isset($_POST['resend_code'])) {
        $email = $_SESSION['verification_email'] ?? null;
        if ($email) {
            $verification_code = rand(100000, 999999);
            $_SESSION['verification_code'] = $verification_code;

            // Update code in DB
            $stmt = $conn->prepare("CALL UpdateVerificationCode(?, ?)");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $verification_code);
            $stmt->execute();


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

    <section class="anim-bg-section">
        <div class="anim-wrapper">
            <div class="anim-re-text">Re</div>
            <div class="anim-content">
                <ol>
                    <li><span>GenEarth</span></li>
                    <li><span>duce</span></li>
                    <li><span>use</span></li>
                    <li><span>cycle</span></li>
                    <li><span>plenish</span></li>
                </ol>
            </div>
        </div>

        <div class="anim-wrapper-2">
            <div id="animTyping" class="anim-typewriter"></div>
        </div>
        <div class="anim-button">
            <button class="learn-more">Learn More</button>
        </div>
    </section>

    <!-- Home -->
    <section class="home">
        <div class="form_container">
            <i class="uil uil-times form_close"></i>

            <!-- Login Form -->
            <div class="form login_form">
                <form action="landing_page.php" method="POST">
                    <h2>Login</h2>
                    <?php if (isset($error_message) && !empty($error_message)): ?>
                        <div class="error-message">
                            <?php echo $error_message; ?>
                        </div>
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
                    <div class=" option_field">
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
                            <div class="error-message">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <div class="progress-container">
                            <div class="progress-bar" id="progressBar">
                                <span class="step-label" id="progressLabel">Step 1 of 2: Signup</span>
                            </div>
                        </div>
                        <h3>Fill in all fields.</h3>
                        <div class="input_box">
                            <i class="uil uil-user"></i> <input type="text" name="username"
                                placeholder="Enter your username" required />

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
                    <form action="landing_page.php" method="POST">
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
    <script>
        const animTypingArea = document.getElementById('animTyping');

        const animMessages1 = ["for the new", "Generation", "of Earth"];
        const animMessages2 = ["Acting Locally,", "Thinking Globally"];

        function animSleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function animTypeLines(lines, delay = 80) {
            animTypingArea.innerHTML = "";
            const cursor = document.createElement("span");
            cursor.className = "cursor";
            animTypingArea.appendChild(cursor);

            for (let line of lines) {
                const lineDiv = document.createElement("div");
                animTypingArea.insertBefore(lineDiv, cursor);

                for (let i = 0; i < line.length; i++) {
                    lineDiv.textContent += line[i];
                    animPlayTypeSound();
                    await animSleep(delay);
                }
                await animSleep(400);
            }

            await animSleep(2000);
        }

        async function animLoop() {
            while (true) {
                await animTypeLines(animMessages1);
                await animSleep(1000);
                await animTypeLines(animMessages2);
                await animSleep(3000);
            }
        }

        animLoop();
    </script>


</body>

</html>

<?php ob_end_flush(); ?>