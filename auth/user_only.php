<?php
// auth/user_only.php

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../landing_page.php");
    exit();
}

// In your session start or any protected file
$session_lifetime = 3600; // 1 hour

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_lifetime) {
    // Session expired, log out the user
    session_unset();
    session_destroy();
    header("Location: ../landing_page.php");
    exit();
}

$_SESSION['last_activity'] = time(); // update the last activity time
