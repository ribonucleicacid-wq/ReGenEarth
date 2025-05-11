<?php
include '../auth/user_only.php';

$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
$role = $_SESSION['role'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ReGenEarth</title>
    <link rel="shortcut icon" href="../uploads/logo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

    <style>
        :root {
            --moonstone: #57AFC3;
            --prussian-blue: #132F43;
            --silver: #CACFD3;
            --taupe-gray: #999A9C;
            --rich-black: #0B1A26;
        }

        .light-mode {
            --moonstone: #489fb5;
            --prussian-blue: #e9ecef;
            --silver: #212529;
            --taupe-gray: #6c757d;
            --rich-black: #ffffff;
        }

        body {
            background-color: var(--rich-black);
            color: var(--silver);
        }

        .navbar {
            background-color: var(--prussian-blue) !important;
            color: var(--silver);
        }

        .navbar a,
        .navbar-brand,
        .nav-link {
            color: var(--silver) !important;
        }

        .nav-link:hover,
        .navbar-brand:hover {
            color: var(--moonstone) !important;
        }

        .btn-outline-secondary {
            border-color: var(--taupe-gray);
            color: var(--taupe-gray);
        }

        .btn-outline-secondary:hover {
            background-color: var(--moonstone);
            border-color: var(--moonstone);
            color: white;
        }

        .dropdown-menu {
            background-color: var(--prussian-blue);
            border-color: var(--moonstone);
        }

        .dropdown-item {
            color: var(--silver);
        }

        .dropdown-item:hover {
            background-color: var(--moonstone);
            color: white;
        }

        .form-control {
            background-color: var(--rich-black);
            color: var(--silver);
            border: 1px solid var(--taupe-gray);
        }

        .form-control::placeholder {
            color: var(--taupe-gray);
        }

        .list-group-item {
            background-color: var(--rich-black);
            color: var(--silver);
            border-color: var(--taupe-gray);
        }

        .list-group-item:hover {
            background-color: var(--moonstone);
            color: white;
        }

        .logo-img,
        .user-img,
        .search-suggest-img {
            border: 1px solid var(--moonstone);
        }

        .search-suggest-img {
            background-color: var(--prussian-blue);
        }

        .badge-light {
            background-color: var(--moonstone);
            color: white;
        }

        .logo-img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .user-img {
            position: absolute;
            height: 27px;
            width: 27px;
            object-fit: cover;
            left: -7%;
            top: -12%;
        }

        .search-suggest-img {
            width: 3em;
            height: 3em;
            object-fit: cover;
            object-position: center center;
        }

        #search-suggest {
            max-height: 20em;
            overflow: auto;
        }

        .request_count:empty {
            display: none !important
        }

        body,
        .navbar,
        .form-control,
        .list-group-item,
        .dropdown-menu {
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
            color: var(--silver) !important;
            padding-left: 4px;
            justify-content: space-evenly;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-img {
            width: 40px;
            height: auto;
            object-fit: contain;
            border: #ffffff 1px solid;
            margin: auto;
        }

        .btn-rounded {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            font-size: 1rem;
        }

        .user-img {
            width: 30px;
            height: auto;
            object-fit: contain;
            border-radius: 50%;
            margin-right: 10px;
        }

        .ml-3 {
            font-size: 0.8rem;
        }

        .d-flex.align-items-center .btn-group {
            margin-left: 15px;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Notification Styles */
        .notifications-nav {
            position: relative;
            margin: 0 1.5rem;
        }

        .notifications-nav .nav-link {
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .notifications-nav .fa-bell {
            font-size: 1.2rem;
            color: var(--silver);
            transition: transform 0.2s ease;
        }

        .notifications-nav .nav-link:hover .fa-bell {
            transform: scale(1.1);
            color: var(--moonstone);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            padding: 0.25em 0.4em;
            font-size: 0.75em;
            line-height: 1;
            border-radius: 50%;
            background-color: #dc3545;
            color: white;
            min-width: 1em;
            text-align: center;
            transform: scale(0.9);
        }

        .d-flex.align-items-center {
            gap: 0.5rem;
        }

        .btn-group.nav-link {
            margin-left: 0.5rem;
        }

        @media (max-width: 991.98px) {
            .notifications-nav {
                margin: 0.5rem 0;
            }

            .navbar-nav {
                gap: 0.5rem;
            }

            .d-flex.align-items-center {
                margin-top: 0.5rem;
            }
        }

        /* Adjust dropdown styling for better spacing */
        .notification-dropdown {
            width: 350px;
            max-height: 480px;
            overflow-y: auto;
        }

        .notifications-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .dropdown-footer {
            padding: 8px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .notification-item-preview {
            padding: 12px 12px 12px 40px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: block;
            text-decoration: none;
            color: inherit;
            transition: background-color 0.2s;
            position: relative;
        }

        .notification-item-preview:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .notification-item-preview.unread {
            background-color: rgba(87, 175, 195, 0.1);
        }

        .notification-item-preview.unread::before {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: var(--moonstone);
            border-radius: 50%;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            animation: pulse 2s infinite;
            animation-delay: -1s;
            box-shadow: 0 0 0 0 rgba(87, 175, 195, 0.7);
            z-index: 1;
        }

        @keyframes pulse {
            0% {
                transform: translateY(-50%) scale(1);
                box-shadow: 0 0 0 0 rgba(87, 175, 195, 0.7);
            }

            70% {
                transform: translateY(-50%) scale(1.3);
                box-shadow: 0 0 0 8px rgba(87, 175, 195, 0);
            }

            100% {
                transform: translateY(-50%) scale(1);
                box-shadow: 0 0 0 0 rgba(87, 175, 195, 0);
            }
        }

        .notification-item-preview .d-flex {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .notification-item-preview .notification-icon {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(87, 175, 195, 0.1);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .notification-item-preview img {
            border: 2px solid var(--moonstone);
            flex-shrink: 0;
        }

        .notification-item-preview .notification-content {
            flex: 1;
            min-width: 200px;
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .notification-item-preview .notification-content div {
            margin-bottom: 0.25rem;
            line-height: 1.4;
            white-space: normal;
            word-break: break-word;
        }

        .notification-item-preview .notification-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .notification-item-preview strong {
            color: var(--moonstone);
        }

        /* Notification Icon Animations */
        .notification-icon {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex-shrink: 0;
            position: relative;
            margin-right: 10px;
        }

        /* Base hover effect for all icons */
        .notification-icon:hover {
            transform: scale(1.1);
        }

        /* Unread Indicator */
        .unread-indicator {
            width: 12px;
            height: 12px;
            background-color: var(--moonstone);
            border-radius: 50%;
            display: inline-block;
            position: absolute;
            top: -5px;
            right: -5px;
            animation: pulse 2s infinite;
            box-shadow: 0 0 0 0 rgba(87, 175, 195, 0.7);
            z-index: 1;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(87, 175, 195, 0.7);
            }

            70% {
                transform: scale(1.2);
                box-shadow: 0 0 0 6px rgba(87, 175, 195, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(87, 175, 195, 0);
            }
        }

        /* Like Icon Animation */
        .notification-icon.like:hover i {
            animation: likeBeat 2s ease-in-out infinite;
        }

        @keyframes likeBeat {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Comment Icon Animation */
        .notification-icon.comment:hover i {
            animation: commentBounce 2s ease-in-out infinite;
        }

        @keyframes commentBounce {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(5deg);
            }

            75% {
                transform: rotate(-5deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        /* Follow Icon Animation */
        .notification-icon.follow:hover i {
            animation: followPulse 2s ease-in-out infinite;
        }

        @keyframes followPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Badge Icon Animation */
        .notification-icon.badge:hover i {
            animation: badgeShine 2s ease-in-out infinite;
        }

        @keyframes badgeShine {
            0% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(15deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        /* Mention Icon Animation */
        .notification-icon.mention:hover i {
            animation: mentionSpin 2s ease-in-out infinite;
        }

        @keyframes mentionSpin {
            0% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(180deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Action Icon Animation */
        .notification-icon.action:hover i {
            animation: actionWave 2s ease-in-out infinite;
        }

        @keyframes actionWave {
            0% {
                transform: scale(1) rotate(0deg);
            }

            50% {
                transform: scale(1.1) rotate(5deg);
            }

            100% {
                transform: scale(1) rotate(0deg);
            }
        }

        /* Notification Icon Colors with better contrast and glow effect */
        .notification-icon.like {
            color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.1);
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.2);
            border: 2px solid #4CAF50;
        }

        .notification-icon.comment {
            color: #2196F3;
            background-color: rgba(33, 150, 243, 0.1);
            box-shadow: 0 0 10px rgba(33, 150, 243, 0.2);
            border: 2px solid #2196F3;
        }

        .notification-icon.follow {
            color: #9C27B0;
            background-color: rgba(156, 39, 176, 0.1);
            box-shadow: 0 0 10px rgba(156, 39, 176, 0.2);
            border: 2px solid #9C27B0;
        }

        .notification-icon.badge {
            color: #FFC107;
            background-color: rgba(255, 193, 7, 0.1);
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.2);
            border: 2px solid #FFC107;
        }

        .notification-icon.mention {
            color: #E91E63;
            background-color: rgba(233, 30, 99, 0.1);
            box-shadow: 0 0 10px rgba(233, 30, 99, 0.2);
            border: 2px solid #E91E63;
        }

        .notification-icon.action {
            color: #00BCD4;
            background-color: rgba(0, 188, 212, 0.1);
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.2);
            border: 2px solid #00BCD4;
        }

        /* Add glow effect on hover */
        .notification-icon:hover {
            box-shadow: 0 0 10px rgba(87, 175, 195, 0.3);
        }

        /* Mobile adjustments */
        @media (max-width: 576px) {
            .notification-item-preview {
                padding: 12px 12px 12px 35px;
            }

            .notification-item-preview.unread::before {
                width: 8px;
                height: 8px;
                left: 12px;
            }
        }

        /* Search Form Container */
        #search-form-folder {
            margin-right: 2rem;
            /* Add margin to create space between search and nav items */
        }

        /* Adjust navbar spacing */
        .navbar-nav {
            gap: 1rem;
            align-items: center;
            margin-left: 1rem;
            /* Add margin to create space after search bar */
        }

        /* Style for Post nav item */
        .nav-link .fa-plus-square {
            font-size: 1.1rem;
            margin-right: 4px;
        }

        .nav-link {
            padding: 0.5rem 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.3s ease;
            white-space: nowrap;
        }

        .mark-all-read-btn {
            padding: 6px 12px;
            font-size: 0.875rem;
            background-color: var(--moonstone);
            color: white;
            border: none;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .mark-all-read-btn:hover {
            background-color: #489fb5;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(87, 175, 195, 0.3);
        }
    </style>
</head>

<body>
    </button>
    <!-- Header -->
    <nav class="main-header navbar navbar-expand-lg navbar-light bg-gradient-light border-bottom border-4 shadow">
        <div class="container px-2 px-lg-3">
            <!-- Toggle button for small screens -->
            <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Logo and Brand Name -->
            <a class="navbar-brand" href="home.php">
                <img src="../uploads/logo.png" class="d-inline-block align-center logo-img" alt=""
                    loading="lazy" />ReGenEarth
            </a>

            <!-- Search Form -->
            <div id="search-form-folder" class="w-25 position-relative">
                <form action="" id="search-form">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-sm rounded-0" name="search" id="search" type="search"
                            placeholder="Search...">
                        <button class="btn btn-outline-secondary btn-sm rounded-0"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <div class="list-group position-absolute w-100 rounded-0" id="search-suggest"></div>
            </div>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="./">Home</a></li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="post.php">
                            <i class="far fa-plus-square me-1"></i>
                            <span>Post</span>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="follows.php">Follows</a></li>
                    <li class="nav-item"><a class="nav-link" href="awareness.php">Awareness</a></li>
                </ul>

                <!-- User Dropdown -->
                <div class="d-flex align-items-center">
                    <!-- Notifications -->
                    <div class="nav-item dropdown notifications-nav">
                        <?php
                        // Get current page filename
                        $current_page = basename($_SERVER['PHP_SELF']);
                        // Only show dropdown functionality if not on notifications page
                        if ($current_page !== 'notifications.php'):
                            ?>
                            <a class="nav-link" href="notifications.php">
                                <i class="fas fa-bell"></i>
                                <span class="badge badge-danger notification-badge">1</span>
                            </a>
                        <?php else: ?>
                            <!-- On notifications page, bell icon links directly to notifications page -->
                            <a class="nav-link" href="notifications.php">
                                <i class="fas fa-bell"></i>
                                <span class="badge badge-danger notification-badge">1</span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- User Dropdown + Mode Toggle -->
                    <div class="btn-group nav-link text-reset">
                        <button type="button"
                            class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon text-reset"
                            data-toggle="dropdown">
                            <span><img src="../uploads/members/sample profile.png"
                                    class="img-circle elevation-2 user-img" alt="User Image"></span>
                            <span class="ml-3">
                                <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
                            </span>
                            <span class="sr-only"></span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="profile.php"><span class="fa fa-user"></span> My Account</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmLogout()"><span
                                    class="fas fa-sign-out-alt"></span> Logout</a>
                        </div>
                    </div>
                    <!-- Toggle Button -->
                    <button class="btn btn-sm btn-outline-secondary ml-2" id="modeToggle">
                        <i class="fas fa-moon" id="modeIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Suggestion Item Template (Hidden) -->
    <noscript id="search-suggest-item-clone">
        <a href="" class="list-group-item list-group-item-action text-reset">
            <div class="d-flex w-100 align-items-center">
                <div class="col-auto text-center">
                    <img src="" alt="" class="rounded-circle border border-dark search-suggest-img">
                </div>
                <div class="col-auto flex-shrink-1 flex-grow-1">
                    <div style="line-height:1.1em">
                        <div class="fw-bolder username">Test</div>
                        <div class="fw-light email">test@sample.com</div>
                    </div>
                </div>
            </div>
        </a>
    </noscript>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        var process_ajax = false;
        $(function () {
            $('#search').on('input change', function () {
                var kw = $(this).val();
                if (kw == '') {
                    $('#search-suggest').html('');
                } else {
                    if (!!process_ajax)
                        process_ajax.abort();
                    process_ajax = $.ajax({
                        url: "search.php",
                        method: 'POST',
                        data: { search: kw },
                        dataType: 'json',
                        error: function (err) {
                            console.log(err);
                            alert("Fetching Search Suggestion Failed due to unknown reason.");
                            process_ajax.abort();
                            process_ajax = false;
                        },
                        success: function (resp) {
                            $('#search-suggest').html('');
                            if (resp.status == 'success') {
                                if (Object.keys(resp.data).length > 0) {
                                    Object.keys(resp.data).map(k => {
                                        var user = resp.data[k];
                                        var anchor = $($('noscript#search-suggest-item-clone').html()).clone();
                                        anchor.find('.search-suggest-img').attr('src', user.avatar);
                                        anchor.find('.username').text(user.name);
                                        anchor.find('.email').text(user.email);
                                        anchor.attr('href', "profile.php?user_id=" + user.id);
                                        $('#search-suggest').append(anchor);
                                    });
                                }
                            } else {
                                alert("Fetching Search Suggestion Failed due to unknown reason.");
                                process_ajax.abort();
                                process_ajax = false;
                            }
                        }
                    });
                }
            });
        });

        function confirmLogout() {
            var confirmed = confirm("Are you sure you want to log out?");
            if (confirmed) {
                window.location.href = '../config.php?action=logout';
            } else {
                return false;
            }
        }

        // Dark/Light Mode Toggle
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById('modeToggle');
            const modeIcon = document.getElementById('modeIcon');
            const body = document.body;

            // Load saved mode
            if (localStorage.getItem('mode') === 'light') {
                body.classList.add('light-mode');
                modeIcon.classList.remove('fa-moon');
                modeIcon.classList.add('fa-sun');
            }

            toggleBtn.addEventListener('click', function () {
                body.classList.toggle('light-mode');
                const isLight = body.classList.contains('light-mode');

                modeIcon.classList.toggle('fa-moon', !isLight);
                modeIcon.classList.toggle('fa-sun', isLight);

                localStorage.setItem('mode', isLight ? 'light' : 'dark');
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Enhanced notification badge update system
            function updateNotificationBadge() {
                // Get accurate count from localStorage
                const unreadCount = parseInt(localStorage.getItem('unreadNotifications') || '0');

                // Update all notification badges in the header
                const badges = document.querySelectorAll('.notification-badge');
                badges.forEach(badge => {
                    badge.textContent = unreadCount;
                    badge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
                });

                console.log('Header notification badge updated:', unreadCount);
            }

            // Initialize badges immediately
            updateNotificationBadge();

            // Multiple sync methods for maximum reliability:

            // 1. Listen for storage events (works across tabs/pages)
            window.addEventListener('storage', function (e) {
                if (e.key === 'unreadNotifications') {
                    console.log('Notification storage updated:', e.newValue);
                    updateNotificationBadge();
                }
            });

            // 2. Listen for custom events from notifications.php
            document.addEventListener('unreadNotificationsUpdated', function (e) {
                console.log('Notification update event received:', e.detail?.count);
                updateNotificationBadge();
            });

            // 3. Periodic check as a fallback (every 3 seconds)
            setInterval(updateNotificationBadge, 3000);

            // 4. Update when notification icon is clicked
            const notificationLinks = document.querySelectorAll('.notifications-nav .nav-link');
            notificationLinks.forEach(link => {
                link.addEventListener('click', function () {
                    // Small delay to ensure localStorage is updated first if needed
                    setTimeout(updateNotificationBadge, 100);
                });
            });
        });
    </script>
</body>

</html>