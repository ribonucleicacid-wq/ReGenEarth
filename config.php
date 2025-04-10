<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('LANDING_PAGE', 'landing_page.php');

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
   $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    redirect(LANDING_PAGE);
}

?>
